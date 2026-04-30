<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New School Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .school-details {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .detail-row {
            margin-bottom: 10px;
        }
        .detail-label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            width: 120px;
        }
        .detail-value {
            color: #333;
        }
        .info-box {
            background-color: #e8f5e9;
            border-left: 4px solid #4caf50;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box p {
            margin: 5px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #e0e0e0;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
        .button:hover {
            background-color: #5a67d8;
        }
        @media only screen and (max-width: 480px) {
            .container {
                width: 100%;
                margin: 0;
                border-radius: 0;
            }
            .content {
                padding: 20px;
            }
            .detail-label {
                display: block;
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 New School Registration</h1>
            <p>A new school has registered on CoreDesk</p>
        </div>

        <div class="content">
            <h2>Hello Admin,</h2>
            <p>A new school has successfully registered on the CoreDesk platform. Below are the registration details:</p>

            <div class="school-details">
                <h3 style="margin-top: 0; color: #667eea;">School Information</h3>
                
                <div class="detail-row">
                    <span class="detail-label">School Name:</span>
                    <span class="detail-value"><strong>{{ $tenant->name }}</strong></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Subdomain:</span>
                    <span class="detail-value"><strong>{{ $tenant->subdomain }}.coredesk.local</strong></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Location:</span>
                    <span class="detail-value">{{ $tenant->location ?? 'Not provided' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value">{{ $tenant->phone ?? 'Not provided' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Plan:</span>
                    <span class="detail-value">{{ ucfirst($tenant->plan) }} (30-day trial)</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Expires:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($tenant->expires_at)->format('F j, Y') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Registered:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($tenant->created_at)->format('F j, Y g:i A') }}</span>
                </div>
            </div>

            <div class="school-details">
                <h3 style="margin-top: 0; color: #667eea;">Administrator Information</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Name:</span>
                    <span class="detail-value"><strong>{{ $user->name }}</strong></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $user->email }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Role:</span>
                    <span class="detail-value">Super Administrator</span>
                </div>
            </div>

            <div class="info-box">
                <p><strong>🔗 Access Links:</strong></p>
                <p>• School Portal: <a href="http://{{ $tenant->subdomain }}.coredesk.local:8000">http://{{ $tenant->subdomain }}.coredesk.local:8000</a></p>
                <p>• Admin Login: <a href="http://{{ $tenant->subdomain }}.coredesk.local:8000/login">http://{{ $tenant->subdomain }}.coredesk.local:8000/login</a></p>
                <p>• Owner Dashboard: <a href="http://coredesk.local:8000/owner/dashboard">http://coredesk.local:8000/owner/dashboard</a></p>
            </div>

            <p style="margin-top: 20px;">
                <a href="http://coredesk.local:8000/owner/dashboard" class="button">
                    View in Owner Dashboard →
                </a>
            </p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} CoreDesk. All rights reserved.</p>
            <p>This is an automated notification. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>