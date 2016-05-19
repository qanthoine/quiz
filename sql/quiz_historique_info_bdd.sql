/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50709
Source Host           : localhost:3306
Source Database       : site

Target Server Type    : MYSQL
Target Server Version : 50709
File Encoding         : 65001

Date: 2016-05-19 15:15:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `quiz_historique_info`
-- ----------------------------
DROP TABLE IF EXISTS `quiz_historique_info`;
CREATE TABLE `quiz_historique_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `time_now` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of quiz_historique_info
-- ----------------------------
INSERT INTO `quiz_historique_info` VALUES ('50', '127.0.0.1', '1', '1463512046', '57');
INSERT INTO `quiz_historique_info` VALUES ('51', '127.0.0.1', '1', '1463512064', null);
INSERT INTO `quiz_historique_info` VALUES ('52', '127.0.0.11', '1', '1463512194', null);
INSERT INTO `quiz_historique_info` VALUES ('55', '127.0.0.1', '1', '1463526666', '100');
INSERT INTO `quiz_historique_info` VALUES ('56', '127.0.0.1', '1', '1463661040', '100');
INSERT INTO `quiz_historique_info` VALUES ('57', '127.0.0.1', '1', '1463661509', '100');
INSERT INTO `quiz_historique_info` VALUES ('58', '127.0.0.1', '1', '1463661638', '100');
INSERT INTO `quiz_historique_info` VALUES ('59', '127.0.0.1', '1', '1463663285', '100');
