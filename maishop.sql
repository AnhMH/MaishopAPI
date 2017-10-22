/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : maishop

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-10-22 21:01:32
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Admin ID',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Vip Type',
  `account` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `description` text CHARACTER SET utf8,
  `disable` tinyint(1) DEFAULT '0',
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', '0', 'admin', 'HdH7tYt5E38XXbD-7NS3l3Y2S0s2Ri1Id1FBWndGdkpHbERnVUZORU14SzFaZUxEbFVXS2lZVk1sSXM', 'ADMIN', null, null, null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `sub_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sub_address` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sub_tel` varchar(20) DEFAULT NULL,
  `ext_cost` varchar(255) DEFAULT NULL,
  `ship_cost` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `note` text,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `disable` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of orders
-- ----------------------------

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `cate_id` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `description` text CHARACTER SET utf8,
  `detail` text CHARACTER SET utf8,
  `avatar` varchar(255) DEFAULT NULL,
  `gallery` varchar(1000) DEFAULT NULL,
  `agent_price` varchar(255) DEFAULT NULL COMMENT 'Gia dai ly',
  `price` varchar(255) DEFAULT NULL,
  `discount` tinyint(2) DEFAULT NULL COMMENT '% giam gia',
  `rate` tinyint(4) DEFAULT NULL,
  `disable` tinyint(1) DEFAULT '0',
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES ('1', null, null, 'a', null, null, null, null, null, null, '127', null, '0', null, null);
