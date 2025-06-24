-- phpMyAdmin SQL Dump
-- version 5.2.1deb1+deb12u1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Июн 24 2025 г., 11:06
-- Версия сервера: 10.11.11-MariaDB-0+deb12u1
-- Версия PHP: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `topservice_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `activity_log`
--

INSERT INTO `activity_log` (`id`, `user_id`, `action`, `details`, `ip_address`, `created_at`) VALUES
(1, 1, 'user_ban', 'User ID: 3', NULL, '2025-06-11 16:52:56'),
(2, 1, 'user_unban', 'User ID: 3', NULL, '2025-06-11 16:53:01'),
(3, 1, 'user_ban', 'User ID: 2', NULL, '2025-06-11 16:53:03'),
(4, 1, 'user_ban', 'User ID: 3', NULL, '2025-06-11 16:53:28'),
(5, 1, 'user_unban', 'User ID: 2', NULL, '2025-06-11 16:58:46'),
(6, 1, 'user_unban', 'User ID: 3', NULL, '2025-06-11 16:58:48');

-- --------------------------------------------------------

--
-- Структура таблицы `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `content`
--

INSERT INTO `content` (`id`, `user_id`, `title`, `body`, `status`, `created_at`) VALUES
(3, 1, 'Первая новость', 'Текст новости...', 'approved', '2025-04-07 19:30:18'),
(4, 2, 'Вторая новость', 'Еще текст...', 'pending', '2025-04-07 19:30:18'),
(5, 1, 'Первая новость', 'Текст новости...', 'approved', '2025-05-11 21:43:52'),
(6, 2, 'Вторая новость', 'Еще текст...', 'pending', '2025-05-11 21:43:52');

-- --------------------------------------------------------

--
-- Структура таблицы `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `helpline`
--

CREATE TABLE `helpline` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `priority` enum('low','medium','high','critical') DEFAULT 'medium',
  `status` enum('open','in_progress','resolved','closed') DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `resolved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `helpline_files`
--

CREATE TABLE `helpline_files` (
  `id` int(11) NOT NULL,
  `helpline_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(512) NOT NULL,
  `file_size` int(11) NOT NULL,
  `mime_type` varchar(100) DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT current_timestamp(),
  `duration` int(11) DEFAULT NULL COMMENT 'Длительность видео в секундах',
  `thumbnail_path` varchar(512) DEFAULT NULL COMMENT 'Путь к превью (скриншоту видео)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `leads`
--

INSERT INTO `leads` (`id`, `name`, `phone`, `email`, `description`, `message`, `created_at`) VALUES
(1692, 'Резепина Анастасия Алексеевна', '79295001005', '70195471@online.muiv.ru', 'Я', 'тест', '2025-06-20 13:00:56'),
(1729, 'Анастасия', '78929500100', 'anastasi9@outlook.com', NULL, '', '2025-06-21 16:14:51'),
(1730, 'Максим', '79191016122', 'm.baryshnikov@it-horeca.ru', '', '', '2025-06-21 16:18:11'),
(1747, 'Денис', '79857772345', 'seleznev@outlook.com', NULL, '', '2025-06-23 11:34:11'),
(1749, 'Подготовка', '78965416654', 'anastasi9rezepina@yandex.ru', NULL, '....', '2025-06-24 07:43:39'),
(1750, 'тест', '71111111111', 'test@outlook.com', NULL, 'тест', '2025-06-24 10:59:29');

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `type` enum('automation','maintenance','training','other') NOT NULL,
  `base_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `service_requests`
--

CREATE TABLE `service_requests` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('new','in_progress','completed','rejected') DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('open','in_progress','closed') DEFAULT 'open',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `title`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'проблемка', 'пуньк', 'closed', '2025-06-18 12:28:08', '2025-06-18 15:42:47'),
(3, 3, 'Не выходит чек', 'Пречек вышел, а после оплаты не вышел', 'closed', '2025-06-18 12:45:27', '2025-06-18 15:49:40'),
(6, 3, 'Помогите', 'не фурычит\r\n', 'closed', '2025-06-18 16:33:18', '2025-06-19 11:21:10'),
(7, 3, 'Нумерация заявок', 'проверка', 'closed', '2025-06-19 11:01:37', '2025-06-19 14:11:36'),
(8, 11, 'Проблемка', 'подробнее', 'closed', '2025-06-20 10:14:47', '2025-06-23 13:18:54'),
(10, 11, 'Проверка', 'Проверка', 'in_progress', '2025-06-23 10:15:11', '2025-06-23 13:18:37'),
(11, 36, '.', '.', 'open', '2025-06-23 19:12:57', '2025-06-23 22:12:57'),
(12, 11, 'Проблемка', '/', 'closed', '2025-06-23 19:29:54', '2025-06-23 22:30:42'),
(13, 11, 'Подготовка', '...', 'closed', '2025-06-24 07:44:25', '2025-06-24 10:45:08');

-- --------------------------------------------------------

--
-- Структура таблицы `ticket_attachments`
--

CREATE TABLE `ticket_attachments` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `ticket_attachments`
--

INSERT INTO `ticket_attachments` (`id`, `ticket_id`, `file_path`, `created_at`) VALUES
(1, 1, '/uploads/tickets/1750249688_Снимок экрана 2025-06-18 150852.png', '2025-06-18 15:28:08'),
(2, 6, '/uploads/tickets/1750264398_Снимок экрана 2025-06-18 193309.png', '2025-06-18 19:33:18');

-- --------------------------------------------------------

--
-- Структура таблицы `ticket_comments`
--

CREATE TABLE `ticket_comments` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `ticket_comments`
--

INSERT INTO `ticket_comments` (`id`, `ticket_id`, `user_id`, `comment`, `created_at`) VALUES
(6, 3, 3, 'Чековая лента не закончилась?', '2025-06-18 15:46:24'),
(7, 3, 3, 'Ой да', '2025-06-18 15:47:01'),
(8, 3, 1, 'ну вот', '2025-06-18 15:49:40'),
(14, 6, 1, 'В процессе', '2025-06-18 20:18:41'),
(17, 7, 1, 'работает', '2025-06-19 14:11:36'),
(18, 8, 11, 'ну что?\r\n', '2025-06-23 11:44:29'),
(19, 10, 37, 'В работе', '2025-06-23 13:18:37'),
(20, 8, 37, 'Проблемка решена', '2025-06-23 13:18:54'),
(21, 12, 37, '////', '2025-06-23 22:30:42'),
(22, 13, 37, '...', '2025-06-24 10:45:08');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','moderator','user') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_banned` tinyint(1) DEFAULT 0,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `created_at`, `is_banned`, `updated_at`) VALUES
(1, 'admin', '$2y$10$8k.ufvo6CtEdZFGtYxRPVuJrbb6ZpZcFi9VpF39.A.xnsjfYard5e', 'anastasiarezepina@outlook.com', 'admin', '2025-04-07 19:27:21', 0, '2025-06-19 10:50:25'),
(2, 'moderator1', '$2y$10$XNB3raAE9cvsBczO888Bmuyz4GzKd/fpDYW5mLaGI6hJBdjewLhku', 'xaxayxyx@yandex.ru', 'moderator', '2025-04-07 19:27:21', 0, '2025-06-19 10:53:15'),
(3, 'user1', '$2y$10$WKLiuWBqfpR7COxS.VdkXOryWmUmNiLbk0VqbbZXvh2zCFGQY3I1.', 'anastasi9@outlook.com', 'user', '2025-04-07 19:27:21', 0, '2025-06-23 09:14:11'),
(5, 'One&Double', '$2y$10$t1t2fWMW1aoIKcMdUryUWO2s27tQYgrKmUDtJZ8AB0JXCudhotl/2', 'anastasi9rezepina@yandex.ru', 'user', '2025-06-13 23:38:58', 0, '2025-06-19 10:53:46'),
(11, 'Bosco', '$2y$10$SgT7dfBTIDHbOsuElczyleESNZQ7VSZyj8dzbkcPEey/WvhEMcLV.', 'test@outlook.com', 'user', '2025-06-20 10:14:19', 0, '2025-06-20 10:14:19'),
(36, 'Скалка', '$2y$10$5m8kJo0MxMBGOJ8IU2UJ1./4VwFeDPQtHXFHiqWWIT0MTp/a4SrNe', 'skalka@yandex.ru', 'user', '2025-06-23 09:31:25', 0, '2025-06-24 07:45:32'),
(37, 'Диспетчер1', '$2y$10$J2oC/TFlp17qFI7Nn3DabOzPJvmd3zK9roLx9oZ6U6lmj1l0yKYU2', 'ts1@yandex.ru', 'moderator', '2025-06-23 09:32:37', 0, '2025-06-23 09:32:41');

-- --------------------------------------------------------

--
-- Структура таблицы `user_activities`
--

CREATE TABLE `user_activities` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `action_type` enum('login','create','update','delete','other') NOT NULL,
  `entity_type` varchar(30) NOT NULL COMMENT 'Тип сущности: user, ticket, lead и т.д.',
  `entity_id` int(11) DEFAULT NULL COMMENT 'ID затронутой сущности',
  `action_details` text DEFAULT NULL COMMENT 'Детали действия',
  `ip_address` varchar(45) DEFAULT NULL COMMENT 'IP адрес',
  `user_agent` varchar(255) DEFAULT NULL COMMENT 'User-Agent браузера',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_name` (`name`);

--
-- Индексы таблицы `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `idx_name` (`last_name`,`first_name`);

--
-- Индексы таблицы `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_mime` (`mime_type`);

--
-- Индексы таблицы `helpline`
--
ALTER TABLE `helpline`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_priority` (`priority`);

--
-- Индексы таблицы `helpline_files`
--
ALTER TABLE `helpline_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `helpline_id` (`helpline_id`);

--
-- Индексы таблицы `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_type` (`type`);

--
-- Индексы таблицы `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_service` (`service_id`),
  ADD KEY `idx_user` (`user_id`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Индексы таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Индексы таблицы `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `user_activities`
--
ALTER TABLE `user_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_entity` (`entity_type`,`entity_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `helpline`
--
ALTER TABLE `helpline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `helpline_files`
--
ALTER TABLE `helpline_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1751;

--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `ticket_comments`
--
ALTER TABLE `ticket_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT для таблицы `user_activities`
--
ALTER TABLE `user_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `content`
--
ALTER TABLE `content`
  ADD CONSTRAINT `content_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `helpline`
--
ALTER TABLE `helpline`
  ADD CONSTRAINT `helpline_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `helpline_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Ограничения внешнего ключа таблицы `helpline_files`
--
ALTER TABLE `helpline_files`
  ADD CONSTRAINT `helpline_files_ibfk_1` FOREIGN KEY (`helpline_id`) REFERENCES `helpline` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `service_requests`
--
ALTER TABLE `service_requests`
  ADD CONSTRAINT `service_requests_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_requests_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  ADD CONSTRAINT `ticket_attachments_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`);

--
-- Ограничения внешнего ключа таблицы `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD CONSTRAINT `ticket_comments_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`),
  ADD CONSTRAINT `ticket_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
