<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>New Job Application</title>
<style>
  body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
  .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
  .header { background: #8B1A1A; color: #fff; padding: 24px 32px; }
  .header h1 { margin: 0; font-size: 22px; }
  .body { padding: 32px; }
  .field { margin-bottom: 20px; }
  .label { font-size: 12px; text-transform: uppercase; color: #888; letter-spacing: .5px; margin-bottom: 4px; }
  .value { font-size: 15px; color: #333; }
  .badge { display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 12px; background: #e8f5e9; color: #2e7d32; }
  .cover-box { background: #f9f9f9; border-left: 4px solid #8B1A1A; padding: 16px; border-radius: 4px; margin-top: 8px; }
  .footer { background: #f5f5f5; padding: 16px 32px; font-size: 12px; color: #999; text-align: center; }
  .btn { display: inline-block; background: #8B1A1A; color: #fff; padding: 12px 24px; border-radius: 4px; text-decoration: none; margin-top: 20px; }
</style>
</head>
<body>
<div class="container">
  <div class="header">
    <h1>New Job Application</h1>
    <p style="margin:4px 0 0;opacity:.8;font-size:13px;">{{ config('app.name') }} — {{ now()->format('d M Y, h:i A') }}</p>
  </div>
  <div class="body">
    <div class="field">
      <div class="label">Position</div>
      <div class="value" style="font-size:18px;font-weight:bold;">{{ $application->job->title }}</div>
    </div>
    <div class="field">
      <div class="label">Applicant</div>
      <div class="value">{{ $application->full_name }}</div>
    </div>
    <div class="field">
      <div class="label">Email</div>
      <div class="value"><a href="mailto:{{ $application->email }}">{{ $application->email }}</a></div>
    </div>
    @if($application->phone)
    <div class="field">
      <div class="label">Phone</div>
      <div class="value">{{ $application->phone }}</div>
    </div>
    @endif
    @if($application->cover_letter)
    <div class="field">
      <div class="label">Cover Letter</div>
      <div class="cover-box">{{ Str::limit($application->cover_letter, 400) }}</div>
    </div>
    @endif
    <a href="{{ route('admin.careers.applications.show', $application->id) }}" class="btn">Review Application</a>
  </div>
  <div class="footer">This email was sent automatically when a new application was submitted on {{ config('app.name') }}.</div>
</div>
</body>
</html>
