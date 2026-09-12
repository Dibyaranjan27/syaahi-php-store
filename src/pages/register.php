<?php
session_start();
require_once('../includes/db.php');

if (isset($_SESSION['loggedInUserId'])) {
    header("Location: ../index.php");
    exit();
}

$pageTitle = 'Register - Syaahi';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    
    if ($password !== $cpassword) {
        $error = 'Passwords do not match.';
    } else {
        $stmt_check = $conn->prepare("SELECT * FROM users WHERE Email = ?");
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        if ($stmt_check->get_result()->num_rows > 0) {
            $error = 'Email already exists.';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (UserName, Email, Password, Phone) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $hashed, $phone);
            if ($stmt->execute()) {
                $success = 'Registration successful! You can now login.';
            } else {
                $error = 'Something went wrong. Please try again.';
            }
        }
    }
}

include('../includes/head.php');
?>
<div class="d-flex align-items-center justify-content-center min-vh-100 py-5" style="background: linear-gradient(135deg, #fdf4ff 0%, #f3e8ff 100%);">
    <div class="syaahi-form-card bg-white p-5 rounded shadow mx-3" style="width: 100%; max-width: 450px;">
        <div class="text-center mb-4">
            <h1 class="fw-bold" style="color: var(--dark-purple); font-family: 'WindSong', cursive; font-size: 4rem; line-height: 1;">Syaahi <span style="font-size: 2.5rem;">🌸</span></h1>
            <p class="text-muted">Create an account to join us!</p>
        </div>
        
        <?php if($error): ?>
            <div class="speech-bubble error mb-4 text-center d-block"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if($success): ?>
            <div class="speech-bubble success mb-4 text-center d-block"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="cpassword" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-sakura btn-pill w-100 mb-3">Sign Up</button>
        </form>
        
        <div class="text-center mt-3">
            <p class="mb-0 text-muted">Already have an account? <a href="login.php" style="color: #d946ef; font-weight: bold; text-decoration: none;">Login</a></p>
        </div>
        <div class="text-center mt-3">
            <a href="../index.php" class="text-muted text-decoration-none small">&larr; Back to Home</a>
        </div>
    </div>
</div>

<?php include('../includes/scripts.php'); ?>
