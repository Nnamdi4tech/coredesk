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
        .button { display: inline-block; padding: 12px 24px; background: #dc2626; color: white; text-decoration: none; border-radius: 5px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; border-top: 1px solid #e2e8f0; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>❌ School Subscription Expired - Account Deactivated</h2>
        </div>
        <div class="content">
            <div class="expired-box">
                <p><strong>A school subscription has expired and their account has been deactivated!</strong></p>
                <p><strong>School Name:</strong> {{ $schoolName }}</p>
                <p><strong>Subdomain:</strong> {{ $subdomain }}.coredesk.local</p>
                <p><strong>Admin Name:</strong> {{ $adminName }}</p>
                <p><strong>Admin Email:</strong> {{ $adminEmail }}</p>
                <p><strong>Previous Plan:</strong> {{ ucfirst($plan) }}</p>
                <p><strong>Expired on:</strong> {{ $expiresAt->format('F j, Y') }}</p>
            </div>
            
            <p>The school portal has been deactivated. To restore access, please renew their subscription.</p>
            
            <p style="margin-top: 30px;">
                <a href="{{ $ownerDashboardUrl }}" class="button">Go to Owner Dashboard to Renew</a>
            </p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} CoreDesk. All rights reserved.</p>
        </div>
    </div>
</body>
</html>