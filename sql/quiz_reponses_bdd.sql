/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50709
Source Host           : localhost:3306
Source Database       : site

Target Server Type    : MYSQL
Target Server Version : 50709
File Encoding         : 65001

Date: 2016-04-20 02:14:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `quiz_reponses`
-- ----------------------------
DROP TABLE IF EXISTS `quiz_reponses`;
CREATE TABLE `quiz_reponses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `id_question` int(11) NOT NULL,
  `id_reponse` int(11) NOT NULL,
  `reponse` varchar(255) NOT NULL,
  `resultat` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of quiz_reponses
-- ----------------------------
INSERT INTO `quiz_reponses` VALUES ('1', '1', '1', '1', '2', '1');
INSERT INTO `quiz_reponses` VALUES ('2', '1', '1', '2', '4', '0');
INSERT INTO `quiz_reponses` VALUES ('3', '1', '1', '3', '6', '0');
INSERT INTO `quiz_reponses` VALUES ('4', '1', '2', '1', '132', '0');
INSERT INTO `quiz_reponses` VALUES ('5', '1', '2', '2', '180', '1');
INSERT INTO `quiz_reponses` VALUES ('6', '1', '2', '3', '453', '0');
INSERT INTO `quiz_reponses` VALUES ('7', '1', '3', '1', '12.5', '0');
INSERT INTO `quiz_reponses` VALUES ('8', '1', '3', '2', '3.54', '0');
INSERT INTO `quiz_reponses` VALUES ('9', '1', '3', '3', '5.4', '1');
INSERT INTO `quiz_reponses` VALUES ('10', '1', '3', '4', '6.7', '0');
INSERT INTO `quiz_reponses` VALUES ('11', '1', '3', '5', '5.9', '0');
INSERT INTO `quiz_reponses` VALUES ('12', '1', '4', '1', '4', '1');
INSERT INTO `quiz_reponses` VALUES ('13', '1', '4', '2', '5', '0');
