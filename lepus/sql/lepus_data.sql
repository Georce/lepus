/*
Navicat MySQL Data Transfer

Source Server         : 219.234.6.180-lepus_db
Source Server Version : 50536
Source Host           : 219.234.6.180:3306
Source Database       : lepus_db

Target Server Type    : MYSQL
Target Server Version : 50536
File Encoding         : 65001

Date: 2015-02-09 16:33:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu` (
  `menu_id` smallint(4) NOT NULL AUTO_INCREMENT,
  `menu_title` varchar(30) NOT NULL,
  `menu_level` tinyint(2) NOT NULL DEFAULT '0',
  `parent_id` tinyint(2) NOT NULL,
  `menu_url` varchar(255) DEFAULT NULL,
  `menu_icon` varchar(50) DEFAULT NULL,
  `system` tinyint(2) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `display_order` smallint(4) NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES ('3', 'MySQL Monitor', '1', '0', 'lp_mysql', 'icon-dashboard', '0', '1', '3', '2014-02-25 19:57:29');
INSERT INTO `admin_menu` VALUES ('5', 'Permission System', '1', '0', 'rabc', 'icon-legal', '0', '1', '10', '2014-02-26 12:24:33');
INSERT INTO `admin_menu` VALUES ('6', 'Health Monitor', '2', '3', 'lp_mysql/index', ' icon-list', '0', '1', '1', '2014-02-26 12:25:15');
INSERT INTO `admin_menu` VALUES ('8', 'Replication Monitor', '2', '3', 'lp_mysql/replication', ' icon-list', '0', '1', '6', '2014-02-26 12:26:05');
INSERT INTO `admin_menu` VALUES ('9', 'Slowquery Analysis', '2', '3', 'lp_mysql/slowquery', 'icon-list', '0', '1', '9', '2014-02-26 12:26:52');
INSERT INTO `admin_menu` VALUES ('10', 'User', '2', '5', 'user/index', '', '0', '1', '1', '2014-02-26 12:43:02');
INSERT INTO `admin_menu` VALUES ('11', 'Role', '2', '5', 'role/index', '', '0', '1', '2', '2014-02-26 12:43:19');
INSERT INTO `admin_menu` VALUES ('12', 'Menu', '2', '5', 'menu/index', '', '0', '1', '3', '2014-02-26 12:43:41');
INSERT INTO `admin_menu` VALUES ('13', 'Privilege', '2', '5', 'privilege/index', '', '0', '1', '4', '2014-02-26 12:45:01');
INSERT INTO `admin_menu` VALUES ('15', 'Authorization', '2', '5', 'auth/index', '', '0', '1', '2', '2014-03-03 22:23:28');
INSERT INTO `admin_menu` VALUES ('16', 'Servers Configure', '1', '0', 'server', 'icon-dashboard', '0', '1', '2', '2014-03-05 18:31:17');
INSERT INTO `admin_menu` VALUES ('18', 'MySQL', '2', '16', 'servers_mysql/index', 'icon-list', '0', '1', '3', '2014-03-05 18:33:40');
INSERT INTO `admin_menu` VALUES ('19', 'AWR Report', '2', '3', 'lp_mysql/awrreport', 'icon-list', '0', '1', '12', '2014-03-06 13:47:17');
INSERT INTO `admin_menu` VALUES ('20', 'Alarm Panel', '1', '0', 'alarm', 'icon-dashboard', '0', '1', '9', '2014-03-11 21:41:13');
INSERT INTO `admin_menu` VALUES ('21', 'Alarm List', '2', '20', 'alarm/index', '', '0', '1', '0', '2014-03-11 21:46:28');
INSERT INTO `admin_menu` VALUES ('22', 'OS Monitor', '1', '0', 'lp_os', 'icon-dashboard', '0', '1', '8', '2014-03-24 15:33:42');
INSERT INTO `admin_menu` VALUES ('26', 'Disk', '2', '22', 'lp_os/disk', 'icon-list', '0', '1', '4', '2014-03-24 17:46:29');
INSERT INTO `admin_menu` VALUES ('28', 'BigTable Analysis', '2', '3', 'lp_mysql/bigtable', 'icon-list', '0', '1', '7', '2014-04-02 13:38:15');
INSERT INTO `admin_menu` VALUES ('29', 'Key Cache Monitor', '2', '3', 'lp_mysql/key_cache', 'icon-list', '0', '1', '3', '2014-04-09 15:52:12');
INSERT INTO `admin_menu` VALUES ('30', 'InnoDB Monitor', '2', '3', 'lp_mysql/innodb', 'icon-list', '0', '1', '4', '2014-04-09 15:54:47');
INSERT INTO `admin_menu` VALUES ('31', 'Resource Monitor', '2', '3', 'lp_mysql/resource', 'icon-list', '0', '1', '2', '2014-04-10 13:23:06');
INSERT INTO `admin_menu` VALUES ('32', 'MongoDB', '2', '16', 'servers_mongodb/index', 'icon-list', '0', '1', '5', '2014-04-14 12:26:35');
INSERT INTO `admin_menu` VALUES ('33', 'MongoDB Monitor', '1', '0', 'lp_mongodb', 'icon-dashboard', '0', '1', '5', '2014-04-14 14:15:52');
INSERT INTO `admin_menu` VALUES ('34', 'Health Montior', '2', '33', 'lp_mongodb/index', 'icon-list', '0', '1', '1', '2014-04-14 14:17:23');
INSERT INTO `admin_menu` VALUES ('35', 'Indexes Monitor', '2', '33', 'lp_mongodb/indexes', 'icon-list', '0', '1', '2', '2014-04-14 16:25:48');
INSERT INTO `admin_menu` VALUES ('36', 'Memory Monitor', '2', '33', 'lp_mongodb/memory', 'icon-list', '0', '1', '3', '2014-04-14 16:26:50');
INSERT INTO `admin_menu` VALUES ('40', 'Oracle', '2', '16', 'servers_oracle/index', 'icon-list', '0', '1', '4', '2014-05-27 13:21:49');
INSERT INTO `admin_menu` VALUES ('43', 'Health Monitor', '2', '22', 'lp_os/index', 'icon-list', '0', '1', '0', '2014-07-08 09:19:11');
INSERT INTO `admin_menu` VALUES ('44', 'Disk IO', '2', '22', 'lp_os/disk_io', 'icon-list', '0', '1', '5', '2014-07-15 15:35:56');
INSERT INTO `admin_menu` VALUES ('45', 'OS', '2', '16', 'servers_os/index', 'icon-list', '0', '1', '8', '2014-07-16 10:32:13');
INSERT INTO `admin_menu` VALUES ('46', 'Settings', '2', '16', 'settings/index', 'icon-list', '0', '1', '0', '2014-08-12 15:30:54');
INSERT INTO `admin_menu` VALUES ('48', 'Redis Monitor', '1', '0', 'lp_redis', 'icon-dashboard', '0', '1', '6', '2014-09-02 12:36:41');
INSERT INTO `admin_menu` VALUES ('50', 'Health Monitor', '2', '48', 'lp_redis/index', 'icon-list', '0', '1', '2', '2014-09-02 12:39:58');
INSERT INTO `admin_menu` VALUES ('51', 'Redis', '2', '16', 'servers_redis/index', 'icon-list', '0', '1', '6', '2014-09-09 17:15:41');
INSERT INTO `admin_menu` VALUES ('52', 'Memory Monitor', '2', '48', 'lp_redis/memory', 'icon-list', '0', '1', '3', '2014-09-11 14:34:13');
INSERT INTO `admin_menu` VALUES ('54', 'Replication Monitor', '2', '48', 'lp_redis/replication', 'icon-list', '0', '0', '5', '2014-09-11 14:37:12');
INSERT INTO `admin_menu` VALUES ('56', 'Oracle Monitor', '1', '0', 'lp_oracle', 'icon-dashboard', '0', '1', '4', '2014-10-24 15:34:50');
INSERT INTO `admin_menu` VALUES ('57', 'Health Montior', '2', '56', 'lp_oracle/index', 'icon-list', '0', '1', '1', '2014-10-24 15:35:47');
INSERT INTO `admin_menu` VALUES ('58', 'Tablespace Monitor', '2', '56', 'lp_oracle/tablespace', 'icon-list', '0', '1', '2', '2014-10-24 15:37:19');

-- ----------------------------
-- Table structure for admin_privilege
-- ----------------------------
DROP TABLE IF EXISTS `admin_privilege`;
CREATE TABLE `admin_privilege` (
  `privilege_id` smallint(4) NOT NULL AUTO_INCREMENT,
  `privilege_title` varchar(30) DEFAULT NULL,
  `menu_id` smallint(4) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `display_order` smallint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`privilege_id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_privilege
-- ----------------------------
INSERT INTO `admin_privilege` VALUES ('1', 'MySQL Health Monitor', '6', 'lp_mysql/index', '1');
INSERT INTO `admin_privilege` VALUES ('3', 'MySQL Replication Monitor', '8', 'lp_mysql/replication', '2');
INSERT INTO `admin_privilege` VALUES ('4', 'MySQLSlowQuery', '9', 'lp_mysql/slowquery', '4');
INSERT INTO `admin_privilege` VALUES ('6', 'Admin User View', '10', 'user/index', '52');
INSERT INTO `admin_privilege` VALUES ('7', 'Admin User Add ', '10', 'user/add', '52');
INSERT INTO `admin_privilege` VALUES ('8', 'Admin User Edit', '10', 'user/edit', '53');
INSERT INTO `admin_privilege` VALUES ('9', 'Admin User Delete', '10', 'user/forever_delete', '54');
INSERT INTO `admin_privilege` VALUES ('10', 'Admin Role View', '11', 'role/index', '61');
INSERT INTO `admin_privilege` VALUES ('11', 'Admin Role Add', '11', 'role/add', '62');
INSERT INTO `admin_privilege` VALUES ('12', 'Admin Role Edit', '11', 'role/edit', '63');
INSERT INTO `admin_privilege` VALUES ('13', 'Admin Role Delete', '11', 'role/forever_delete', '64');
INSERT INTO `admin_privilege` VALUES ('14', 'Admin Menu View', '12', 'menu/index', '71');
INSERT INTO `admin_privilege` VALUES ('15', 'Admin Menu Add', '12', 'menu/add', '72');
INSERT INTO `admin_privilege` VALUES ('16', 'Admin Menu Edit', '12', 'menu/edit', '73');
INSERT INTO `admin_privilege` VALUES ('17', 'Admin Menu Delete', '12', 'menu/forever_delete', '74');
INSERT INTO `admin_privilege` VALUES ('18', 'Admin Privilege View', '13', 'privilege/index', '81');
INSERT INTO `admin_privilege` VALUES ('19', 'Admin Privilege Add', '13', 'privilege/add', '82');
INSERT INTO `admin_privilege` VALUES ('20', 'Admin Privilege Edit', '13', 'privilege/edit', '83');
INSERT INTO `admin_privilege` VALUES ('21', 'Admin Privilege Delete', '13', 'privilege/forever_delete', '84');
INSERT INTO `admin_privilege` VALUES ('22', 'Admin Auth View', '15', 'auth/index', '91');
INSERT INTO `admin_privilege` VALUES ('23', 'Admin Role Privilege Update', '15', 'auth/update_role_privilege', '92');
INSERT INTO `admin_privilege` VALUES ('24', 'Login System', '0', 'index/index', '0');
INSERT INTO `admin_privilege` VALUES ('25', 'Admin User Role Update', '13', 'auth/update_user_role', '93');
INSERT INTO `admin_privilege` VALUES ('31', 'MySQL Servers View', '18', 'servers_mysql/index', '36');
INSERT INTO `admin_privilege` VALUES ('32', 'MySQL Servers Add', '18', 'servers_mysql/add', '37');
INSERT INTO `admin_privilege` VALUES ('33', 'MySQL Servers Edit', '18', 'servers_mysql/edit', '38');
INSERT INTO `admin_privilege` VALUES ('34', 'MySQL Servers Trash', '18', 'servers_mysql/trash', '39');
INSERT INTO `admin_privilege` VALUES ('35', 'MySQL Servers Delete', '18', 'servers_mysql/delete', '40');
INSERT INTO `admin_privilege` VALUES ('36', 'MySQLSlowQuery Detail', '9', 'lp_mysql/slowquery_detail', '4');
INSERT INTO `admin_privilege` VALUES ('37', 'MySQL AWR Report', '19', 'lp_mysql/awrreport', '5');
INSERT INTO `admin_privilege` VALUES ('38', 'MySQL Health Chart', '6', 'lp_mysql/chart', '1');
INSERT INTO `admin_privilege` VALUES ('39', 'MySQL Replication Chart', '8', 'lp_mysql/replication_chart', '2');
INSERT INTO `admin_privilege` VALUES ('40', 'Alarm View', '21', 'alarm/index', '8');
INSERT INTO `admin_privilege` VALUES ('41', 'OS Health View', '43', 'lp_os/index', '100');
INSERT INTO `admin_privilege` VALUES ('44', 'OS Disk View', '26', 'lp_os/disk', '100');
INSERT INTO `admin_privilege` VALUES ('46', 'OS Disk Chart View', '26', 'lp_os/disk_chart', '100');
INSERT INTO `admin_privilege` VALUES ('48', 'OS Health Chart View', '43', 'lp_os/chart', '100');
INSERT INTO `admin_privilege` VALUES ('49', 'MySQL BigTable Analysis', '28', 'lp_mysql/bigtable', '8');
INSERT INTO `admin_privilege` VALUES ('50', 'MySQL BigTable Analysis Chart', '28', 'lp_mysql/bigtable_chart', '8');
INSERT INTO `admin_privilege` VALUES ('51', 'MySQL Key Cache Monitor', '29', 'lp_mysql/key_cache', '2');
INSERT INTO `admin_privilege` VALUES ('52', 'MySQL InnoDB Monitor', '30', 'lp_mysql/innodb', '2');
INSERT INTO `admin_privilege` VALUES ('53', 'MySQL Resource Monitor', '31', 'lp_mysql/resource', '2');
INSERT INTO `admin_privilege` VALUES ('54', 'MongoDB Servers View', '32', 'servers_mongodb/index', '42');
INSERT INTO `admin_privilege` VALUES ('55', 'MongoDB Servers Add', '32', 'servers_mongodb/add', '43');
INSERT INTO `admin_privilege` VALUES ('56', 'MongoDB Servers Edit', '32', 'servers_mongodb/edit', '44');
INSERT INTO `admin_privilege` VALUES ('57', 'MongoDB Servers Trash', '32', 'servers_mongodb/trash', '44');
INSERT INTO `admin_privilege` VALUES ('58', 'MongoDB Servers Delete', '32', 'servers_mongodb/delete', '44');
INSERT INTO `admin_privilege` VALUES ('59', 'MongoDB Health View', '34', 'lp_mongodb/index', '10');
INSERT INTO `admin_privilege` VALUES ('60', 'MongoDB Indexes View', '35', 'lp_mongodb/indexes', '11');
INSERT INTO `admin_privilege` VALUES ('61', 'MongoDB Memory View', '36', 'lp_mongodb/memory', '12');
INSERT INTO `admin_privilege` VALUES ('67', 'Oracle Servers View', '40', 'servers_oracle/index', '45');
INSERT INTO `admin_privilege` VALUES ('68', 'Oracle Servers Add', '40', 'servers_oracle/add', '46');
INSERT INTO `admin_privilege` VALUES ('69', 'Oracle Servers Edit', '40', 'servers_oracle/edit', '47');
INSERT INTO `admin_privilege` VALUES ('76', 'Mongodb Health Chart View', '34', 'lp_mongodb/chart', '13');
INSERT INTO `admin_privilege` VALUES ('77', 'OS Disk View', '44', 'lp_os/disk_io', '100');
INSERT INTO `admin_privilege` VALUES ('78', 'OS Disk Chart View', '44', 'lp_os/disk_io_chart', '100');
INSERT INTO `admin_privilege` VALUES ('79', 'OS Servers View', '45', 'servers_os/index', '50');
INSERT INTO `admin_privilege` VALUES ('80', 'OS  Servers Add', '45', 'servers_os/add', '50');
INSERT INTO `admin_privilege` VALUES ('81', 'OS Servers Edit', '45', 'servers_os/edit', '50');
INSERT INTO `admin_privilege` VALUES ('82', 'OS Servers Delete', '45', 'servers_os/delete', '50');
INSERT INTO `admin_privilege` VALUES ('83', 'OS Servers Trash', '45', 'servers_os/trash', '50');
INSERT INTO `admin_privilege` VALUES ('84', 'OS Servers Batch Add', '45', 'servers_os/batch_add', '50');
INSERT INTO `admin_privilege` VALUES ('85', 'MongoDB Servers Batch Add', '32', 'servers_mongodb/batch_add', '44');
INSERT INTO `admin_privilege` VALUES ('86', 'MySQL Servers Batch Add', '18', 'servers_mysql/batch_add', '40');
INSERT INTO `admin_privilege` VALUES ('87', 'Settings View', '46', 'settings/index', '30');
INSERT INTO `admin_privilege` VALUES ('92', 'Redis Health View', '50', 'lp_redis/index', '19');
INSERT INTO `admin_privilege` VALUES ('93', 'Redis Health Chart View', '50', 'lp_redis/chart', '20');
INSERT INTO `admin_privilege` VALUES ('94', 'Redis Servers View', '51', 'servers_redis/index', '51');
INSERT INTO `admin_privilege` VALUES ('95', 'Redis Servers Add', '51', 'servers_redis/add', '51');
INSERT INTO `admin_privilege` VALUES ('96', 'Redis Servers Edit', '51', 'servers_redis/edit', '51');
INSERT INTO `admin_privilege` VALUES ('97', 'Redis Servers Trash', '51', 'servers_redis/trash', '51');
INSERT INTO `admin_privilege` VALUES ('98', 'Redis Servers Delete', '51', 'servers_redis/delete', '51');
INSERT INTO `admin_privilege` VALUES ('99', 'Redis Servers Batch Add', '51', 'servers_redis/batch_add', '51');
INSERT INTO `admin_privilege` VALUES ('100', 'Redis Memory View', '52', 'lp_redis/memory', '21');
INSERT INTO `admin_privilege` VALUES ('101', 'Redis Memory Chart View', '52', 'lp_redis/memory_chart', '21');
INSERT INTO `admin_privilege` VALUES ('104', 'Redis Replication View', '54', 'lp_redis/replication', '23');
INSERT INTO `admin_privilege` VALUES ('105', 'Redis Replication Chart View', '54', 'lp_redis/replication_chart', '23');
INSERT INTO `admin_privilege` VALUES ('110', 'Oracle Health Monitor', '57', 'lp_oracle/index', '25');
INSERT INTO `admin_privilege` VALUES ('111', 'Oracle Health Chart', '57', 'lp_oracle/chart', '26');
INSERT INTO `admin_privilege` VALUES ('112', 'Oracle Tablespace Monitor', '58', 'lp_oracle/tablespace', '27');
INSERT INTO `admin_privilege` VALUES ('113', 'Settings Save', '46', 'settings/save', '31');
INSERT INTO `admin_privilege` VALUES ('114', 'Oracle Servers Trash', '40', 'servers_oracle/trash', '48');
INSERT INTO `admin_privilege` VALUES ('115', 'Oracle Servers Delete', '40', 'servers_oracle/delete', '48');
INSERT INTO `admin_privilege` VALUES ('116', 'Oracle Servers Batch Add', '40', 'servers_oracle/batch_add', '48');

-- ----------------------------
-- Table structure for admin_role
-- ----------------------------
DROP TABLE IF EXISTS `admin_role`;
CREATE TABLE `admin_role` (
  `role_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(30) NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_role
-- ----------------------------
INSERT INTO `admin_role` VALUES ('1', 'Administrator');
INSERT INTO `admin_role` VALUES ('3', 'IT-DBA');
INSERT INTO `admin_role` VALUES ('5', 'IT-Developer');
INSERT INTO `admin_role` VALUES ('7', 'guest_group');

-- ----------------------------
-- Table structure for admin_role_privilege
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_privilege`;
CREATE TABLE `admin_role_privilege` (
  `role_id` smallint(4) NOT NULL,
  `privilege_id` smallint(4) NOT NULL,
  PRIMARY KEY (`role_id`,`privilege_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_role_privilege
-- ----------------------------
INSERT INTO `admin_role_privilege` VALUES ('1', '1');
INSERT INTO `admin_role_privilege` VALUES ('1', '3');
INSERT INTO `admin_role_privilege` VALUES ('1', '4');
INSERT INTO `admin_role_privilege` VALUES ('1', '6');
INSERT INTO `admin_role_privilege` VALUES ('1', '7');
INSERT INTO `admin_role_privilege` VALUES ('1', '8');
INSERT INTO `admin_role_privilege` VALUES ('1', '9');
INSERT INTO `admin_role_privilege` VALUES ('1', '10');
INSERT INTO `admin_role_privilege` VALUES ('1', '11');
INSERT INTO `admin_role_privilege` VALUES ('1', '12');
INSERT INTO `admin_role_privilege` VALUES ('1', '13');
INSERT INTO `admin_role_privilege` VALUES ('1', '14');
INSERT INTO `admin_role_privilege` VALUES ('1', '15');
INSERT INTO `admin_role_privilege` VALUES ('1', '16');
INSERT INTO `admin_role_privilege` VALUES ('1', '17');
INSERT INTO `admin_role_privilege` VALUES ('1', '18');
INSERT INTO `admin_role_privilege` VALUES ('1', '19');
INSERT INTO `admin_role_privilege` VALUES ('1', '20');
INSERT INTO `admin_role_privilege` VALUES ('1', '21');
INSERT INTO `admin_role_privilege` VALUES ('1', '22');
INSERT INTO `admin_role_privilege` VALUES ('1', '23');
INSERT INTO `admin_role_privilege` VALUES ('1', '24');
INSERT INTO `admin_role_privilege` VALUES ('1', '25');
INSERT INTO `admin_role_privilege` VALUES ('1', '31');
INSERT INTO `admin_role_privilege` VALUES ('1', '32');
INSERT INTO `admin_role_privilege` VALUES ('1', '33');
INSERT INTO `admin_role_privilege` VALUES ('1', '34');
INSERT INTO `admin_role_privilege` VALUES ('1', '35');
INSERT INTO `admin_role_privilege` VALUES ('1', '36');
INSERT INTO `admin_role_privilege` VALUES ('1', '37');
INSERT INTO `admin_role_privilege` VALUES ('1', '38');
INSERT INTO `admin_role_privilege` VALUES ('1', '39');
INSERT INTO `admin_role_privilege` VALUES ('1', '40');
INSERT INTO `admin_role_privilege` VALUES ('1', '41');
INSERT INTO `admin_role_privilege` VALUES ('1', '44');
INSERT INTO `admin_role_privilege` VALUES ('1', '46');
INSERT INTO `admin_role_privilege` VALUES ('1', '48');
INSERT INTO `admin_role_privilege` VALUES ('1', '49');
INSERT INTO `admin_role_privilege` VALUES ('1', '50');
INSERT INTO `admin_role_privilege` VALUES ('1', '51');
INSERT INTO `admin_role_privilege` VALUES ('1', '52');
INSERT INTO `admin_role_privilege` VALUES ('1', '53');
INSERT INTO `admin_role_privilege` VALUES ('1', '54');
INSERT INTO `admin_role_privilege` VALUES ('1', '55');
INSERT INTO `admin_role_privilege` VALUES ('1', '56');
INSERT INTO `admin_role_privilege` VALUES ('1', '57');
INSERT INTO `admin_role_privilege` VALUES ('1', '58');
INSERT INTO `admin_role_privilege` VALUES ('1', '59');
INSERT INTO `admin_role_privilege` VALUES ('1', '60');
INSERT INTO `admin_role_privilege` VALUES ('1', '61');
INSERT INTO `admin_role_privilege` VALUES ('1', '67');
INSERT INTO `admin_role_privilege` VALUES ('1', '68');
INSERT INTO `admin_role_privilege` VALUES ('1', '69');
INSERT INTO `admin_role_privilege` VALUES ('1', '76');
INSERT INTO `admin_role_privilege` VALUES ('1', '77');
INSERT INTO `admin_role_privilege` VALUES ('1', '78');
INSERT INTO `admin_role_privilege` VALUES ('1', '79');
INSERT INTO `admin_role_privilege` VALUES ('1', '80');
INSERT INTO `admin_role_privilege` VALUES ('1', '81');
INSERT INTO `admin_role_privilege` VALUES ('1', '82');
INSERT INTO `admin_role_privilege` VALUES ('1', '83');
INSERT INTO `admin_role_privilege` VALUES ('1', '84');
INSERT INTO `admin_role_privilege` VALUES ('1', '85');
INSERT INTO `admin_role_privilege` VALUES ('1', '86');
INSERT INTO `admin_role_privilege` VALUES ('1', '87');
INSERT INTO `admin_role_privilege` VALUES ('1', '92');
INSERT INTO `admin_role_privilege` VALUES ('1', '93');
INSERT INTO `admin_role_privilege` VALUES ('1', '94');
INSERT INTO `admin_role_privilege` VALUES ('1', '95');
INSERT INTO `admin_role_privilege` VALUES ('1', '96');
INSERT INTO `admin_role_privilege` VALUES ('1', '97');
INSERT INTO `admin_role_privilege` VALUES ('1', '98');
INSERT INTO `admin_role_privilege` VALUES ('1', '99');
INSERT INTO `admin_role_privilege` VALUES ('1', '100');
INSERT INTO `admin_role_privilege` VALUES ('1', '101');
INSERT INTO `admin_role_privilege` VALUES ('1', '104');
INSERT INTO `admin_role_privilege` VALUES ('1', '105');
INSERT INTO `admin_role_privilege` VALUES ('1', '110');
INSERT INTO `admin_role_privilege` VALUES ('1', '111');
INSERT INTO `admin_role_privilege` VALUES ('1', '112');
INSERT INTO `admin_role_privilege` VALUES ('1', '113');
INSERT INTO `admin_role_privilege` VALUES ('1', '114');
INSERT INTO `admin_role_privilege` VALUES ('1', '115');
INSERT INTO `admin_role_privilege` VALUES ('1', '116');
INSERT INTO `admin_role_privilege` VALUES ('2', '4');
INSERT INTO `admin_role_privilege` VALUES ('3', '1');
INSERT INTO `admin_role_privilege` VALUES ('3', '2');
INSERT INTO `admin_role_privilege` VALUES ('3', '3');
INSERT INTO `admin_role_privilege` VALUES ('3', '4');
INSERT INTO `admin_role_privilege` VALUES ('3', '6');
INSERT INTO `admin_role_privilege` VALUES ('3', '7');
INSERT INTO `admin_role_privilege` VALUES ('3', '8');
INSERT INTO `admin_role_privilege` VALUES ('3', '9');
INSERT INTO `admin_role_privilege` VALUES ('3', '10');
INSERT INTO `admin_role_privilege` VALUES ('3', '11');
INSERT INTO `admin_role_privilege` VALUES ('3', '12');
INSERT INTO `admin_role_privilege` VALUES ('3', '13');
INSERT INTO `admin_role_privilege` VALUES ('3', '14');
INSERT INTO `admin_role_privilege` VALUES ('3', '15');
INSERT INTO `admin_role_privilege` VALUES ('3', '16');
INSERT INTO `admin_role_privilege` VALUES ('3', '17');
INSERT INTO `admin_role_privilege` VALUES ('3', '18');
INSERT INTO `admin_role_privilege` VALUES ('3', '19');
INSERT INTO `admin_role_privilege` VALUES ('3', '20');
INSERT INTO `admin_role_privilege` VALUES ('3', '21');
INSERT INTO `admin_role_privilege` VALUES ('3', '22');
INSERT INTO `admin_role_privilege` VALUES ('3', '23');
INSERT INTO `admin_role_privilege` VALUES ('3', '24');
INSERT INTO `admin_role_privilege` VALUES ('3', '25');
INSERT INTO `admin_role_privilege` VALUES ('3', '26');
INSERT INTO `admin_role_privilege` VALUES ('3', '27');
INSERT INTO `admin_role_privilege` VALUES ('3', '28');
INSERT INTO `admin_role_privilege` VALUES ('3', '29');
INSERT INTO `admin_role_privilege` VALUES ('3', '30');
INSERT INTO `admin_role_privilege` VALUES ('3', '31');
INSERT INTO `admin_role_privilege` VALUES ('3', '32');
INSERT INTO `admin_role_privilege` VALUES ('3', '33');
INSERT INTO `admin_role_privilege` VALUES ('3', '34');
INSERT INTO `admin_role_privilege` VALUES ('3', '35');
INSERT INTO `admin_role_privilege` VALUES ('3', '36');
INSERT INTO `admin_role_privilege` VALUES ('3', '37');
INSERT INTO `admin_role_privilege` VALUES ('3', '38');
INSERT INTO `admin_role_privilege` VALUES ('3', '39');
INSERT INTO `admin_role_privilege` VALUES ('3', '40');
INSERT INTO `admin_role_privilege` VALUES ('3', '41');
INSERT INTO `admin_role_privilege` VALUES ('3', '42');
INSERT INTO `admin_role_privilege` VALUES ('3', '43');
INSERT INTO `admin_role_privilege` VALUES ('3', '44');
INSERT INTO `admin_role_privilege` VALUES ('3', '46');
INSERT INTO `admin_role_privilege` VALUES ('3', '47');
INSERT INTO `admin_role_privilege` VALUES ('3', '48');
INSERT INTO `admin_role_privilege` VALUES ('3', '49');
INSERT INTO `admin_role_privilege` VALUES ('3', '50');
INSERT INTO `admin_role_privilege` VALUES ('3', '51');
INSERT INTO `admin_role_privilege` VALUES ('3', '52');
INSERT INTO `admin_role_privilege` VALUES ('3', '53');
INSERT INTO `admin_role_privilege` VALUES ('3', '54');
INSERT INTO `admin_role_privilege` VALUES ('3', '55');
INSERT INTO `admin_role_privilege` VALUES ('3', '56');
INSERT INTO `admin_role_privilege` VALUES ('3', '57');
INSERT INTO `admin_role_privilege` VALUES ('3', '58');
INSERT INTO `admin_role_privilege` VALUES ('3', '59');
INSERT INTO `admin_role_privilege` VALUES ('3', '60');
INSERT INTO `admin_role_privilege` VALUES ('3', '61');
INSERT INTO `admin_role_privilege` VALUES ('3', '67');
INSERT INTO `admin_role_privilege` VALUES ('3', '68');
INSERT INTO `admin_role_privilege` VALUES ('3', '69');
INSERT INTO `admin_role_privilege` VALUES ('3', '70');
INSERT INTO `admin_role_privilege` VALUES ('3', '71');
INSERT INTO `admin_role_privilege` VALUES ('3', '72');
INSERT INTO `admin_role_privilege` VALUES ('3', '74');
INSERT INTO `admin_role_privilege` VALUES ('3', '75');
INSERT INTO `admin_role_privilege` VALUES ('3', '76');
INSERT INTO `admin_role_privilege` VALUES ('3', '77');
INSERT INTO `admin_role_privilege` VALUES ('3', '78');
INSERT INTO `admin_role_privilege` VALUES ('3', '79');
INSERT INTO `admin_role_privilege` VALUES ('3', '80');
INSERT INTO `admin_role_privilege` VALUES ('3', '81');
INSERT INTO `admin_role_privilege` VALUES ('3', '82');
INSERT INTO `admin_role_privilege` VALUES ('3', '83');
INSERT INTO `admin_role_privilege` VALUES ('3', '84');
INSERT INTO `admin_role_privilege` VALUES ('3', '85');
INSERT INTO `admin_role_privilege` VALUES ('3', '86');
INSERT INTO `admin_role_privilege` VALUES ('3', '87');
INSERT INTO `admin_role_privilege` VALUES ('3', '88');
INSERT INTO `admin_role_privilege` VALUES ('3', '89');
INSERT INTO `admin_role_privilege` VALUES ('3', '90');
INSERT INTO `admin_role_privilege` VALUES ('5', '1');
INSERT INTO `admin_role_privilege` VALUES ('5', '3');
INSERT INTO `admin_role_privilege` VALUES ('5', '4');
INSERT INTO `admin_role_privilege` VALUES ('5', '24');
INSERT INTO `admin_role_privilege` VALUES ('5', '36');
INSERT INTO `admin_role_privilege` VALUES ('5', '38');
INSERT INTO `admin_role_privilege` VALUES ('5', '39');
INSERT INTO `admin_role_privilege` VALUES ('5', '42');
INSERT INTO `admin_role_privilege` VALUES ('5', '43');
INSERT INTO `admin_role_privilege` VALUES ('5', '44');
INSERT INTO `admin_role_privilege` VALUES ('5', '46');
INSERT INTO `admin_role_privilege` VALUES ('5', '47');
INSERT INTO `admin_role_privilege` VALUES ('5', '48');
INSERT INTO `admin_role_privilege` VALUES ('5', '59');
INSERT INTO `admin_role_privilege` VALUES ('5', '60');
INSERT INTO `admin_role_privilege` VALUES ('5', '61');
INSERT INTO `admin_role_privilege` VALUES ('5', '74');
INSERT INTO `admin_role_privilege` VALUES ('5', '75');
INSERT INTO `admin_role_privilege` VALUES ('5', '76');
INSERT INTO `admin_role_privilege` VALUES ('5', '77');
INSERT INTO `admin_role_privilege` VALUES ('5', '78');
INSERT INTO `admin_role_privilege` VALUES ('5', '88');
INSERT INTO `admin_role_privilege` VALUES ('5', '89');
INSERT INTO `admin_role_privilege` VALUES ('5', '90');
INSERT INTO `admin_role_privilege` VALUES ('7', '1');
INSERT INTO `admin_role_privilege` VALUES ('7', '3');
INSERT INTO `admin_role_privilege` VALUES ('7', '4');
INSERT INTO `admin_role_privilege` VALUES ('7', '6');
INSERT INTO `admin_role_privilege` VALUES ('7', '10');
INSERT INTO `admin_role_privilege` VALUES ('7', '14');
INSERT INTO `admin_role_privilege` VALUES ('7', '18');
INSERT INTO `admin_role_privilege` VALUES ('7', '22');
INSERT INTO `admin_role_privilege` VALUES ('7', '24');
INSERT INTO `admin_role_privilege` VALUES ('7', '36');
INSERT INTO `admin_role_privilege` VALUES ('7', '37');
INSERT INTO `admin_role_privilege` VALUES ('7', '38');
INSERT INTO `admin_role_privilege` VALUES ('7', '39');
INSERT INTO `admin_role_privilege` VALUES ('7', '40');
INSERT INTO `admin_role_privilege` VALUES ('7', '41');
INSERT INTO `admin_role_privilege` VALUES ('7', '44');
INSERT INTO `admin_role_privilege` VALUES ('7', '46');
INSERT INTO `admin_role_privilege` VALUES ('7', '48');
INSERT INTO `admin_role_privilege` VALUES ('7', '49');
INSERT INTO `admin_role_privilege` VALUES ('7', '50');
INSERT INTO `admin_role_privilege` VALUES ('7', '51');
INSERT INTO `admin_role_privilege` VALUES ('7', '52');
INSERT INTO `admin_role_privilege` VALUES ('7', '53');
INSERT INTO `admin_role_privilege` VALUES ('7', '59');
INSERT INTO `admin_role_privilege` VALUES ('7', '60');
INSERT INTO `admin_role_privilege` VALUES ('7', '61');
INSERT INTO `admin_role_privilege` VALUES ('7', '76');
INSERT INTO `admin_role_privilege` VALUES ('7', '77');
INSERT INTO `admin_role_privilege` VALUES ('7', '78');
INSERT INTO `admin_role_privilege` VALUES ('7', '87');
INSERT INTO `admin_role_privilege` VALUES ('7', '92');
INSERT INTO `admin_role_privilege` VALUES ('7', '93');
INSERT INTO `admin_role_privilege` VALUES ('7', '100');
INSERT INTO `admin_role_privilege` VALUES ('7', '101');
INSERT INTO `admin_role_privilege` VALUES ('7', '104');
INSERT INTO `admin_role_privilege` VALUES ('7', '105');
INSERT INTO `admin_role_privilege` VALUES ('7', '110');
INSERT INTO `admin_role_privilege` VALUES ('7', '111');
INSERT INTO `admin_role_privilege` VALUES ('7', '112');

-- ----------------------------
-- Table structure for admin_user
-- ----------------------------
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `realname` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `login_count` int(11) DEFAULT '0',
  `last_login_ip` varchar(100) DEFAULT NULL,
  `last_login_time` datetime DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_user
-- ----------------------------
INSERT INTO `admin_user` VALUES ('1', 'admin', '6f493fbddf9107797f5044bb229ac6ee', 'Administrator', 'admin@mail.com', '', '0', '', '2015-02-09 13:55:31', '1', '2013-12-25 15:58:34');
INSERT INTO `admin_user` VALUES ('8', 'guest', 'e10adc3949ba59abbe56e057f20f883e', 'Guest', '', '', '624', '114.86.1.166', '2015-02-09 13:39:57', '1', '2014-03-12 17:06:36');

-- ----------------------------
-- Table structure for admin_user_role
-- ----------------------------
DROP TABLE IF EXISTS `admin_user_role`;
CREATE TABLE `admin_user_role` (
  `user_id` int(10) NOT NULL,
  `role_id` smallint(4) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_user_role
-- ----------------------------
INSERT INTO `admin_user_role` VALUES ('1', '1');
INSERT INTO `admin_user_role` VALUES ('2', '1');
INSERT INTO `admin_user_role` VALUES ('2', '2');
INSERT INTO `admin_user_role` VALUES ('2', '3');
INSERT INTO `admin_user_role` VALUES ('2', '5');
INSERT INTO `admin_user_role` VALUES ('8', '7');
INSERT INTO `admin_user_role` VALUES ('9', '3');

-- ----------------------------
-- Table structure for lepus_status
-- ----------------------------
DROP TABLE IF EXISTS `lepus_status`;
CREATE TABLE `lepus_status` (
  `lepus_variables` varchar(255) NOT NULL,
  `lepus_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lepus_status
-- ----------------------------
INSERT INTO `lepus_status` VALUES ('lepus_running', '1');
INSERT INTO `lepus_status` VALUES ('lepus_version', '3.7');
INSERT INTO `lepus_status` VALUES ('lepus_checktime', 'none');

-- ----------------------------
-- Table structure for options
-- ----------------------------
DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `name` varchar(50) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  KEY `idx_name` (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of options
-- ----------------------------
INSERT INTO `options` VALUES ('monitor', '1', '是否开启全局监控,此项如果关闭则所有项目都不会被监控，下面监控选项都失效');
INSERT INTO `options` VALUES ('monitor_mysql', '1', '是否开启MySQL状态监控');
INSERT INTO `options` VALUES ('send_alarm_mail', '1', '是否发送报警邮件');
INSERT INTO `options` VALUES ('send_mail_to_list', '', '报警邮件通知人员');
INSERT INTO `options` VALUES ('monitor_os', '1', '是否开启OS监控');
INSERT INTO `options` VALUES ('monitor_mongodb', '1', '是否监控MongoDB');
INSERT INTO `options` VALUES ('alarm', '1', '是否开启告警');
INSERT INTO `options` VALUES ('send_mail_max_count', '1', '发送邮件最大次数');
INSERT INTO `options` VALUES ('report_mail_to_list', '', '报告邮件推送接收人员');
INSERT INTO `options` VALUES ('frequency_monitor', '60', '监控频率');
INSERT INTO `options` VALUES ('send_mail_sleep_time', '720', '发送邮件休眠时间(分钟)');
INSERT INTO `options` VALUES ('mailtype', 'html', '邮件发送配置:邮件类型');
INSERT INTO `options` VALUES ('mailprotocol', 'smtp', '邮件发送配置:邮件协议');
INSERT INTO `options` VALUES ('smtp_host', 'smtp.126.com', '邮件发送配置:邮件主机');
INSERT INTO `options` VALUES ('smtp_port', '25', '邮件发送配置:邮件端口');
INSERT INTO `options` VALUES ('smtp_user', 'noreplymail', '邮件发送配置:用户');
INSERT INTO `options` VALUES ('smtp_pass', '', '邮件发送配置:密码');
INSERT INTO `options` VALUES ('smtp_timeout', '10', '邮件发送配置:超时时间');
INSERT INTO `options` VALUES ('mailfrom', 'noreplymail@126.com', '邮件发送配置:发件人');
INSERT INTO `options` VALUES ('monitor_redis', '1', '是否监控Redis');
INSERT INTO `options` VALUES ('monitor_oracle', '1', '是否监控Oracle');
INSERT INTO `options` VALUES ('send_alarm_sms', '1', '是否发生短信');
INSERT INTO `options` VALUES ('send_sms_to_list', '', '短信收件人列表');
INSERT INTO `options` VALUES ('send_sms_max_count', '1', '发送短信最大次数');
INSERT INTO `options` VALUES ('send_sms_sleep_time', '180', '发送短信休眠时间(分钟)');
INSERT INTO `options` VALUES ('sms_fetion_user', '', '飞信发送短信账号');
INSERT INTO `options` VALUES ('sms_fetion_pass', '', '飞信发送短信密码');
INSERT INTO `options` VALUES ('smstype', 'fetion', '发送短信方式：fetion/api');
