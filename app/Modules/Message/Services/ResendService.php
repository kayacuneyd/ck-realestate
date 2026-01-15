<?php

namespace App\Modules\Message\Services;

/**
 * Resend Email Service
 * 
 * Sends transactional emails via Resend API.
 */
class ResendService
{
    protected string $apiKey;
    protected string $fromEmail;
    protected string $fromName;

    public function __construct()
    {
        $this->apiKey = env('RESEND_API_KEY', '');
        $this->fromEmail = env('MAIL_FROM_ADDRESS', 'noreply@bawue-immobilien.de');
        $this->fromName = env('MAIL_FROM_NAME', 'Bawue Immobilien');
    }

    /**
     * Send email via Resend API.
     */
    public function send(string $to, string $subject, string $html, ?string $replyTo = null): array
    {
        if (empty($this->apiKey)) {
            log_message('warning', 'Resend API key not configured. Email not sent.');
            return ['success' => false, 'error' => 'API key not configured'];
        }

        $payload = [
            'from' => "{$this->fromName} <{$this->fromEmail}>",
            'to' => [$to],
            'subject' => $subject,
            'html' => $html,
        ];

        if ($replyTo) {
            $payload['reply_to'] = $replyTo;
        }

        $ch = curl_init('https://api.resend.com/emails');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->apiKey,
                'Content-Type: application/json',
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            log_message('error', 'Resend API error: ' . $error);
            return ['success' => false, 'error' => $error];
        }

        $data = json_decode($response, true);

        if ($httpCode >= 200 && $httpCode < 300) {
            log_message('info', 'Email sent successfully via Resend to: ' . $to);
            return ['success' => true, 'data' => $data];
        }

        log_message('error', 'Resend API failed: ' . $response);
        return ['success' => false, 'error' => $data['message'] ?? 'Unknown error'];
    }

    /**
     * Send new message notification to admin.
     */
    public function sendNewMessageNotification(array $messageData): array
    {
        $adminEmail = env('ADMIN_EMAIL', 'admin@bawue.immo');

        $html = $this->buildNewMessageEmailHtml($messageData);

        return $this->send(
            $adminEmail,
            'New Contact Message from ' . $messageData['name'],
            $html,
            $messageData['email'] // Reply-To allows direct response
        );
    }

    /**
     * Send reply notification to customer.
     */
    public function sendReplyNotification(string $customerEmail, string $customerName, string $originalMessage, string $reply): array
    {
        $html = $this->buildReplyEmailHtml($customerName, $originalMessage, $reply);

        return $this->send(
            $customerEmail,
            'Re: Your inquiry to Bawue Immobilien',
            $html
        );
    }

    /**
     * Build HTML for new message notification email.
     */
    protected function buildNewMessageEmailHtml(array $data): string
    {
        $name = esc($data['name']);
        $email = esc($data['email']);
        $phone = esc($data['phone'] ?? 'Not provided');
        $subject = esc($data['subject'] ?? 'No subject');
        $message = nl2br(esc($data['message']));

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); color: white; padding: 20px; border-radius: 8px 8px 0 0; }
        .content { background: #f9fafb; padding: 20px; border: 1px solid #e5e7eb; }
        .field { margin-bottom: 15px; }
        .label { font-weight: bold; color: #6b7280; font-size: 12px; text-transform: uppercase; }
        .value { margin-top: 5px; }
        .message-box { background: white; padding: 15px; border-radius: 8px; border: 1px solid #e5e7eb; }
        .footer { background: #0f172a; color: #9ca3af; padding: 15px; text-align: center; font-size: 12px; border-radius: 0 0 8px 8px; }
        .btn { display: inline-block; background: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin: 0;">New Contact Message</h2>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">Someone has reached out via the contact form</p>
        </div>
        <div class="content">
            <div class="field">
                <div class="label">From</div>
                <div class="value">{$name}</div>
            </div>
            <div class="field">
                <div class="label">Email</div>
                <div class="value"><a href="mailto:{$email}">{$email}</a></div>
            </div>
            <div class="field">
                <div class="label">Phone</div>
                <div class="value">{$phone}</div>
            </div>
            <div class="field">
                <div class="label">Subject</div>
                <div class="value">{$subject}</div>
            </div>
            <div class="field">
                <div class="label">Message</div>
                <div class="message-box">{$message}</div>
            </div>
            <p style="color: #6b7280; font-size: 14px;">
                <strong>Tip:</strong> You can reply directly to this email to respond to {$name}.
            </p>
        </div>
        <div class="footer">
            Bawue Immobilien &bull; Contact Management System
        </div>
    </div>
</body>
</html>
HTML;
    }

    /**
     * Build HTML for reply email to customer.
     */
    protected function buildReplyEmailHtml(string $name, string $originalMessage, string $reply): string
    {
        $name = esc($name);
        $originalMessage = nl2br(esc($originalMessage));
        $reply = nl2br(esc($reply));

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); color: white; padding: 20px; border-radius: 8px 8px 0 0; }
        .content { background: #f9fafb; padding: 20px; border: 1px solid #e5e7eb; }
        .reply-box { background: white; padding: 15px; border-radius: 8px; border: 1px solid #e5e7eb; margin-bottom: 20px; }
        .original { background: #f3f4f6; padding: 15px; border-radius: 8px; border-left: 4px solid #9ca3af; font-size: 14px; color: #6b7280; }
        .footer { background: #0f172a; color: #9ca3af; padding: 15px; text-align: center; font-size: 12px; border-radius: 0 0 8px 8px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin: 0;">Response from Bawue Immobilien</h2>
        </div>
        <div class="content">
            <p>Dear {$name},</p>
            <p>Thank you for contacting us. Here is our response:</p>
            <div class="reply-box">{$reply}</div>
            <p style="color: #6b7280; font-size: 14px;">Your original message:</p>
            <div class="original">{$originalMessage}</div>
            <p style="margin-top: 20px;">Best regards,<br><strong>Bawue Immobilien Team</strong></p>
        </div>
        <div class="footer">
            Bawue Immobilien &bull; Your trusted partner in real estate
        </div>
    </div>
</body>
</html>
HTML;
    }
}
