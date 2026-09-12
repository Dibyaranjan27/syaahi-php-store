<?php
session_start();
require_once('../includes/db.php');
$pageTitle = 'Blog';
include('../includes/head.php');
?>
<?php include('../includes/navbar.php'); ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="section-title m-0">Syaahi Blog 📖</h2>
        <?php if(isset($_SESSION['loggedInUserId'])): ?>
            <a href="blog-manage.php" class="btn btn-sakura btn-pill">Write a Post</a>
        <?php endif; ?>
    </div>
    
    <?php
    $limit = 9;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $offset = ($page - 1) * $limit;

    $countQuery = "SELECT COUNT(*) as total FROM blog_posts";
    $countResult = $conn->query($countQuery);
    $totalRows = $countResult->fetch_assoc()['total'];
    $totalPages = ceil($totalRows / $limit);

    $query = "SELECT bp.*, u.UserName FROM blog_posts bp JOIN users u ON bp.author_id = u.UserID ORDER BY bp.created_at DESC LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result && $result->num_rows > 0):
    ?>
    <div class="manga-grid">
        <?php while($row = $result->fetch_assoc()): 
            $excerpt = substr(strip_tags($row['content']), 0, 150) . '...';
        ?>
        <div class="card blog-card h-100 fade-in-on-scroll">
            <?php if($row['image_url']): ?>
                <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="card-img-top" alt="Blog Image" style="height:200px; object-fit:cover;">
            <?php else: ?>
                <div class="card-img-top" style="height:200px; background: linear-gradient(135deg, #e9d5ff 0%, #fbcfe8 100%);"></div>
            <?php endif; ?>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title fw-bold"><?php echo htmlspecialchars($row['title']); ?></h5>
                <p class="text-muted small mb-2">By <?php echo htmlspecialchars($row['UserName']); ?> on <?php echo date('M d, Y', strtotime($row['created_at'])); ?></p>
                <p class="card-text flex-grow-1"><?php echo htmlspecialchars($excerpt); ?></p>
                <a href="blog-post.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-lavender mt-3">Read More</a>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    
    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <nav class="mt-5 fade-in-on-scroll">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
            <?php endfor; ?>
            <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>

    <?php else: ?>
    <div class="text-center">
        <div class="speech-bubble d-inline-block">No blog posts yet. Be the first to write one! ✍️</div>
    </div>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
<?php include('../includes/scripts.php'); ?>
