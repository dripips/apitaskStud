-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 24 2023 г., 04:48
-- Версия сервера: 10.3.36-MariaDB
-- Версия PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `apimang`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `token`) VALUES
(1, 'drip', '$2y$10$fWi6wy6NLnjYYe9LGTOm5eCox3HTd3.SuyFBeokerUCfCwMKZOKD6', '89e36e468f37d7ed254a83d00227f0ac2c970dce24a59b26efe497ea98b6aa4b');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(35, '4К Телевизоры'),
(5, '4К Телевизорыs'),
(30, 'Авто и мото'),
(12, 'Аксессуары для мобильных устройств'),
(13, 'Аудио и наушники'),
(4, 'Бытовая техника'),
(14, 'Видеоигры и консоли'),
(19, 'Гаджеты для автомобилей'),
(26, 'Детские товары'),
(16, 'Домашние кинотеатры'),
(32, 'Животные и зоотовары'),
(31, 'Инструменты и оборудование'),
(11, 'Камеры'),
(3, 'Книги'),
(28, 'Книги и журналы'),
(25, 'Красота и уход'),
(22, 'Кухонные приборы'),
(27, 'Мебель и интерьер'),
(8, 'Ноутбуки'),
(2, 'Одежда'),
(24, 'Одежда и обувь'),
(10, 'Планшеты'),
(18, 'Портативная электроника'),
(7, 'Смартфоны'),
(23, 'Спортивные товары'),
(9, 'Телевизоры'),
(21, 'Техника для дома'),
(15, 'Умные часы'),
(20, 'Устройства хранения данных'),
(17, 'Фотоаппараты'),
(29, 'Хобби и творчество'),
(1, 'Электроника');

-- --------------------------------------------------------

--
-- Структура таблицы `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(6) unsigned NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `employees`
--

INSERT INTO `employees` (`id`, `first_name`, `last_name`, `date_of_birth`, `phone_number`, `email`, `department`, `position`, `hire_date`, `salary`, `created_at`) VALUES
(1, 'John', 'Doe', '1985-07-15', '1234567890', 'johndoe@example.com', 'IT', 'Software Developer', '2020-01-15', 5000.00, '2023-05-22 16:59:02'),
(2, 'Emma', 'Smith', '1990-04-23', '0987654321', 'emmasmith@example.com', 'HR', 'Human Resources Manager', '2018-05-10', 6000.00, '2023-05-22 16:59:02'),
(3, 'Michael', 'Johnson', '1988-09-30', '9876543210', 'michaeljohnson@example.com', 'Sales', 'Sales Executive', '2019-03-22', 4500.00, '2023-05-22 16:59:02'),
(4, 'Sarah', 'Williams', '1993-12-05', '0123456789', 'sarahwilliams@example.com', 'Marketing', 'Marketing Specialist', '2020-08-17', 4800.00, '2023-05-22 16:59:02'),
(5, 'David', 'Brown', '1987-03-12', '5678901234', 'davidbrown@example.com', 'Finance', 'Financial Analyst', '2017-06-08', 5500.00, '2023-05-22 16:59:02'),
(6, 'Jennifer', 'Taylor', '1992-06-25', '4321098765', 'jennifertaylor@example.com', 'IT', 'System Administrator', '2019-02-03', 5200.00, '2023-05-22 16:59:02'),
(7, 'William', 'Anderson', '1991-09-19', '8901234567', 'williamanderson@example.com', 'Operations', 'Operations Manager', '2018-09-14', 6500.00, '2023-05-22 16:59:02'),
(8, 'Sophia', 'Martinez', '1989-02-28', '3456789012', 'sophiamartinez@example.com', 'HR', 'HR Coordinator', '2021-04-05', 4200.00, '2023-05-22 16:59:02'),
(9, 'Daniel', 'Thompson', '1994-08-10', '6789012345', 'danielthompson@example.com', 'Sales', 'Sales Manager', '2016-11-20', 7000.00, '2023-05-22 16:59:02'),
(10, 'Olivia', 'Davis', '1995-05-01', '9012345678', 'oliviadavis@example.com', 'Finance', 'Financial Controller', '2017-07-30', 7500.00, '2023-05-22 16:59:02');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `order_date`) VALUES
(1, 'Иванов', '2023-05-01'),
(2, 'Петров', '2023-05-02'),
(3, 'Сидоров', '2023-05-03');

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 2),
(2, 1, 2, 1),
(3, 2, 3, 3),
(4, 3, 4, 1),
(5, 3, 5, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=294 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `category_id`) VALUES
(1, 'Смартфон', 1000.00, 1),
(2, 'Телевизор', 1500.00, 1),
(3, 'Футболка', 25.00, 2),
(4, 'Джинсы', 50.00, 2),
(5, 'Роман', 10.00, 3),
(6, 'Учебник', 30.00, 3),
(7, 'Холодильник', 800.00, 4),
(8, 'Пылесос', 120.00, 4),
(9, 'iPhone 12', 999.99, 1),
(10, 'Samsung Galaxy S21', 799.99, 1),
(11, 'Google Pixel 5', 699.99, 1),
(12, 'OnePlus 9 Pro', 899.99, 1),
(13, 'Xiaomi Mi 11', 599.99, 1),
(14, 'Huawei P40 Pro', 699.99, 1),
(15, 'Sony Xperia 1 II', 899.99, 1),
(16, 'LG Velvet', 799.99, 1),
(17, 'Motorola Edge', 899.99, 1),
(18, 'Nokia 8.3', 699.99, 1),
(19, 'Google Pixel 4a', 599.99, 1),
(20, 'OnePlus Nord', 699.99, 1),
(21, 'Samsung Galaxy A52', 499.99, 1),
(22, 'Xiaomi Redmi Note 10 Pro', 349.99, 1),
(23, 'Motorola Moto G Power', 249.99, 1),
(24, 'Apple MacBook Pro', 1999.99, 2),
(25, 'Dell XPS 13', 1499.99, 2),
(26, 'HP Spectre x360', 1599.99, 2),
(27, 'Lenovo ThinkPad X1 Carbon', 1799.99, 2),
(28, 'Asus ZenBook 14', 1299.99, 2),
(29, 'Acer Swift 3', 999.99, 2),
(30, 'Microsoft Surface Laptop 4', 1499.99, 2),
(31, 'Razer Blade Stealth', 1699.99, 2),
(32, 'LG Gram', 1399.99, 2),
(33, 'Lenovo Yoga C940', 1299.99, 2),
(34, 'HP Envy x360', 1199.99, 2),
(35, 'Asus ROG Zephyrus G14', 1699.99, 2),
(36, 'Acer Predator Helios 300', 1299.99, 2),
(37, 'MSI GS66 Stealth', 1799.99, 2),
(38, 'Lenovo Legion 5', 1099.99, 2),
(39, 'Samsung QLED Q90T', 1999.99, 3),
(40, 'LG OLED CX', 1799.99, 3),
(41, 'Sony BRAVIA X900H', 1499.99, 3),
(42, 'TCL 6-Series', 999.99, 3),
(43, 'Vizio P-Series Quantum', 1199.99, 3),
(44, 'Hisense H9G', 999.99, 3),
(45, 'Samsung Crystal UHD TU8000', 799.99, 3),
(46, 'LG NanoCell 85 Series', 1299.99, 3),
(47, 'Sony X800H', 899.99, 3),
(48, 'Toshiba Fire TV Edition', 599.99, 3),
(49, 'Insignia Smart 4K UHD TV', 499.99, 3),
(50, 'Samsung The Frame', 1299.99, 3),
(51, 'LG OLED GX', 2499.99, 3),
(52, 'Sony MASTER Series A9G', 2999.99, 3),
(53, 'Vizio OLED TV', 1799.99, 3),
(54, 'Apple AirPods Pro', 249.99, 4),
(55, 'Sony WH-1000XM4', 349.99, 4),
(56, 'Bose QuietComfort 35 II', 299.99, 4),
(57, 'Jabra Elite 75t', 179.99, 4),
(58, 'Sennheiser HD 660 S', 499.99, 4),
(59, 'Beats Solo Pro', 299.99, 4),
(60, 'Bose SoundSport Free', 199.99, 4),
(61, 'JBL Free X', 129.99, 4),
(62, 'Audio-Technica ATH-M50x', 149.99, 4),
(63, 'Skullcandy Indy Evo', 79.99, 4),
(64, 'Samsung Galaxy Buds Pro', 199.99, 4),
(65, 'Anker Soundcore Liberty Air 2 Pro', 129.99, 4),
(66, 'Plantronics BackBeat FIT 3200', 149.99, 4),
(67, 'Sennheiser Momentum True Wireless 2', 299.99, 4),
(68, 'JBL Live 650BTNC', 199.99, 4),
(69, 'Canon EOS R5', 3899.99, 5),
(70, 'Nikon Z7 II', 2999.99, 5),
(71, 'Sony Alpha A7R IV', 3499.99, 5),
(72, 'Fujifilm X-T4', 1699.99, 5),
(73, 'Panasonic Lumix GH5', 1999.99, 5),
(74, 'Olympus OM-D E-M1 Mark III', 1799.99, 5),
(75, 'Leica Q2', 4999.99, 5),
(76, 'Pentax K-1 Mark II', 1999.99, 5),
(77, 'Sony Alpha A6600', 1399.99, 5),
(78, 'Nikon D850', 2999.99, 5),
(79, 'Canon EOS 5D Mark IV', 2499.99, 5),
(80, 'Fujifilm X100V', 1399.99, 5),
(81, 'Olympus PEN-F', 999.99, 5),
(82, 'Sony Cyber-shot RX100 VII', 1199.99, 5),
(83, 'Panasonic Lumix LX100 II', 799.99, 5),
(129, 'iPhone 12', 999.99, 1),
(130, 'Samsung Galaxy S21', 799.99, 1),
(131, 'Google Pixel 5', 699.99, 1),
(132, 'OnePlus 9 Pro', 899.99, 1),
(133, 'Xiaomi Mi 11', 599.99, 1),
(134, 'Huawei P40 Pro', 699.99, 1),
(135, 'Sony Xperia 1 II', 899.99, 1),
(136, 'LG Velvet', 799.99, 1),
(137, 'Motorola Edge', 899.99, 1),
(138, 'Nokia 8.3', 699.99, 1),
(139, 'Google Pixel 4a', 599.99, 1),
(140, 'OnePlus Nord', 699.99, 1),
(141, 'Samsung Galaxy A52', 499.99, 1),
(142, 'Xiaomi Redmi Note 10 Pro', 349.99, 1),
(143, 'Motorola Moto G Power', 249.99, 1),
(144, 'Apple MacBook Pro', 1999.99, 2),
(145, 'Dell XPS 13', 1499.99, 2),
(146, 'HP Spectre x360', 1599.99, 2),
(147, 'Lenovo ThinkPad X1 Carbon', 1799.99, 2),
(148, 'Asus ZenBook 14', 1299.99, 2),
(149, 'Acer Swift 3', 999.99, 2),
(150, 'Microsoft Surface Laptop 4', 1499.99, 2),
(151, 'Razer Blade Stealth', 1699.99, 2),
(152, 'LG Gram', 1399.99, 2),
(153, 'Lenovo Yoga C940', 1299.99, 2),
(154, 'HP Envy x360', 1199.99, 2),
(155, 'Asus ROG Zephyrus G14', 1699.99, 2),
(156, 'Acer Predator Helios 300', 1299.99, 2),
(157, 'MSI GS66 Stealth', 1799.99, 2),
(158, 'Lenovo Legion 5', 1099.99, 2),
(159, 'Samsung QLED Q90T', 1999.99, 3),
(160, 'LG OLED CX', 1799.99, 3),
(161, 'Sony BRAVIA X900H', 1499.99, 3),
(162, 'TCL 6-Series', 999.99, 3),
(163, 'Vizio P-Series Quantum', 1199.99, 3),
(164, 'Hisense H9G', 999.99, 3),
(165, 'Samsung Crystal UHD TU8000', 799.99, 3),
(166, 'LG NanoCell 85 Series', 1299.99, 3),
(167, 'Sony X800H', 899.99, 3),
(168, 'Toshiba Fire TV Edition', 599.99, 3),
(169, 'Insignia Smart 4K UHD TV', 499.99, 3),
(170, 'Samsung The Frame', 1299.99, 3),
(171, 'LG OLED GX', 2499.99, 3),
(172, 'Sony MASTER Series A9G', 2999.99, 3),
(173, 'Vizio OLED TV', 1799.99, 3),
(174, 'Apple AirPods Pro', 249.99, 4),
(175, 'Sony WH-1000XM4', 349.99, 4),
(176, 'Bose QuietComfort 35 II', 299.99, 4),
(177, 'Jabra Elite 75t', 179.99, 4),
(178, 'Sennheiser HD 660 S', 499.99, 4),
(179, 'Beats Solo Pro', 299.99, 4),
(180, 'Bose SoundSport Free', 199.99, 4),
(181, 'JBL Free X', 129.99, 4),
(182, 'Audio-Technica ATH-M50x', 149.99, 4),
(183, 'Skullcandy Indy Evo', 79.99, 4),
(184, 'Samsung Galaxy Buds Pro', 199.99, 4),
(185, 'Anker Soundcore Liberty Air 2 Pro', 129.99, 4),
(186, 'Plantronics BackBeat FIT 3200', 149.99, 4),
(187, 'Sennheiser Momentum True Wireless 2', 299.99, 4),
(188, 'JBL Live 650BTNC', 199.99, 4),
(189, 'Canon EOS R5', 3899.99, 5),
(190, 'Nikon Z7 II', 2999.99, 5),
(191, 'Sony Alpha A7R IV', 3499.99, 5),
(192, 'Fujifilm X-T4', 1699.99, 5),
(193, 'Panasonic Lumix GH5', 1999.99, 5),
(194, 'Olympus OM-D E-M1 Mark III', 1799.99, 5),
(195, 'Leica Q2', 4999.99, 5),
(196, 'Pentax K-1 Mark II', 1999.99, 5),
(197, 'Sony Alpha A6600', 1399.99, 5),
(198, 'Nikon D850', 2999.99, 5),
(199, 'Canon EOS 5D Mark IV', 2499.99, 5),
(200, 'Fujifilm X100V', 1399.99, 5),
(201, 'Olympus PEN-F', 999.99, 5),
(202, 'Sony Cyber-shot RX100 VII', 1199.99, 5),
(203, 'Panasonic Lumix LX100 II', 799.99, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(6) unsigned NOT NULL,
  `user_id` int(6) unsigned DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `transaction_type` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `amount`, `transaction_date`, `transaction_type`, `description`) VALUES
(1, 1, 100.00, '2023-05-01 07:30:00', 'Пополнение', 'Пополнение счета'),
(2, 1, -50.00, '2023-05-02 12:45:00', 'Списание', 'Оплата за товар'),
(3, 2, 200.00, '2023-05-03 06:15:00', 'Пополнение', 'Пополнение счета'),
(4, 2, -75.50, '2023-05-04 09:20:00', 'Списание', 'Оплата за услуги'),
(5, 3, 150.00, '2023-05-05 08:10:00', 'Пополнение', 'Пополнение счета'),
(6, 3, -30.00, '2023-05-06 11:25:00', 'Списание', 'Оплата за подписку'),
(7, 4, 80.00, '2023-05-07 05:40:00', 'Пополнение', 'Пополнение счета'),
(8, 4, -20.00, '2023-05-08 13:55:00', 'Списание', 'Оплата за доставку'),
(9, 5, 250.00, '2023-05-09 07:05:00', 'Пополнение', 'Пополнение счета'),
(10, 5, -40.50, '2023-05-10 10:15:00', 'Списание', 'Оплата за услуги'),
(11, 1, -25.00, '2023-05-11 06:30:00', 'Списание', 'Оплата за услуги'),
(12, 2, 150.00, '2023-05-12 11:45:00', 'Пополнение', 'Пополнение счета'),
(13, 3, -50.50, '2023-05-13 07:15:00', 'Списание', 'Оплата за товар'),
(14, 4, 100.00, '2023-05-14 08:20:00', 'Пополнение', 'Пополнение счета'),
(15, 5, -75.00, '2023-05-15 05:30:00', 'Списание', 'Оплата за услуги'),
(16, 1, 200.00, '2023-05-16 09:40:00', 'Пополнение', 'Пополнение счета'),
(17, 2, -30.50, '2023-05-17 06:50:00', 'Списание', 'Оплата за услуги'),
(18, 3, 80.00, '2023-05-18 11:10:00', 'Пополнение', 'Пополнение счета'),
(19, 4, -20.00, '2023-05-19 08:25:00', 'Списание', 'Оплата за доставку'),
(20, 5, 250.00, '2023-05-20 07:35:00', 'Пополнение', 'Пополнение счета'),
(21, 1, -40.50, '2023-05-21 10:50:00', 'Списание', 'Оплата за услуги'),
(22, 2, 180.00, '2023-05-22 05:15:00', 'Пополнение', 'Пополнение счета'),
(23, 3, -60.00, '2023-05-23 11:25:00', 'Списание', 'Оплата за товар'),
(24, 4, 120.00, '2023-05-24 08:40:00', 'Пополнение', 'Пополнение счета'),
(25, 5, -90.50, '2023-05-25 06:55:00', 'Списание', 'Оплата за услуги'),
(26, 1, 220.00, '2023-05-26 09:05:00', 'Пополнение', 'Пополнение счета'),
(27, 2, -50.00, '2023-05-27 07:20:00', 'Списание', 'Оплата за услуги'),
(28, 3, 100.00, '2023-05-28 11:30:00', 'Пополнение', 'Пополнение счета'),
(29, 4, -15.50, '2023-05-29 08:45:00', 'Списание', 'Оплата за доставку'),
(30, 5, 280.00, '2023-05-30 07:55:00', 'Пополнение', 'Пополнение счета'),
(31, 1, -45.00, '2023-05-31 10:10:00', 'Списание', 'Оплата за услуги'),
(32, 2, 210.00, '2023-06-01 05:30:00', 'Пополнение', 'Пополнение счета'),
(33, 3, -70.50, '2023-06-02 11:40:00', 'Списание', 'Оплата за товар'),
(34, 4, 140.00, '2023-06-03 08:55:00', 'Пополнение', 'Пополнение счета'),
(35, 5, -85.00, '2023-06-04 07:10:00', 'Списание', 'Оплата за услуги'),
(36, 1, 240.00, '2023-06-05 09:20:00', 'Пополнение', 'Пополнение счета'),
(37, 2, -35.50, '2023-06-06 06:35:00', 'Списание', 'Оплата за услуги'),
(38, 3, 120.00, '2023-06-07 11:50:00', 'Пополнение', 'Пополнение счета'),
(39, 4, -25.00, '2023-06-08 09:05:00', 'Списание', 'Оплата за доставку'),
(40, 5, 310.00, '2023-06-09 07:20:00', 'Пополнение', 'Пополнение счета'),
(41, 1, -50.50, '2023-06-10 10:35:00', 'Списание', 'Оплата за услуги'),
(42, 11, 88.44, '2023-05-22 17:00:34', 'Пополнение', 'Пополнение счета'),
(43, 12, 26.27, '2023-05-22 17:00:34', 'Пополнение', 'Пополнение счета'),
(44, 13, 66.01, '2023-05-22 17:00:34', 'Пополнение', 'Пополнение счета'),
(45, 14, 51.26, '2023-05-22 17:00:34', 'Пополнение', 'Пополнение счета'),
(46, 15, 58.25, '2023-05-22 17:00:34', 'Пополнение', 'Пополнение счета'),
(47, 16, 37.47, '2023-05-22 17:00:34', 'Пополнение', 'Пополнение счета'),
(48, 17, 12.63, '2023-05-22 17:00:34', 'Пополнение', 'Пополнение счета'),
(49, 18, 50.71, '2023-05-22 17:00:34', 'Пополнение', 'Пополнение счета'),
(50, 19, 15.66, '2023-05-22 17:00:34', 'Пополнение', 'Пополнение счета'),
(51, 20, 26.18, '2023-05-22 17:00:34', 'Пополнение', 'Пополнение счета');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(6) unsigned NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `balance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `full_name`, `date_of_birth`, `phone_number`, `email`, `balance`) VALUES
(1, 'John Doe', '1990-05-10', '1234567890', 'test@example.com', 500.00),
(2, 'Sara Prow', '1985-11-15', '0987654321', 'user2@example.com', 700.00),
(3, 'Michael Brown', '1992-07-03', '9876543210', 'user3@example.com', 300.00),
(4, 'Sarah Davis', '1988-09-22', '0123456789', 'user4@example.com', 900.00),
(5, 'David Wilson', '1995-02-28', '5678901234', 'user5@example.com', 200.00),
(6, 'Jennifer Taylor', '1991-04-12', '4321098765', 'user6@example.com', 600.00),
(7, 'William Anderson', '1987-12-07', '8901234567', 'user7@example.com', 400.00),
(8, 'Sophia Martinez', '1993-08-19', '3456789012', 'user8@example.com', 800.00),
(9, 'Daniel Thompson', '1997-06-25', '6789012345', 'user9@example.com', 100.00),
(10, 'Olivia Johnson', '1994-03-01', '9012345678', 'user10@example.com', 1000.00),
(11, 'Иван Иванов', '1990-05-10', '1234567890', 'user11@example.com', 500.00),
(12, 'Елена Смирнова', '1985-11-15', '0987654321', 'user12@example.com', 700.00),
(13, 'Алексей Петров', '1992-07-03', '9876543210', 'user13@example.com', 300.00),
(14, 'Мария Сидорова', '1988-09-22', '0123456789', 'user14@example.com', 900.00),
(15, 'Сергей Волков', '1995-02-28', '5678901234', 'user15@example.com', 200.00),
(16, 'Ольга Кузнецова', '1991-04-12', '4321098765', 'user16@example.com', 600.00),
(17, 'Дмитрий Морозов', '1987-12-07', '8901234567', 'user17@example.com', 400.00),
(18, 'Анна Новикова', '1993-08-19', '3456789012', 'user18@example.com', 800.00),
(19, 'Павел Козлов', '1997-06-25', '6789012345', 'user19@example.com', 100.00),
(20, 'Екатерина Зайцева', '1994-03-01', '9012345678', 'user20@example.com', 1000.00);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT для таблицы `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=294;
--
-- AUTO_INCREMENT для таблицы `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Ограничения внешнего ключа таблицы `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
