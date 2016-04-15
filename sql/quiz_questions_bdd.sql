/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50709
Source Host           : localhost:3306
Source Database       : site

Target Server Type    : MYSQL
Target Server Version : 50709
File Encoding         : 65001

Date: 2016-04-15 15:47:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `quiz_questions`
-- ----------------------------
DROP TABLE IF EXISTS `quiz_questions`;
CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `id_question` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of quiz_questions
-- ----------------------------
INSERT INTO `quiz_questions` VALUES ('1', '1', '1', 'Combien font 1+1 ?');
INSERT INTO `quiz_questions` VALUES ('2', '1', '2', 'Combien font 12x15 ?');
INSERT INTO `quiz_questions` VALUES ('3', '1', '3', 'Combien font 27/5 ?');
INSERT INTO `quiz_questions` VALUES ('4', '1', '4', 'Combien font 2+2 ?');
