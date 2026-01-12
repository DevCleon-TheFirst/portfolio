---
description: Quick start checklist for GitHub Actions deployment
---

# GitHub Actions Deployment - Quick Start Checklist

Use this checklist to set up deployment in order. For detailed instructions, see `github-actions-deployment.md`.

## ✅ Pre-Deployment Checklist

### Server Setup
- [ ] SSH access to server confirmed
- [ ] Created `/var/www/porty` directory
- [ ] Created `/var/www/backups/porty` directory
- [ ] Set correct ownership (`chown -R $USER:www-data /var/www/porty`)
- [ ] Database created and user configured
- [ ] Production `.env` file created in `/var/www/porty/.env`

### SSH Key Setup
- [ ] Generated SSH key pair on server: `ssh-keygen -t rsa -b 4096 -C "github-actions-deploy" -f ~/.ssh/github_deploy_key -N ""`
- [ ] Added public key to authorized_keys: `cat ~/.ssh/github_deploy_key.pub >> ~/.ssh/authorized_keys`
- [ ] Copied private key content: `cat ~/.ssh/github_deploy_key`

### GitHub Repository
- [ ] GitHub repository created
- [ ] Local git initialized and connected: `git remote add origin <url>`
- [ ] Initial push completed: `git push -u origin main`

### GitHub Secrets (Settings → Secrets → Actions)
- [ ] `SSH_HOST` - Server IP or domain
- [ ] `SSH_USERNAME` - SSH username
- [ ] `SSH_PORT` - SSH port (usually 22)
- [ ] `SSH_PRIVATE_KEY` - Full private key from server
- [ ] `DEPLOY_PATH` - `/var/www/porty`
- [ ] `BACKUP_PATH` - `/var/www/backups/porty`

### Web Server Configuration
- [ ] Nginx/Apache configured to serve `/var/www/porty/public`
- [ ] Site enabled and web server reloaded
- [ ] SSL certificate installed (recommended)

## 🚀 First Deployment

```bash
# Make a test change
echo "# Dev Cleon Portfolio" > README.md
git add README.md
git commit -m "Test deployment"
git push origin main
```

Then check GitHub Actions tab to monitor deployment.

## 📝 Daily Usage

Every time you want to deploy:

```bash
git add .
git commit -m "Your change description"
git push origin main
```

GitHub Actions automatically deploys to your server!

## 🔧 Quick Server Commands

```bash
# Check Laravel logs
ssh user@server
cd /var/www/porty
tail -f storage/logs/laravel.log

# Fix permissions
sudo chown -R $USER:www-data .
sudo chmod -R 775 storage bootstrap/cache

# Clear cache manually
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## 🆘 Common Issues

| Problem | Solution |
|---------|----------|
| SSH connection failed | Check secrets: `SSH_HOST`, `SSH_USERNAME`, `SSH_PORT` |
| Permission denied | Run: `sudo chmod -R 775 storage bootstrap/cache` |
| 500 error | Check: `tail -f storage/logs/laravel.log` |
| Assets 404 | Verify `public/build` exists and web server config |

## 📚 Full Guide

For complete step-by-step instructions, see: [github-actions-deployment.md](file:///home/devcleon/porty/.agent/workflows/github-actions-deployment.md)
