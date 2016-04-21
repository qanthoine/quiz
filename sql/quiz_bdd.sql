/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50709
Source Host           : localhost:3306
Source Database       : site

Target Server Type    : MYSQL
Target Server Version : 50709
File Encoding         : 65001

Date: 2016-04-21 17:41:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `quiz`
-- ----------------------------
DROP TABLE IF EXISTS `quiz`;
CREATE TABLE `quiz` (
  `quiz_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_quiz` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `nb_questions` int(11) NOT NULL,
  PRIMARY KEY (`quiz_id`),
  UNIQUE KEY `quiz_id` (`quiz_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of quiz
-- ----------------------------
INSERT INTO `quiz` VALUES ('1', 'Les Maths', 'Un Quiz sur les maths ! Les additions, multiplications, soustraction, ..', '4');
INSERT INTO `quiz` VALUES ('2', 'Les Animaux', 'Un Quiz sur les animaux ! Les chiens, chats, lapins, ..', '5');
INSERT INTO `quiz` VALUES ('3', 'Les Montagnes', 'Un Quiz sur les montagnes ! Les Alpes, le Mont-Blanc, les Voges, .', '6');
