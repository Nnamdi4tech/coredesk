<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CheckTenantStatus
{
   public function handle(Request $request, Closure $next)
{
    $subdomain = $request->route('subdomain');

    if (!$subdomain || $request->is('owner/*') || $request->is('/')) {
        return $next($request);
    }

    $tenant = Tenant::where('subdomain', $subdomain)->first();

    if (!$tenant) {
        return response($this->getTenantNotFoundPage(), 404);
    }

    // ❌ Inactive — show suspension page
    if (!$tenant->is_active) {
        return response($this->getInactivePage(), 403)
            ->header('Content-Type', 'text/html');
    }

    // ❌ Expired (only for paid plans)
    if ($tenant->plan !== 'free' && $tenant->expires_at) {
        if (Carbon::now()->gt($tenant->expires_at)) {
            return response($this->getExpiredPage(), 403)
                ->header('Content-Type', 'text/html');
        }
    }

    return $next($request);
}


    private function getInactivePage()
    {
        return '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Account Deactivated - CoreDesk</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body {
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 20px;
                }
                .card {
                    background: white;
                    border-radius: 24px;
                    padding: 48px 40px;
                    max-width: 480px;
                    width: 100%;
                    text-align: center;
                    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
                    animation: fadeIn 0.5s ease;
                }
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .icon-wrap {
                    width: 80px;
                    height: 80px;
                    border-radius: 20px;
                    background: linear-gradient(135deg, #ff416c, #ff4b2b);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin: 0 auto 24px;
                    box-shadow: 0 10px 30px rgba(255,65,108,0.3);
                }
                .icon-wrap i { color: white; font-size: 36px; }
                h1 {
                    font-size: 24px;
                    font-weight: 700;
                    color: #1e293b;
                    margin-bottom: 12px;
                }
                p {
                    font-size: 15px;
                    color: #64748b;
                    line-height: 1.7;
                    margin-bottom: 8px;
                }
                .divider {
                    height: 1px;
                    background: #f1f5f9;
                    margin: 24px 0;
                }
                .contact-box {
                    background: #f8fafc;
                    border-radius: 12px;
                    padding: 16px 20px;
                    margin-top: 8px;
                }
                .contact-box p {
                    font-size: 13px;
                    color: #475569;
                    margin-bottom: 4px;
                }
                .contact-box a {
                    font-size: 15px;
                    font-weight: 700;
                    color: #3b82f6;
                    text-decoration: none;
                }
                .contact-box a:hover { text-decoration: underline; }
                .badge {
                    display: inline-block;
                    background: #fef2f2;
                    color: #ef4444;
                    font-size: 11px;
                    font-weight: 600;
                    padding: 4px 12px;
                    border-radius: 20px;
                    margin-bottom: 20px;
                    border: 1px solid #fecaca;
                }
                .btn-home {
                    display: inline-block;
                    margin-top: 20px;
                    padding: 12px 24px;
                    background: linear-gradient(135deg, #667eea, #764ba2);
                    color: white;
                    text-decoration: none;
                    border-radius: 8px;
                    font-weight: 600;
                    font-size: 14px;
                    transition: transform 0.2s;
                }
                .btn-home:hover {
                    transform: translateY(-2px);
                }
            </style>
        </head>
        <body>
            <div class="card">
                <div class="icon-wrap">
                    <i class="fa fa-ban"></i>
                </div>
                <span class="badge"><i class="fa fa-circle" style="font-size:7px; margin-right:5px;"></i> Account Deactivated</span>
                <h1>Access Suspended</h1>
                <p>This school account has been deactivated and is currently inaccessible.</p>
                <p>Please contact your school administrator or CoreDesk support for assistance.</p>
                <div class="divider"></div>
                <div class="contact-box">
                    <p><i class="fa fa-headset" style="margin-right:6px; color:#3b82f6;"></i> Contact CoreDesk Support</p>
                    <a href="mailto:hammocktechglobal@gmail.com">hammocktechglobal@gmail.com</a>
                    <a href="tel:+2348137159867" style="display: block; margin-top: 5px;">+234 813 715 9867</a>
                </div>
                <a href="http://coredesk.local:8000" class="btn-home">
                    <i class="fa fa-home"></i> Return to Home
                </a>
            </div>
        </body>
        </html>';
    }

    private function getExpiredPage()
    {
        return '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Subscription Expired - CoreDesk</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body {
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 20px;
                }
                .card {
                    background: white;
                    border-radius: 24px;
                    padding: 48px 40px;
                    max-width: 480px;
                    width: 100%;
                    text-align: center;
                    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
                    animation: fadeIn 0.5s ease;
                }
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .icon-wrap {
                    width: 80px;
                    height: 80px;
                    border-radius: 20px;
                    background: linear-gradient(135deg, #f59e0b, #d97706);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin: 0 auto 24px;
                    box-shadow: 0 10px 30px rgba(245,158,11,0.3);
                }
                .icon-wrap i { color: white; font-size: 36px; }
                h1 { font-size: 24px; font-weight: 700; color: #1e293b; margin-bottom: 12px; }
                p { font-size: 15px; color: #64748b; line-height: 1.7; margin-bottom: 8px; }
                .divider { height: 1px; background: #f1f5f9; margin: 24px 0; }
                .contact-box {
                    background: #f8fafc;
                    border-radius: 12px;
                    padding: 16px 20px;
                    margin-top: 8px;
                }
                .contact-box p { font-size: 13px; color: #475569; margin-bottom: 4px; }
                .contact-box a { font-size: 15px; font-weight: 700; color: #3b82f6; text-decoration: none; }
                .badge {
                    display: inline-block;
                    background: #fffbeb;
                    color: #d97706;
                    font-size: 11px;
                    font-weight: 600;
                    padding: 4px 12px;
                    border-radius: 20px;
                    margin-bottom: 20px;
                    border: 1px solid #fde68a;
                }
                .btn-home {
                    display: inline-block;
                    margin-top: 20px;
                    padding: 12px 24px;
                    background: linear-gradient(135deg, #667eea, #764ba2);
                    color: white;
                    text-decoration: none;
                    border-radius: 8px;
                    font-weight: 600;
                    font-size: 14px;
                    transition: transform 0.2s;
                }
                .btn-home:hover {
                    transform: translateY(-2px);
                }
            </style>
        </head>
        <body>
            <div class="card">
                <div class="icon-wrap">
                    <i class="fa fa-clock"></i>
                </div>
                <span class="badge"><i class="fa fa-circle" style="font-size:7px; margin-right:5px;"></i> Subscription Expired</span>
                <h1>Subscription Expired</h1>
                <p>Your subscription plan has ended. Please contact CoreDesk support to renew and restore access.</p>
                <div class="divider"></div>
                <div class="contact-box">
                    <p><i class="fa fa-headset" style="margin-right:6px; color:#3b82f6;"></i> Contact CoreDesk Support</p>
                    <a href="mailto:hammocktechglobal@gmail.com">hammocktechglobal@gmail.com</a>
                    <a href="tel:+2348137159867" style="display: block; margin-top: 5px;">+234 813 715 9867</a>
                </div>
                <a href="http://coredesk.local:8000" class="btn-home">
                    <i class="fa fa-home"></i> Return to Home
                </a>
            </div>
        </body>
        </html>';
    }

    public static function getInactivePageStatic()
{
    return (new self)->getInactivePage();
}

private function getTenantNotFoundPage()
{
    return '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>School Not Found - CoreDesk</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }
            .card {
                background: white;
                border-radius: 24px;
                padding: 48px 40px;
                max-width: 480px;
                width: 100%;
                text-align: center;
                box-shadow: 0 20px 60px rgba(0,0,0,0.2);
                animation: fadeIn 0.5s ease;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .icon-wrap {
                width: 80px;
                height: 80px;
                border-radius: 20px;
                background: linear-gradient(135deg, #ef4444, #dc2626);
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 24px;
                box-shadow: 0 10px 30px rgba(239,68,68,0.3);
            }
            .icon-wrap i { color: white; font-size: 36px; }
            h1 { font-size: 24px; font-weight: 700; color: #1e293b; margin-bottom: 12px; }
            p { font-size: 15px; color: #64748b; line-height: 1.7; margin-bottom: 8px; }
            .divider { height: 1px; background: #f1f5f9; margin: 24px 0; }
            .btn-home {
                display: inline-block;
                margin-top: 20px;
                padding: 12px 24px;
                background: linear-gradient(135deg, #667eea, #764ba2);
                color: white;
                text-decoration: none;
                border-radius: 8px;
                font-weight: 600;
                font-size: 14px;
                transition: transform 0.2s;
            }
            .btn-home:hover { transform: translateY(-2px); }
        </style>
    </head>
    <body>
        <div class="card">
            <div class="icon-wrap">
                <i class="fa fa-school"></i>
            </div>
            <h1>School Not Found</h1>
            <p>The school you are looking for does not exist or has been removed.</p>
            <p>Please check the web address and try again.</p>
            <div class="divider"></div>
            <a href="http://coredesk.local:8000" class="btn-home">
                <i class="fa fa-home"></i> Return to CoreDesk
            </a>
        </div>
    </body>
    </html>';
}



}