<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService {
    private $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);
        
        try {
            // Server settings
            $this->mailer->isSMTP();
            $this->mailer->Host       = getenv('SMTP_HOST') ?: 'smtp.mailtrap.io';
            $this->mailer->SMTPAuth   = true;
            $this->mailer->Username   = getenv('SMTP_USER') ?: 'user';
            $this->mailer->Password   = getenv('SMTP_PASS') ?: 'pass';
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port       = getenv('SMTP_PORT') ?: 2525;
            
            // Default From
            $this->mailer->setFrom('noreply@syaahi.com', 'Syaahi Shop');
            $this->mailer->isHTML(true);
        } catch (Exception $e) {
            error_log("Email config error: {$this->mailer->ErrorInfo}");
        }
    }

    public function sendOrderConfirmation($toEmail, $orderId, $totalAmount) {
        try {
            $this->mailer->addAddress($toEmail);
            $this->mailer->Subject = "Order Confirmation #{}";
            $this->mailer->Body    = "
                <div style='font-family: Arial, sans-serif; padding: 20px; background-color: #fdf4ff; border-radius: 10px;'>
                    <h2 style='color: #6b21a8;'>Thank you for your order! ??</h2>
                    <p>Your order <strong>#{}</strong> has been confirmed.</p>
                    <p><strong>Total Amount:</strong> ?{}</p>
                    <p>We are preparing your items for shipment. Thank you for shopping with Syaahi!</p>
                </div>
            ";
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Order email error: {$this->mailer->ErrorInfo}");
            return false;
        }
    }

    public function sendPasswordReset($toEmail, $token) {
        try {
            $this->mailer->addAddress($toEmail);
            $this->mailer->Subject = "Reset Your Password - Syaahi";
            
            // Build absolute URL for reset link
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $resetLink = "{}://{['HTTP_HOST']}/pages/reset-password.php?token={}";

            $this->mailer->Body = "
                <div style='font-family: Arial, sans-serif; padding: 20px; background-color: #fdf4ff; border-radius: 10px;'>
                    <h2 style='color: #6b21a8;'>Password Reset Request ??</h2>
                    <p>We received a request to reset your Syaahi password.</p>
                    <p>Click the link below to set a new password:</p>
                    <a href='{}' style='display: inline-block; padding: 10px 20px; background-color: #d946ef; color: white; text-decoration: none; border-radius: 50px;'>Reset Password</a>
                    <p style='margin-top: 20px; font-size: 12px; color: #666;'>If you didn't request this, you can safely ignore this email.</p>
                </div>
            ";
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Reset email error: {$this->mailer->ErrorInfo}");
            return false;
        }
    }
}
?>
