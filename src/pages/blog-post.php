<?php
session_start();
require_once('../includes/db.php');

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header("Location: blog-listing.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT bp.*, u.UserName FROM blog_posts bp JOIN users u ON bp.author_id = u.UserID WHERE bp.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0){
    header("Location: blog-listing.php");
    exit();
}

$post = $result->fetch_assoc();
$pageTitle = $post['title'];

include('../includes/head.php');
?>
<?php include('../includes/navbar.php'); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a href="blog-listing.php" class="btn btn-sm btn-outline-lavender mb-4">&larr; Back to Blog</a>
            
            <article class="bg-white p-4 p-md-5 rounded shadow-sm">
                <?php if($post['image_url']): ?>
                    <img src="<?php echo htmlspecialchars($post['image_url']); ?>" class="img-fluid rounded mb-4 w-100" style="max-height: 400px; object-fit: cover;" alt="Blog Image">
                <?php endif; ?>
                
                <h1 class="fw-bold mb-3" style="color: #4c1d95;"><?php echo htmlspecialchars($post['title']); ?></h1>
                
                <div class="d-flex align-items-center text-muted mb-4 pb-3 border-bottom gap-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-user-circle"></i>
                        <span><?php echo htmlspecialchars($post['UserName']); ?></span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="far fa-calendar-alt"></i>
                        <span><?php echo date('F d, Y', strtotime($post['created_at'])); ?></span>
                    </div>
                </div>
                
                <div class="blog-content lh-lg" style="font-size: 1.1rem; color: #334155;">
                    <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                </div>
            </article>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
<?php include('../includes/scripts.php'); ?>
