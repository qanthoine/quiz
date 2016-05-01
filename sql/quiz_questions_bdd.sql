/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50709
Source Host           : localhost:3306
Source Database       : site

Target Server Type    : MYSQL
Target Server Version : 50709
File Encoding         : 65001

Date: 2016-05-01 14:40:06
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
  `nb_rep` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_id` (`quiz_id`),
  CONSTRAINT `quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of quiz_questions
-- ----------------------------
INSERT INTO `quiz_questions` VALUES ('1', '1', '1', 'Combien font 1+1 ?', '2');
INSERT INTO `quiz_questions` VALUES ('2', '1', '2', 'Combien font 12x15 ?', '1');
INSERT INTO `quiz_questions` VALUES ('3', '1', '3', 'Combien font 27/5 ?', '1');
INSERT INTO `quiz_questions` VALUES ('4', '1', '4', 'Combien font 2+2 ?', '1');
INSERT INTO `quiz_questions` VALUES ('5', '2', '1', 'Espérance de vie moyenne d\'un chat domestique ?', '1');
INSERT INTO `quiz_questions` VALUES ('6', '2', '2', 'Espérance de vie moyenne d\'un chien ?', '1');
INSERT INTO `quiz_questions` VALUES ('7', '2', '3', 'Nom scientifique d\'un chat ?', '1');
INSERT INTO `quiz_questions` VALUES ('8', '2', '4', 'Petit du Sanglier ?', '1');
INSERT INTO `quiz_questions` VALUES ('9', '2', '5', 'Femelle du Lion ?', '1');
INSERT INTO `quiz_questions` VALUES ('10', '3', '1', 'Quel est le plus haut sommet de France ?', '1');
INSERT INTO `quiz_questions` VALUES ('11', '3', '2', 'Quel est le plus haut sommet du Cantal ?', '1');
INSERT INTO `quiz_questions` VALUES ('12', '3', '3', 'Quel est le point culminant des Pyrénées ?\r\n', '1');
INSERT INTO `quiz_questions` VALUES ('13', '3', '4', 'Combien y-a-t-il de sommets de plus de 4000 mètres dans le massif du Mont-Blanc ?', '1');
INSERT INTO `quiz_questions` VALUES ('14', '3', '5', 'Parmi ces trois glaciers, lequel est le plus grand ?', '1');
INSERT INTO `quiz_questions` VALUES ('15', '3', '6', 'Quelle est la plus vieille montagne de France ?', '1');
