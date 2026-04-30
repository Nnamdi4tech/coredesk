<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Expiring Soon</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 30px; text-align: center; }
        .content { padding: 30px; background: #f8fafc; }
        .warning-box { background: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; margin: 20px 0; border-radius: 8px; }
        .info-box { background: #dbeafe; border-left: 4px solid #3b82f6; padding: 15px; margin: 20px 0; border-radius: 8px; }
        .button { display: inline-block; padding: 12px 24px; background: #1e3a5f; color: white; text-decoration: none; border-radius: 5px; }
        .button-owner { background: #dc2626; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; border-top: 1px solid #e2e8f0; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>⚠️ Subscription Expiring in {{ $daysLeft }} Days</h2>
        </div>
        <div class="content">
            <h3>Hello {{ $adminName }},</h3>
            
            <div class="warning-box">
                <p><strong>Your subscription for {{ $schoolName }} will expire in {{ $daysLeft }} days!</strong></p>
                <p><strong>Expiry Date:</strong> {{ $expiresAt->format('F j, Y') }}</p>
                <p><strong>Current Plan:</strong> {{ ucfirst($plan) }}</p>
            </div>
            
            <p>To avoid service interruption, please contact your school owner to renew the subscription.</p>
            
            <div class="info-box">
                <p><strong>What happens after expiry?</strong></p>
                <ul>
                    <li>Your school portal will be deactivated</li>
                    <li>Students and teachers won't be able to access the platform</li>
                    <li>Your data will remain safe but inaccessible until renewal</li>
                </ul>
            </div>
            
            <p>Need help? Contact CoreDesk support.</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} CoreDesk. All rights reserved.</p>
        </div>
    </div>
</body>
</html>