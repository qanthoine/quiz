/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50709
Source Host           : localhost:3306
Source Database       : site

Target Server Type    : MYSQL
Target Server Version : 50709
File Encoding         : 65001

Date: 2016-05-19 15:15:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `quiz_historique_data`
-- ----------------------------
DROP TABLE IF EXISTS `quiz_historique_data`;
CREATE TABLE `quiz_historique_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `historique_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `reponse_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `historique` (`historique_id`) USING BTREE,
  CONSTRAINT `historique` FOREIGN KEY (`historique_id`) REFERENCES `quiz_historique_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of quiz_historique_data
-- ----------------------------
INSERT INTO `quiz_historique_data` VALUES ('159', '50', '1', '1');
INSERT INTO `quiz_historique_data` VALUES ('160', '50', '1', '2');
INSERT INTO `quiz_historique_data` VALUES ('161', '50', '2', '101');
INSERT INTO `quiz_historique_data` VALUES ('162', '50', '3', '32');
INSERT INTO `quiz_historique_data` VALUES ('163', '50', '3', '12');
INSERT INTO `quiz_historique_data` VALUES ('164', '50', '3', '22');
INSERT INTO `quiz_historique_data` VALUES ('165', '50', '4', '1');
INSERT INTO `quiz_historique_data` VALUES ('166', '55', '1', '1');
INSERT INTO `quiz_historique_data` VALUES ('167', '55', '1', '2');
INSERT INTO `quiz_historique_data` VALUES ('168', '55', '2', '101');
INSERT INTO `quiz_historique_data` VALUES ('169', '55', '3', '3');
INSERT INTO `quiz_historique_data` VALUES ('170', '55', '3', '1');
INSERT INTO `quiz_historique_data` VALUES ('171', '55', '3', '2');
INSERT INTO `quiz_historique_data` VALUES ('172', '55', '4', '1');
INSERT INTO `quiz_historique_data` VALUES ('173', '56', '1', '1');
INSERT INTO `quiz_historique_data` VALUES ('174', '56', '1', '2');
INSERT INTO `quiz_historique_data` VALUES ('175', '56', '2', '101');
INSERT INTO `quiz_historique_data` VALUES ('176', '56', '3', '3');
INSERT INTO `quiz_historique_data` VALUES ('177', '56', '3', '1');
INSERT INTO `quiz_historique_data` VALUES ('178', '56', '3', '2');
INSERT INTO `quiz_historique_data` VALUES ('179', '56', '4', '1');
INSERT INTO `quiz_historique_data` VALUES ('180', '57', '1', '1');
INSERT INTO `quiz_historique_data` VALUES ('181', '57', '1', '2');
INSERT INTO `quiz_historique_data` VALUES ('182', '57', '2', '101');
INSERT INTO `quiz_historique_data` VALUES ('183', '57', '3', '3');
INSERT INTO `quiz_historique_data` VALUES ('184', '57', '3', '1');
INSERT INTO `quiz_historique_data` VALUES ('185', '57', '3', '2');
INSERT INTO `quiz_historique_data` VALUES ('186', '57', '4', '1');
INSERT INTO `quiz_historique_data` VALUES ('187', '58', '1', '1');
INSERT INTO `quiz_historique_data` VALUES ('188', '58', '1', '2');
INSERT INTO `quiz_historique_data` VALUES ('189', '58', '2', '101');
INSERT INTO `quiz_historique_data` VALUES ('190', '58', '3', '3');
INSERT INTO `quiz_historique_data` VALUES ('191', '58', '3', '1');
INSERT INTO `quiz_historique_data` VALUES ('192', '58', '3', '2');
INSERT INTO `quiz_historique_data` VALUES ('193', '58', '4', '1');
INSERT INTO `quiz_historique_data` VALUES ('194', '59', '1', '1');
INSERT INTO `quiz_historique_data` VALUES ('195', '59', '1', '2');
INSERT INTO `quiz_historique_data` VALUES ('196', '59', '2', '101');
INSERT INTO `quiz_historique_data` VALUES ('197', '59', '3', '3');
INSERT INTO `quiz_historique_data` VALUES ('198', '59', '3', '1');
INSERT INTO `quiz_historique_data` VALUES ('199', '59', '3', '2');
INSERT INTO `quiz_historique_data` VALUES ('200', '59', '4', '1');
