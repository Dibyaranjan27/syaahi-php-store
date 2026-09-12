<?php
session_start();
require_once('../includes/db.php');

$pageTitle = 'Reset Password - Syaahi';
$error = '';
$success = '';

if (!isset($_GET['token'])) {
    header("Location: login.php");
    exit();
}
$token = $_GET['token'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    
    if ($password !== $cpassword) {
        $error = 'Passwords do not match.';
    } else {
        $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ? AND created_at >= NOW() - INTERVAL 1 HOUR LIMIT 1");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $res = $stmt->get_result();
        
        if ($res->num_rows === 1) {
            $email = $res->fetch_assoc()['email'];
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            
            $update = $conn->prepare("UPDATE users SET Password = ? WHERE Email = ?");
            $update->bind_param("ss", $hashed, $email);
            $update->execute();
            
            $del = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
            $del->bind_param("s", $email);
            $del->execute();
            
            $success = "Password successfully reset! You can now login.";
        } else {
            $error = "Invalid or expired reset token.";
        }
    }
}
include('../includes/head.php');
?>
<div class="d-flex align-items-center justify-content-center min-vh-100 py-5" style="background: linear-gradient(135deg, #fdf4ff 0%, #f3e8ff 100%);">
    <div class="syaahi-form-card bg-white p-5 rounded shadow" style="width: 100%; max-width: 450px;">
        <div class="text-center mb-4">
            <h1 class="fw-bold" style="color: var(--dark-purple); font-family: 'WindSong', cursive; font-size: 4rem; line-height: 1;">Syaahi <span style="font-size: 2.5rem;">🌸</span></h1>
            <p class="text-muted">Enter your new password below.</p>
        </div>
        
        <?php if($error): ?>
            <div class="speech-bubble error mb-4 text-center d-block"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if($success): ?>
            <div class="speech-bubble success mb-4 text-center d-block"><?php echo htmlspecialchars($success); ?></div>
            <a href="login.php" class="btn btn-lavender btn-pill w-100 mb-3">Go to Login</a>
        <?php else: ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" name="password" class="form-control" required minlength="6">
            </div>
            <div class="mb-4">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="cpassword" class="form-control" required minlength="6">
            </div>
            <button type="submit" class="btn btn-lavender btn-pill w-100 mb-3">Reset Password</button>
        </form>
        <?php endif; ?>
    </div>
</div>
