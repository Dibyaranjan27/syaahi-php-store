<?php
session_start();
require_once('../includes/db.php');

if (!isset($_SESSION['loggedInUserId'])) {
    header("Location: login.php");
    exit();
}

$pageTitle = 'Change Password - Syaahi';
$userId = $_SESSION['loggedInUserId'];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $cNewPassword = $_POST['c_new_password'];
    
    if ($newPassword !== $cNewPassword) {
        $error = 'New passwords do not match.';
    } else {
        // Verify current password
        $stmt = $conn->prepare("SELECT Password FROM users WHERE UserID = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $res = $stmt->get_result();
        
        if ($res->num_rows === 1) {
            $user = $res->fetch_assoc();
            if (password_verify($currentPassword, $user['Password'])) {
                // Hash new password
                $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
                $update = $conn->prepare("UPDATE users SET Password = ? WHERE UserID = ?");
                $update->bind_param("si", $hashed, $userId);
                $update->execute();
                
                $success = "Password successfully changed!";
            } else {
                $error = "Incorrect current password.";
            }
        }
    }
}
include('../includes/head.php');
?>
<?php include('../includes/navbar.php'); ?>

<div class="container py-5 min-vh-100 d-flex align-items-center justify-content-center">
    <div class="syaahi-form-card shadow bg-white p-5 rounded" style="width: 100%; max-width: 500px;">
        <div class="text-center mb-4 fade-in-on-scroll">
            <h2 class="form-title">Change Password ??</h2>
            <p class="text-muted">Keep your account secure.</p>
        </div>
        
        <?php if($error): ?>
            <div class="speech-bubble error mb-4 text-center d-block fade-in-on-scroll"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if($success): ?>
            <div class="speech-bubble success mb-4 text-center d-block fade-in-on-scroll"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <form method="POST" class="fade-in-on-scroll">
            <div class="mb-3">
                <label class="form-label text-muted">Current Password</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-muted">New Password</label>
                <input type="password" name="new_password" class="form-control" required minlength="6">
            </div>
            <div class="mb-4">
                <label class="form-label text-muted">Confirm New Password</label>
                <input type="password" name="c_new_password" class="form-control" required minlength="6">
            </div>
            <button type="submit" class="btn btn-lavender btn-pill w-100 mb-3">Update Password</button>
        </form>
        
        <div class="text-center mt-3 fade-in-on-scroll">
            <a href="profile.php" class="text-muted text-decoration-none small">&larr; Back to Profile</a>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
<?php include('../includes/scripts.php'); ?>
