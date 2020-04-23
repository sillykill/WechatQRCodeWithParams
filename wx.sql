/*
 Navicat Premium Data Transfer

 Source Server         : alia
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : 47.106.147.209:3306
 Source Schema         : wx

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 23/04/2020 18:25:28
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for opendate
-- ----------------------------
DROP TABLE IF EXISTS `opendate`;
CREATE TABLE `opendate` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `subscribe` varchar(100) DEFAULT NULL,
  `openida` varchar(50) DEFAULT NULL,
  `nickname` varchar(30) DEFAULT NULL,
  `sex` varchar(2) DEFAULT NULL,
  `languagea` varchar(10) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `province` varchar(30) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `headimgurl` varchar(255) DEFAULT NULL,
  `unionid` varchar(255) DEFAULT NULL,
  `subscribe_time` varchar(50) DEFAULT NULL,
  `remark` varchar(30) DEFAULT NULL,
  `groupid` varchar(30) DEFAULT NULL,
  `subscribe_scene` varchar(30) DEFAULT NULL,
  `qr_scene` varchar(30) DEFAULT NULL,
  `qr_scene_str` varchar(30) DEFAULT NULL,
  `ctime` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for qrscan
-- ----------------------------
DROP TABLE IF EXISTS `qrscan`;
CREATE TABLE `qrscan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) DEFAULT NULL COMMENT '扫描着的openid',
  `event` varchar(10) DEFAULT NULL COMMENT '扫描事件',
  `qrscene` varchar(10) DEFAULT NULL COMMENT '扫描情景',
  `state` smallint(3) DEFAULT NULL COMMENT '扫描状态',
  `ctime` varchar(30) DEFAULT NULL COMMENT '扫描事件',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for store
-- ----------------------------
DROP TABLE IF EXISTS `store`;
CREATE TABLE `store` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `touser` varchar(100) DEFAULT NULL COMMENT '店铺名称',
  `ticket` varchar(100) DEFAULT NULL COMMENT 'wx获取qr的ticket',
  `qrl` varchar(100) DEFAULT NULL COMMENT 'qr的本地名称',
  `descr` varchar(255) DEFAULT NULL COMMENT '店铺描述',
  `scene` varchar(30) DEFAULT NULL COMMENT '店铺唯一表示',
  `state` smallint(3) DEFAULT NULL COMMENT '店铺状态',
  `ctime` varchar(30) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for sub
-- ----------------------------
DROP TABLE IF EXISTS `sub`;
CREATE TABLE `sub` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `touserid` varchar(100) DEFAULT NULL,
  `openid` varchar(100) DEFAULT NULL,
  `subtime` varchar(100) DEFAULT NULL,
  `unsubtime` varchar(100) DEFAULT NULL,
  `state` smallint(3) DEFAULT NULL COMMENT '0ns1nun3os4oun',
  `ctime` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
