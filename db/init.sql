-- Syaahi Database Initialization
-- Books & Stickers E-Commerce Platform

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- Table: admin
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
(1, 'admin1', 'admin1@gmail.com', '$2y$10$LgAHzPZYOFv7ESGxFq5HNOhGkr8bVsYBXkqJEi6FH9yVYqxBs3gUy'),
(2, 'admin2', 'admin2@gmail.com', '$2y$10$LgAHzPZYOFv7ESGxFq5HNOhGkr8bVsYBXkqJEi6FH9yVYqxBs3gUy');

-- --------------------------------------------------------
-- Table: users
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(30) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `type` int(1) NOT NULL DEFAULT 1,
  `Status` int(1) DEFAULT 1,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `UserName` (`UserName`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`UserID`, `UserName`, `Email`, `Password`, `Phone`, `type`, `Status`) VALUES
(1, 'Dibya', 'dibya@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1234567890', 1, 1),
(2, 'TestUser', 'test@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '9876543210', 1, 1);
-- All user passwords: 'password' (bcrypt hashed)

-- --------------------------------------------------------
-- Table: categories (Books & Stickers)
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `categories` (
  `CategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(40) NOT NULL,
  PRIMARY KEY (`CategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`CategoryID`, `CategoryName`) VALUES
(1, 'Fiction'),
(2, 'Non-Fiction'),
(3, 'Manga & Comics'),
(4, 'Academic'),
(5, 'Children Books'),
(6, 'Sticker Packs'),
(7, 'Decorative Stickers'),
(8, 'Journal Stickers');

-- --------------------------------------------------------
-- Table: products (Books & Stickers)
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `products` (
  `ProductId` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) NOT NULL,
  `Description` varchar(500) NOT NULL,
  `IsAvailable` varchar(10) NOT NULL DEFAULT 'AVAILABLE',
  `Price` int(11) NOT NULL,
  `ImgPath` varchar(300) NOT NULL,
  `Rating` int(11) NOT NULL DEFAULT 0,
  `Brand` varchar(50) NOT NULL DEFAULT '',
  `Size` varchar(30) NOT NULL DEFAULT '',
  `Specification` varchar(200) NOT NULL DEFAULT '',
  `CategoryID` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`ProductId`),
  KEY `fk_product_category` (`CategoryID`),
  CONSTRAINT `fk_product_category` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`CategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `products` (`ProductId`, `Title`, `Description`, `IsAvailable`, `Price`, `ImgPath`, `Rating`, `Brand`, `Size`, `Specification`, `CategoryID`) VALUES
(1, 'The Great Gatsby', 'A timeless classic by F. Scott Fitzgerald exploring wealth, love, and the American Dream in the Jazz Age.', 'AVAILABLE', 299, 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=400&h=600&fit=crop', 5, 'Penguin Classics', 'Paperback', 'Fiction', 1),
(2, 'Atomic Habits', 'James Clear reveals practical strategies for forming good habits, breaking bad ones, and mastering tiny behaviors.', 'AVAILABLE', 399, 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?w=400&h=600&fit=crop', 5, 'Random House', 'Paperback', 'Non-Fiction', 2),
(3, 'Sapiens: A Brief History', 'Yuval Noah Harari takes you on a journey through the entire history of humankind from Stone Age to Silicon Age.', 'AVAILABLE', 499, 'https://images.unsplash.com/photo-1531988042231-d39a9cc12a9a?w=400&h=600&fit=crop', 5, 'Vintage Books', 'Paperback', 'Non-Fiction', 2),
(4, 'One Piece Vol. 1', 'Join Monkey D. Luffy on his epic quest to find the legendary treasure One Piece and become King of the Pirates!', 'AVAILABLE', 350, 'https://images.unsplash.com/photo-1618519764620-7403abdbdfe9?w=400&h=600&fit=crop', 5, 'Viz Media', 'Manga', 'Manga & Comics', 3),
(5, 'Naruto Vol. 1', 'The beloved ninja saga begins! Follow Naruto Uzumaki as he trains to become the greatest Hokage.', 'AVAILABLE', 350, 'https://images.unsplash.com/photo-1613376023733-0a73315d9b06?w=400&h=600&fit=crop', 4, 'Viz Media', 'Manga', 'Manga & Comics', 3),
(6, 'Data Structures & Algorithms', 'Comprehensive guide to DSA with examples in C++ and Java. Perfect for interview prep.', 'AVAILABLE', 599, 'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=400&h=600&fit=crop', 4, 'McGraw Hill', 'Paperback', 'Academic', 4),
(7, 'The Very Hungry Caterpillar', 'Eric Carle''s beloved picture book about a caterpillar''s journey through food and transformation.', 'AVAILABLE', 250, 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=400&h=600&fit=crop', 5, 'Puffin Books', 'Hardcover', 'Children Books', 5),
(8, 'Harry Potter & The Sorcerer''s Stone', 'J.K. Rowling''s magical tale where Harry discovers he''s a wizard and begins his Hogwarts adventure.', 'AVAILABLE', 450, 'https://images.unsplash.com/photo-1626618012641-bfbca5a31239?w=400&h=600&fit=crop', 5, 'Bloomsbury', 'Paperback', 'Fiction', 1),
(9, 'Kawaii Animal Sticker Pack', 'Adorable pack of 50 cute animal stickers — cats, bunnies, bears, and more! Perfect for journals and laptops.', 'AVAILABLE', 149, 'https://images.unsplash.com/photo-1572375992501-4b0892d50c69?w=400&h=600&fit=crop', 4, 'Syaahi Originals', 'Mixed', 'Sticker Pack', 6),
(10, 'Floral Aesthetic Stickers', 'Beautiful set of 30 watercolor floral stickers. Great for planners, scrapbooks, and decoration.', 'AVAILABLE', 129, 'https://images.unsplash.com/photo-1513542789411-b6a5d4f31634?w=400&h=600&fit=crop', 4, 'Syaahi Originals', 'A6 Sheet', 'Sticker Pack', 6),
(11, 'Motivational Quote Stickers', 'Set of 25 inspiring quote stickers with beautiful typography. Brighten up your workspace!', 'AVAILABLE', 99, 'https://images.unsplash.com/photo-1531346878377-a5be20888e57?w=400&h=600&fit=crop', 3, 'Syaahi Originals', 'Mixed', 'Sticker Pack', 7),
(12, 'Bullet Journal Sticker Kit', 'Complete sticker kit for bullet journaling — includes tabs, icons, headers, and decorative elements.', 'AVAILABLE', 199, 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=400&h=600&fit=crop', 5, 'Syaahi Originals', 'A5 Sheets', 'Journal Stickers', 8),
(13, 'The Alchemist', 'Paulo Coelho''s enchanting novel about a shepherd boy''s journey to find treasure and discover his destiny.', 'AVAILABLE', 299, 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=400&h=600&fit=crop', 5, 'HarperOne', 'Paperback', 'Fiction', 1),
(14, 'My Hero Academia Vol. 1', 'In a world where superpowers are common, one boy without them dreams of becoming the greatest hero.', 'AVAILABLE', 399, 'https://images.unsplash.com/photo-1612178537253-bccd437b730e?w=400&h=600&fit=crop', 4, 'Viz Media', 'Manga', 'Manga & Comics', 3),
(15, 'Vintage Travel Stickers', 'Pack of 40 retro travel destination stickers. Perfect for suitcases, laptops, and scrapbooks.', 'AVAILABLE', 179, 'https://images.unsplash.com/photo-1553991562-9f24b119ff51?w=400&h=600&fit=crop', 4, 'Syaahi Originals', 'Mixed', 'Sticker Pack', 7);

-- --------------------------------------------------------
-- Table: shoppingcart
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `shoppingcart` (
  `ShoppingCartId` int(11) NOT NULL AUTO_INCREMENT,
  `ProductId` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL DEFAULT 1,
  `Price` int(11) NOT NULL,
  `clientId` int(11) NOT NULL,
  PRIMARY KEY (`ShoppingCartId`),
  KEY `fk_cart_product` (`ProductId`),
  KEY `fk_cart_user` (`clientId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: orders
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `orders` (
  `orderId` varchar(200) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `Price` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL DEFAULT 1,
  `DateOfOrder` varchar(100) NOT NULL,
  `clientId` int(11) NOT NULL,
  PRIMARY KEY (`orderId`),
  KEY `fk_order_product` (`ProductId`),
  KEY `fk_order_user` (`clientId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: wishlist
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_wishlist` (`user_id`, `product_id`),
  KEY `fk_wishlist_product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: comments (product reviews)
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `comments` (
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `Date` date NOT NULL,
  `Status` int(1) NOT NULL DEFAULT 1,
  `Details` varchar(500) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  PRIMARY KEY (`commentID`),
  KEY `fk_comment_user` (`UserID`),
  KEY `fk_comment_product` (`ProductId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `comments` (`commentID`, `Date`, `Status`, `Details`, `UserID`, `ProductId`) VALUES
(1, '2026-08-20', 1, 'Absolutely loved this book! The storytelling is incredible. Couldn''t put it down! 📖', 1, 1),
(2, '2026-08-21', 1, 'Changed my life. I''ve already built 3 new habits using these techniques!', 2, 2),
(3, '2026-08-22', 1, 'These stickers are SO cute! Perfect for my bullet journal 💜', 1, 9),
(4, '2026-08-23', 1, 'Great quality manga, the print is sharp and the story is amazing as always!', 2, 4);

-- --------------------------------------------------------
-- Table: feedback (contact form)
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: blog_posts
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(300) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_blog_author` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `blog_posts` (`id`, `title`, `content`, `image_url`, `author_id`) VALUES
(1, 'Welcome to Syaahi ✒️', 'Welcome to Syaahi — your cozy corner for books and stickers! We believe in the magic of reading and the joy of decorating your world with beautiful stickers. Whether you are a bookworm looking for your next page-turner, a manga enthusiast collecting volumes, or a sticker lover decorating journals and laptops — Syaahi has something special for you.\n\nOur name comes from the Hindi word स्याही (syaahi), meaning ink. Just as ink brings stories to life on paper, we aim to bring stories and creativity into your everyday life.', 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=800&h=400&fit=crop', 1),
(2, 'Top 5 Must-Read Books This Season 📚', 'Looking for your next great read? Here are our top picks that we absolutely love this season:\n\n1. The Great Gatsby — A timeless classic that never gets old\n2. Atomic Habits — Transform your daily routines\n3. Sapiens — Understand humanity like never before\n4. The Alchemist — A journey of self-discovery\n5. Harry Potter — Magic never goes out of style!\n\nEach of these books offers something unique and unforgettable. Drop by our shop to grab your copy!', 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=800&h=400&fit=crop', 1),
(3, 'How to Start a Sticker Collection 🌸', 'Sticker collecting is one of the most fun and creative hobbies you can pick up! Here is how to get started:\n\n• Start with a theme — kawaii animals, florals, vintage travel, or motivational quotes\n• Get a sticker album or use a journal to display your favorites\n• Mix and match — combine different styles for a unique aesthetic\n• Trade with friends — sticker swapping is a wonderful way to grow your collection\n• Support indie creators — handmade stickers have so much character!\n\nCheck out our sticker collection at Syaahi for beautiful, hand-curated packs!', 'https://images.unsplash.com/photo-1513542789411-b6a5d4f31634?w=800&h=400&fit=crop', 2);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
