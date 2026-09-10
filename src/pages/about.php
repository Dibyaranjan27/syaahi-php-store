<?php
session_start();
require_once('../includes/db.php');
$pageTitle = 'About Us';
include('../includes/head.php');
?>
<?php include('../includes/navbar.php'); ?>

<div class="container py-5">
    <div class="text-center mb-5 p-5 rounded" style="background: linear-gradient(135deg, #f3e8ff 0%, #fae8ff 100%);">
        <h1 class="display-4 fw-bold mb-3" style="color: #6b21a8;">About Syaahi ✒️</h1>
        <p class="lead fs-4 text-muted">A passion project for book lovers and sticker enthusiasts</p>
    </div>

    <div class="row g-4 mt-4">
        <div class="col-md-4 fade-in-on-scroll">
            <div class="contact-info-card h-100 p-4 text-center border-0 shadow-sm rounded">
                <h3 class="mb-3">Books 📚</h3>
                <p>We carefully curate a selection of captivating reads, from thrilling fantasies to heartwarming contemporaries. Dive into a world of stories with Syaahi.</p>
            </div>
        </div>
        
        <div class="col-md-4 fade-in-on-scroll">
            <div class="contact-info-card h-100 p-4 text-center border-0 shadow-sm rounded">
                <h3 class="mb-3">Stickers 🌸</h3>
                <p>Decorate your world with our adorable and quirky sticker collections. Perfect for laptops, notebooks, or gifting to a friend!</p>
            </div>
        </div>
        
        <div class="col-md-4 fade-in-on-scroll">
            <div class="contact-info-card h-100 p-4 text-center border-0 shadow-sm rounded">
                <h3 class="mb-3">Community 💜</h3>
                <p>Syaahi is more than a store. We are a community of creatives, readers, and dreamers. Join us in celebrating the love for words and art.</p>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
<?php include('../includes/scripts.php'); ?>
