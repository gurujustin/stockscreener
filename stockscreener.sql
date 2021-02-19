/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100411
 Source Host           : localhost:3306
 Source Schema         : stockscreener

 Target Server Type    : MySQL
 Target Server Version : 100411
 File Encoding         : 65001

 Date: 20/02/2021 04:29:54
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin', '$2y$10$uDKsVJveROX/BQe5ZKz4kOahu7R9/6NTHhoPM6fFwNclFsKGr9Gre', '2021-02-19 02:03:47');
-- ----------------------------
-- Table structure for gb_item
-- ----------------------------
DROP TABLE IF EXISTS `gb_item`;
CREATE TABLE `gb_item`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `item` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `userid` int NOT NULL,
  `trigger_price` decimal(12, 4) NULL DEFAULT NULL,
  `projection_price` decimal(12, 4) NULL DEFAULT NULL,
  `recommended` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `recom_date` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `recom_type` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `date_created` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `updated_at` datetime(0) NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `userid`(`userid`) USING BTREE,
  CONSTRAINT `gb_item_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of gb_item
-- ----------------------------
INSERT INTO `gb_item` VALUES (3, 'APPL', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-20 00:21:08', '2021-02-20 00:25:32');
INSERT INTO `gb_item` VALUES (4, 'APEX', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-20 00:21:08', '2021-02-20 00:25:34');
INSERT INTO `gb_item` VALUES (5, 'SAMS', 1, 23.0000, 12.0000, 'Y', '02/19/2021', 'EY,TXT', '02/17/2021', '2021-02-20 01:55:50', '2021-02-20 03:15:55');

-- ----------------------------
-- Table structure for gb_item_ed
-- ----------------------------
DROP TABLE IF EXISTS `gb_item_ed`;
CREATE TABLE `gb_item_ed`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `stock_id` int UNSIGNED NOT NULL,
  `ed_date` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ed_price` decimal(12, 4) NULL DEFAULT NULL,
  `ed_chg` decimal(12, 4) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `stock_id`(`stock_id`) USING BTREE,
  CONSTRAINT `gb_item_ed_ibfk_1` FOREIGN KEY (`stock_id`) REFERENCES `gb_item` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of gb_item_ed
-- ----------------------------
INSERT INTO `gb_item_ed` VALUES (1, 5, '02/19/2021', 34.0000, 24.6000);
INSERT INTO `gb_item_ed` VALUES (2, 5, '02/20/2021', 456.0000, 45.3000);

-- ----------------------------
-- Table structure for gb_item_notes
-- ----------------------------
DROP TABLE IF EXISTS `gb_item_notes`;
CREATE TABLE `gb_item_notes`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `stock_id` int UNSIGNED NOT NULL,
  `notes_date` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `stock_id`(`stock_id`) USING BTREE,
  CONSTRAINT `gb_item_notes_ibfk_1` FOREIGN KEY (`stock_id`) REFERENCES `gb_item` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of gb_item_notes
-- ----------------------------
INSERT INTO `gb_item_notes` VALUES (1, 5, '02/19/2021', 'I have good experience with react.js. grammar good');
INSERT INTO `gb_item_notes` VALUES (2, 5, '02/19/2021', 'For me, it seems, that browser does not send the post/get-parameter if nothing was selected of the multiple-select. How can you force to have an empty array, instead?');

-- ----------------------------
-- Table structure for gb_item_rating
-- ----------------------------
DROP TABLE IF EXISTS `gb_item_rating`;
CREATE TABLE `gb_item_rating`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `stock_id` int UNSIGNED NOT NULL,
  `company` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rating` enum('Good','Very Good','Excellent','Poor') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `price_target` decimal(12, 4) NULL DEFAULT NULL,
  `rate_date` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `stock_id`(`stock_id`) USING BTREE,
  CONSTRAINT `gb_item_rating_ibfk_1` FOREIGN KEY (`id`) REFERENCES `gb_item` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of gb_item_rating
-- ----------------------------
INSERT INTO `gb_item_rating` VALUES (3, 5, 'Apple', 'Good', 345.0000, '02/19/2021');

-- ----------------------------
-- Table structure for gb_item_transactions
-- ----------------------------
DROP TABLE IF EXISTS `gb_item_transactions`;
CREATE TABLE `gb_item_transactions`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `stock_id` int UNSIGNED NOT NULL,
  `trans_type` enum('Bought','Sold') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `qnty` decimal(12, 4) NULL DEFAULT NULL,
  `price` decimal(12, 4) NULL DEFAULT NULL,
  `total` decimal(12, 4) NULL DEFAULT NULL,
  `trans_date` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `on_hand_qnty` decimal(12, 4) NULL DEFAULT NULL,
  `avg_price` decimal(12, 4) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `transactions_ibfk_1`(`stock_id`) USING BTREE,
  CONSTRAINT `gb_item_transactions_ibfk_1` FOREIGN KEY (`stock_id`) REFERENCES `gb_item` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of gb_item_transactions
-- ----------------------------
INSERT INTO `gb_item_transactions` VALUES (1, 3, 'Bought', 150.0000, 150.0000, 22500.0000, '1/1/2021', NULL, NULL);
INSERT INTO `gb_item_transactions` VALUES (2, 4, 'Bought', 120.0000, 110.0000, 13200.0000, '02/15/2021', NULL, NULL);
INSERT INTO `gb_item_transactions` VALUES (3, 4, 'Sold', 90.0000, 150.0000, 13500.0000, '02/19/2021', NULL, NULL);
INSERT INTO `gb_item_transactions` VALUES (4, 4, 'Bought', 40.0000, 99.1200, 3964.8000, '02/19/2021', NULL, NULL);
INSERT INTO `gb_item_transactions` VALUES (5, 4, 'Sold', 25.0000, 106.0000, 2650.0000, '02/19/2021', NULL, NULL);
INSERT INTO `gb_item_transactions` VALUES (7, 5, 'Bought', 140.0000, 35.0000, 4900.0000, '02/09/2021', 140.0000, 35.0000);
INSERT INTO `gb_item_transactions` VALUES (8, 5, 'Sold', 50.0000, 65.0000, 3250.0000, '02/10/2021', 90.0000, 50.0000);
INSERT INTO `gb_item_transactions` VALUES (9, 5, 'Bought', 50.0000, 55.0000, 2750.0000, '02/14/2021', 140.0000, 51.6667);


SET FOREIGN_KEY_CHECKS = 1;
