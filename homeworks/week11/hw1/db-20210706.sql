-- Adminer 4.8.1 MySQL 5.5.5-10.4.19-MariaDB dump

SET NAMES utf8;
SET time_zone = '+08:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `demo` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `demo`;

CREATE TABLE `sixwings-comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `user_id` int(10) unsigned NOT NULL COMMENT '使用者編號',
  `content` text NOT NULL COMMENT '內容',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建立時間',
  `is_del` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否刪除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `sixwings-roles` (
  `role_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色編號',
  `role_name` varchar(32) NOT NULL COMMENT '角色名稱',
  `add` tinyint(4) NOT NULL DEFAULT 1 COMMENT '可否新增留言',
  `edit_range` enum('NONE','OWN','ALL') NOT NULL DEFAULT 'OWN' COMMENT '編輯留言範圍',
  `del_range` enum('NONE','OWN','ALL') NOT NULL DEFAULT 'OWN' COMMENT '刪除留言範圍',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `sixwings-users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `role` tinyint(3) unsigned NOT NULL DEFAULT 2 COMMENT '身分',
  `nickname` varchar(64) NOT NULL COMMENT '暱稱',
  `username` varchar(64) CHARACTER SET utf8 NOT NULL COMMENT '帳號',
  `pass` varchar(128) CHARACTER SET utf8 NOT NULL COMMENT '密碼',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '帳號建立時間',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `sixwings-v_comments` (`id` int(10) unsigned, `owner_id` int(10) unsigned, `username` varchar(64), `nickname` varchar(64), `content` text, `created_at` datetime);


DROP TABLE IF EXISTS `sixwings-v_comments`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `sixwings-v_comments` AS (select `c`.`id` AS `id`,`c`.`user_id` AS `owner_id`,`u`.`username` AS `username`,`u`.`nickname` AS `nickname`,`c`.`content` AS `content`,`c`.`created_at` AS `created_at` from (`sixwings-comments` `c` left join `sixwings-users` `u` on(`c`.`user_id` = `u`.`id`)) where `c`.`is_del` = 0);

-- 2021-07-06 13:21:54
