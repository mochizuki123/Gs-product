-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2025-02-06 11:58:35
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `gs_product_v1`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `speech_file`
--

CREATE TABLE `speech_file` (
  `file_id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `content_file` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `speech_text`
--

CREATE TABLE `speech_text` (
  `id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `text_id` int(12) NOT NULL,
  `speech_text` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `speech_text`
--

INSERT INTO `speech_text` (`id`, `user_id`, `text_id`, `speech_text`, `created_at`, `updated_at`, `deleted_at`) VALUES
(19, 0, 0, '声の抑揚がほしい', '2025-01-26 18:53:09', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `user_id` varchar(12) NOT NULL,
  `login_pw` varchar(12) NOT NULL,
  `user_name` varchar(64) NOT NULL,
  `user_email` varchar(64) NOT NULL,
  `kanri_flg` int(1) NOT NULL,
  `life_flg` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`user_id`, `login_pw`, `user_name`, `user_email`, `kanri_flg`, `life_flg`) VALUES
('owner', 'owner', 'mochizuki', '', 1, 0),
('test', 'test', 'testさん', '', 0, 0);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `speech_text`
--
ALTER TABLE `speech_text`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `speech_text`
--
ALTER TABLE `speech_text`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
