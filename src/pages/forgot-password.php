<?php
session_start();
require_once('../includes/db.php');
require_once('../includes/EmailService.php');

$pageTitle = 'Forgot Password - Syaahi';
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    
    $stmt = $conn->prepare("SELECT UserID FROM users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows === 1) {
        $token = bin2hex(random_bytes(50));
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $token);
        $stmt->execute();
        
        $emailService = new EmailService();
        if ($emailService->sendPasswordReset($email, $token)) {
            $message = "We've sent a password reset link to your email.";
        } else {
            $error = "Failed to send email. Please try again.";
        }
    } else {
        // Prevent email enumeration
        $message = "We've sent a password reset link to your email.";
    }
}
include('../includes/head.php');
?>
<div class="d-flex align-items-center justify-content-center min-vh-100 py-5" style="background: linear-gradient(135deg, #fdf4ff 0%, #f3e8ff 100%);">
    <div class="syaahi-form-card bg-white p-5 rounded shadow mx-3" style="width: 100%; max-width: 450px;">
        <div class="text-center mb-4">
            <h1 class="fw-bold" style="color: var(--dark-purple); font-family: 'WindSong', cursive; font-size: 4rem; line-height: 1;">Syaahi <span style="font-size: 2.5rem;">🌸</span></h1>
            <p class="text-muted">Forgot your password? No worries!</p>
        </div>
        
        <?php if($error): ?>
            <div class="speech-bubble error mb-4 text-center d-block"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if($message): ?>
            <div class="speech-bubble success mb-4 text-center d-block"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-4">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-lavender btn-pill w-100 mb-3">Send Reset Link</button>
        </form>
        
        <div class="text-center mt-3">
            <a href="login.php" class="text-muted text-decoration-none small">&larr; Back to Login</a>
        </div>
    </div>
</div>
