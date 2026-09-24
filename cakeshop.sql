-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 25 sep. 2026 à 00:59
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cakeshop`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Popular Desserts', 'Our customers\' favorite treats, all in one place'),
(2, 'Cakes', 'Classic layered cakes for birthdays and celebrations'),
(3, 'Cheesecakes', 'Creamy cheesecakes on a crisp biscuit base'),
(4, 'Cupcakes', 'Individually iced cupcakes, baked fresh daily'),
(5, 'Tarts', 'Sweet tarts with fruit, chocolate and caramel'),
(6, 'Mini Cakes', 'Small single-serving cakes, full-size flavor'),
(7, 'Pastries', 'Morning pastries and viennoiserie, baked fresh'),
(8, 'Gluten-Free', 'Bakes made without gluten, without compromise'),
(9, 'Vegan', '100% plant-based cakes and treats'),
(10, 'Seasonal', 'Limited-time bakes for the season'),
(11, 'Wedding Cakes', 'Made-to-order centerpieces for your big day');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','preparing','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `delivery_address` text NOT NULL,
  `notes` text DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `delivery_address`, `notes`, `order_date`) VALUES
(1, 2, 6.50, 'preparing', 'hanakuzabsqkba', '', '2026-09-24 22:49:43');

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`) VALUES
(1, 1, 1, 1, 6.50);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `ingredients` text DEFAULT NULL,
  `sizes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category_id`, `stock`, `is_available`, `ingredients`, `sizes`, `created_at`) VALUES
(1, 'Tiramisu', 'One of our best-sellers, made fresh in-house and loved by regulars and first-time visitors alike.', 6.50, 'tiramisu.jpg', 1, 15, 1, 'Varies by item — see description', NULL, '2026-09-24 22:41:32'),
(2, 'Black Forest', 'One of our best-sellers, made fresh in-house and loved by regulars and first-time visitors alike.', 29.00, 'black_forest.jpg', 1, 15, 1, 'Varies by item — see description', '6\" (serves 6) $29.00, 8\" (serves 8-10) $37.50, 10\" (serves 12-15) $52.00', '2026-09-24 22:41:32'),
(3, 'NY Cheesecake', 'One of our best-sellers, made fresh in-house and loved by regulars and first-time visitors alike.', 25.00, 'ny_cheesecake.jpg', 1, 15, 1, 'Varies by item — see description', '6\" (serves 6) $25.00, 8\" (serves 8-10) $32.50, 10\" (serves 12-15) $45.00', '2026-09-24 22:41:32'),
(4, 'Chocolate Delight', 'A moist, generously filled layer cake, baked fresh every day. Perfect for birthdays and celebrations.', 26.00, 'chocolate_delight.jpg', 2, 12, 1, 'Flour, Sugar, Eggs, Butter, Milk, Vanilla', '6\" (serves 6) $26.00, 8\" (serves 8-10) $34.00, 10\" (serves 12-15) $47.00', '2026-09-24 22:41:32'),
(5, 'Red Velvet', 'A moist, generously filled layer cake, baked fresh every day. Perfect for birthdays and celebrations.', 28.00, 'red_velvet.jpg', 2, 12, 1, 'Flour, Sugar, Eggs, Butter, Milk, Vanilla', '6\" (serves 6) $28.00, 8\" (serves 8-10) $36.50, 10\" (serves 12-15) $50.50', '2026-09-24 22:41:32'),
(6, 'Caramel Crunch', 'A moist, generously filled layer cake, baked fresh every day. Perfect for birthdays and celebrations.', 27.00, 'caramel_crunch.jpg', 2, 12, 1, 'Flour, Sugar, Eggs, Butter, Milk, Vanilla', '6\" (serves 6) $27.00, 8\" (serves 8-10) $35.00, 10\" (serves 12-15) $48.50', '2026-09-24 22:41:32'),
(7, 'Oreo Drip', 'A moist, generously filled layer cake, baked fresh every day. Perfect for birthdays and celebrations.', 29.00, 'oreo_drip.jpg', 2, 12, 1, 'Flour, Sugar, Eggs, Butter, Milk, Vanilla', '6\" (serves 6) $29.00, 8\" (serves 8-10) $37.50, 10\" (serves 12-15) $52.00', '2026-09-24 22:41:32'),
(8, 'Vanilla Dream', 'A moist, generously filled layer cake, baked fresh every day. Perfect for birthdays and celebrations.', 24.00, 'vanilla_dream.jpg', 2, 12, 1, 'Flour, Sugar, Eggs, Butter, Milk, Vanilla', '6\" (serves 6) $24.00, 8\" (serves 8-10) $31.00, 10\" (serves 12-15) $43.00', '2026-09-24 22:41:32'),
(9, 'Strawberry Shortcake', 'A moist, generously filled layer cake, baked fresh every day. Perfect for birthdays and celebrations.', 26.00, 'strawberry_shortcake.jpg', 2, 12, 1, 'Flour, Sugar, Eggs, Butter, Milk, Vanilla', '6\" (serves 6) $26.00, 8\" (serves 8-10) $34.00, 10\" (serves 12-15) $47.00', '2026-09-24 22:41:32'),
(10, 'Rustic Cake', 'A moist, generously filled layer cake, baked fresh every day. Perfect for birthdays and celebrations.', 170.00, 'rustic.jpg', 11, 12, 1, 'Flour, Sugar, Eggs, Butter, Milk, Vanilla', '2 tiers (serves 20) $170.00, 3 tiers (serves 40) $255.00, 4 tiers (serves 60) $357.00', '2026-09-24 22:41:32'),
(11, 'Hot Chocolate Cake', 'A moist, generously filled layer cake, baked fresh every day. Perfect for birthdays and celebrations.', 27.00, 'hot_chocolate_cake.jpg', 2, 12, 1, 'Flour, Sugar, Eggs, Butter, Milk, Vanilla', '6\" (serves 6) $27.00, 8\" (serves 8-10) $35.00, 10\" (serves 12-15) $48.50', '2026-09-24 22:41:32'),
(12, 'Gingerbread', 'A moist, generously filled layer cake, baked fresh every day. Perfect for birthdays and celebrations.', 24.00, 'gingerbread.jpg', 10, 12, 1, 'Flour, Sugar, Eggs, Butter, Milk, Vanilla', '6\" (serves 6) $24.00, 8\" (serves 8-10) $31.20, 10\" (serves 12-15) $43.20', '2026-09-24 22:41:32'),
(13, 'Fruit Basket Cake', 'A moist, generously filled layer cake, baked fresh every day. Perfect for birthdays and celebrations.', 32.00, 'fruit_basket.jpg', 2, 12, 1, 'Flour, Sugar, Eggs, Butter, Milk, Vanilla', '6\" (serves 6) $32.00, 8\" (serves 8-10) $41.50, 10\" (serves 12-15) $57.50', '2026-09-24 22:41:32'),
(14, 'Blueberry Cheesecake', 'A rich, creamy cheesecake set on a crisp biscuit base, made with quality cream cheese.', 25.00, 'blueberry_cheese.jpg', 3, 10, 1, 'Cream cheese, Sugar, Eggs, Biscuit crust, Butter, Cream', '6\" (serves 6) $25.00, 8\" (serves 8-10) $32.50', '2026-09-24 22:41:32'),
(15, 'Mango Cheesecake', 'A rich, creamy cheesecake set on a crisp biscuit base, made with quality cream cheese.', 26.00, 'mango_cheese.jpg', 3, 10, 1, 'Cream cheese, Sugar, Eggs, Biscuit crust, Butter, Cream', '6\" (serves 6) $26.00, 8\" (serves 8-10) $34.00', '2026-09-24 22:41:32'),
(16, 'Oreo Cheesecake', 'A rich, creamy cheesecake set on a crisp biscuit base, made with quality cream cheese.', 25.00, 'oreo_cheese.jpg', 3, 10, 1, 'Cream cheese, Sugar, Eggs, Biscuit crust, Butter, Cream', '6\" (serves 6) $25.00, 8\" (serves 8-10) $32.50', '2026-09-24 22:41:32'),
(17, 'Caramel Cupcake', 'A perfectly moist cupcake topped with a generous swirl of buttercream.', 4.20, 'caramel_cup.jpg', 4, 30, 1, 'Flour, Sugar, Eggs, Butter, Milk, Buttercream', NULL, '2026-09-24 22:41:32'),
(18, 'Coconut Cupcake', 'A perfectly moist cupcake topped with a generous swirl of buttercream.', 4.20, 'coconut_cup.jpg', 4, 30, 1, 'Flour, Sugar, Eggs, Butter, Milk, Buttercream', NULL, '2026-09-24 22:41:32'),
(19, 'Lemon Cupcake', 'A perfectly moist cupcake topped with a generous swirl of buttercream.', 4.00, 'lemon_cup.jpg', 4, 30, 1, 'Flour, Sugar, Eggs, Butter, Milk, Buttercream', NULL, '2026-09-24 22:41:32'),
(20, 'Peanut Cupcake', 'A perfectly moist cupcake topped with a generous swirl of buttercream.', 4.50, 'peanut_cup.jpg', 4, 30, 1, 'Flour, Sugar, Eggs, Butter, Milk, Buttercream', NULL, '2026-09-24 22:41:32'),
(21, 'Red Velvet Cupcake', 'A perfectly moist cupcake topped with a generous swirl of buttercream.', 4.50, 'redvelvet_cup.jpg', 4, 30, 1, 'Flour, Sugar, Eggs, Butter, Milk, Buttercream', NULL, '2026-09-24 22:41:32'),
(22, 'Strawberry Cupcake', 'A perfectly moist cupcake topped with a generous swirl of buttercream.', 3.80, 'strawberry_cupcake.jpg', 4, 30, 1, 'Flour, Sugar, Eggs, Butter, Milk, Buttercream', NULL, '2026-09-24 22:41:32'),
(23, 'Nutella Cupcake', 'A perfectly moist cupcake topped with a generous swirl of buttercream.', 4.80, 'nutella_cup.jpg', 4, 30, 1, 'Flour, Sugar, Eggs, Butter, Milk, Buttercream', NULL, '2026-09-24 22:41:32'),
(24, 'Apple Crumble Tart', 'A crisp, buttery pastry shell with a generous filling, baked fresh every morning.', 19.00, 'apple_crumble_tart.jpg', 5, 12, 1, 'Flour, Butter, Sugar, Eggs, Seasonal fruit or filling', '6\" (serves 4) $19.00, 8\" (serves 6) $26.50, 10\" (serves 8) $34.00', '2026-09-24 22:41:32'),
(25, 'Blueberry Tart', 'A crisp, buttery pastry shell with a generous filling, baked fresh every morning.', 20.00, 'blueberry_tart.jpg', 5, 12, 1, 'Flour, Butter, Sugar, Eggs, Seasonal fruit or filling', '6\" (serves 4) $20.00, 8\" (serves 6) $28.00, 10\" (serves 8) $36.00', '2026-09-24 22:41:32'),
(26, 'Caramel Nut Tart', 'A crisp, buttery pastry shell with a generous filling, baked fresh every morning.', 21.00, 'caramel_nut_tart.jpg', 5, 12, 1, 'Flour, Butter, Sugar, Eggs, Seasonal fruit or filling', '6\" (serves 4) $21.00, 8\" (serves 6) $29.50, 10\" (serves 8) $38.00', '2026-09-24 22:41:32'),
(27, 'Chocolate Tart', 'A crisp, buttery pastry shell with a generous filling, baked fresh every morning.', 20.00, 'chocolate_tart.jpg', 5, 12, 1, 'Flour, Butter, Sugar, Eggs, Seasonal fruit or filling', '6\" (serves 4) $20.00, 8\" (serves 6) $28.00, 10\" (serves 8) $36.00', '2026-09-24 22:41:32'),
(28, 'Fruit Tart', 'A crisp, buttery pastry shell with a generous filling, baked fresh every morning.', 21.00, 'fruit_tart.jpg', 5, 12, 1, 'Flour, Butter, Sugar, Eggs, Seasonal fruit or filling', '6\" (serves 4) $21.00, 8\" (serves 6) $29.50, 10\" (serves 8) $38.00', '2026-09-24 22:41:32'),
(29, 'Lemon Tart', 'A crisp, buttery pastry shell with a generous filling, baked fresh every morning.', 19.00, 'lemon_tart.jpg', 5, 12, 1, 'Flour, Butter, Sugar, Eggs, Seasonal fruit or filling', '6\" (serves 4) $19.00, 8\" (serves 6) $26.50, 10\" (serves 8) $34.00', '2026-09-24 22:41:32'),
(30, 'Raspberry Tart', 'A crisp, buttery pastry shell with a generous filling, baked fresh every morning.', 22.00, 'raspberry_tart.jpg', 5, 12, 1, 'Flour, Butter, Sugar, Eggs, Seasonal fruit or filling', '6\" (serves 4) $22.00, 8\" (serves 6) $31.00, 10\" (serves 8) $39.50', '2026-09-24 22:41:32'),
(31, 'Strawberry Tart', 'A crisp, buttery pastry shell with a generous filling, baked fresh every morning.', 22.00, 'strawberry_tart.jpg', 5, 12, 1, 'Flour, Butter, Sugar, Eggs, Seasonal fruit or filling', '6\" (serves 4) $22.00, 8\" (serves 6) $31.00, 10\" (serves 8) $39.50', '2026-09-24 22:41:32'),
(32, 'Summer Berry Tart', 'A crisp, buttery pastry shell with a generous filling, baked fresh every morning.', 23.00, 'summer_berry_tart.jpg', 5, 12, 1, 'Flour, Butter, Sugar, Eggs, Seasonal fruit or filling', '6\" (serves 4) $23.00, 8\" (serves 6) $32.00, 10\" (serves 8) $41.50', '2026-09-24 22:41:32'),
(33, 'Lemon Raspberry Tart', 'A crisp, buttery pastry shell with a generous filling, baked fresh every morning.', 22.00, 'lemon_raspberry.jpg', 5, 12, 1, 'Flour, Butter, Sugar, Eggs, Seasonal fruit or filling', '6\" (serves 4) $22.00, 8\" (serves 6) $31.00, 10\" (serves 8) $39.50', '2026-09-24 22:41:32'),
(34, 'Mini Black Forest', 'A single-serving cake with all the flavor of the full-size version, in a smaller portion.', 6.80, 'mini_black_forest.jpg', 6, 20, 1, 'Flour, Sugar, Eggs, Butter, Cream', NULL, '2026-09-24 22:41:32'),
(35, 'Mini Caramel Cake', 'A single-serving cake with all the flavor of the full-size version, in a smaller portion.', 6.50, 'mini_caramel_cake.jpg', 6, 20, 1, 'Flour, Sugar, Eggs, Butter, Cream', NULL, '2026-09-24 22:41:32'),
(36, 'Mini Chocolate Cake', 'A single-serving cake with all the flavor of the full-size version, in a smaller portion.', 6.50, 'mini_chocolate_cake.jpg', 6, 20, 1, 'Flour, Sugar, Eggs, Butter, Cream', NULL, '2026-09-24 22:41:32'),
(37, 'Mini Lemon Drop', 'A single-serving cake with all the flavor of the full-size version, in a smaller portion.', 6.00, 'mini_lemon_drop.jpg', 6, 20, 1, 'Flour, Sugar, Eggs, Butter, Cream', NULL, '2026-09-24 22:41:32'),
(38, 'Mini Red Velvet', 'A single-serving cake with all the flavor of the full-size version, in a smaller portion.', 7.00, 'mini_red_velvet.jpg', 6, 20, 1, 'Flour, Sugar, Eggs, Butter, Cream', NULL, '2026-09-24 22:41:32'),
(39, 'Mini Vanilla Bean', 'A single-serving cake with all the flavor of the full-size version, in a smaller portion.', 6.00, 'mini_vanilla_bean.jpg', 6, 20, 1, 'Flour, Sugar, Eggs, Butter, Cream', NULL, '2026-09-24 22:41:32'),
(40, 'Almond Croissant', 'A pure butter pastry, crisp outside and soft inside, baked fresh every morning.', 3.00, 'almond_croissant.jpg', 7, 35, 1, 'Flour, Butter, Milk, Sugar, Yeast, Salt', NULL, '2026-09-24 22:41:32'),
(41, 'Chocolate Croissant', 'A pure butter pastry, crisp outside and soft inside, baked fresh every morning.', 2.80, 'chocolate_croissant.jpg', 7, 35, 1, 'Flour, Butter, Milk, Sugar, Yeast, Salt', NULL, '2026-09-24 22:41:32'),
(42, 'Pain Chocolat', 'A pure butter pastry, crisp outside and soft inside, baked fresh every morning.', 2.70, 'pain_chocolat.jpg', 7, 35, 1, 'Flour, Butter, Milk, Sugar, Yeast, Salt', NULL, '2026-09-24 22:41:32'),
(43, 'Cinnamon Roll', 'A pure butter pastry, crisp outside and soft inside, baked fresh every morning.', 3.30, 'cinnamon_roll.jpg', 7, 35, 1, 'Flour, Butter, Milk, Sugar, Yeast, Salt', NULL, '2026-09-24 22:41:32'),
(44, 'Fruit Danish', 'A pure butter pastry, crisp outside and soft inside, baked fresh every morning.', 3.50, 'fruit_danish.jpg', 7, 35, 1, 'Flour, Butter, Milk, Sugar, Yeast, Salt', NULL, '2026-09-24 22:41:32'),
(45, 'Apple Turnover', 'A pure butter pastry, crisp outside and soft inside, baked fresh every morning.', 2.90, 'apple_turnover.jpg', 7, 35, 1, 'Flour, Butter, Milk, Sugar, Yeast, Salt', NULL, '2026-09-24 22:41:32'),
(46, 'GF Almond Cake', 'Baked without gluten, with the same care and flavor as our classic recipes.', 24.00, 'gluten_free_almond.jpg', 8, 8, 1, 'Rice flour, Almond flour, Sugar, Eggs, Butter', '6\" (serves 6) $24.00, 8\" (serves 8-10) $31.00, 10\" (serves 12-15) $43.00', '2026-09-24 22:41:32'),
(47, 'GF Brownie', 'Baked without gluten, with the same care and flavor as our classic recipes.', 3.80, 'gluten_free_brownie.jpg', 8, 8, 1, 'Rice flour, Almond flour, Sugar, Eggs, Butter', NULL, '2026-09-24 22:41:32'),
(48, 'GF Carrot Cake', 'Baked without gluten, with the same care and flavor as our classic recipes.', 23.00, 'gluten_free_carrot.jpg', 8, 8, 1, 'Rice flour, Almond flour, Sugar, Eggs, Butter', '6\" (serves 6) $23.00, 8\" (serves 8-10) $30.00, 10\" (serves 12-15) $41.50', '2026-09-24 22:41:32'),
(49, 'GF Chocolate Cake', 'Baked without gluten, with the same care and flavor as our classic recipes.', 25.00, 'gluten_free_chocolate.jpg', 8, 8, 1, 'Rice flour, Almond flour, Sugar, Eggs, Butter', '6\" (serves 6) $25.00, 8\" (serves 8-10) $32.50, 10\" (serves 12-15) $45.00', '2026-09-24 22:41:32'),
(50, 'GF Lemon Cake', 'Baked without gluten, with the same care and flavor as our classic recipes.', 23.00, 'gluten_free_lemon.jpg', 8, 8, 1, 'Rice flour, Almond flour, Sugar, Eggs, Butter', '6\" (serves 6) $23.00, 8\" (serves 8-10) $30.00, 10\" (serves 12-15) $41.50', '2026-09-24 22:41:32'),
(51, 'Vegan Berry Cake', 'Made without eggs or dairy, with no compromise on taste or texture.', 25.00, 'vegan_berry.jpg', 9, 8, 1, 'Flour, Sugar, Vegetable oil, Plant-based milk, Vanilla', '6\" (serves 6) $25.00, 8\" (serves 8-10) $32.50, 10\" (serves 12-15) $45.00', '2026-09-24 22:41:32'),
(52, 'Vegan Carrot Cake', 'Made without eggs or dairy, with no compromise on taste or texture.', 24.00, 'vegan_carrot.jpg', 9, 8, 1, 'Flour, Sugar, Vegetable oil, Plant-based milk, Vanilla', '6\" (serves 6) $24.00, 8\" (serves 8-10) $31.00, 10\" (serves 12-15) $43.00', '2026-09-24 22:41:32'),
(53, 'Vegan Chocolate', 'Made without eggs or dairy, with no compromise on taste or texture.', 25.00, 'vegan_choc.jpg', 9, 8, 1, 'Flour, Sugar, Vegetable oil, Plant-based milk, Vanilla', '6\" (serves 6) $25.00, 8\" (serves 8-10) $32.50, 10\" (serves 12-15) $45.00', '2026-09-24 22:41:32'),
(54, 'Easter Carrot', 'A limited-time bake, available only while the season lasts.', 26.00, 'easter_carrot.jpg', 10, 10, 1, 'Seasonal ingredients — see description', '6\" (serves 6) $26.00, 8\" (serves 8-10) $34.00, 10\" (serves 12-15) $47.00', '2026-09-24 22:41:32'),
(55, 'Pumpkin Spice', 'A limited-time bake, available only while the season lasts.', 26.00, 'pumpkin_spice.jpg', 10, 10, 1, 'Seasonal ingredients — see description', '6\" (serves 6) $26.00, 8\" (serves 8-10) $34.00, 10\" (serves 12-15) $47.00', '2026-09-24 22:41:32'),
(56, 'Yule Log', 'A limited-time bake, available only while the season lasts.', 30.00, 'yule_log.jpg', 10, 10, 1, 'Seasonal ingredients — see description', '6\" (serves 6) $30.00, 8\" (serves 8-10) $39.00, 10\" (serves 12-15) $54.00', '2026-09-24 22:41:32'),
(57, 'Lavender Cake', 'A limited-time bake, available only while the season lasts.', 28.00, 'lavender.jpg', 10, 10, 1, 'Seasonal ingredients — see description', '6\" (serves 6) $28.00, 8\" (serves 8-10) $36.50, 10\" (serves 12-15) $50.50', '2026-09-24 22:41:32'),
(58, 'Champagne Cake', 'A custom-order centerpiece cake, designed and priced per event; the listed price is a starting estimate.', 180.00, 'champagne.jpg', 11, 3, 1, 'Flour, Sugar, Eggs, Butter, Milk, Fondant or buttercream (custom per design)', '2 tiers (serves 20) $180.00, 3 tiers (serves 40) $270.00, 4 tiers (serves 60) $378.00', '2026-09-24 22:41:32'),
(59, 'Cherry Blossom', 'A custom-order centerpiece cake, designed and priced per event; the listed price is a starting estimate.', 195.00, 'cherry_blossom.jpg', 11, 3, 1, 'Flour, Sugar, Eggs, Butter, Milk, Fondant or buttercream (custom per design)', '2 tiers (serves 20) $195.00, 3 tiers (serves 40) $292.50, 4 tiers (serves 60) $409.50', '2026-09-24 22:41:32'),
(60, 'Pearl Cake', 'A custom-order centerpiece cake, designed and priced per event; the listed price is a starting estimate.', 210.00, 'pearl.jpg', 11, 3, 1, 'Flour, Sugar, Eggs, Butter, Milk, Fondant or buttercream (custom per design)', '2 tiers (serves 20) $210.00, 3 tiers (serves 40) $315.00, 4 tiers (serves 60) $441.00', '2026-09-24 22:41:32'),
(61, 'White Rose', 'A custom-order centerpiece cake, designed and priced per event; the listed price is a starting estimate.', 190.00, 'white_rose.jpg', 11, 3, 1, 'Flour, Sugar, Eggs, Butter, Milk, Fondant or buttercream (custom per design)', '2 tiers (serves 20) $190.00, 3 tiers (serves 40) $285.00, 4 tiers (serves 60) $399.00', '2026-09-24 22:41:32'),
(62, 'Matilda chocolate Cake', 'A custom-order centerpiece cake, designed and priced per event; the listed price is a starting estimate.', 30.00, 'wedding_cake_hero.jpg', 2, 3, 1, 'Flour, Sugar, Eggs, Butter, Milk, Fondant or buttercream (custom per design)', '6\" (serves 6) $30.00, 8\" (serves 8-10) $39.00, 10\" (serves 12-15) $54.00', '2026-09-24 22:41:32');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('client','admin') NOT NULL DEFAULT 'client',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `phone`, `password`, `role`, `created_at`) VALUES
(1, 'Administrator', 'admin@cakeshop.com', NULL, '$2y$12$H1j.h1xChY7AYgV7GPTfpuPg9qQlRWVxIATUbhippP5EzwS63UjKu', 'admin', '2026-09-24 22:41:32'),
(2, 'hanine hosni', 'Haninehosni@gmail.com', 'hosni@gmail.com', '$2y$10$mxbpj01yk5nKVsrOXZUyzutqPROy0RTBBuf6DKiSx6ldNNRgj5J/i', 'client', '2026-09-24 22:49:12');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_categories_name` (`name`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_orders_user` (`user_id`);

--
-- Index pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_items_order` (`order_id`),
  ADD KEY `idx_items_product` (`product_id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_products_category` (`category_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_users_email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
