/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : 127.0.0.1:3306
 Source Schema         : neasyth

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 18/02/2019 18:59:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for at_advertisements
-- ----------------------------
DROP TABLE IF EXISTS `at_advertisements`;
CREATE TABLE `at_advertisements`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `position` tinyint(4) UNSIGNED NOT NULL DEFAULT 0,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `image_url` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `target_url` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for at_attachment
-- ----------------------------
DROP TABLE IF EXISTS `at_attachment`;
CREATE TABLE `at_attachment`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `name` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `size` int(11) NOT NULL DEFAULT 0,
  `extension` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ix_attachment_uuid`(`uuid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for at_category
-- ----------------------------
DROP TABLE IF EXISTS `at_category`;
CREATE TABLE `at_category`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `en_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `zh_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `order` smallint(6) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ix_category_parent_id`(`parent_id`) USING BTREE,
  INDEX `ix_category_order`(`order`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of at_category
-- ----------------------------
INSERT INTO `at_category` VALUES (1, 'Clothing', '服装', 0, 0, '2019-02-16 01:09:26', '2019-02-16 01:09:28');
INSERT INTO `at_category` VALUES (2, 'Home Furnishing', '家居', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `at_category` VALUES (3, 'Outdoors', '户外', 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `at_category` VALUES (4, 'Sports', '运动', 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `at_category` VALUES (5, 'Shorts', '短裤', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for at_eventlogs
-- ----------------------------
DROP TABLE IF EXISTS `at_eventlogs`;
CREATE TABLE `at_eventlogs`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `operator` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `user_id` int(11) NULL DEFAULT 0,
  `assort` tinyint(4) UNSIGNED NOT NULL DEFAULT 0,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ix_eventlogs_uuid`(`uuid`) USING BTREE,
  INDEX `ix_eventlogs_operator`(`operator`) USING BTREE,
  INDEX `ix_eventlogs_assort`(`assort`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of at_eventlogs
-- ----------------------------
INSERT INTO `at_eventlogs` VALUES (1, '2f8e5d06-e00c-411c-8004-b21abab4766c', '0', 0, 2, 'adawda 尝试登录失败', '2019-02-18 10:42:19', '127.0.0.1');
INSERT INTO `at_eventlogs` VALUES (2, 'f7c384a3-e781-4544-8973-8ff5f961da93', '0', 0, 2, '232423 尝试登录失败', '2019-02-18 10:44:32', '127.0.0.1');
INSERT INTO `at_eventlogs` VALUES (3, 'a8cdd468-a8a6-4e23-b567-e5f41d22a6bb', '0', 0, 2, '232423 尝试登录失败', '2019-02-18 10:44:38', '127.0.0.1');
INSERT INTO `at_eventlogs` VALUES (4, '6b9278b7-efeb-463a-bb5f-8ddbdf1e741b', 'System', 0, 2, 'adwwdaw 尝试登录失败', '2019-02-18 10:51:07', '127.0.0.1');
INSERT INTO `at_eventlogs` VALUES (5, '181ee13a-c416-4666-bb55-6b2be214b937', 'System', 0, 2, 'adwwdaw 尝试登录失败', '2019-02-18 10:51:14', '127.0.0.1');
INSERT INTO `at_eventlogs` VALUES (6, 'df869370-7557-497c-9398-65ae88a82be6', 'System', 0, 2, 'leo 尝试登录失败', '2019-02-18 10:52:10', '127.0.0.1');
INSERT INTO `at_eventlogs` VALUES (7, '6ccf2d7d-2231-45e9-a4b1-33a9ca58ca45', 'System', 0, 2, 'leo 尝试登录失败', '2019-02-18 10:53:01', '127.0.0.1');
INSERT INTO `at_eventlogs` VALUES (8, 'c56a4d05-204b-493c-a082-2062c9cd6e07', 'System', 0, 2, 'admin 尝试登录失败', '2019-02-18 10:53:08', '127.0.0.1');
INSERT INTO `at_eventlogs` VALUES (9, '22e407eb-1272-46cb-a096-0f0ca2aa84c0', 'System', 0, 2, 'admin 尝试登录失败', '2019-02-18 10:53:18', '127.0.0.1');
INSERT INTO `at_eventlogs` VALUES (10, 'a2893d84-0222-49fc-8bb4-f9a714f0db08', 'System', 0, 0, '登录成功', '2019-02-18 10:56:11', '127.0.0.1');
INSERT INTO `at_eventlogs` VALUES (11, 'd10b0f43-9557-430c-94e1-32a6ac3d131e', 'System', 0, 0, '登录成功', '2019-02-18 10:57:05', '127.0.0.1');
INSERT INTO `at_eventlogs` VALUES (12, 'eaa405d0-aa17-4caa-bb49-0203b73560ae', 'System', 0, 0, '登录成功', '2019-02-18 10:57:21', '127.0.0.1');
INSERT INTO `at_eventlogs` VALUES (13, '6721a501-5237-48e1-8e58-6b81afe481ac', 'System', 0, 0, '登录成功', '2019-02-18 10:58:05', '127.0.0.1');
INSERT INTO `at_eventlogs` VALUES (14, 'ded3779d-14ed-4195-a745-835f82a95f33', 'System', 0, 0, '登录成功', '2019-02-18 10:58:10', '127.0.0.1');
INSERT INTO `at_eventlogs` VALUES (15, 'de69de39-64c7-470a-bd2a-8d59054919a5', 'System', 0, 0, '登录成功', '2019-02-18 10:58:16', '127.0.0.1');
INSERT INTO `at_eventlogs` VALUES (16, 'f51dfc54-a5b2-4778-895e-e1c64ad8cb25', 'System', 0, 0, '登录成功', '2019-02-18 10:58:37', '127.0.0.1');

-- ----------------------------
-- Table structure for at_messages
-- ----------------------------
DROP TABLE IF EXISTS `at_messages`;
CREATE TABLE `at_messages`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `subject` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for at_modules
-- ----------------------------
DROP TABLE IF EXISTS `at_modules`;
CREATE TABLE `at_modules`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `puid` char(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `module_name` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `link` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `style` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ix_modules_uuid`(`uuid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for at_product_attachments
-- ----------------------------
DROP TABLE IF EXISTS `at_product_attachments`;
CREATE TABLE `at_product_attachments`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `attachment_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `product_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ix_pa_attachment_id`(`attachment_id`) USING BTREE,
  INDEX `ix_pa_product_id`(`product_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for at_products
-- ----------------------------
DROP TABLE IF EXISTS `at_products`;
CREATE TABLE `at_products`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `en_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `zh_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `cover_url` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `amazon_url` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `category_id` smallint(6) NOT NULL DEFAULT 0,
  `stars` tinyint(4) UNSIGNED NOT NULL DEFAULT 0,
  `origin_price` decimal(6, 2) NOT NULL DEFAULT 0.00,
  `sell_price` decimal(6, 2) NOT NULL DEFAULT 0.00,
  `is_feature` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_best_saller` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_on_sale` tinyint(1) NOT NULL DEFAULT 0,
  `sale_start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sale_end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `views` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `order` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ix_products_uuid`(`uuid`) USING BTREE,
  INDEX `ix_products_category_id`(`category_id`) USING BTREE,
  INDEX `ix_products_is_feature`(`is_feature`) USING BTREE,
  INDEX `ix_products_is_saller`(`is_best_saller`) USING BTREE,
  INDEX `ix_products_is_on_sale`(`is_on_sale`) USING BTREE,
  INDEX `ix_products_order`(`order`) USING BTREE,
  INDEX `ix_products_is_deleted`(`is_deleted`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of at_products
-- ----------------------------
INSERT INTO `at_products` VALUES (1, 'd7489d14-3144-11e9-8b6b-c86000176710', '女士短裤', '短裤', NULL, NULL, 5, 8, 18.99, 16.99, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 0, 1, 0, '2019-02-16 01:15:11', '2019-02-16 01:15:15');

-- ----------------------------
-- Table structure for at_products_affixs
-- ----------------------------
DROP TABLE IF EXISTS `at_products_affixs`;
CREATE TABLE `at_products_affixs`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `intro` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `seo_keywords` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `seo_description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ix_products_affixs_product_id`(`product_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for at_sys_settings
-- ----------------------------
DROP TABLE IF EXISTS `at_sys_settings`;
CREATE TABLE `at_sys_settings`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `org_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `time_zone` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `date_format` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `language` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `retain` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of at_sys_settings
-- ----------------------------
INSERT INTO `at_sys_settings` VALUES (1, '零度科技有限公司', 'Asia/Shanghai', 'Y-m-d', 'zh', 1);

-- ----------------------------
-- Table structure for at_users
-- ----------------------------
DROP TABLE IF EXISTS `at_users`;
CREATE TABLE `at_users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `username` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `truename` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `password` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `signature` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `is_super` tinyint(1) NOT NULL DEFAULT 0,
  `last_login_ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `last_login_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of at_users
-- ----------------------------
INSERT INTO `at_users` VALUES (1, 'e3c17a59-336b-11e9-a8de-408d5cdc9504', 'admin', 'administrator', 'cf64a023ac6154ccae8c10ce72a58f72', '', NULL, 'lingdu332@163.com', 1, 1, '127.0.0.1', '2019-02-18 10:58:37', '2019-02-18 18:54:01', '0000-00-00 00:00:00');

SET FOREIGN_KEY_CHECKS = 1;
