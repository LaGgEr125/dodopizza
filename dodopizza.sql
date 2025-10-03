-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 30 2025 г., 13:21
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `dodopizza`
--

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE `goods` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `price` float NOT NULL,
  `description` varchar(255) NOT NULL,
  `img` varchar(1000) NOT NULL,
  `category` enum('pizza','snacks','salads','drinks') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`id`, `name`, `price`, `description`, `img`, `category`) VALUES
(1, 'Пеперони', 650, 'Острая пицца с колбасками пепперони, увеличенной порцией моццареллы и фирменным томатным соусом на тонком тесте', 'pepe.avif', 'pizza'),
(2, 'Маргарита', 550, 'Классика с нежным сочетанием моццареллы, сочных томатов и ароматного базилика на воздушном тесте', 'margarita.avif', 'pizza'),
(3, 'Диабло', 700, 'Огненно-острая пицца с колбасками чоризо, перцем халапеньо, моццареллой и томатным соусом', 'diablo.avif', 'pizza'),
(4, 'Сырная', 750, 'Роскошная четырехсырная пицца с моццареллой, пармезаном, дор блю и чеддером под сливочным соусом', 'chees.avif', 'pizza'),
(5, 'Колбаски барбекю', 720, 'Пикантная пицца с копчеными колбасками, луком, сладким перцем и фирменным соусом барбекю', 'bbq_chicken.avif', 'pizza'),
(6, 'Наггетсы', 250, 'Хрустящие куриные наггетсы в панировке, подаются с соусом на выбор: сырный, барбекю или чесночный', 'nagets.avif', 'snacks'),
(7, 'Креветки', 300, 'Крупные тигровые креветки в хрустящей панировке с соусом тар-тар и долькой лимона', 'kruetcki.avif', 'snacks'),
(8, 'Овощной салат', 400, 'Свежие сезонные овощи: томаты, огурцы, болгарский перец с зеленью и оливковым маслом', 'ovoch.avif', 'salads'),
(9, 'Цезарь салат', 380, 'Классический салат с хрустящими листьями айсберга, курицей-гриль, пармезаном и соусом цезарь', 'cezar.avif', 'salads'),
(10, 'Добрая кола', 150, 'Освежающий безалкогольный газированный напиток 0.5л в экологичной алюминиевой банке', 'cola.avif', 'drinks'),
(11, 'Добрая лимон лайм', 180, 'Тонизирующий напиток с ярким вкусом лимона и лайма, идеально сочетается с пиццей', 'lime.avif', 'drinks'),
(12, 'Морс Вишня', 160, 'Натуральный ягодный морс с вишней, приготовленный по традиционному рецепту', 'mors.avif', 'drinks'),
(13, 'Греческий салат', 240, 'Средиземноморский вкус с хрустящим салатом айсберг, томатами черри, маслинами, огурцом и брынзой', 'grechesky.avif', 'salads');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('new','processing','completed','cancelled') NOT NULL DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `goods`
--
ALTER TABLE `goods`
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
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `goods` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
