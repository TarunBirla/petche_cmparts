<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to Petchemparts</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 600px; background: #ffffff; border-radius: 12px; overflow: hidden; padding: 25px; margin: 0 auto; border: 1px solid #e2e8f0; }
        .header { background: #0A4744; color: #ffffff; padding: 20px; text-align: center; border-radius: 8px; }
        .header h2 { margin: 0; }
        .content { margin-top: 20px; font-size: 14px; leading-height: 1.6; }
        .footer { text-align: center; font-size: 12px; color: #64748b; margin-top: 25px; border-top: 1px solid #e2e8f0; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Welcome to Petchemparts</h2>
        </div>
        <div class="content">
            <p>Hello <strong>{{ $user->name }}</strong>,</p>
            <p>Thank you for registering an account on Petchemparts! Your account has been created successfully.</p>
            <p><strong>Account Details:</strong></p>
            <ul>
                <li><strong>Name:</strong> {{ $user->name }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</li>
                <li><strong>Company:</strong> {{ $user->company_name ?? 'N/A' }}</li>
            </ul>
            <p>You can now log in anytime to build equipment quote lists, request instant quotations, and track inquiry status.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Petchemparts UK. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
