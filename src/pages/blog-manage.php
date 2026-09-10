<?php
session_start();
require_once('../includes/db.php');

if (!isset($_SESSION['loggedInUserId'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['loggedInUserId'];
$pageTitle = 'Manage Blog Posts';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image_url = $_POST['image_url'];
    
    $stmt = $conn->prepare("INSERT INTO blog_posts (title, content, image_url, author_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $title, $content, $image_url, $userId);
    $stmt->execute();
    header("Location: blog-manage.php?success=1");
    exit();
}

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $del_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM blog_posts WHERE id = ? AND author_id = ?");
    $stmt->bind_param("ii", $del_id, $userId);
    $stmt->execute();
    header("Location: blog-manage.php?deleted=1");
    exit();
}

include('../includes/head.php');
?>
<?php include('../includes/navbar.php'); ?>

<div class="container py-5">
    <h2 class="section-title text-center mb-5">Manage Blog Posts ✍️</h2>
    
    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="syaahi-form-card shadow-sm p-4 rounded bg-white fade-in-on-scroll">
                <h4 class="mb-4">Create New Post</h4>
                <form method="POST">
                    <input type="hidden" name="action" value="create">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image URL (optional)</label>
                        <input type="url" name="image_url" class="form-control">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Content</label>
                        <textarea name="content" class="form-control" rows="6" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-sakura btn-pill w-100">Publish Post</button>
                </form>
            </div>
        </div>
        
        <div class="col-lg-7">
            <div class="bg-white p-4 rounded shadow-sm fade-in-on-scroll">
                <h4 class="mb-4">Your Posts</h4>
                
                <?php
                $stmt = $conn->prepare("SELECT * FROM blog_posts WHERE author_id = ? ORDER BY created_at DESC");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0):
                ?>
                <div class="table-responsive">
                    <table class="table syaahi-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td data-label="Title" class="mobile-full-width"><a href="blog-post.php?id=<?php echo $row['id']; ?>" class="text-decoration-none" style="color: var(--dark-purple); font-weight: 600; white-space: normal;"><?php echo htmlspecialchars($row['title']); ?></a></td>
                                <td data-label="Date"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                <td data-label="Action">
                                    <button type="button" class="btn btn-sm btn-outline-sakura btn-pill px-3" onclick="confirmDelete(<?php echo $row['id']; ?>)">
                                        <i class="fas fa-trash-alt nav-icon"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                    <p class="text-muted">You haven't written any posts yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Delete Post?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ffb7c5',
        cancelButtonColor: '#b8a9e8',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'blog-manage.php?delete=' + id;
        }
    })
}
</script>

<?php include('../includes/footer.php'); ?>
<?php include('../includes/scripts.php'); ?>
