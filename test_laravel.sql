-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 11 2017 г., 23:51
-- Версия сервера: 5.6.34
-- Версия PHP: 7.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test_laravel`
--

-- --------------------------------------------------------

--
-- Структура таблицы `appointments`
--

DROP TABLE IF EXISTS `appointments`;
CREATE TABLE `appointments` (
  `id` int(10) UNSIGNED NOT NULL,
  `datetime` datetime NOT NULL,
  `place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contacts` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `note` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `appointments`
--

INSERT INTO `appointments` (`id`, `datetime`, `place`, `contacts`, `company_id`, `person_id`, `note`, `status`, `created_at`, `updated_at`) VALUES
(1, '1970-01-01 00:00:00', '1 222', NULL, 1, NULL, NULL, 'active', '2017-06-11 11:52:05', '2017-06-11 11:52:05'),
(2, '1970-01-01 00:00:00', '222', NULL, 1, NULL, NULL, 'active', '2017-06-11 11:54:49', '2017-06-11 11:54:49'),
(3, '2017-06-11 11:11:00', 'Tyumen', NULL, 2, 4, '123', 'confirm', '2017-06-11 12:02:16', '2017-06-11 17:03:53'),
(4, '2017-01-01 19:40:00', '1 Tyumen', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 4, NULL, 'active', '2017-06-11 12:02:16', '2017-06-11 15:18:26'),
(5, '2017-06-11 11:11:00', '3 Tyumen', NULL, 2, 4, NULL, 'confirm', '2017-06-11 12:02:16', '2017-06-11 17:03:03'),
(6, '2017-06-11 11:11:00', '4 Tyumen', NULL, 2, 4, NULL, 'active', '2017-06-11 12:02:16', '2017-06-11 12:02:16'),
(8, '2017-06-11 11:11:00', '6 Tyumen', NULL, 2, 4, NULL, 'cancel', '2017-06-11 12:02:16', '2017-06-11 17:02:57'),
(9, '2017-06-11 11:11:00', '7 Tyumen', NULL, 2, 4, NULL, 'active', '2017-06-11 12:02:16', '2017-06-11 12:02:16'),
(10, '2017-06-11 11:11:00', '8 Tyumen', NULL, 2, 4, NULL, 'active', '2017-06-11 12:02:16', '2017-06-11 12:02:16'),
(11, '2017-06-11 11:11:00', '9 Tyumen', NULL, 2, 4, NULL, 'active', '2017-06-11 12:02:16', '2017-06-11 12:02:16'),
(12, '2017-06-11 11:11:00', '10 Tyumen', NULL, 2, 4, NULL, 'active', '2017-06-11 12:02:16', '2017-06-11 12:02:16'),
(13, '2017-06-11 11:11:00', '11 Tyumen', NULL, 2, 4, NULL, 'active', '2017-06-11 12:02:16', '2017-06-11 12:02:16'),
(14, '1970-01-01 00:00:00', 'Tyumen', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 2, 4, NULL, 'active', '2017-06-11 14:55:57', '2017-06-11 14:55:57'),
(15, '2017-06-11 11:11:00', '4 Tyumen', NULL, 2, 4, NULL, 'active', '2017-06-11 12:02:16', '2017-06-11 12:02:16'),
(16, '2017-06-11 11:11:00', '11 Tyumen', NULL, 2, 4, NULL, 'active', '2017-06-11 12:02:16', '2017-06-11 12:02:16');

-- --------------------------------------------------------

--
-- Структура таблицы `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `house_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `companies`
--

INSERT INTO `companies` (`id`, `name`, `locality`, `street`, `house_number`, `postal_code`, `url`, `created_at`, `updated_at`) VALUES
(1, 'Super tables', 'Tyumen', 'Permyakova', '1', '1111', NULL, NULL, NULL),
(2, 'Micro chair', 'Moskow', 'Gorkogo', '1', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2017_06_11_103921_create_appointments_table', 1),
(2, '2017_06_11_105112_create_companies_table', 1),
(3, '2017_06_11_105148_create_people_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `people`
--

DROP TABLE IF EXISTS `people`;
CREATE TABLE `people` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salutation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `people`
--

INSERT INTO `people` (`id`, `company_id`, `first_name`, `last_name`, `telephone`, `email`, `salutation`, `created_at`, `updated_at`) VALUES
(1, 1, 'Aleksey', 'Ivanov', '+7(111)222 33-44', NULL, NULL, NULL, NULL),
(2, 1, 'Artem', 'Guskov', NULL, 'guskov@mail.ru', NULL, NULL, NULL),
(3, 2, 'Anna', 'Vasilyeva', NULL, 'vasilyeva@mail.ru', NULL, NULL, NULL),
(4, 2, 'Victoria', 'Alegrova', '+7(999)222 33-44', 'alegrova@mail.ru', NULL, NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT для таблицы `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `people`
--
ALTER TABLE `people`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
