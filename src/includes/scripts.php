<?php
/**
 * Syaahi - Shared Scripts
 * Include this before </body> on every page
 */
$isSubdir = (strpos($_SERVER['SCRIPT_NAME'], '/pages/') !== false);
$basePath = $isSubdir ? '../' : '';
?>

<!-- Floating Cart Button -->
<?php if (isset($_SESSION['loggedInUserId'])): ?>
<a href="<?php echo $basePath; ?>pages/cart.php" class="floating-cart-btn" title="Shopping Cart">
    <i class="fas fa-shopping-cart"></i>
    <?php
    if (isset($conn)) {
        $cartStmt = mysqli_prepare($conn, "SELECT COUNT(ShoppingCartId) as cnt FROM shoppingcart WHERE clientId = ?");
        mysqli_stmt_bind_param($cartStmt, "i", $_SESSION['loggedInUserId']);
        mysqli_stmt_execute($cartStmt);
        $cartRes = mysqli_stmt_get_result($cartStmt);
        $cartCount = mysqli_fetch_assoc($cartRes)['cnt'] ?? 0;
        if ($cartCount > 0) {
            echo '<span class="cart-badge">' . $cartCount . '</span>';
        }
    }
    ?>
</a>
<?php endif; ?>

<!-- jQuery -->
<script src="<?php echo $basePath; ?>assets/js/jquery-1.11.0.min.js"></script>
<script src="<?php echo $basePath; ?>assets/js/jquery-migrate-1.2.1.min.js"></script>

<!-- Bootstrap Bundle -->
<script src="<?php echo $basePath; ?>assets/js/bootstrap.bundle.min.js"></script>

<!-- Template Scripts -->
<script src="<?php echo $basePath; ?>assets/js/templatemo.js"></script>
<script src="<?php echo $basePath; ?>assets/js/custom.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Syaahi Animations -->
<script>
// Fade-in on scroll animation
document.addEventListener('DOMContentLoaded', function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.fade-in-on-scroll').forEach(el => {
        observer.observe(el);
    });

    // Animate star ratings
    document.querySelectorAll('.star-rating').forEach(rating => {
        const stars = rating.querySelectorAll('.fa-star');
        stars.forEach((star, index) => {
            star.style.animationDelay = (index * 0.1) + 's';
        });
    });
});
</script>
</body>
</html>
