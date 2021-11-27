/*
 Navicat Premium Data Transfer

 Source Server         : stugsa
 Source Server Type    : MySQL
 Source Server Version : 50651
 Source Host           : localhost:3306
 Source Schema         : stugsa

 Target Server Type    : MySQL
 Target Server Version : 50651
 File Encoding         : 65001

 Date: 27/11/2021 14:41:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for account
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account`  (
  `key` int(255) NOT NULL AUTO_INCREMENT,
  `memberId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `memberPd` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of account
-- ----------------------------
INSERT INTO `account` VALUES (3, 'stugaAdmin', 'bc030f8d2020188c0b37eabfddf85c89aa3fc510');

-- ----------------------------
-- Table structure for activity
-- ----------------------------
DROP TABLE IF EXISTS `activity`;
CREATE TABLE `activity`  (
  `key` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `feedback` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of activity
-- ----------------------------

-- ----------------------------
-- Table structure for activity_join
-- ----------------------------
DROP TABLE IF EXISTS `activity_join`;
CREATE TABLE `activity_join`  (
  `a_key` int(11) NOT NULL,
  `m_key` int(11) NOT NULL,
  PRIMARY KEY (`a_key`, `m_key`) USING BTREE,
  INDEX `m_key`(`m_key`) USING BTREE,
  CONSTRAINT `activity_join_ibfk_1` FOREIGN KEY (`a_key`) REFERENCES `activity` (`key`) ON DELETE NO ACTION ON UPDATE RESTRICT,
  CONSTRAINT `activity_join_ibfk_2` FOREIGN KEY (`m_key`) REFERENCES `member` (`key`) ON DELETE NO ACTION ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of activity_join
-- ----------------------------

-- ----------------------------
-- Table structure for calendar
-- ----------------------------
DROP TABLE IF EXISTS `calendar`;
CREATE TABLE `calendar`  (
  `key` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `start_time` int(10) NOT NULL,
  `end_time` int(10) NULL DEFAULT NULL,
  `allday` tinyint(1) NOT NULL DEFAULT 0,
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `color` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 48 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of calendar
-- ----------------------------

-- ----------------------------
-- Table structure for class
-- ----------------------------
DROP TABLE IF EXISTS `class`;
CREATE TABLE `class`  (
  `key` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of class
-- ----------------------------
INSERT INTO `class` VALUES (1, '甲');
INSERT INTO `class` VALUES (2, '乙');
INSERT INTO `class` VALUES (3, '丙');
INSERT INTO `class` VALUES (4, '丁');

-- ----------------------------
-- Table structure for department
-- ----------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department`  (
  `key` int(255) NOT NULL AUTO_INCREMENT,
  `class_key` int(255) NOT NULL,
  `system_key` int(255) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  INDEX `class_key`(`class_key`) USING BTREE,
  INDEX `system_key`(`system_key`) USING BTREE,
  CONSTRAINT `department_ibfk_1` FOREIGN KEY (`class_key`) REFERENCES `class` (`key`) ON DELETE NO ACTION ON UPDATE RESTRICT,
  CONSTRAINT `department_ibfk_2` FOREIGN KEY (`system_key`) REFERENCES `system` (`key`) ON DELETE NO ACTION ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 83 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of department
-- ----------------------------

-- ----------------------------
-- Table structure for finance
-- ----------------------------
DROP TABLE IF EXISTS `finance`;
CREATE TABLE `finance`  (
  `f_key` int(255) NOT NULL AUTO_INCREMENT,
  `f_type` int(2) NOT NULL,
  `f_month` int(255) NOT NULL,
  `f_year` int(255) NOT NULL,
  `f_modifyDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`f_key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of finance
-- ----------------------------

-- ----------------------------
-- Table structure for finance_account
-- ----------------------------
DROP TABLE IF EXISTS `finance_account`;
CREATE TABLE `finance_account`  (
  `fa_key` int(10) NOT NULL AUTO_INCREMENT,
  `f_key` int(10) NOT NULL,
  `fac_key` int(255) NOT NULL,
  `fa_content` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fa_type` int(1) NOT NULL,
  `fa_money` int(7) NOT NULL,
  `fa_date` date NULL DEFAULT NULL,
  PRIMARY KEY (`fa_key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 116 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of finance_account
-- ----------------------------

-- ----------------------------
-- Table structure for finance_account_class
-- ----------------------------
DROP TABLE IF EXISTS `finance_account_class`;
CREATE TABLE `finance_account_class`  (
  `fac_key` int(100) NOT NULL AUTO_INCREMENT,
  `fac_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`fac_key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of finance_account_class
-- ----------------------------
INSERT INTO `finance_account_class` VALUES (1, '會費');
INSERT INTO `finance_account_class` VALUES (5, '評審及講座鐘點費');
INSERT INTO `finance_account_class` VALUES (6, '交通費');
INSERT INTO `finance_account_class` VALUES (7, '文宣場佈費');
INSERT INTO `finance_account_class` VALUES (8, '餐費');
INSERT INTO `finance_account_class` VALUES (9, '保險費');
INSERT INTO `finance_account_class` VALUES (10, '其他業務費');
INSERT INTO `finance_account_class` VALUES (11, '雜支');

-- ----------------------------
-- Table structure for finance_temporary
-- ----------------------------
DROP TABLE IF EXISTS `finance_temporary`;
CREATE TABLE `finance_temporary`  (
  `ft_key` int(255) NOT NULL AUTO_INCREMENT,
  `f_key` int(255) NULL DEFAULT NULL,
  `fac_key` int(255) NULL DEFAULT NULL,
  `ft_content` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ft_type` int(255) NULL DEFAULT NULL,
  `ft_money` int(255) NULL DEFAULT NULL,
  `ft_date` date NULL DEFAULT NULL,
  PRIMARY KEY (`ft_key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 58 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of finance_temporary
-- ----------------------------

-- ----------------------------
-- Table structure for member
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member`  (
  `key` int(255) NOT NULL AUTO_INCREMENT,
  `d_key` int(255) NOT NULL,
  `studentid` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`key`, `studentid`) USING BTREE,
  INDEX `d_key`(`d_key`) USING BTREE,
  CONSTRAINT `member_ibfk_1` FOREIGN KEY (`d_key`) REFERENCES `department` (`key`) ON DELETE NO ACTION ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1809 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of member
-- ----------------------------

-- ----------------------------
-- Table structure for member_check
-- ----------------------------
DROP TABLE IF EXISTS `member_check`;
CREATE TABLE `member_check`  (
  `d_key` int(255) NOT NULL,
  `check_time` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`d_key`) USING BTREE,
  CONSTRAINT `member_check_ibfk_1` FOREIGN KEY (`d_key`) REFERENCES `department` (`key`) ON DELETE NO ACTION ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of member_check
-- ----------------------------

-- ----------------------------
-- Table structure for notice
-- ----------------------------
DROP TABLE IF EXISTS `notice`;
CREATE TABLE `notice`  (
  `key` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of notice
-- ----------------------------

-- ----------------------------
-- Table structure for system
-- ----------------------------
DROP TABLE IF EXISTS `system`;
CREATE TABLE `system`  (
  `key` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of system
-- ----------------------------
INSERT INTO `system` VALUES (1, '日間四技');
INSERT INTO `system` VALUES (2, '四技進修');
INSERT INTO `system` VALUES (3, '二技日間');
INSERT INTO `system` VALUES (4, '二技進修');
INSERT INTO `system` VALUES (5, '進修二專');
INSERT INTO `system` VALUES (6, '產學四技學士專班');
INSERT INTO `system` VALUES (7, '二技進修');
INSERT INTO `system` VALUES (8, '碩士班');
INSERT INTO `system` VALUES (9, '碩士在職專班');
INSERT INTO `system` VALUES (10, '博士班');

SET FOREIGN_KEY_CHECKS = 1;
