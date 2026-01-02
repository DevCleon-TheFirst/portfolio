<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #3b82f6 0%, #881337 100%);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            margin: -30px -30px 30px -30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .field {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        .field:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: 600;
            color: #6b7280;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .value {
            color: #1f2937;
            font-size: 16px;
        }
        .message-content {
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #3b82f6;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
        .reply-button {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6 0%, #881337 100%);
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
            font-weight: 600;
        }
        .timestamp {
            color: #9ca3af;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📬 New Contact Form Submission</h1>
        </div>

        <div class="field">
            <div class="label">From</div>
            <div class="value">{{ $contactMessage->name }}</div>
        </div>

        <div class="field">
            <div class="label">Email</div>
            <div class="value">
                <a href="mailto:{{ $contactMessage->email }}" style="color: #3b82f6; text-decoration: none;">
                    {{ $contactMessage->email }}
                </a>
            </div>
        </div>

        <div class="field">
            <div class="label">Subject</div>
            <div class="value">{{ $contactMessage->subject }}</div>
        </div>

        <div class="field">
            <div class="label">Message</div>
            <div class="message-content">{{ $contactMessage->message }}</div>
        </div>

        <div class="timestamp">
            Received: {{ $contactMessage->created_at->format('F j, Y \a\t g:i A') }}
        </div>

        <center>
            <a href="mailto:{{ $contactMessage->email }}?subject=Re: {{ $contactMessage->subject }}" class="reply-button">
                Reply to {{ $contactMessage->name }}
            </a>
        </center>

        <div class="footer">
            <p>This message was sent via the contact form on <strong>DevCleon Portfolio</strong></p>
            <p>You can view all messages in your <a href="{{ url('/dashboard/contact-messages') }}" style="color: #3b82f6;">dashboard</a></p>
        </div>
    </div>
</body>
</html>
