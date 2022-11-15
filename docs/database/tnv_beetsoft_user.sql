/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MariaDB
 Source Server Version : 100334 (10.3.34-MariaDB-0ubuntu0.20.04.1)
 Source Host           : localhost:3306
 Source Schema         : bapi

 Target Server Type    : MariaDB
 Target Server Version : 100334 (10.3.34-MariaDB-0ubuntu0.20.04.1)
 File Encoding         : 65001

 Date: 15/11/2022 09:38:51
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tnv_beetsoft_user
-- ----------------------------
DROP TABLE IF EXISTS `tnv_beetsoft_user`;
CREATE TABLE `tnv_beetsoft_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `department_id` int(11) unsigned NOT NULL COMMENT 'Id của phòng / ban',
  `parent` int(11) NOT NULL DEFAULT 0 COMMENT 'ID user cha',
  `username` varchar(255) NOT NULL COMMENT 'Username duy nhất trong hệ thống',
  `fullname` varchar(255) NOT NULL COMMENT 'Fullname',
  `address` varchar(255) NOT NULL COMMENT 'địa chỉ',
  `email` varchar(255) NOT NULL COMMENT 'Email beetsoft, email cần phải là duy nhất trong toàn bộ hệ thống',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Active, 0 = Deactive, 2 = Wait active',
  `avatar` varchar(256) DEFAULT NULL,
  `group_id` int(11) unsigned NOT NULL COMMENT 'ID của nhóm quyền được phân',
  `password` varchar(255) NOT NULL,
  `reset_password` tinyint(1) DEFAULT 0 COMMENT '0 - chưa cập nhật , 1- đã cập nhật',
  `updated_pass` datetime NOT NULL,
  `phone` varchar(255) NOT NULL,
  `note` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `salt` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `activation_key` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `google_token` varchar(256) NOT NULL,
  `google_refresh_token` varchar(256) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `username` (`username`) USING BTREE,
  UNIQUE KEY `email_2` (`email`),
  KEY `status` (`status`) USING BTREE,
  KEY `group_id` (`group_id`) USING BTREE,
  KEY `email` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
