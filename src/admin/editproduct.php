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
    <div class="row">
        <div class="col-md-8 mx-auto mt-4">
            <div class="card syaahi-admin-card p-4">
                <h3 class="mb-4" style="font-family: 'Carter One', cursive; color: var(--dark-purple, #6b21a8);">Update Product ✨</h3>
                
                <?php if ($message) : ?>
                    <div class="alert alert-info rounded-pill"><?php echo $message; ?></div>
                <?php endif; ?>

                <?php if ($product) : ?>
                    <form action="editproduct.php?ProductId=<?php echo $productId; ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="ProductId" value="<?php echo $product['ProductId']; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Product Title</label>
                            <input class="form-control" type="text" name="Title" value="<?php echo htmlspecialchars($product['Title']); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Description</label>
                            <textarea class="form-control" name="Description" rows="3"><?php echo htmlspecialchars($product['Description']); ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Price ($)</label>
                                <input class="form-control" type="number" step="0.01" name="Price" value="<?php echo htmlspecialchars($product['Price']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Category ID</label>
                                <input class="form-control" type="number" name="CategoryID" value="<?php echo htmlspecialchars($product['CategoryID'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label font-weight-bold">Rating</label>
                                <input class="form-control" type="number" step="0.1" name="Rating" value="<?php echo htmlspecialchars($product['Rating'] ?? ''); ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label font-weight-bold">Brand</label>
                                <input class="form-control" type="text" name="Brand" value="<?php echo htmlspecialchars($product['Brand'] ?? ''); ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label font-weight-bold">Size</label>
                                <input class="form-control" type="text" name="Size" value="<?php echo htmlspecialchars($product['Size'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Specifications</label>
                            <textarea class="form-control" name="Specification" rows="2"><?php echo htmlspecialchars($product['Specification'] ?? ''); ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label font-weight-bold">Product Image</label>
                            <?php if (!empty($product['ImgPath'])) : ?>
                                <div class="mb-2">
                                    <img src="<?php echo htmlspecialchars($product['ImgPath']); ?>" alt="Current Image" class="rounded shadow-sm" style="max-height: 100px;">
                                </div>
                                <input type="hidden" name="existingImgPath" value="<?php echo htmlspecialchars($product['ImgPath']); ?>">
                            <?php endif; ?>
                            <input class="form-control-file" type="file" name="ImgPath" id="ImgPath">
                        </div>

                        <div class="custom-control custom-switch mb-4">
                            <input type="checkbox" class="custom-control-input" id="isAvailable" name="IsAvailable" <?php echo $product['IsAvailable'] === "AVAILABLE" ? 'checked' : ''; ?>>
                            <label class="custom-control-label font-weight-bold text-success" for="isAvailable">Product is Available</label>
                        </div>

                        <div class="text-right">
                            <a href="addproduct.php" class="btn btn-light rounded-pill px-4 mr-2">Cancel</a>
                            <button type="submit" class="btn btn-lavender btn-pill px-5 shadow-sm">Update Product</button>
                        </div>
                    </form>
                <?php else : ?>
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Product not found.</h4>
                        <a href="addproduct.php" class="btn btn-outline-lavender btn-pill mt-3">Back to Products</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </main>

    <?php include_once("./templates/footer.php"); ?>
</body>

</html>