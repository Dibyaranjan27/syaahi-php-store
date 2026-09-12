<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location:login.php");
    exit;
}

require_once("../includes/db.php");
$message = '';
$productId = $_GET['ProductId'] ?? null;

// Handle form submission for update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ProductId'])) {
    // Sanitize and process form data
    $productId = mysqli_real_escape_string($conn, $_POST['ProductId']);
    $title = mysqli_real_escape_string($conn, $_POST['Title']);
    $description = mysqli_real_escape_string($conn, $_POST['Description']);
    $isAvailable = isset($_POST['IsAvailable']) ? "AVAILABLE" : "UNAVAILABLE";
    $price = mysqli_real_escape_string($conn, $_POST['Price']);
    $rating = mysqli_real_escape_string($conn, $_POST['Rating'] ?? '');
    $brand = mysqli_real_escape_string($conn, $_POST['Brand'] ?? '');
    $size = mysqli_real_escape_string($conn, $_POST['Size'] ?? '');
    $specification = mysqli_real_escape_string($conn, $_POST['Specification'] ?? '');
    $categories = mysqli_real_escape_string($conn, $_POST['Categories'] ?? '');

    // ... [Sanitization for other fields]

    // Handle image upload
    $existingImgPath = '$imgPath';
    $imgPath = '';
    	if (isset($_FILES['ImgPath']) && $_FILES['ImgPath']['error'] == 0) {
        $validMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['ImgPath']['tmp_name']);
        finfo_close($finfo);

        if (in_array($mime, $validMimeTypes)) {
            $target_dir = 'ProductImages/';
            $target_file = $target_dir . basename($_FILES['ImgPath']['name']);
            if (move_uploaded_file($_FILES['ImgPath']['tmp_name'], "../".$target_file)) {
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

    // Continue with the update if no error
    if (!$message) {
        $sql = "UPDATE products SET Title = ?, Description = ?, IsAvailable = ?, Price = ?, ImgPath = ?, Rating = ?, Brand = ?, Size = ?, Specification = ?, Categories = ? WHERE ProductId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssi", $title, $description, $isAvailable, $price, $imgPath, $rating, $brand, $size, $specification, $categories, $productId);
        if ($stmt->execute()) {
            header('Location: addproduct.php');
            exit;
        } else {
            $message = "Error updating record: " . $stmt->error;
        }
    }
}

// Fetch existing product details for editing
if ($productId && $_SERVER['REQUEST_METHOD'] != 'POST') {
    $productId = mysqli_real_escape_string($conn, $productId);
    $query = "SELECT * FROM products WHERE ProductId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Product</title>
    <!-- Additional head elements here -->

    <!-- CSS -->
    <style>
        *,
        *::after,
        *::before {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        form {
            --bg-color: #fff;
            --main-color: #323232;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            padding: 2rem;
            border-radius: 5px;
            border: 1px solid var(--main-color);
            box-shadow: 2px 2px var(--main-color);
            background: #f0f0f0;
            font-weight: bold;
            margin-inline: 10rem;
        }

        .styling,
        textarea {
            min-width: 20rem;
            height: 3rem;
            border-radius: 4px;
            border: 1px solid var(--main-color);
            background-color: var(--bg-color);
            box-shadow: 2px 2px var(--main-color);
            font-size: 15px;
            font-weight: 600;
            color: var(--font-color);
            padding: 5px 10px;
            outline: none;
        }

        textarea {
            resize: vertical;
            max-height: 8rem;
        }

        label {
            display: flex;
            line-height: 2rem;
        }

        label input {
            margin-inline: 1rem;
        }

        button {
            color: #fff;
            border: 1px solid #000;
            border-radius: 4px;
            padding: 0.8em 2em;
            background: #000;
            transition: 0.2s;
            margin-inline: 4rem;
        }

        button:hover {
            color: #000;
            transform: translate(-0.25rem, -0.25rem);
            background: #ff90e8;
            box-shadow: 0.25rem 0.25rem #000;
        }
    </style>
    <!-- CSS END -->
</head>

<body>
    <?php include_once("./templates/top.php"); ?>
    <?php include_once("./templates/navbar.php"); ?>
    <?php include "./templates/sidebar.php"; ?>

    <?php if ($message) : ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <?php if ($product) : ?>

        <form action="editproduct.php?ProductId=<?php echo $productId; ?>" method="post" enctype="multipart/form-data">
            <h1>Update Product</h1>
            <input class="styling" type="hidden" name="ProductId" value="<?php echo $product['ProductId']; ?>">
            <input class="styling" type="text" name="Title" value="<?php echo $product['Title']; ?>" required>
            <textarea name="Description"><?php echo $product['Description']; ?></textarea>
            <label>
                Available
                <input type="checkbox" name="IsAvailable" <?php echo $product['IsAvailable'] === "AVAILABLE" ? 'checked' : ''; ?>>
            </label>
            <input class="styling" type="number" step="0.01" name="Price" value="<?php echo $product['Price']; ?>">
            <?php if (!empty($product['ImgPath'])) : ?>
                <img src="<?php echo $product['ImgPath']; ?>" alt="Current Image" style="max-width: 100px; max-height: 100px;">
                <input type="hidden" name="existingImgPath" value="<?php echo $product['ImgPath']; ?>">
            <?php endif; ?>
            <input type="file" name="ImgPath" id="ImgPath">
            <input class="styling" type="number" step="0.1" name="Rating" value="<?php echo $product['Rating']; ?>">
            <input class="styling" type="text" name="Brand" value="<?php echo $product['Brand']; ?>">
            <input class="styling" type="text" name="Size" value="<?php echo $product['Size']; ?>">
            <textarea name="Specification"><?php echo $product['Specification']; ?></textarea>
            <input class="styling" type="text" name="Categories" value="<?php echo $product['Categories']; ?>">
            <button type="submit">Update Product</button>
        </form>
    <?php else : ?>
        <p>Product not found.</p>
    <?php endif; ?>

    <?php include_once("./templates/footer.php"); ?>
</body>

</html>