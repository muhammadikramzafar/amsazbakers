<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>New Contact Message</title>
<style>
  body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
  .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
  .header { background: #8B1A1A; color: #fff; padding: 24px 32px; }
  .header h1 { margin: 0; font-size: 22px; }
  .body { padding: 32px; }
  .field { margin-bottom: 20px; }
  .label { font-size: 12px; text-transform: uppercase; color: #888; letter-spacing: .5px; margin-bottom: 4px; }
  .value { font-size: 15px; color: #333; }
  .message-box { background: #f9f9f9; border-left: 4px solid #8B1A1A; padding: 16px; border-radius: 4px; margin-top: 8px; }
  .footer { background: #f5f5f5; padding: 16px 32px; font-size: 12px; color: #999; text-align: center; }
  .btn { display: inline-block; background: #8B1A1A; color: #fff; padding: 12px 24px; border-radius: 4px; text-decoration: none; margin-top: 20px; }
</style>
</head>
<body>
<div class="container">
  <div class="header">
    <h1>New Contact Message</h1>
    <p style="margin:4px 0 0;opacity:.8;font-size:13px;">{{ config('app.name') }} — {{ now()->format('d M Y, h:i A') }}</p>
  </div>
  <div class="body">
    <div class="field">
      <div class="label">From</div>
      <div class="value">{{ $contactMessage->name }}</div>
    </div>
    <div class="field">
      <div class="label">Email</div>
      <div class="value"><a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></div>
    </div>
    @if($contactMessage->phone)
    <div class="field">
      <div class="label">Phone</div>
      <div class="value">{{ $contactMessage->phone }}</div>
    </div>
    @endif
    @if($contactMessage->subject)
    <div class="field">
      <div class="label">Subject</div>
      <div class="value">{{ $contactMessage->subject }}</div>
    </div>
    @endif
    <div class="field">
      <div class="label">Message</div>
      <div class="message-box">{{ $contactMessage->message }}</div>
    </div>
    <a href="{{ route('admin.contacts.index') }}" class="btn">View in Admin Panel</a>
  </div>
  <div class="footer">This email was sent automatically from the {{ config('app.name') }} website contact form.</div>
</div>
</body>
</html>
