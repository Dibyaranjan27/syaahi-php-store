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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddProductModalLabel">Add New Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="addproduct.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="text" name="Title" class="form-control" placeholder="Product Title" required>
                        </div>
                        <div class="form-group">
                            <textarea name="Description" class="form-control" placeholder="Product Description"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="isAvailableCheck" name="IsAvailable" checked>
                                <label class="custom-control-label" for="isAvailableCheck">Available</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="number" step="0.01" name="Price" class="form-control" placeholder="Price">
                        </div>
                        <div class="form-group">
                            <label>Product Image</label>
                            <input type="file" name="ImgPath" class="form-control-file">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="number" step="0.1" name="Rating" class="form-control" placeholder="Rating">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="Brand" class="form-control" placeholder="Brand">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" name="Size" class="form-control" placeholder="Size">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="Categories" class="form-control" placeholder="Categories">
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea name="Specification" class="form-control" placeholder="Specification"></textarea>
                        </div>
                        <button type="submit" class="btn btn-lavender btn-pill w-100">Add Product</button>
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