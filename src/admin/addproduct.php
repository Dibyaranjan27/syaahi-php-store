<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location:login.php");
    exit;
}
require_once("../includes/db.php"); // Ensure this path is correct

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process form data and construct SQL query
    $title = mysqli_real_escape_string($conn, $_POST['Title']);
    $description = mysqli_real_escape_string($conn, $_POST['Description']);
    $isAvailable = isset($_POST['IsAvailable']) ? 1 : 0;
    $price = mysqli_real_escape_string($conn, $_POST['Price']);
    $rating = mysqli_real_escape_string($conn, $_POST['Rating'] ?? '');
    $brand = mysqli_real_escape_string($conn, $_POST['Brand'] ?? '');
    $size = mysqli_real_escape_string($conn, $_POST['Size'] ?? '');
    $specification = mysqli_real_escape_string($conn, $_POST['Specification'] ?? '');
    $categories = mysqli_real_escape_string($conn, $_POST['Categories'] ?? '');

    // Handle file upload
    $imgPath = '';
    if (isset($_FILES['ImgPath']) && $_FILES['ImgPath']['error'] == 0) {
        $validMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['ImgPath']['tmp_name']);
        finfo_close($finfo);

        if (in_array($mime, $validMimeTypes)) {
            $target_dir = "../ProductImages/"; // Adjust the path as needed
            $target_file = $target_dir . basename($_FILES['ImgPath']['name']);
            if (move_uploaded_file($_FILES['ImgPath']['tmp_name'], $target_file)) {
                $imgPath = $target_file;
            } else {
                $message = "Sorry, there was an error uploading your file.";
            }
        } else {
            $message = "Invalid file type. Only JPG, PNG, and WEBP are allowed.";
        }
    }

    if (!$message) {
        // Ensure column names are correct as per your database schema
        $sql = "INSERT INTO products (Title, Description, IsAvailable, Price, ImgPath, Rating, Brand, Size, Specification, Categories) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdssssss", $title, $description, $isAvailable, $price, $imgPath, $rating, $brand, $size, $specification, $categories);
        if ($stmt->execute()) {
            // Redirect to the same page after successful insertion
            header('Location: addproduct.php');
            exit;
        } else {
            $message = "Error: " . $stmt->error;
        }
    }
}

// Fetch products after potential redirection
$query = "SELECT * FROM products";
$stmt = $conn->prepare($query);
$stmt->execute();
$products = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Product Management</title>
    <!-- Add additional head elements here -->
</head>

<body>

    <?php include_once("./templates/top.php"); ?>
    <?php include_once("./templates/navbar.php"); ?>
    <?php include "./templates/sidebar.php"; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-10">
                <h2>Products</h2>
            </div>
            <div class="col-2">
                <a href="#" data-toggle="modal" data-target="#add_product_modal" class="btn btn-lavender btn-sm">Add Product</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-pastel table-borderless">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Brand</th>
                        <!-- Add other headers as necessary -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM products";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $products = $stmt->get_result();
                    while ($product = $products->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $product['ProductId']; ?></td>
                            <td><?php echo $product['Title']; ?></td>
                            <td><?php echo $product['Price']; ?></td>
                            <td><?php echo $product['Brand']; ?></td>
                            <!-- Add other product fields here -->
                            <td>
                                <!-- Edit button (can link to an edit page or open a modal) -->
                                <a href="editproduct.php?ProductId=<?php echo $product['ProductId']; ?>" class="btn btn-lavender btn-sm">Edit</a>
                                <!-- Delete form -->
                                <form action="deleteproduct.php" method="post" style="display: inline-block;">
                                    <input type="hidden" name="ProductId" value="<?php echo $product['ProductId']; ?>">
                                    <button type="submit" class="btn btn-sakura btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Adding a New Product -->
    <div class="modal fade" id="add_product_modal" tabindex="-1" role="dialog" aria-labelledby="AddProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
                <div class="modal-header bg-light border-0">
                    <h5 class="modal-title" id="AddProductModalLabel" style="font-family: 'Carter One', cursive; color: var(--dark-purple, #6b21a8);">Add New Product ✨</h5>
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <form action="addproduct.php" method="post" enctype="multipart/form-data">
                        <div class="form-group mb-3">
                            <input type="text" name="Title" class="form-control form-control-lg bg-light border-0 rounded-pill px-4" placeholder="Product Title" required>
                        </div>
                        <div class="form-group mb-3">
                            <textarea name="Description" class="form-control bg-light border-0 px-4 py-3" style="border-radius: 15px;" placeholder="Product Description" rows="3"></textarea>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6 form-group">
                                <input type="number" step="0.01" name="Price" class="form-control form-control-lg bg-light border-0 rounded-pill px-4" placeholder="Price ($)">
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="number" name="Categories" class="form-control form-control-lg bg-light border-0 rounded-pill px-4" placeholder="Category ID">
                            </div>
                        </div>

                        <div class="form-group mb-4 p-3 bg-light" style="border-radius: 15px; border: 2px dashed #ddd;">
                            <label class="font-weight-bold text-muted d-block mb-2">Product Image</label>
                            <input type="file" name="ImgPath" id="ImgPath" class="form-control-file">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 form-group">
                                <input type="number" step="0.1" name="Rating" class="form-control bg-light border-0 rounded-pill px-4" placeholder="Rating (0.0 - 5.0)">
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="text" name="Brand" class="form-control bg-light border-0 rounded-pill px-4" placeholder="Brand">
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="text" name="Size" class="form-control bg-light border-0 rounded-pill px-4" placeholder="Size (e.g., Paperback)">
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <textarea name="Specification" class="form-control bg-light border-0 px-4 py-3" style="border-radius: 15px;" placeholder="Specifications" rows="2"></textarea>
                        </div>

                        <div class="form-group mb-4">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="isAvailableCheck" name="IsAvailable" checked>
                                <label class="custom-control-label font-weight-bold text-success" for="isAvailableCheck">Product is Available</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-lavender btn-pill btn-block py-2 shadow-sm font-weight-bold" style="font-size: 1.1rem;">Add Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include_once("./templates/footer.php"); ?>
    <?php
    // ... [Your existing code]

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        error_log(print_r($_POST, true)); // Debugging line

        // Your existing form handling code

        $sql = "INSERT INTO products (Title, Description, IsAvailable, Price, ImgPath, Rating, Brand, Size, Specification, Categories) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdssssss", $title, $description, $isAvailable, $price, $imgPath, $rating, $brand, $size, $specification, $categories);
        if ($stmt->execute()) {
            echo "New product added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    ?>

</body>

</html>