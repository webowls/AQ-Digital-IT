<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Contact Message</title>
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
      background: linear-gradient(135deg, #1a1a2e 0%, #2d2d5a 100%);
      padding: 32px 40px;
    }

    .header .badge {
      display: inline-block;
      background: #4f46e5;
      color: #fff;
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      padding: 4px 12px;
      border-radius: 50px;
      margin-bottom: 12px;
    }

    .header h1 {
      margin: 0;
      font-size: 1.25rem;
      font-weight: 700;
      color: #ffffff;
    }

    .body {
      padding: 36px 40px;
    }

    .meta-grid {
      display: grid;
      grid-template-columns: 120px 1fr;
      gap: 0;
      margin-bottom: 28px;
      border: 1px solid #eeeef5;
      border-radius: 8px;
      overflow: hidden;
    }

    .meta-row {
      display: contents;
    }

    .meta-row .key {
      background: #f8f9ff;
      padding: 10px 14px;
      font-size: 0.85rem;
      font-weight: 600;
      color: #4f46e5;
      border-bottom: 1px solid #eeeef5;
    }

    .meta-row .val {
      background: #ffffff;
      padding: 10px 14px;
      font-size: 0.85rem;
      color: #3a3a5a;
      border-bottom: 1px solid #eeeef5;
    }

    .meta-row:last-child .key,
    .meta-row:last-child .val {
      border-bottom: none;
    }

    .section-label {
      font-size: 0.82rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: #9090aa;
      margin-bottom: 10px;
    }

    .message-box {
      background: #f8f9ff;
      border: 1px solid #e8e8f5;
      border-radius: 8px;
      padding: 18px 20px;
      font-size: 0.9rem;
      color: #3a3a5a;
      line-height: 1.7;
      white-space: pre-wrap;
    }

    .footer {
      background: #f8f9ff;
      padding: 20px 40px;
      text-align: center;
      font-size: 0.82rem;
      color: #9090aa;
      border-top: 1px solid #eeeef5;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="header">
      <div class="badge">New Inquiry</div>
      <h1>Contact Form Submission</h1>
    </div>
    <div class="body">

      <div class="meta-grid">
        <div class="meta-row">
          <div class="key">Name</div>
          <div class="val">{{ $contactData['name'] }}</div>
        </div>
        <div class="meta-row">
          <div class="key">Email</div>
          <div class="val">{{ $contactData['email'] }}</div>
        </div>
        <div class="meta-row">
          <div class="key">Subject</div>
          <div class="val">{{ $contactData['subject'] }}</div>
        </div>
        <div class="meta-row">
          <div class="key">Received</div>
          <div class="val">{{ now()->format('M d, Y \a\t h:i A') }}</div>
        </div>
      </div>

      <div class="section-label">Message</div>
      <div class="message-box">{{ $contactData['message'] }}</div>

    </div>
    <div class="footer">
      {{ $appName }} — Internal Notification &bull; Do not forward this email.
    </div>
  </div>
</body>

</html>