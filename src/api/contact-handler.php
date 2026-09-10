<?php
session_start();
require_once('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $email = filter_var($_POST['email_address'] ?? '', FILTER_SANITIZE_EMAIL);
    $comment = trim($_POST['comment'] ?? '');

    if (!empty($firstName) && !empty($email) && !empty($comment)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO feedback (first_name, last_name, email_address, comment) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $firstName, $lastName, $email, $comment);
        mysqli_stmt_execute($stmt);
        header('Location: ../pages/contact.php?success=1');
        exit;
    }
}

header('Location: ../pages/contact.php?error=1');
exit;
