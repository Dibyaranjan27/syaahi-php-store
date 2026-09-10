<?php
/**
 * Syaahi - Shared HTML Head
 * Include this at the top of every page after setting $pageTitle
 * Usage: $pageTitle = 'Shop'; include('../includes/head.php');
 * For root: $pageTitle = 'Home'; include('includes/head.php');
 */

// Determine base path (root vs pages/ subdirectory)
$isSubdir = (strpos($_SERVER['SCRIPT_NAME'], '/pages/') !== false);
$basePath = $isSubdir ? '../' : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo SITE_NAME; ?><?php echo isset($pageTitle) ? ' | ' . $pageTitle : ''; ?></title>

    <!-- Google Fonts: WindSong (logo) + Carter One (headings) + Nunito (body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&family=Nunito:wght@300;400;600;700&family=WindSong:wght@400;500&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/bootstrap.min.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/templatemo.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/custom.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/style.css?v=<?php echo time(); ?>">

    <!-- Syaahi Manga Theme -->
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/syaahi.css?v=<?php echo time(); ?>">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body class="syaahi-body">
