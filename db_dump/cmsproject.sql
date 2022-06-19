-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pon 20. čen 2022, 00:00
-- Verze serveru: 10.4.24-MariaDB
-- Verze PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `cmsproject`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `image_title` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `file_name`, `image_title`, `status`) VALUES
(69, '629faf371ace5.jpg', 'Sunset', 1),
(70, '629faf51f3db0.jpg', 'Lake', 1),
(71, '629faf6857a79.jpg', 'Fox', 1),
(72, '629faf8358e97.jpg', 'City', 1),
(73, '629fafa971251.jpg', 'Stars', 1),
(74, '629fafdbbf413.jpg', 'Waterfall', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` varchar(100) NOT NULL,
  `country` varchar(255) NOT NULL,
  `shipping_provider_id` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `cardholder` varchar(255) NOT NULL,
  `card_number` varchar(255) NOT NULL,
  `expiration` varchar(255) NOT NULL,
  `cvv` varchar(100) NOT NULL,
  `products` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `total_price` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `orders`
--

INSERT INTO `orders` (`order_id`, `fname`, `lname`, `email`, `phone`, `address`, `postal_code`, `country`, `shipping_provider_id`, `payment_method`, `cardholder`, `card_number`, `expiration`, `cvv`, `products`, `total_price`, `created`) VALUES
(27, 'test', 'test', 'test@seznam.cz', '+420705021314', 'teststreet1137006', '370 05', 'Czech Republic', 1, 'mastercard', 'test', '5559769864569669', '01/98', '946', '{\"52\":1,\"53\":2}', '2066.561725', '2022-06-18 12:58:39');

-- --------------------------------------------------------

--
-- Struktura tabulky `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `main_title` varchar(255) NOT NULL,
  `main_content` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `pages`
--

INSERT INTO `pages` (`id`, `meta_title`, `main_title`, `main_content`, `title`, `content`) VALUES
(1, 'Home', 'Home page', 'Welcome to the CMS project home page', 'Another title', 'another content'),
(2, 'About us', 'This is about us page', 'Welcome to the about us page', 'Another title', 'another content'),
(3, 'Contact us', 'Welcome to the contact us page', 'feel free to contact us', 'Another title', 'another content'),
(4, 'Thank you', 'Thank you for contacting us', 'We will reply as soon as possible.', 'Another title', 'another content'),
(5, 'Contact form submitted', 'You have already submitted the contact form', 'Please be patient as we process your message.', 'Another title', 'another content'),
(6, 'Gallery', 'Gallery content', 'Welcome to our gallery', 'Another title', 'another content'),
(7, 'Shop', 'Shop', 'Welcome to our shop', 'Shopping is life', ''),
(9, 'Shopping cart', 'Shopping cart', 'This is shopping cart content', '', '');

-- --------------------------------------------------------

--
-- Struktura tabulky `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `product_weight` decimal(15,5) NOT NULL,
  `image_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `type`, `price`, `product_weight`, `image_name`) VALUES
(56, 'Asus X-97', 'High performance gaming pc', 'Gaming PC', 2150, '15.94000', '62af802d6ed87.jpg'),
(57, 'Iphone 7', 'best-selling mobile phone on the market', 'mobile phone', 670, '1.23000', '62af811f219c5.jpg'),
(58, 'MacBook 10 pro', 'professional laptop for work', 'laptop', 1340, '6.35000', '62af81c521809.jpg');

-- --------------------------------------------------------

--
-- Struktura tabulky `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `entity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `routes`
--

INSERT INTO `routes` (`id`, `url`, `module`, `action`, `entity_id`) VALUES
(1, 'home', 'page', '', 1),
(2, 'about_us', 'page', '', 2),
(3, 'contact_us', 'contact', '', 3),
(4, 'gallery', 'gallery', '', 6),
(9, 'shop', 'shop', '', 7),
(11, 'product', 'product', '', 0),
(13, 'shopping_cart', 'cart', '', 9),
(14, 'shipping_form', 'shipping', 'shippingForm', 10),
(15, 'login', 'entry', 'login', 0),
(16, 'register', 'entry', 'register', 0),
(17, 'logout', 'entry', 'logout', 0),
(18, 'shipping_method', 'shipping', 'shippingMethod', 0),
(19, 'credit_card', 'payment', '', 0),
(20, 'summary', 'summary', '', 0),
(21, 'order_successfully_sent', 'summary', 'orderCompleted', 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `shipping_providers`
--

CREATE TABLE `shipping_providers` (
  `id` int(11) NOT NULL,
  `provider_name` varchar(255) NOT NULL,
  `price_per_kilo` decimal(5,5) NOT NULL,
  `logo_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `shipping_providers`
--

INSERT INTO `shipping_providers` (`id`, `provider_name`, `price_per_kilo`, `logo_name`) VALUES
(1, 'dpd', '0.75000', 'DPD_logo_(2015).svg'),
(2, 'ppl', '0.65000', 'ppl-logo.png');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` varchar(100) NOT NULL,
  `country` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `privileges` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `username`, `fname`, `lname`, `email`, `phone`, `address`, `postal_code`, `country`, `password`, `privileges`) VALUES
(1, 'admin', 'Admin', 'Admin', 'google@gmail.com', '', '', '', '', '$2y$10$VmKrxZSOFqcA4mJVJvQZXuNL1ZeF2n58QrkTcXLJp96Uh.rw80E3e', 'admin'),
(3, 'JamesNew11', 'James', 'Newman', 'jimmy.newman@gmail.com', '+420101121311', 'Address 123/4', '370 05', 'Czech Republic', '$2y$10$Nwk0LI.kfCe6xNGplwEKAupzHUv5lO1cckySf2B9kF.eNDEnB08U6', 'user');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexy pro tabulku `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `shipping_providers`
--
ALTER TABLE `shipping_providers`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT pro tabulku `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pro tabulku `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pro tabulku `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT pro tabulku `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pro tabulku `shipping_providers`
--
ALTER TABLE `shipping_providers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
