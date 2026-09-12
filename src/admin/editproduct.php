<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location:login.php");
    exit;
}

require_once("../includes/db.php");
$message = '';

// Handle form submission for update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ProductId'])) {
    $productId = mysqli_real_escape_string($conn, $_POST['ProductId']);
    $title = mysqli_real_escape_string($conn, $_POST['Title']);
    $description = mysqli_real_escape_string($conn, $_POST['Description']);
    $isAvailable = isset($_POST['IsAvailable']) ? "AVAILABLE" : "UNAVAILABLE";
    $price = mysqli_real_escape_string($conn, $_POST['Price']);
    $rating = mysqli_real_escape_string($conn, $_POST['Rating'] ?? '');
    $brand = mysqli_real_escape_string($conn, $_POST['Brand'] ?? '');
    $size = mysqli_real_escape_string($conn, $_POST['Size'] ?? '');
    $specification = mysqli_real_escape_string($conn, $_POST['Specification'] ?? '');
    $categoryID = mysqli_real_escape_string($conn, $_POST['Categories'] ?? '');

    // Handle image upload
    $imgPath = '';
    if (isset($_FILES['ImgPath']) && $_FILES['ImgPath']['error'] == 0) {
        $validMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['ImgPath']['tmp_name']);
        finfo_close($finfo);

        if (in_array($mime, $validMimeTypes)) {
            $target_dir = '../ProductImages/';
            $target_file = $target_dir . basename($_FILES['ImgPath']['name']);
            if (move_uploaded_file($_FILES['ImgPath']['tmp_name'], $target_file)) {
                $imgPath = $target_file;
            } else {
                $message = "Sorry, there was an error uploading your file.";
            }
        } else {
            $message = "Invalid file type. Only JPG, PNG, and WEBP are allowed.";
        }
    } else {
        // Use existing image path if new image not uploaded
        $imgPath = mysqli_real_escape_string($conn, $_POST['existingImgPath']);
    }

    if (!$message) {
        $sql = "UPDATE products SET Title = ?, Description = ?, IsAvailable = ?, Price = ?, ImgPath = ?, Rating = ?, Brand = ?, Size = ?, Specification = ?, CategoryID = ? WHERE ProductId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssi", $title, $description, $isAvailable, $price, $imgPath, $rating, $brand, $size, $specification, $categoryID, $productId);
        if ($stmt->execute()) {
            header('Location: addproduct.php');
            exit;
        } else {
            die("Error updating record: " . $stmt->error);
        }
    } else {
        die($message);
    }
} else {
    header('Location: addproduct.php');
    exit;
}
?>