<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Message</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 600px; background: #ffffff; border-radius: 12px; overflow: hidden; padding: 25px; margin: 0 auto; border: 1px solid #e2e8f0; }
        .header { background: #0A4744; color: #ffffff; padding: 20px; text-align: center; border-radius: 8px; }
        .header h2 { margin: 0; }
        .content { margin-top: 20px; font-size: 14px; }
        .footer { text-align: center; font-size: 12px; color: #64748b; margin-top: 25px; border-top: 1px solid #e2e8f0; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Petchemparts - New Contact Inquiry</h2>
        </div>
        <div class="content">
            <p><strong>From:</strong> {{ $contactMessage->name }} ({{ $contactMessage->email }})</p>
            <p><strong>Phone:</strong> {{ $contactMessage->phone ?? 'N/A' }}</p>
            <p><strong>Subject:</strong> {{ $contactMessage->subject }}</p>
            <p><strong>Message:</strong></p>
            <div style="background: #f8fafc; padding: 15px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 13px;">
                {!! nl2br(e($contactMessage->message)) !!}
            </div>
        </div>
        <div class="footer">
            <p>Sent to sales@petchemparts.com via Petchemparts Website Contact Form.</p>
        </div>
    </div>
</body>
</html>
