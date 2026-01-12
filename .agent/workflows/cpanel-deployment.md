---
description: Deploy Laravel Portfolio to cPanel Hosting
---

# Deploy to cPanel - Simple Guide

This guide is for deploying your Laravel portfolio to **cPanel hosting** (shared hosting). This is much simpler than VPS deployment!

## 🎯 Understanding Your Setup

**You have cPanel** = You're using shared hosting (like Hostinger, Bluehost, SiteGround, etc.)

**What this means:**
- You access your server through a web interface (cPanel)
- You don't need SSH keys or complex terminal commands
- cPanel has built-in Git tools
- Everything is done through your browser!

---

## 📋 Prerequisites

- [ ] cPanel login credentials
- [ ] GitHub account
- [ ] Your repository: `https://github.com/DevCleon-TheFirst/portfolio`
- [ ] MySQL database created in cPanel

---

## Method 1: Using cPanel Git Version Control (Recommended)

This is the **easiest** method if your cPanel has Git tools.

### Step 1: Check if Your cPanel Has Git

1. Log into your cPanel
2. Search for "Git Version Control" or "Git™ Version Control"
3. If you see it → Use this method ✅
4. If you don't see it → Skip to Method 2 (FTP)

### Step 2: Create Database in cPanel

1. In cPanel, find **MySQL Databases**
2. Create new database:
   - Database name: `porty_prod` (or any name)
   - Click "Create Database"
3. Create database user:
   - Username: `porty_user`
   - Password: *create a strong password*
   - Click "Create User"
4. Add user to database:
   - Select the database and user you just created
   - Grant "ALL PRIVILEGES"
   - Click "Add"
5. **Write down:**
   - Database name
   - Database username
   - Database password
   - Database host (usually `localhost`)

### Step 3: Set Up Git Repository in cPanel

1. Go to **Git Version Control** in cPanel
2. Click **Create**
3. Fill in the form:
   - **Clone URL**: `https://github.com/DevCleon-TheFirst/portfolio.git`
   - **Repository Path**: `repositories/portfolio` (or any folder name)
   - **Repository Name**: `portfolio`
4. Click **Create**

### Step 4: Generate GitHub Personal Access Token

Since your repository is private, you need to authenticate:

1. Go to GitHub: https://github.com/settings/tokens
2. Click **"Generate new token"** → **"Generate new token (classic)"**
3. Give it a name: `cPanel Deployment`
4. Set expiration: `90 days` (or longer)
5. Check these permissions:
   - ✅ `repo` (Full control of private repositories)
6. Click **"Generate token"**
7. **Copy the token immediately** (you won't see it again!)

### Step 5: Pull Code to cPanel

1. Back in cPanel Git Version Control
2. Click **Manage** on your repository
3. Click **Pull or Deploy** tab
4. If asked for credentials:
   - Username: Your GitHub username
   - Password: Paste the token you copied
5. Click **Update from Remote**

The code is now on your server! 🎉

### Step 6: Configure Laravel

Now we need to set up Laravel properly. This requires some file editing in cPanel.

#### 6.1 Create .env File

1. In cPanel, go to **File Manager**
2. Navigate to `repositories/portfolio/`
3. Find `.env.example` file
4. Right-click → Copy
5. Name it `.env`
6. Right-click `.env` → Edit
7. Update these values:

```env
APP_NAME="Dev Cleon Portfolio"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=porty_prod
DB_USERNAME=porty_user
DB_PASSWORD=your-database-password-here

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

8. Click **Save Changes**

#### 6.2 Generate Application Key

You need to run some commands. In cPanel:

1. Search for **Terminal** (if available)
2. If Terminal is available:
   ```bash
   cd repositories/portfolio
   php artisan key:generate
   php artisan migrate --force
   php artisan storage:link
   ```

3. If NO Terminal:
   - Go to File Manager → `repositories/portfolio/.env`
   - For `APP_KEY=`, you need to generate one online
   - Go to: https://generate-random.org/laravel-key-generator
   - Copy the generated key
   - Paste it after `APP_KEY=` (should look like `APP_KEY=base64:...`)

#### 6.3 Run Migrations Manually

If you don't have Terminal access:

1. Download a tool like **Adminer** or use **phpMyAdmin** in cPanel
2. Import the database schema manually
3. Or upload a migration script

### Step 7: Point Domain to Laravel

#### 7.1 Copy Files to Public Directory

In cPanel File Manager:

1. Navigate to `repositories/portfolio/public/`
2. Select all files in `public/` folder
3. Right-click → Copy
4. Navigate to your website root (usually `public_html/`)
5. Paste files there

6. Create/Edit `.htaccess` in `public_html/`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

**OR** (Better approach):

#### 7.2 Change Document Root

1. In cPanel, find **Domains** or **Addon Domains**
2. Click on your domain
3. Change **Document Root** to: `repositories/portfolio/public`
4. Save

### Step 8: Set File Permissions

In File Manager:

1. Go to `repositories/portfolio/storage/`
2. Right-click → Change Permissions
3. Set to `755` or `775`
4. Check "Recurse into subdirectories"
5. Apply

6. Do the same for `bootstrap/cache/` folder

### Step 9: Test Your Website

Visit your domain: `https://yourdomain.com`

If you see your portfolio → Success! 🎉

---

## Method 2: Using FTP (If No Git in cPanel)

If your cPanel doesn't have Git tools:

### Step 1: Build Project Locally

On your computer:

```bash
cd /home/devcleon/porty

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Create deployment package
tar -czf portfolio-deploy.tar.gz \
  --exclude='.git' \
  --exclude='node_modules' \
  --exclude='.env' \
  --exclude='tests' \
  .
```

### Step 2: Upload via FTP

1. In cPanel, go to **File Manager**
2. Or use an FTP client like **FileZilla**
3. Get FTP credentials from cPanel (look for FTP Accounts)
4. Upload `portfolio-deploy.tar.gz` to a folder (e.g., `portfolio/`)
5. In File Manager, right-click the file → Extract
6. Delete the `.tar.gz` file

### Step 3: Follow Steps 6-9 from Method 1

Configure `.env`, set permissions, and point your domain.

---

## 🔄 Updating Your Site (After Initial Setup)

### Using Git Method

1. Make changes locally
2. Push to GitHub:
   ```bash
   git add .
   git commit -m "Update portfolio"
   git push origin main
   ```
3. In cPanel Git Version Control:
   - Click **Manage** on your repository
   - Click **Update from Remote**
4. Done! ✅

### Using FTP Method

1. Build locally (see Method 2, Step 1)
2. Upload files via FTP
3. Extract and replace

---

## 🔧 Troubleshooting

### Issue: 500 Internal Server Error

**Fix:**
1. Check `.env` file is configured correctly
2. Set proper file permissions on `storage/` and `bootstrap/cache/`
3. Make sure `APP_KEY` is set in `.env`

### Issue: Database Connection Error

**Fix:**
1. Verify database credentials in `.env`
2. Check database host (might be different from `localhost`)
3. Ensure database user has all privileges

### Issue: Blank Page

**Fix:**
1. Check if `public/index.php` exists
2. Verify Document Root points to `public/` folder
3. Check file permissions

### Issue: CSS/JS Not Loading

**Fix:**
1. Run `npm run build` before uploading
2. Make sure `public/build/` folder is uploaded
3. Check `.htaccess` file in public folder

---

## 📝 Quick Reference

### Database Info Template
```
DB_HOST=localhost (or from cPanel)
DB_DATABASE=your_cpanel_username_porty_prod
DB_USERNAME=your_cpanel_username_porty_user
DB_PASSWORD=your_password
```

### Common cPanel Paths
- Website root: `public_html/`
- Custom apps: `repositories/` or `laravel/`
- Logs: `public_html/storage/logs/`

---

## 💡 Tips

1. **Keep `.env` secure** - Never commit it to Git
2. **Regular backups** - Use cPanel backup tools
3. **Monitor errors** - Check `storage/logs/laravel.log`
4. **Use HTTPS** - Enable SSL in cPanel (usually free with Let's Encrypt)

---

## Need More Help?

Common cPanel providers documentation:
- **Hostinger**: Search "Git cPanel Hostinger"
- **Bluehost**: Search "Deploy Laravel Bluehost"
- **SiteGround**: Search "Git deployment SiteGround"
- **Namecheap**: Search "cPanel Git Namecheap"

Most have video tutorials specific to their platform!

---

Good luck with your deployment! 🚀

This method is much simpler than the server deployment because cPanel does most of the heavy lifting for you.
