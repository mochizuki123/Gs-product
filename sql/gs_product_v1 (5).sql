-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2025-02-19 11:10:27
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
-- テーブルの構造 `speech_text_prompt`
--

CREATE TABLE `speech_text_prompt` (
  `id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `text_id` int(12) NOT NULL,
  `text_prompt` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `speech_text_prompt`
--

INSERT INTO `speech_text_prompt` (`id`, `user_id`, `text_id`, `text_prompt`, `created_at`, `updated_at`, `deleted_at`) VALUES
(19, 0, 0, '声の抑揚がほしい', '2025-01-26 18:53:09', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, 0, 0, 'aa', '2025-02-11 08:23:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 0, 0, '良い', '2025-02-11 21:21:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 0, 0, '悪い', '2025-02-11 21:35:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 0, 0, 'cc', '2025-02-15 11:43:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, 0, 0, 'dd', '2025-02-15 11:45:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `speech_text_ready`
--

CREATE TABLE `speech_text_ready` (
  `id` int(11) NOT NULL,
  `user_id` int(12) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text_id` int(12) NOT NULL,
  `text_ready` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `speech_text_ready`
--

INSERT INTO `speech_text_ready` (`id`, `user_id`, `title`, `text_id`, `text_ready`, `created_at`, `updated_at`, `deleted_at`) VALUES
(21, 0, 'TEST', 0, '人生のすばらしさを心から感じよう。', '2025-02-19 11:39:31', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 0, '', 0, 'もちろんです。具体的な内容が必要ない場合は、以下のような短い文章も考えられます。\r\n\r\n「大切な情報を共有します。」\r\n\r\nもし、もう少し具体的な内容をお求めでしたら、スピーチの骨子や伝えたいメッセージを教えていただければ、さらに適した提案が可能です。', '2025-02-19 12:20:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 0, '', 0, '人生の美しさを信じて。', '2025-02-19 12:21:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 0, 'test', 0, '「プログラミングは楽しい！」というメッセージを伝えるスピーチを作成するには、以下のような骨子を考えてみてください：\r\n\r\nスピーチの骨子①: プログラミングの創造性  \r\nスピーチの骨子②: 問題解決能力の向上  \r\nスピーチの骨子③: 学びの楽しさと達成感  \r\nスピーチの骨子④: コミュニティと共有の喜び\r\n\r\nこれらを基に、短く魅力的なスピーチを作成してください。ううう', '2025-02-19 12:23:40', '2025-02-19 05:41:00', '0000-00-00 00:00:00'),
(33, 0, '', 0, 'すばらしい人生を楽しもう！', '2025-02-19 05:16:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 0, '', 0, '「人生は驚きと発見に満ちています。」', '2025-02-19 13:28:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
-- テーブルのインデックス `speech_text_prompt`
--
ALTER TABLE `speech_text_prompt`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `speech_text_ready`
--
ALTER TABLE `speech_text_ready`
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
-- テーブルの AUTO_INCREMENT `speech_text_prompt`
--
ALTER TABLE `speech_text_prompt`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- テーブルの AUTO_INCREMENT `speech_text_ready`
--
ALTER TABLE `speech_text_ready`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
