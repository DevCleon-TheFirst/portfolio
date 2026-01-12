# Cron Job Setup for Scheduled Blog Posts

## 🔄 Queue Worker Setup (Required for Scheduled Posts)

Your scheduled blog posts feature requires a cron job to check and publish posts at their scheduled time.

---

## **Setup Cron Job in Namecheap cPanel**

### **Step 1: Login to cPanel**
1. Go to Namecheap Dashboard
2. Navigate to your hosting cPanel

### **Step 2: Open Cron Jobs**
1. Search for **"Cron Jobs"**
2. Click on **"Cron Jobs"**

### **Step 3: Add New Cron Job**

#### **Common Settings:**
Select **"Common Settings"**: `* * * * *` (Every Minute)

Or manually set:
- **Minute:** `*`
- **Hour:** `*`
- **Day:** `*`
- **Month:** `*`
- **Weekday:** `*`

#### **Command:**
Replace `username` with your actual cPanel username:

```bash
cd /home/username/public_html && /usr/local/bin/php artisan schedule:run >> /dev/null 2>&1
```

**Example:**
```bash
cd /home/devcicde/public_html && /usr/local/bin/php artisan schedule:run >> /dev/null 2>&1
```

### **Step 4: Click "Add New Cron Job"**

---

## **What This Does**

- ✅ Runs every minute
- ✅ Checks for scheduled blog posts
- ✅ Publishes posts at their scheduled time
- ✅ Runs Laravel's task scheduler

---

## **Verify It's Working**

### **Method 1: Check Cron Emails**
- cPanel sends email notifications for cron job outputs
- Check your email for confirmation

### **Method 2: Schedule a Test Post**
1. Login to your dashboard
2. Create a blog post
3. Set status to "Scheduled"
4. Set publish date to 2 minutes from now
5. Wait and refresh - should auto-publish!

### **Method 3: Check Cron Logs**
In cPanel:
1. Go to **Cron Jobs**
2. Scroll to **"Current Cron Jobs"**
3. Check **"Last Run"** timestamp - should update every minute

---

## **Alternative: If php is in Different Location**

If the command doesn't work, try these alternatives:

```bash
# Alternative 1: Use php binary
cd /home/username/public_html && php artisan schedule:run >> /dev/null 2>&1

# Alternative 2: Use specific PHP version
cd /home/username/public_html && /opt/cpanel/ea-php82/root/usr/bin/php artisan schedule:run >> /dev/null 2>&1

# Alternative 3: With full path
cd /home/username/public_html && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
```

To find PHP path on your server:
1. cPanel → **Terminal** (if available)
2. Run: `which php`
3. Use that path in your cron command

---

## **Troubleshooting**

### **Issue: Cron job not running**
**Check:**
- Path to public_html is correct
- PHP path is correct (`which php`)
- Permissions on artisan file: `chmod +x artisan`

### **Issue: Posts not publishing**
**Check:**
1. Cron job is running (check Last Run time)
2. Database connection works
3. Post status is "scheduled"
4. Scheduled time has passed

### **Issue: Getting error emails**
**Fix:**
- Add `>> /dev/null 2>&1` to suppress output
- Or review errors to fix issues

---

## **Your Scheduled Posts Commands**

Located in: `app/Console/Kernel.php`

```php
protected function schedule(Schedule $schedule)
{
    // Publish scheduled blog posts every minute
    $schedule->command('posts:publish-scheduled')->everyMinute();
}
```

Command file: `app/Console/Commands/PublishScheduledPosts.php`

---

## ✅ **Setup Checklist**

- [ ] Cron job created in cPanel
- [ ] Set to run every minute (`* * * * *`)
- [ ] Correct path to public_html
- [ ] Correct PHP binary path
- [ ] Test with a scheduled post
- [ ] Verify auto-publishing works

---

**After setting this up, your scheduled blog posts will automatically publish at their scheduled time!** 🎉
