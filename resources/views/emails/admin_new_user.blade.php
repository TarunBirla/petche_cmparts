<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Customer Registered</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 600px; background: #ffffff; border-radius: 12px; overflow: hidden; padding: 25px; margin: 0 auto; border: 1px solid #e2e8f0; }
        .header { background: #0F6B66; color: #ffffff; padding: 20px; text-align: center; border-radius: 8px; }
        .header h2 { margin: 0; }
        .content { margin-top: 20px; font-size: 14px; }
        .footer { text-align: center; font-size: 12px; color: #64748b; margin-top: 25px; border-top: 1px solid #e2e8f0; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Petchemparts Admin Alert</h2>
            <p style="margin:5px 0 0 0;">New Customer Registration</p>
        </div>
        <div class="content">
            <p>A new customer account has been registered on Petchemparts:</p>
            <table style="width:100%; border-collapse:collapse; margin-top:10px;">
                <tr><td style="padding:8px; border:1px solid #ddd; font-weight:bold;">Name:</td><td style="padding:8px; border:1px solid #ddd;">{{ $user->name }}</td></tr>
                <tr><td style="padding:8px; border:1px solid #ddd; font-weight:bold;">Email:</td><td style="padding:8px; border:1px solid #ddd;">{{ $user->email }}</td></tr>
                <tr><td style="padding:8px; border:1px solid #ddd; font-weight:bold;">Phone:</td><td style="padding:8px; border:1px solid #ddd;">{{ $user->phone ?? 'N/A' }}</td></tr>
                <tr><td style="padding:8px; border:1px solid #ddd; font-weight:bold;">Company:</td><td style="padding:8px; border:1px solid #ddd;">{{ $user->company_name ?? 'N/A' }}</td></tr>
                <tr><td style="padding:8px; border:1px solid #ddd; font-weight:bold;">Registered Date:</td><td style="padding:8px; border:1px solid #ddd;">{{ $user->created_at ? $user->created_at->format('d M Y, h:i A') : date('d M Y') }}</td></tr>
            </table>
        </div>
        <div class="footer">
            <p>This notification was automatically sent to sales@petchemparts.com.</p>
        </div>
    </div>
</body>
</html>
