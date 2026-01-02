# Email Configuration Guide

## Quick Setup

Your email notification system is ready! Now you need to configure your mail settings in the `.env` file.

## Option 1: Mailtrap (Recommended for Testing)

Mailtrap is perfect for testing emails without sending real emails.

1. Sign up at [mailtrap.io](https://mailtrap.io) (free)
2. Get your SMTP credentials from the inbox
3. Add to `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@devcleon.site"
MAIL_FROM_NAME="DevCleon Portfolio"
```

## Option 2: Gmail

1. Enable 2-Step Verification in your Google Account
2. Generate an App Password: [myaccount.google.com/apppasswords](https://myaccount.google.com/apppasswords)
3. Add to `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-16-char-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="DevCleon Portfolio"
```

## Option 3: Mailgun

1. Sign up at [mailgun.com](https://www.mailgun.com)
2. Verify your domain
3. Get API credentials
4. Add to `.env`:

```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your-domain.com
MAILGUN_SECRET=your-api-key
MAIL_FROM_ADDRESS="noreply@your-domain.com"
MAIL_FROM_NAME="DevCleon Portfolio"
```

## Testing

After configuring, test by submitting the contact form:

```bash
# Clear config cache
php artisan config:clear

# Test email (optional)
php artisan tinker
>>> Mail::raw('Test email', function($msg) { $msg->to('hello@devcleon.site')->subject('Test'); });
```

## Troubleshooting

- **"Connection refused"**: Check MAIL_HOST and MAIL_PORT
- **"Authentication failed"**: Verify MAIL_USERNAME and MAIL_PASSWORD
- **No email received**: Check spam folder, verify MAIL_FROM_ADDRESS
- **SSL errors**: Try changing MAIL_ENCRYPTION from 'tls' to 'ssl' or vice versa
