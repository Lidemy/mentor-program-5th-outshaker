-- Adminer 4.8.1 MySQL 5.5.5-10.4.19-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE `mtr04group5`;

SET NAMES utf8mb4;

CREATE TABLE `sixwings-blog-posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL COMMENT '文章標題',
  `content` text NOT NULL COMMENT '文章內容',
  `posted_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建立時間',
  `status` enum('draft','publish','deleted') NOT NULL COMMENT '文章狀態',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `sixwings-blog-users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(128) NOT NULL COMMENT '管理員名稱',
  `pass` varchar(128) NOT NULL COMMENT '密碼(hashed)',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 2021-07-25 11:26:31
