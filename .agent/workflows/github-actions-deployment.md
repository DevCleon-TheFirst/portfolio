---
description: Deploy Portfolio via GitHub Actions to Server
---

# Complete GitHub Actions Deployment Guide

This guide will walk you through deploying your Laravel portfolio application to your server using GitHub Actions. Follow each step carefully.

## Prerequisites Checklist

Before starting, ensure you have:
- [ ] A server with SSH access (username and password/key)
- [ ] Git installed on your local machine
- [ ] A GitHub account
- [ ] PHP 8.2+ and Composer on your server
- [ ] MySQL/MariaDB database on your server
- [ ] Web server (Apache/Nginx) configured on your server

---

## Step 1: Prepare Your Server

### 1.1 Connect to Your Server via SSH

```bash
ssh your-username@your-server-ip
```

### 1.2 Create Deployment Directories

```bash
# Create main deployment directory
mkdir -p /var/www/porty

# Create backup directory
mkdir -p /var/www/backups/porty

# Set ownership (replace 'www-data' with your web server user if different)
sudo chown -R $USER:www-data /var/www/porty
sudo chown -R $USER:www-data /var/www/backups/porty
```

### 1.3 Set Up Database

```bash
# Login to MySQL
mysql -u root -p

# Create database and user
CREATE DATABASE porty_production;
CREATE USER 'porty_user'@'localhost' IDENTIFIED BY 'your-strong-password';
GRANT ALL PRIVILEGES ON porty_production.* TO 'porty_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 1.4 Create Production .env File

```bash
cd /var/www/porty
nano .env
```

Add this content (customize with your values):

```env
APP_NAME="Dev Cleon Portfolio"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=porty_production
DB_USERNAME=porty_user
DB_PASSWORD=your-strong-password

SESSION_DRIVER=database
SESSION_LIFETIME=120

CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=your-mail-host
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@your-domain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

Save and exit (Ctrl+X, then Y, then Enter).

---

## Step 2: Generate SSH Key for GitHub Actions

### 2.1 Generate a New SSH Key Pair

On your **server**, run:

```bash
ssh-keygen -t rsa -b 4096 -C "github-actions-deploy" -f ~/.ssh/github_deploy_key -N ""
```

### 2.2 Add Public Key to Authorized Keys

```bash
cat ~/.ssh/github_deploy_key.pub >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
```

### 2.3 Copy the Private Key

```bash
cat ~/.ssh/github_deploy_key
```

**Copy the entire output** (including `-----BEGIN OPENSSH PRIVATE KEY-----` and `-----END OPENSSH PRIVATE KEY-----`). You'll need this in Step 4.

---

## Step 3: Initialize Git Repository (If Not Done)

### 3.1 Check Git Status

On your **local machine**, in your project directory:

```bash
cd /home/devcleon/porty
git status
```

### 3.2 If Git Is Already Initialized

If you see git output, check your remote:

```bash
git remote -v
```

If you don't have a `origin` remote or need to add one, go to Step 3.4.

### 3.3 If Git Is NOT Initialized

```bash
git init
git add .
git commit -m "Initial commit"
```

### 3.4 Create GitHub Repository

1. Go to https://github.com/new
2. Repository name: `portfolio` (or any name you prefer)
3. Make it **Private** (recommended)
4. Do **NOT** initialize with README, .gitignore, or license
5. Click "Create repository"

### 3.5 Connect Local Repository to GitHub

```bash
git remote add origin https://github.com/YOUR-USERNAME/portfolio.git
git branch -M main
git push -u origin main
```

Replace `YOUR-USERNAME` with your GitHub username.

---

## Step 4: Configure GitHub Secrets

### 4.1 Go to Repository Settings

1. Open your GitHub repository in the browser
2. Click **Settings** tab
3. In left sidebar, click **Secrets and variables** → **Actions**
4. Click **New repository secret**

### 4.2 Add Required Secrets

Add each of these secrets one by one:

| Secret Name | Value | Example |
|------------|-------|---------|
| `SSH_HOST` | Your server IP or domain | `123.45.67.89` or `server.example.com` |
| `SSH_USERNAME` | Your SSH username | `devcleon` or `ubuntu` |
| `SSH_PORT` | SSH port (usually 22) | `22` |
| `SSH_PRIVATE_KEY` | Private key from Step 2.3 | The entire key including BEGIN/END lines |
| `DEPLOY_PATH` | Server deployment path | `/var/www/porty` |
| `BACKUP_PATH` | Server backup path | `/var/www/backups/porty` |

> [!IMPORTANT]
> For `SSH_PRIVATE_KEY`, paste the **entire private key** including the header and footer lines.

---

## Step 5: Test the Deployment Workflow

### 5.1 Verify Workflow File Exists

Your workflow is already set up at `.github/workflows/deploy.yml`.

### 5.2 Make a Test Change

```bash
# Make a small change
echo "# Portfolio" > README.md
git add README.md
git commit -m "Test deployment workflow"
git push origin main
```

### 5.3 Monitor Deployment

1. Go to your GitHub repository
2. Click the **Actions** tab
3. You should see your workflow running
4. Click on it to see the progress

### 5.4 Check for Errors

If the workflow fails:
- Check the error logs in the Actions tab
- Verify all secrets are correct
- Ensure your server is accessible via SSH
- Check server permissions

---

## Step 6: Configure Web Server

### 6.1 For Nginx

Create a new site configuration:

```bash
sudo nano /etc/nginx/sites-available/porty
```

Add this configuration:

```nginx
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    root /var/www/porty/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable the site:

```bash
sudo ln -s /etc/nginx/sites-available/porty /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 6.2 For Apache

Create a new site configuration:

```bash
sudo nano /etc/apache2/sites-available/porty.conf
```

Add this configuration:

```apache
<VirtualHost *:80>
    ServerName your-domain.com
    ServerAlias www.your-domain.com
    DocumentRoot /var/www/porty/public

    <Directory /var/www/porty/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/porty_error.log
    CustomLog ${APACHE_LOG_DIR}/porty_access.log combined
</VirtualHost>
```

Enable the site:

```bash
sudo a2ensite porty.conf
sudo a2enmod rewrite
sudo systemctl reload apache2
```

---

## Step 7: Set Up SSL (Optional but Recommended)

### 7.1 Install Certbot

```bash
sudo apt update
sudo apt install certbot python3-certbot-nginx  # For Nginx
# OR
sudo apt install certbot python3-certbot-apache  # For Apache
```

### 7.2 Obtain SSL Certificate

```bash
sudo certbot --nginx -d your-domain.com -d www.your-domain.com  # For Nginx
# OR
sudo certbot --apache -d your-domain.com -d www.your-domain.com  # For Apache
```

Follow the prompts. Certbot will automatically configure SSL.

---

## Step 8: Regular Deployment Process

### 8.1 Daily Workflow

From now on, whenever you want to deploy changes:

```bash
# 1. Make your changes locally
# 2. Commit them
git add .
git commit -m "Description of changes"

# 3. Push to GitHub
git push origin main

# 4. GitHub Actions will automatically deploy to your server!
```

### 8.2 Monitor Deployments

Always check the Actions tab on GitHub to ensure deployment succeeded.

---

## Troubleshooting Common Issues

### Issue 1: SSH Connection Failed

**Solution:**
- Verify `SSH_HOST`, `SSH_USERNAME`, and `SSH_PORT` secrets
- Test SSH connection manually: `ssh -p 22 username@server-ip`
- Check firewall settings on server

### Issue 2: Permission Denied

**Solution:**
```bash
# On server
cd /var/www/porty
sudo chown -R $USER:www-data .
sudo chmod -R 775 storage bootstrap/cache
```

### Issue 3: Database Connection Error

**Solution:**
- Verify `.env` database credentials on server
- Test database connection: `mysql -u porty_user -p porty_production`

### Issue 4: 500 Internal Server Error

**Solution:**
```bash
# On server, check Laravel logs
cd /var/www/porty
tail -f storage/logs/laravel.log
```

### Issue 5: Assets Not Loading (404 for CSS/JS)

**Solution:**
- Ensure `npm run build` completed successfully in GitHub Actions
- Check that `public/build` directory exists on server
- Verify web server is serving the `public` directory

---

## Advanced: Manual Deployment Commands

If you need to manually run deployment commands on the server:

```bash
# Connect to server
ssh your-username@your-server-ip

# Navigate to project
cd /var/www/porty

# Pull latest changes (if needed)
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader
npm ci && npm run build

# Run migrations
php artisan migrate --force

# Clear and cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
sudo chown -R $USER:www-data .
sudo chmod -R 775 storage bootstrap/cache
```

---

## Security Best Practices

1. **Never commit `.env` file** - It's already in `.gitignore`
2. **Use strong database passwords** - At least 16 characters
3. **Keep APP_DEBUG=false** in production
4. **Use HTTPS** - Always use SSL certificates
5. **Regular backups** - The workflow creates automatic backups
6. **Update dependencies** - Run `composer update` and `npm update` regularly
7. **Monitor logs** - Check `storage/logs` for suspicious activity

---

## What Happens During Deployment

When you push to GitHub, the workflow:

1. ✅ Checks out your code
2. ✅ Installs PHP 8.2 and Node.js 18
3. ✅ Installs Composer dependencies (production only)
4. ✅ Installs NPM dependencies
5. ✅ Builds frontend assets (Vite/Tailwind)
6. ✅ Creates a deployment package (tar.gz)
7. ✅ Uploads package to server
8. ✅ Creates backup of current version
9. ✅ Extracts new version
10. ✅ Restores `.env` file
11. ✅ Sets correct permissions
12. ✅ Runs database migrations
13. ✅ Clears all caches
14. ✅ Caches config, routes, and views
15. ✅ Creates storage link
16. ✅ Cleans up old backups (keeps last 5)

---

## Need Help?

- **GitHub Actions logs**: Check the Actions tab in your repository
- **Server logs**: `tail -f storage/logs/laravel.log`
- **Web server logs**: 
  - Nginx: `/var/log/nginx/error.log`
  - Apache: `/var/log/apache2/error.log`

---

Good luck with your deployment! 🚀
