/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50709
Source Host           : localhost:3306
Source Database       : site

Target Server Type    : MYSQL
Target Server Version : 50709
File Encoding         : 65001

Date: 2016-05-01 14:40:11
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
  PRIMARY KEY (`id`),
  KEY `quiz_id` (`quiz_id`),
  CONSTRAINT `quiz_id_quiz` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of quiz_reponses
-- ----------------------------
INSERT INTO `quiz_reponses` VALUES ('1', '1', '1', '1', '2', '1');
INSERT INTO `quiz_reponses` VALUES ('2', '1', '1', '2', '4', '1');
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
INSERT INTO `quiz_reponses` VALUES ('14', '2', '1', '1', '11 ans', '0');
INSERT INTO `quiz_reponses` VALUES ('15', '2', '1', '2', '13 ans', '0');
INSERT INTO `quiz_reponses` VALUES ('16', '2', '1', '3', '15 ans', '1');
INSERT INTO `quiz_reponses` VALUES ('17', '2', '2', '1', '9-12 ans', '0');
INSERT INTO `quiz_reponses` VALUES ('18', '2', '2', '2', '10-13 ans', '1');
INSERT INTO `quiz_reponses` VALUES ('19', '2', '2', '3', '11-14 ans', '0');
INSERT INTO `quiz_reponses` VALUES ('20', '2', '2', '4', '12-15 ans', '0');
INSERT INTO `quiz_reponses` VALUES ('21', '2', '4', '1', 'Faon', '0');
INSERT INTO `quiz_reponses` VALUES ('22', '2', '4', '2', 'Marcassin', '1');
INSERT INTO `quiz_reponses` VALUES ('23', '2', '4', '3', 'Laie', '0');
INSERT INTO `quiz_reponses` VALUES ('24', '2', '4', '4', 'Truie', '0');
INSERT INTO `quiz_reponses` VALUES ('25', '2', '5', '1', 'Tigresse', '0');
INSERT INTO `quiz_reponses` VALUES ('26', '2', '5', '2', 'Lionne', '1');
INSERT INTO `quiz_reponses` VALUES ('27', '2', '5', '3', 'Marcassin', '0');
INSERT INTO `quiz_reponses` VALUES ('28', '2', '5', '4', 'Léoparde', '0');
INSERT INTO `quiz_reponses` VALUES ('29', '2', '5', '5', 'Poule', '0');
INSERT INTO `quiz_reponses` VALUES ('30', '3', '1', '1', 'Mont-Blanc', '1');
INSERT INTO `quiz_reponses` VALUES ('31', '3', '1', '2', 'Pic du Midi', '0');
INSERT INTO `quiz_reponses` VALUES ('32', '3', '2', '1', 'Le Mont du Lioran', '0');
INSERT INTO `quiz_reponses` VALUES ('33', '3', '2', '2', 'Le Plomb du Cantal', '1');
INSERT INTO `quiz_reponses` VALUES ('34', '3', '2', '3', 'Le Puy du Cantal', '0');
INSERT INTO `quiz_reponses` VALUES ('35', '3', '3', '1', 'Le Pic d\'Aneto', '1');
INSERT INTO `quiz_reponses` VALUES ('36', '3', '3', '2', 'Le Pic Canigou', '0');
INSERT INTO `quiz_reponses` VALUES ('37', '3', '3', '3', 'Le Pic du Midi', '0');
INSERT INTO `quiz_reponses` VALUES ('38', '3', '4', '1', '32', '0');
INSERT INTO `quiz_reponses` VALUES ('39', '3', '4', '2', '28', '0');
INSERT INTO `quiz_reponses` VALUES ('40', '3', '4', '3', '16', '1');
INSERT INTO `quiz_reponses` VALUES ('41', '3', '5', '1', 'Le glacier du Géant', '0');
INSERT INTO `quiz_reponses` VALUES ('42', '3', '5', '2', 'Le glacier de Taconnaz', '0');
INSERT INTO `quiz_reponses` VALUES ('43', '3', '5', '3', 'Le glacier d\'Argentière', '1');
INSERT INTO `quiz_reponses` VALUES ('44', '3', '6', '1', 'Le Jura', '0');
INSERT INTO `quiz_reponses` VALUES ('45', '3', '6', '2', 'Le Massif central', '1');
INSERT INTO `quiz_reponses` VALUES ('46', '2', '3', '1', 'Felis catus', '1');
INSERT INTO `quiz_reponses` VALUES ('47', '2', '3', '2', 'Felidae', '0');
