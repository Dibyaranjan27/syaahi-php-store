<?php
/**
 * Syaahi - Application Configuration
 */

// Database Configuration
define('DB_HOST', getenv('MYSQL_HOST') ?: 'localhost');
define('DB_NAME', getenv('MYSQL_DATABASE') ?: 'syaahi');
define('DB_USER', getenv('MYSQL_USER') ?: 'root');
define('DB_PASS', getenv('MYSQL_PASSWORD') ?: '');

// Site Configuration
define('SITE_NAME', 'Syaahi');
define('SITE_URL', '/');
define('SITE_TAGLINE', 'Your Book & Sticker Store ✨');

// Brand Colors (Manga/Anime Pastel Theme)
define('BRAND_PRIMARY', '#B8A9E8');
define('BRAND_SECONDARY', '#FFB7C5');
define('BRAND_DARK', '#4A3F6B');
