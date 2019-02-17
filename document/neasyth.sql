/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : neasyth

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-02-17 23:44:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for at_advertisements
-- ----------------------------
DROP TABLE IF EXISTS `at_advertisements`;
CREATE TABLE `at_advertisements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `position` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `description` text,
  `image_url` text,
  `target_url` text,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of at_advertisements
-- ----------------------------

-- ----------------------------
-- Table structure for at_attachment
-- ----------------------------
DROP TABLE IF EXISTS `at_attachment`;
CREATE TABLE `at_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL DEFAULT '',
  `name` text,
  `size` int(11) NOT NULL DEFAULT '0',
  `extension` varchar(20) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `ix_attachment_uuid` (`uuid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of at_attachment
-- ----------------------------

-- ----------------------------
-- Table structure for at_category
-- ----------------------------
DROP TABLE IF EXISTS `at_category`;
CREATE TABLE `at_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `en_name` varchar(255) NOT NULL DEFAULT '',
  `zh_name` varchar(255) NOT NULL DEFAULT '',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order` smallint(6) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `ix_category_parent_id` (`parent_id`) USING BTREE,
  KEY `ix_category_order` (`order`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of at_category
-- ----------------------------
INSERT INTO `at_category` VALUES ('1', 'Clothing', '服装', '0', '0', '2019-02-16 01:09:26', '2019-02-16 01:09:28');
INSERT INTO `at_category` VALUES ('2', 'Home Furnishing', '家居', '0', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `at_category` VALUES ('3', 'Outdoors', '户外', '0', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `at_category` VALUES ('4', 'Sports', '运动', '0', '3', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `at_category` VALUES ('5', 'Shorts', '短裤', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for at_eventlogs
-- ----------------------------
DROP TABLE IF EXISTS `at_eventlogs`;
CREATE TABLE `at_eventlogs` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL DEFAULT '',
  `operator` int(10) unsigned NOT NULL DEFAULT '0',
  `assort` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `content` text,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `ix_eventlogs_uuid` (`uuid`) USING BTREE,
  KEY `ix_eventlogs_operator` (`operator`) USING BTREE,
  KEY `ix_eventlogs_assort` (`assort`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of at_eventlogs
-- ----------------------------

-- ----------------------------
-- Table structure for at_messages
-- ----------------------------
DROP TABLE IF EXISTS `at_messages`;
CREATE TABLE `at_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `subject` text,
  `content` text,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of at_messages
-- ----------------------------

-- ----------------------------
-- Table structure for at_modules
-- ----------------------------
DROP TABLE IF EXISTS `at_modules`;
CREATE TABLE `at_modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL DEFAULT '',
  `puid` char(36) NOT NULL DEFAULT '',
  `module_name` varchar(60) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `style` varchar(60) NOT NULL DEFAULT '',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ix_modules_uuid` (`uuid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of at_modules
-- ----------------------------

-- ----------------------------
-- Table structure for at_products
-- ----------------------------
DROP TABLE IF EXISTS `at_products`;
CREATE TABLE `at_products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL DEFAULT '',
  `en_name` varchar(100) NOT NULL DEFAULT '',
  `zh_name` varchar(100) NOT NULL DEFAULT '',
  `cover_url` text,
  `amazon_url` text,
  `category_id` smallint(6) NOT NULL DEFAULT '0',
  `stars` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `origin_price` decimal(6,2) NOT NULL DEFAULT '0.00',
  `sell_price` decimal(6,2) NOT NULL DEFAULT '0.00',
  `is_feature` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_best_saller` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_on_sale` tinyint(1) NOT NULL DEFAULT '0',
  `sale_start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sale_end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `order` smallint(5) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `ix_products_uuid` (`uuid`) USING BTREE,
  KEY `ix_products_category_id` (`category_id`) USING BTREE,
  KEY `ix_products_is_feature` (`is_feature`) USING BTREE,
  KEY `ix_products_is_saller` (`is_best_saller`) USING BTREE,
  KEY `ix_products_is_on_sale` (`is_on_sale`) USING BTREE,
  KEY `ix_products_order` (`order`) USING BTREE,
  KEY `ix_products_is_deleted` (`is_deleted`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of at_products
-- ----------------------------
INSERT INTO `at_products` VALUES ('1', 'd7489d14-3144-11e9-8b6b-c86000176710', '女士短裤', '短裤', null, null, '5', '8', '18.99', '16.99', '1', '0', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '6', '0', '1', '0', '2019-02-16 01:15:11', '2019-02-16 01:15:15');

-- ----------------------------
-- Table structure for at_products_affixs
-- ----------------------------
DROP TABLE IF EXISTS `at_products_affixs`;
CREATE TABLE `at_products_affixs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `intro` text,
  `description` text,
  `seo_keywords` text,
  `seo_description` text,
  PRIMARY KEY (`id`),
  KEY `ix_products_affixs_product_id` (`product_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of at_products_affixs
-- ----------------------------

-- ----------------------------
-- Table structure for at_product_attachments
-- ----------------------------
DROP TABLE IF EXISTS `at_product_attachments`;
CREATE TABLE `at_product_attachments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attachment_id` int(10) unsigned NOT NULL DEFAULT '0',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `ix_pa_attachment_id` (`attachment_id`) USING BTREE,
  KEY `ix_pa_product_id` (`product_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of at_product_attachments
-- ----------------------------

-- ----------------------------
-- Table structure for at_users
-- ----------------------------
DROP TABLE IF EXISTS `at_users`;
CREATE TABLE `at_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL DEFAULT '',
  `truename` varchar(60) NOT NULL DEFAULT '',
  `password` varchar(60) NOT NULL DEFAULT '',
  `avatar` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `is_super` tinyint(1) NOT NULL DEFAULT '0',
  `last_login_ip` varchar(20) NOT NULL DEFAULT '0',
  `last_login_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of at_users
-- ----------------------------
