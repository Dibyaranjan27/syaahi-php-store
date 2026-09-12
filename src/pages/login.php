<?php
session_start();
require_once('../includes/db.php');

if (isset($_SESSION['loggedInUserId'])) {
    header("Location: ../index.php");
    exit();
}

$pageTitle = 'Login - Syaahi';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Password'])) {
            $_SESSION['SESSION_EMAIL'] = $user['Email'];
            $_SESSION['usernamelogin'] = $user['UserName'];
            $_SESSION['loggedInUserId'] = $user['UserID'];
            header("Location: ../index.php");
            exit();
        } else {
            $error = 'Invalid email or password.';
        }
    } else {
        $error = 'Invalid email or password.';
    }
}

include('../includes/head.php');
?>
<div class="d-flex align-items-center justify-content-center min-vh-100" style="background: linear-gradient(135deg, #fdf4ff 0%, #f3e8ff 100%);">
    <div class="syaahi-form-card bg-white p-5 rounded shadow mx-3" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4">
            <h1 class="fw-bold" style="color: var(--dark-purple); font-family: 'WindSong', cursive; font-size: 4rem; line-height: 1;">Syaahi <span style="font-size: 2.5rem;">🌸</span></h1>
            <p class="text-muted">Welcome back! Please login.</p>
        </div>
        
        <?php if($error): ?>
            <div class="speech-bubble error mb-4 text-center d-block"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0">Password</label>
                    <a href="forgot-password.php" style="color: #d946ef; font-size: 0.85rem; text-decoration: none;">Forgot Password?</a>
                </div>
                <input type="password" name="password" class="form-control mt-2" required>
            </div>
            <button type="submit" class="btn btn-lavender btn-pill w-100 mb-3">Login</button>
        </form>
        
        <div class="text-center mt-3">
            <p class="mb-0 text-muted">Don't have an account? <a href="register.php" style="color: #d946ef; font-weight: bold; text-decoration: none;">Sign Up</a></p>
        </div>
        <div class="text-center mt-3">
            <a href="../index.php" class="text-muted text-decoration-none small">&larr; Back to Home</a>
        </div>
    </div>
</div>

<?php include('../includes/scripts.php'); ?>
