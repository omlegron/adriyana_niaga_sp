/*
 Navicat Premium Data Transfer

 Source Server         : mysql
 Source Server Type    : MySQL
 Source Server Version : 110202
 Source Host           : localhost:3306
 Source Schema         : test

 Target Server Type    : MySQL
 Target Server Version : 110202
 File Encoding         : 65001

 Date: 26/04/2024 18:22:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` varchar(255) DEFAULT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `vessel_name` varchar(255) DEFAULT NULL,
  `port_code` varchar(255) DEFAULT NULL,
  `pod_pol` varchar(255) DEFAULT NULL,
  `nett_amount` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pk` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of orders
-- ----------------------------
BEGIN;
INSERT INTO `orders` VALUES (1, 'ORD/SBY/0001', 'MAJU', 'LUZON SBY-SRI ', 'SBY', 'SRI', '23904');
INSERT INTO `orders` VALUES (2, 'ORD/SBY/0002', 'MAJU', 'LUZON SBY-SRI ', 'SBY', 'SRI', '4198828');
INSERT INTO `orders` VALUES (3, 'ORD/SBY/0003', 'MAJU', 'LUZON SBY-SRI ', 'SBY', 'SRI', '15377293');
INSERT INTO `orders` VALUES (4, 'ORD/SBY/0004', 'HS', 'JADE JKT-JYP', 'JKT', 'JYP', '30720003');
INSERT INTO `orders` VALUES (5, 'ORD/SBY/0005', 'SAN', 'LUZON SBY-MKS', 'SBY', 'MKS', '13900000');
INSERT INTO `orders` VALUES (6, 'ORD/SBY/0006', 'SAN', 'LUZON SBY-MKS', 'SBY', 'MKS', '17700000');
INSERT INTO `orders` VALUES (7, 'ORD/SBY/0007', 'SAN', 'LUZON SBY-MKS', 'SBY', 'MKS', '11600000');
INSERT INTO `orders` VALUES (8, 'ORD/SBY/0008', 'SAN', 'LUZON SBY-MKS', 'SBY', 'MKS', '11600000');
INSERT INTO `orders` VALUES (9, 'ORD/SBY/0009', 'SAN', 'LUZON SBY-MKS', 'SBY', 'MKS', '15600000');
INSERT INTO `orders` VALUES (10, 'ORD/SBY/0010', 'SAN', 'LUZON SBY-MKS', 'SBY', 'MKS', '17700000');
INSERT INTO `orders` VALUES (11, 'ORD/SBY/0011', 'INDAH', 'LUZON SBY-MKS', 'SBY', 'MKS', '13338500');
INSERT INTO `orders` VALUES (12, 'ORD/SBY/0012', 'INDAH', 'LUZON SBY-MKS', 'SBY', 'MKS', '12875000');
INSERT INTO `orders` VALUES (13, 'ORD/SBY/0013', 'INDAH', 'LUZON SBY-MKS', 'SBY', 'MKS', '12875000');
INSERT INTO `orders` VALUES (14, 'ORD/SBY/0014', 'INDAH', 'LUZON SBY-MKS', 'SBY', 'MKS', '15093330');
INSERT INTO `orders` VALUES (15, 'ORD/SBY/0015', 'INDAH', 'LUZON SBY-MKS', 'SBY', 'MKS', '14368500');
INSERT INTO `orders` VALUES (16, 'ORD/SBY/0016', 'TH', 'LUZON SBY-MKS', 'SBY', 'MKS', '13541500');
INSERT INTO `orders` VALUES (17, 'ORD/SBY/0017', 'PABRIK', 'LUZON SBY-MKS', 'SBY', 'MKS', '15566640');
INSERT INTO `orders` VALUES (18, 'ORD/SBY/0018', 'INDO', 'LUZON SBY-MKS', 'SBY', 'MKS', '13450000');
INSERT INTO `orders` VALUES (19, 'ORD/SBY/0019', 'INDO', 'LUZON SBY-MKS', 'SBY', 'MKS', '14350000');
INSERT INTO `orders` VALUES (20, 'ORD/SBY/0020', 'INDO', 'LUZON SBY-MKS', 'SBY', 'MKS', '14350000');
INSERT INTO `orders` VALUES (21, 'ORD/SBY/0021', 'ASTR', 'LUZON SBY-SRI', 'SBY', 'SRI', '38198000');
INSERT INTO `orders` VALUES (22, 'ORD/SBY/0022', 'ASTR', 'LUZON SBY-SRI', 'SBY', 'SRI', '40891600');
INSERT INTO `orders` VALUES (23, 'ORD/SBY/0023', 'MULTI', 'LUZON SBY-MKS', 'SBY', 'MKS', '38461920');
INSERT INTO `orders` VALUES (24, 'ORD/SBY/0024', 'PT. DIAN', 'LUZON SBY-MKS', 'SBY', 'MKS', '20600000');
INSERT INTO `orders` VALUES (25, 'ORD/SBY/0025', 'SALI', 'LUZON SBY-MKS', 'SBY', 'MKS', '11800000');
INSERT INTO `orders` VALUES (26, 'ORD/SBY/0026', 'LAYAR', 'LUZON SBY-MKS', 'SBY', 'MKS', '15800000');
INSERT INTO `orders` VALUES (27, 'ORD/SBY/0027', 'LAYAR', 'LUZON SBY-MKS', 'SBY', 'MKS', '15800000');
INSERT INTO `orders` VALUES (28, 'ORD/SBY/0028', 'MAJU', 'LUZON SBY-SRI', 'SBY', 'SRI', '19600000');
INSERT INTO `orders` VALUES (29, 'ORD/SBY/0029', 'PANDA', 'TANTO SEMANGAT MKS-SRG', 'MKS', 'SRG', '103625000');
INSERT INTO `orders` VALUES (30, 'ORD/SBY/0030', 'SINT', 'TANTO SEMANGAT MKS-SRG', 'MKS', 'SRG', '41000000');
INSERT INTO `orders` VALUES (31, 'ORD/SBY/0031', 'MADU', 'TANTO SEMANGAT MKS-SRG', 'MKS', 'SRG', '19300000');
INSERT INTO `orders` VALUES (32, 'ORD/SBY/0032', 'SAN', 'LUZON SBY-MKS', 'SBY', 'MKS', '17700000');
INSERT INTO `orders` VALUES (33, 'ORD/SBY/0033', 'SAN', 'LUZON SBY-MKS', 'SBY', 'MKS', '11600000');
INSERT INTO `orders` VALUES (34, 'ORD/SBY/0034', 'GIM', 'TANTO SEMANGAT MKS-SRG', 'MKS', 'SRG', '41000000');
INSERT INTO `orders` VALUES (35, 'ORD/SBY/0035', 'HAJI', 'TANTO SEMANGAT MKS-SRG', 'MKS', 'SRG', '23700000');
INSERT INTO `orders` VALUES (36, 'ORD/SBY/0036', 'ASA', 'ORIENTAL JADE JKT-JYP', 'JKT', 'JYP', '23150000');
INSERT INTO `orders` VALUES (37, 'ORD/SBY/0037', 'HELM', 'ORIENTAL JADE JKT-JYP', 'JKT', 'JYP', '6314683');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
