<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Expired - Account Deactivated</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #dc2626, #991b1b); color: white; padding: 30px; text-align: center; }
        .content { padding: 30px; background: #f8fafc; }
        .expired-box { background: #fee2e2; border-left: 4px solid #dc2626; padding: 15px; margin: 20px 0; border-radius: 8px; }
        .button { display: inline-block; padding: 12px 24px; background: #1e3a5f; color: white; text-decoration: none; border-radius: 5px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; border-top: 1px solid #e2e8f0; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>❌ Subscription Expired - Account Deactivated</h2>
        </div>
        <div class="content">
            <h3>Hello {{ $adminName }},</h3>
            
            <div class="expired-box">
                <p><strong>Your subscription for {{ $schoolName }} has expired!</strong></p>
                <p><strong>Expired on:</strong> {{ $expiresAt->format('F j, Y') }}</p>
                <p><strong>Previous Plan:</strong> {{ ucfirst($plan) }}</p>
            </div>
            
            <p>Your school portal has been deactivated. To restore access, please contact your school owner to renew the subscription.</p>
            
            <p>All your data remains safe and will be restored upon renewal.</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} CoreDesk. All rights reserved.</p>
        </div>
    </div>
</body>
</html>