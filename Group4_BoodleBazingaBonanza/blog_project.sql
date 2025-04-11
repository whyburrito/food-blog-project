-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2025 at 08:06 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `post_id` int(11) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`post_id`, `author_id`, `title`, `content`, `image`, `created_at`, `updated_at`) VALUES
(7, 4, 'Salted Egg Fried Chicken! A New Favorite?', 'I may have just found my new favorite dish 😍\r\n\r\nnah', 'https://kwokspots.com/wp-content/uploads/2022/04/salted-egg-yolk-chicken-wings.png', '2025-03-31 16:39:55', '2025-04-11 04:39:44'),
(8, 3, 'My Go-To Burrito in the City', 'Dish: California Burrito\r\nStuffed with carne asada, crispy fries, and creamy guac, this burrito hits every craving. It’s the kind of meal that fills both your stomach and your soul.', 'https://www.espressomykitchen.com/wp-content/uploads/2024/04/EMK-The-Ultimate-California-Burrito-hero.jpg', '2025-04-01 17:54:47', NULL),
(9, 6, 'The Crispiest Korean Fried Chicken I’ve Tried', 'Dish: Yangnyeom Korean Fried Chicken\r\nSweet, spicy, and unbelievably crunchy — this Korean fried chicken recipe is perfect for food lovers who like bold flavors and finger-licking goodness.', 'https://i.ytimg.com/vi/XnLWBoZn710/maxresdefault.jpg', '2025-04-02 18:26:57', NULL),
(10, 6, 'Why Bibimbap Is My One of My Favorite Food', 'A colorful rice bowl packed with sautéed vegetables, meat, and a fried egg. It\'s balanced, satisfying, and great for meal prep too.', 'https://cdn.apartmenttherapy.info/image/upload/f_jpg,q_auto:eco,c_fill,g_auto,w_1500,ar_4:3/k%2FPhoto%2FRecipes%2F2024-03-bimbimbap%2Fbibimbap-074', '2025-04-03 18:29:04', NULL),
(11, 5, 'I Made Margherita Pizza by Hand', 'With fresh basil, tomato sauce, and gooey mozzarella, this classic pizza proves that sometimes the simplest recipes are the best.', 'https://cdn.shopify.com/s/files/1/0274/9503/9079/files/20220211142754-margherita-9920_5a73220e-4a1a-4d33-b38f-26e98e3cd986.jpg?v=1723650067', '2025-04-04 18:30:49', NULL),
(12, 4, 'Cheesy Goodness: The Perfect Grilled Cheese Sandwich', 'There’s something magical about the simplicity of grilled cheese. Crunchy on the outside, melty on the inside — this recipe keeps it golden and satisfying every time.', 'https://cdn.loveandlemons.com/wp-content/uploads/2023/01/grilled-cheese.jpg', '2025-04-05 18:32:51', NULL),
(13, 3, 'Spice and Everything Nice: Homemade Guacamole', 'This guac recipe is creamy, zesty, and pairs perfectly with chips or even as a taco topper. Easy to make and always a crowd-pleaser.', 'https://blog.blueapron.com/wp-content/uploads/2020/09/guacamole-and-homemade-tortilla-chips.jpg', '2025-04-06 18:34:21', NULL),
(14, 3, 'Easy Chicken Tacos for Weeknight Dinners', 'These tacos come together fast and pack a flavorful punch. Seasoned chicken, fresh toppings, and warm tortillas — dinner doesn\'t get much easier. totally!', 'https://s23209.pcdn.co/wp-content/uploads/2019/08/Easy-Chicken-TacosIMG_9890.jpg', '2025-04-07 18:35:14', '2025-04-11 05:30:50'),
(15, 4, 'A Bowl of Home: Classic Tonkotsu Ramen', 'This ramen isn\'t just food — it\'s comfort in a bowl. The rich pork broth, soft-boiled egg, and tender chashu slices make this a go-to for chilly evenings or lazy Sundays.', 'https://www.seriouseats.com/thmb/IBikLAGkkP2QVaF3vLIk_LeNqHM=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/rich-and-creamy-tonkotsu-ramen-broth-from-scratch-recipe-Diana-Chistruga-hero-6d318fadcca64cc9ac3e1c40fc7682fb.JPG', '2025-04-08 18:37:40', NULL),
(16, 5, 'My Creamy Fettuccine Alfredo Fix', 'Sometimes all you need is a big plate of pasta. This Alfredo recipe is creamy, garlicky, and always hits the spot when you\'re in the mood for something rich.', 'https://www.allrecipes.com/thmb/6iFrYmTh80DMqrMAOYTYKfBawvY=/0x512/filters:no_upscale():max_bytes(150000):strip_icc()/AR-23431-to-die-for-fettuccine-alfredo-DDMFS-beauty-3x4-b64d36c7ff314cb39774e261c5b18352.jpg', '2025-04-09 18:39:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'bruh', '$2y$10$hIwTsv/IOHh2kc1WXzvi5utyj8KVlShXKBCcKhVJoIc8UN10HIzBi', 'user'),
(3, 'SeanHeartBurritos', '$2y$10$6jlajMoAkFrqmAnLseIHg.G5UyzDEJeJOIJ7i5OLvefI/jmPKSadO', 'admin'),
(4, 'warmatthewrox', '$2y$10$gEwFirCWswV90n/hVTsBJeVULHAacbYcB3rhFMVXAngFyxI1wbRBq', 'admin'),
(5, 'LloydHands', '$2y$10$iLiZHSPPZPDPKqdWNjQJYe96I78B6SN3gxIHlXODjSWcIFvR7ZHKi', 'admin'),
(6, 'rysakmbap', '$2y$10$QTKOK7GLMt2m6Nz6COSSj.nbPBmPB3GqdZkjsxyBrsP1xvYAyK2sS', 'admin'),
(7, 'user1', '$2y$10$.hwwMfLnrLiggq8.F01YhuOXrl7bm7jMfW.waYeIxfqMLv5XDkB7u', 'user'),
(10, 'foodisgood', '$2y$10$0DTKkR7O7BMvJzTsc2CPBu0twdM0c4w5S9nhV1BE4B95j1fKlOz3K', 'user'),
(11, 'test', '$2y$10$RlIvYZZv/moWGSZouuoQgue.LOQFDZlmiZUTcnqZffG.KgCGr7DL.', 'user'),
(12, 'hello', '$2y$10$cHbW9lfqv4yIObyWgwbNjOQIZY0ELV4d2Eyz4QPbry6iqBkiHUYaC', 'user'),
(13, 'please', '$2y$10$56DPPIXAlapx7/KCSdIme.YMvqWrvsoSYJ/7GAU65Qldq.JFXGBI.', 'user'),
(14, 'foodie123', '$2y$10$jJSCq0BxxNYK5.rvnD0QROVgU5y8W45WsmYW8YFn4PIL96VTDuufW', 'user'),
(15, 'mmm', '$2y$10$j2vEMV16lra5il9JPRa3.umwZnL.sTY0wj61VORtznN5iYO2J.a7y', 'user'),
(16, 'yum', '$2y$10$YotBcZQwibz0/mi6y7Fit.FPDsDlfJDrVwbqoP1lnl2m2UhANY.hq', 'user'),
(17, 'ilovefood123', '$2y$10$LaqwqbbbiF33vvFSSAp6suHje5izQUpevkEmKRbHcq3Iz3QNkhhaW', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `fk_post_author` (`author_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `fk_post_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
