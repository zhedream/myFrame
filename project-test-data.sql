/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50723
Source Host           : localhost:3306
Source Database       : project-test

Target Server Type    : MYSQL
Target Server Version : 50723
File Encoding         : 65001

Date: 2018-10-19 16:02:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `content` longtext COLLATE utf8mb4_unicode_ci COMMENT '文章内容',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发表时间',
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '跳转的地址',
  `article_category_id` int(10) unsigned NOT NULL COMMENT '关联的分类ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='文章表';

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('1', '阿瑟东', '123', '2018-10-13 10:58:20', '', '3');
INSERT INTO `article` VALUES ('2', '一篇文章', '21', '2018-10-11 11:56:14', '', '2');
INSERT INTO `article` VALUES ('3', '哈哈哈哈', '阿桑的歌撒旦哈给', '2018-10-12 17:02:29', '', '2');
INSERT INTO `article` VALUES ('4', 'myblog', '1231412', '2018-10-12 17:18:25', '', '3');
INSERT INTO `article` VALUES ('5', '我是啊', '123阿三', '2018-10-12 18:23:56', '', '1');
INSERT INTO `article` VALUES ('6', '阿斯弗', '阿斯蒂芬', '2018-10-13 10:58:55', null, '3');

-- ----------------------------
-- Table structure for article_category
-- ----------------------------
DROP TABLE IF EXISTS `article_category`;
CREATE TABLE `article_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cat_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分类名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='文章分类表';

-- ----------------------------
-- Records of article_category
-- ----------------------------
INSERT INTO `article_category` VALUES ('1', 'Hellas');
INSERT INTO `article_category` VALUES ('2', '支付方式');
INSERT INTO `article_category` VALUES ('3', '生活用品');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '邮箱',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名',
  `money` bigint(20) unsigned DEFAULT NULL COMMENT '余额',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '头像',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密码',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', null, 'l19517863@163.com', 'zhedream', null, null, '123123', null, null);
INSERT INTO `users` VALUES ('2', null, 'l19517861@163.com', '似篮', null, null, '123123', null, null);
INSERT INTO `users` VALUES ('3', null, 'l19517862@163.com', '似篮', null, null, '123123', null, null);
INSERT INTO `users` VALUES ('4', null, 'l19517864@163.com', '似篮', null, null, '123123', null, null);
INSERT INTO `users` VALUES ('5', null, 'l19517865@163.com', '似篮', null, null, '123123', null, null);
INSERT INTO `users` VALUES ('6', null, 'l19517866@163.com', '似篮', null, null, '123123', null, null);
INSERT INTO `users` VALUES ('7', null, 'l19517867@163.com', '似篮', null, null, '123123', null, null);
INSERT INTO `users` VALUES ('8', null, 'l19517868@163.com', '似篮', null, null, '123123', null, null);
INSERT INTO `users` VALUES ('9', null, 'l19517869@163.com', '似篮', null, null, '123123', null, null);
INSERT INTO `users` VALUES ('10', '17605978252', '', 'liuhaozhe', null, null, '123123', null, null);
INSERT INTO `users` VALUES ('11', '17605978251', '', '似篮', null, null, '123123', null, null);
