<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>We received your message</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: #f4f6f9;
      font-family: 'Segoe UI', Arial, sans-serif;
      color: #1a1a2e;
    }

    .wrapper {
      max-width: 580px;
      margin: 40px auto;
      background: #ffffff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
    }

    .header {
      background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
      padding: 40px 40px 32px;
      text-align: center;
    }

    .header .logo {
      font-size: 1.5rem;
      font-weight: 800;
      color: #ffffff;
      letter-spacing: -0.02em;
    }

    .header .logo span {
      opacity: 0.75;
    }

    .body {
      padding: 40px;
    }

    .greeting {
      font-size: 1.15rem;
      font-weight: 600;
      margin-bottom: 12px;
      color: #1a1a2e;
    }

    .text {
      font-size: 0.95rem;
      line-height: 1.7;
      color: #4a4a6a;
      margin-bottom: 24px;
    }

    .card {
      background: #f8f9ff;
      border: 1px solid #e8e8f5;
      border-radius: 8px;
      padding: 20px 24px;
      margin-bottom: 28px;
    }

    .card-row {
      display: flex;
      gap: 8px;
      margin-bottom: 10px;
      font-size: 0.9rem;
    }

    .card-row:last-child {
      margin-bottom: 0;
    }

    .label {
      font-weight: 600;
      color: #4f46e5;
      min-width: 80px;
      flex-shrink: 0;
    }

    .value {
      color: #3a3a5a;
    }

    .message-box {
      background: #f8f9ff;
      border-left: 3px solid #4f46e5;
      border-radius: 4px;
      padding: 14px 18px;
      font-size: 0.9rem;
      color: #3a3a5a;
      line-height: 1.65;
      margin-bottom: 28px;
      white-space: pre-wrap;
    }

    .footer {
      background: #f8f9ff;
      padding: 24px 40px;
      text-align: center;
      font-size: 0.82rem;
      color: #9090aa;
      border-top: 1px solid #eeeef5;
    }

    .footer a {
      color: #4f46e5;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="header">
      <div class="logo">{{ $appName }}</div>
    </div>
    <div class="body">
      <p class="greeting">Hi {{ $contactData['name'] }},</p>
      <p class="text">
        Thank you for reaching out! We've received your message and will get back to you as soon as possible — usually within 1–2 business days.
      </p>

      <div class="card">
        <div class="card-row">
          <span class="label">Subject</span>
          <span class="value">{{ $contactData['subject'] }}</span>
        </div>
        <div class="card-row">
          <span class="label">Submitted</span>
          <span class="value">{{ now()->format('M d, Y \a\t h:i A') }}</span>
        </div>
      </div>

      <p style="font-size:0.88rem;font-weight:600;color:#4a4a6a;margin-bottom:8px;">Your message:</p>
      <div class="message-box">{{ $contactData['message'] }}</div>

      <p class="text" style="margin-bottom:0;">
        In the meantime, feel free to browse our work or reach out directly if anything is urgent.
      </p>
    </div>
    <div class="footer">
      &copy; {{ date('Y') }} {{ $appName }}. All rights reserved.<br>
      This is an automated confirmation — please do not reply to this email.
    </div>
  </div>
</body>

</html>