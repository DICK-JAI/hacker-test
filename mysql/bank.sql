/*
 Navicat Premium Data Transfer

 Source Server         : 123
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : bank

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 25/11/2023 14:17:12
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for amount
-- ----------------------------
DROP TABLE IF EXISTS `amount`;
CREATE TABLE `amount`  (
  `id` int(11) NOT NULL,
  `mid` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `balance` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `mid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of amount
-- ----------------------------
INSERT INTO `amount` VALUES (1, '63010213111230112', 10000);

SET FOREIGN_KEY_CHECKS = 1;
