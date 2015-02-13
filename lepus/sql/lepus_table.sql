/*
Navicat MySQL Data Transfer

Source Server         : 219.234.6.180-lepus_db
Source Server Version : 50536
Source Host           : 219.234.6.180:3306
Source Database       : lepus_db

Target Server Type    : MYSQL
Target Server Version : 50536
File Encoding         : 65001

Date: 2015-02-09 15:48:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_log
-- ----------------------------
DROP TABLE IF EXISTS `admin_log`;
CREATE TABLE `admin_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` smallint(4) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `client_ip` varchar(100) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1560 DEFAULT CHARSET=utf8;

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
-- Table structure for admin_role
-- ----------------------------
DROP TABLE IF EXISTS `admin_role`;
CREATE TABLE `admin_role` (
  `role_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(30) NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

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
-- Table structure for admin_user_role
-- ----------------------------
DROP TABLE IF EXISTS `admin_user_role`;
CREATE TABLE `admin_user_role` (
  `user_id` int(10) NOT NULL,
  `role_id` smallint(4) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for alarm
-- ----------------------------
DROP TABLE IF EXISTS `alarm`;
CREATE TABLE `alarm` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) NOT NULL DEFAULT '0',
  `tags` varchar(50) DEFAULT NULL,
  `host` varchar(30) DEFAULT NULL,
  `port` varchar(10) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `db_type` varchar(30) DEFAULT NULL,
  `alarm_item` varchar(50) DEFAULT NULL,
  `alarm_value` varchar(50) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `send_mail` tinyint(2) DEFAULT NULL,
  `send_mail_to_list` varchar(255) DEFAULT NULL,
  `send_sms` tinyint(2) DEFAULT NULL,
  `send_sms_to_list` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3349377 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for alarm_history
-- ----------------------------
DROP TABLE IF EXISTS `alarm_history`;
CREATE TABLE `alarm_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) NOT NULL DEFAULT '0',
  `tags` varchar(50) DEFAULT NULL,
  `host` varchar(30) DEFAULT NULL,
  `port` varchar(10) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `db_type` varchar(30) DEFAULT NULL,
  `alarm_item` varchar(50) DEFAULT NULL,
  `alarm_value` varchar(50) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `send_mail` tinyint(2) DEFAULT NULL,
  `send_mail_to_list` varchar(255) DEFAULT NULL,
  `send_sms` tinyint(2) DEFAULT NULL,
  `send_sms_to_list` varchar(255) DEFAULT NULL,
  `send_mail_status` tinyint(2) NOT NULL DEFAULT '0',
  `send_sms_status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_server_id` (`server_id`),
  KEY `idx_host` (`host`),
  KEY `idx_alarm_type` (`alarm_item`),
  KEY `idx_level` (`level`)
) ENGINE=InnoDB AUTO_INCREMENT=45633 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for alarm_temp
-- ----------------------------
DROP TABLE IF EXISTS `alarm_temp`;
CREATE TABLE `alarm_temp` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) NOT NULL DEFAULT '0',
  `ip` varchar(50) DEFAULT NULL,
  `db_type` varchar(30) DEFAULT NULL,
  `alarm_item` varchar(50) DEFAULT NULL,
  `alarm_type` varchar(30) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2902859 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for db_servers_mongodb
-- ----------------------------
DROP TABLE IF EXISTS `db_servers_mongodb`;
CREATE TABLE `db_servers_mongodb` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `host` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `port` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tags` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `monitor` tinyint(2) DEFAULT '1',
  `send_mail` tinyint(2) DEFAULT '1',
  `send_mail_to_list` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `send_sms` tinyint(2) DEFAULT '0',
  `send_sms_to_list` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alarm_connections_current` tinyint(2) NOT NULL DEFAULT '1',
  `alarm_active_clients` tinyint(2) NOT NULL DEFAULT '1',
  `alarm_current_queue` tinyint(2) NOT NULL DEFAULT '1',
  `threshold_warning_connections_current` int(10) NOT NULL DEFAULT '1000',
  `threshold_warning_active_clients` smallint(4) NOT NULL DEFAULT '10',
  `threshold_warning_current_queue` smallint(4) NOT NULL DEFAULT '5',
  `threshold_critical_connections_current` int(10) NOT NULL DEFAULT '3000',
  `threshold_critical_active_clients` smallint(4) NOT NULL DEFAULT '30',
  `threshold_critical_current_queue` smallint(4) NOT NULL DEFAULT '15',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `display_order` smallint(4) NOT NULL DEFAULT '0',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_host` (`host`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for db_servers_mysql
-- ----------------------------
DROP TABLE IF EXISTS `db_servers_mysql`;
CREATE TABLE `db_servers_mysql` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `host` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `port` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tags` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `monitor` tinyint(2) DEFAULT '1' COMMENT '1:ç›‘æŽ§ 0ï¼šä¸ç›‘æŽ§',
  `send_mail` tinyint(2) DEFAULT '1',
  `send_mail_to_list` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `send_sms` tinyint(2) DEFAULT '0',
  `send_sms_to_list` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `send_slowquery_to_list` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alarm_threads_connected` tinyint(2) DEFAULT '1',
  `alarm_threads_running` tinyint(2) DEFAULT '1',
  `alarm_threads_waits` tinyint(2) DEFAULT '1',
  `alarm_repl_status` tinyint(2) DEFAULT '1',
  `alarm_repl_delay` tinyint(2) DEFAULT '1',
  `threshold_warning_threads_connected` int(10) DEFAULT '1000',
  `threshold_warning_threads_running` int(10) DEFAULT '10',
  `threshold_warning_threads_waits` int(10) DEFAULT '5',
  `threshold_warning_repl_delay` int(10) DEFAULT '60',
  `threshold_critical_threads_connected` int(10) DEFAULT '3000',
  `threshold_critical_threads_running` int(10) DEFAULT '30',
  `threshold_critical_threads_waits` int(10) DEFAULT '15',
  `threshold_critical_repl_delay` int(10) DEFAULT '600',
  `slow_query` tinyint(2) NOT NULL DEFAULT '0',
  `binlog_auto_purge` tinyint(1) NOT NULL DEFAULT '0',
  `binlog_store_days` smallint(4) NOT NULL DEFAULT '30',
  `bigtable_monitor` tinyint(1) NOT NULL DEFAULT '0',
  `bigtable_size` int(10) NOT NULL DEFAULT '50',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `display_order` smallint(4) NOT NULL DEFAULT '0',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_host` (`host`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=270 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for db_servers_oracle
-- ----------------------------
DROP TABLE IF EXISTS `db_servers_oracle`;
CREATE TABLE `db_servers_oracle` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `host` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `port` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dsn` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tags` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `monitor` tinyint(2) DEFAULT '1',
  `send_mail` tinyint(2) DEFAULT '0',
  `send_mail_to_list` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `send_sms` tinyint(2) DEFAULT '0',
  `send_sms_to_list` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alarm_session_total` tinyint(2) NOT NULL DEFAULT '1',
  `alarm_session_actives` tinyint(2) NOT NULL DEFAULT '1',
  `alarm_session_waits` tinyint(2) NOT NULL DEFAULT '1',
  `alarm_tablespace` tinyint(2) NOT NULL DEFAULT '1',
  `threshold_warning_session_total` smallint(4) NOT NULL DEFAULT '1000',
  `threshold_warning_session_actives` smallint(4) NOT NULL DEFAULT '10',
  `threshold_warning_session_waits` tinyint(4) NOT NULL DEFAULT '5',
  `threshold_warning_tablespace` smallint(10) NOT NULL DEFAULT '85',
  `threshold_critical_session_total` smallint(4) NOT NULL DEFAULT '3000',
  `threshold_critical_session_actives` smallint(4) NOT NULL DEFAULT '30',
  `threshold_critical_session_waits` smallint(4) NOT NULL DEFAULT '15',
  `threshold_critical_tablespace` smallint(4) NOT NULL DEFAULT '95',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `display_order` smallint(4) NOT NULL DEFAULT '0',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_host` (`host`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for db_servers_os
-- ----------------------------
DROP TABLE IF EXISTS `db_servers_os`;
CREATE TABLE `db_servers_os` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `host` varchar(30) DEFAULT NULL,
  `community` varchar(50) DEFAULT NULL,
  `tags` varchar(30) DEFAULT NULL,
  `monitor` tinyint(2) DEFAULT '0',
  `send_mail` tinyint(2) DEFAULT '0',
  `send_mail_to_list` varchar(255) DEFAULT NULL,
  `send_sms` tinyint(2) DEFAULT '0',
  `send_sms_to_list` varchar(255) DEFAULT NULL,
  `alarm_os_process` tinyint(1) NOT NULL DEFAULT '1',
  `alarm_os_load` tinyint(1) NOT NULL DEFAULT '1',
  `alarm_os_cpu` tinyint(1) NOT NULL DEFAULT '1',
  `alarm_os_network` tinyint(1) NOT NULL DEFAULT '1',
  `alarm_os_disk` tinyint(1) NOT NULL DEFAULT '1',
  `alarm_os_memory` tinyint(1) NOT NULL DEFAULT '1',
  `threshold_warning_os_process` int(10) NOT NULL DEFAULT '300',
  `threshold_warning_os_load` int(10) NOT NULL DEFAULT '3',
  `threshold_warning_os_cpu` int(10) NOT NULL DEFAULT '80',
  `threshold_warning_os_network` int(10) NOT NULL DEFAULT '2',
  `threshold_warning_os_disk` int(10) NOT NULL DEFAULT '75',
  `threshold_warning_os_memory` int(10) NOT NULL DEFAULT '85',
  `threshold_critical_os_process` int(10) NOT NULL DEFAULT '500',
  `threshold_critical_os_load` int(10) NOT NULL DEFAULT '10',
  `threshold_critical_os_cpu` int(10) NOT NULL DEFAULT '40',
  `threshold_critical_os_network` int(10) NOT NULL DEFAULT '10',
  `threshold_critical_os_disk` int(10) NOT NULL DEFAULT '90',
  `threshold_critical_os_memory` tinyint(10) NOT NULL DEFAULT '95',
  `filter_os_disk` varchar(100) DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `display_order` smallint(4) NOT NULL DEFAULT '0',
  `remark` varchar(1000) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_host` (`host`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for db_servers_redis
-- ----------------------------
DROP TABLE IF EXISTS `db_servers_redis`;
CREATE TABLE `db_servers_redis` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `host` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `port` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tags` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `monitor` tinyint(2) DEFAULT '1',
  `send_mail` tinyint(2) DEFAULT '1',
  `send_mail_to_list` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `send_sms` tinyint(2) DEFAULT '0',
  `send_sms_to_list` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alarm_connected_clients` tinyint(2) NOT NULL DEFAULT '1',
  `alarm_command_processed` tinyint(2) NOT NULL DEFAULT '1',
  `alarm_blocked_clients` tinyint(2) NOT NULL DEFAULT '1',
  `threshold_warning_connected_clients` smallint(4) NOT NULL DEFAULT '1000',
  `threshold_warning_command_processed` smallint(4) NOT NULL DEFAULT '10',
  `threshold_warning_blocked_clients` smallint(4) NOT NULL DEFAULT '5',
  `threshold_critical_connected_clients` smallint(4) NOT NULL DEFAULT '3000',
  `threshold_critical_command_processed` smallint(4) NOT NULL DEFAULT '30',
  `threshold_critical_blocked_clients` smallint(4) NOT NULL DEFAULT '15',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `display_order` smallint(4) NOT NULL DEFAULT '0',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_host` (`host`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for db_status
-- ----------------------------
DROP TABLE IF EXISTS `db_status`;
CREATE TABLE `db_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) NOT NULL DEFAULT '0',
  `host` varchar(30) NOT NULL DEFAULT '',
  `port` varchar(10) NOT NULL DEFAULT '',
  `db_type` varchar(10) NOT NULL DEFAULT '',
  `db_type_sort` tinyint(2) NOT NULL DEFAULT '0',
  `tags` varchar(50) NOT NULL DEFAULT '-1',
  `role` varchar(30) NOT NULL DEFAULT '-1',
  `version` varchar(30) NOT NULL DEFAULT '-1',
  `connect` tinyint(2) NOT NULL DEFAULT '-1',
  `connect_tips` varchar(500) NOT NULL DEFAULT 'no_data',
  `sessions` tinyint(2) NOT NULL DEFAULT '-1',
  `sessions_tips` varchar(500) NOT NULL DEFAULT 'no_data',
  `actives` tinyint(2) NOT NULL DEFAULT '-1',
  `actives_tips` varchar(500) NOT NULL DEFAULT 'no_data',
  `waits` tinyint(2) NOT NULL DEFAULT '-1',
  `waits_tips` varchar(500) NOT NULL DEFAULT 'no_data',
  `repl` tinyint(2) NOT NULL DEFAULT '-1',
  `repl_tips` varchar(500) NOT NULL DEFAULT 'no_data',
  `repl_delay` tinyint(2) NOT NULL DEFAULT '-1',
  `repl_delay_tips` varchar(500) NOT NULL DEFAULT 'no_data',
  `tablespace` tinyint(2) NOT NULL DEFAULT '-1',
  `tablespace_tips` varchar(500) NOT NULL DEFAULT '-1',
  `snmp` tinyint(2) NOT NULL DEFAULT '-1',
  `snmp_tips` varchar(500) NOT NULL DEFAULT 'no_data',
  `process` tinyint(2) NOT NULL DEFAULT '-1',
  `process_tips` varchar(500) NOT NULL DEFAULT 'no_data',
  `load_1` tinyint(2) NOT NULL DEFAULT '-1',
  `load_1_tips` varchar(500) NOT NULL DEFAULT 'no_data',
  `cpu` tinyint(2) NOT NULL DEFAULT '-1',
  `cpu_tips` varchar(500) NOT NULL DEFAULT 'no_data',
  `network` tinyint(2) NOT NULL DEFAULT '-1',
  `network_tips` varchar(500) NOT NULL DEFAULT 'no_data',
  `memory` tinyint(2) NOT NULL DEFAULT '-1',
  `memory_tips` varchar(500) NOT NULL DEFAULT 'no_data',
  `disk` tinyint(2) NOT NULL DEFAULT '-1',
  `disk_tips` varchar(500) NOT NULL DEFAULT 'no_data',
  `uptime_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=295 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for lepus_status
-- ----------------------------
DROP TABLE IF EXISTS `lepus_status`;
CREATE TABLE `lepus_status` (
  `lepus_variables` varchar(255) NOT NULL,
  `lepus_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for mongodb_status
-- ----------------------------
DROP TABLE IF EXISTS `mongodb_status`;
CREATE TABLE `mongodb_status` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) NOT NULL DEFAULT '0',
  `host` varchar(50) NOT NULL,
  `port` varchar(30) NOT NULL,
  `tags` varchar(50) DEFAULT NULL,
  `connect` smallint(6) NOT NULL DEFAULT '0',
  `replset` smallint(2) NOT NULL DEFAULT '-1',
  `repl_role` varchar(30) NOT NULL DEFAULT '-1',
  `ok` tinyint(2) NOT NULL DEFAULT '-1',
  `uptime` int(11) NOT NULL DEFAULT '-1',
  `version` varchar(50) NOT NULL DEFAULT '-1',
  `connections_current` int(10) NOT NULL DEFAULT '-1',
  `connections_available` int(10) NOT NULL DEFAULT '-1',
  `globalLock_currentQueue` smallint(4) NOT NULL DEFAULT '-1',
  `globalLock_activeClients` smallint(4) NOT NULL DEFAULT '-1',
  `indexCounters_accesses` bigint(18) NOT NULL DEFAULT '-1',
  `indexCounters_hits` bigint(18) NOT NULL DEFAULT '-1',
  `indexCounters_misses` bigint(18) NOT NULL DEFAULT '-1',
  `indexCounters_resets` int(10) NOT NULL DEFAULT '-1',
  `indexCounters_missRatio` char(10) NOT NULL DEFAULT '-1',
  `cursors_totalOpen` smallint(4) NOT NULL DEFAULT '-1',
  `cursors_timeOut` int(10) NOT NULL DEFAULT '-1',
  `dur_commits` smallint(4) NOT NULL DEFAULT '-1',
  `dur_journaledMB` varchar(30) NOT NULL DEFAULT '-1',
  `dur_writeToDataFilesMB` varchar(30) NOT NULL DEFAULT '-1',
  `dur_compression` varchar(30) NOT NULL DEFAULT '-1',
  `dur_commitsInWriteLock` smallint(4) NOT NULL DEFAULT '-1',
  `dur_earlyCommits` smallint(4) NOT NULL DEFAULT '-1',
  `dur_timeMs_dt` smallint(4) NOT NULL DEFAULT '-1',
  `dur_timeMs_prepLogBuffer` smallint(4) NOT NULL DEFAULT '-1',
  `dur_timeMs_writeToJournal` smallint(4) NOT NULL DEFAULT '-1',
  `dur_timeMs_writeToDataFiles` smallint(4) NOT NULL DEFAULT '-1',
  `dur_timeMs_remapPrivateView` smallint(4) NOT NULL DEFAULT '-1',
  `mem_bits` smallint(4) NOT NULL DEFAULT '-1',
  `mem_resident` int(10) NOT NULL DEFAULT '-1',
  `mem_virtual` int(10) NOT NULL DEFAULT '-1',
  `mem_supported` varchar(10) NOT NULL DEFAULT '-1',
  `mem_mapped` int(10) NOT NULL DEFAULT '-1',
  `mem_mappedWithJournal` int(10) NOT NULL DEFAULT '-1',
  `network_bytesIn_persecond` int(10) NOT NULL DEFAULT '-1',
  `network_bytesOut_persecond` int(10) NOT NULL DEFAULT '-1',
  `network_numRequests_persecond` int(10) NOT NULL DEFAULT '-1',
  `opcounters_insert_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `opcounters_query_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `opcounters_update_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `opcounters_delete_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `opcounters_command_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_server_id` (`server_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=267286 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for mongodb_status_history
-- ----------------------------
DROP TABLE IF EXISTS `mongodb_status_history`;
CREATE TABLE `mongodb_status_history` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) NOT NULL DEFAULT '0',
  `host` varchar(50) NOT NULL,
  `port` varchar(30) NOT NULL,
  `tags` varchar(50) DEFAULT NULL,
  `connect` smallint(6) NOT NULL DEFAULT '0',
  `replset` tinyint(2) NOT NULL DEFAULT '-1',
  `repl_role` varchar(30) NOT NULL DEFAULT '-1',
  `ok` tinyint(2) NOT NULL DEFAULT '-1',
  `uptime` int(11) NOT NULL DEFAULT '-1',
  `version` varchar(50) NOT NULL DEFAULT '-1',
  `connections_current` int(10) NOT NULL DEFAULT '-1',
  `connections_available` int(10) NOT NULL DEFAULT '-1',
  `globalLock_currentQueue` smallint(4) NOT NULL DEFAULT '-1',
  `globalLock_activeClients` smallint(4) NOT NULL DEFAULT '-1',
  `indexCounters_accesses` bigint(18) NOT NULL DEFAULT '-1',
  `indexCounters_hits` bigint(18) NOT NULL DEFAULT '-1',
  `indexCounters_misses` bigint(18) NOT NULL DEFAULT '-1',
  `indexCounters_resets` int(10) NOT NULL DEFAULT '-1',
  `indexCounters_missRatio` char(10) NOT NULL DEFAULT '-1',
  `cursors_totalOpen` smallint(4) NOT NULL DEFAULT '-1',
  `cursors_timeOut` int(10) NOT NULL DEFAULT '-1',
  `dur_commits` smallint(4) NOT NULL DEFAULT '-1',
  `dur_journaledMB` varchar(30) NOT NULL DEFAULT '-1',
  `dur_writeToDataFilesMB` varchar(30) NOT NULL DEFAULT '-1',
  `dur_compression` varchar(30) NOT NULL DEFAULT '-1',
  `dur_commitsInWriteLock` smallint(4) NOT NULL DEFAULT '-1',
  `dur_earlyCommits` smallint(4) NOT NULL DEFAULT '-1',
  `dur_timeMs_dt` smallint(4) NOT NULL DEFAULT '-1',
  `dur_timeMs_prepLogBuffer` smallint(4) NOT NULL DEFAULT '-1',
  `dur_timeMs_writeToJournal` smallint(4) NOT NULL DEFAULT '-1',
  `dur_timeMs_writeToDataFiles` smallint(4) NOT NULL DEFAULT '-1',
  `dur_timeMs_remapPrivateView` smallint(4) NOT NULL DEFAULT '-1',
  `mem_bits` smallint(4) NOT NULL DEFAULT '-1',
  `mem_resident` int(10) NOT NULL DEFAULT '-1',
  `mem_virtual` int(10) NOT NULL DEFAULT '-1',
  `mem_supported` varchar(10) NOT NULL DEFAULT '-1',
  `mem_mapped` int(10) NOT NULL DEFAULT '-1',
  `mem_mappedWithJournal` int(10) NOT NULL DEFAULT '-1',
  `network_bytesIn_persecond` int(10) NOT NULL DEFAULT '-1',
  `network_bytesOut_persecond` int(10) NOT NULL DEFAULT '-1',
  `network_numRequests_persecond` int(10) NOT NULL DEFAULT '-1',
  `opcounters_insert_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `opcounters_query_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `opcounters_update_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `opcounters_delete_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `opcounters_command_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `YmdHi` bigint(18) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_serverid_ymdhi` (`server_id`,`YmdHi`) USING BTREE,
  KEY `idx_ymdhi` (`YmdHi`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=267285 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for mysql_bigtable
-- ----------------------------
DROP TABLE IF EXISTS `mysql_bigtable`;
CREATE TABLE `mysql_bigtable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) DEFAULT NULL,
  `host` varchar(30) NOT NULL,
  `port` varchar(10) NOT NULL,
  `tags` varchar(50) NOT NULL DEFAULT '',
  `db_name` varchar(50) DEFAULT NULL,
  `table_name` varchar(100) DEFAULT NULL,
  `table_size` decimal(10,2) DEFAULT NULL,
  `table_comment` varchar(200) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_server_id` (`server_id`) USING BTREE,
  KEY `idx_table_size` (`table_size`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1855 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for mysql_bigtable_history
-- ----------------------------
DROP TABLE IF EXISTS `mysql_bigtable_history`;
CREATE TABLE `mysql_bigtable_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) DEFAULT NULL,
  `host` varchar(30) NOT NULL,
  `port` varchar(10) NOT NULL,
  `tags` varchar(50) NOT NULL DEFAULT '',
  `db_name` varchar(50) DEFAULT NULL,
  `table_name` varchar(100) DEFAULT NULL,
  `table_size` decimal(10,2) DEFAULT NULL,
  `table_comment` varchar(200) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Ymd` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_create_time` (`create_time`) USING BTREE,
  KEY `idx_server_id_tablename_ymd` (`server_id`,`table_name`,`Ymd`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1829 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for mysql_connected
-- ----------------------------
DROP TABLE IF EXISTS `mysql_connected`;
CREATE TABLE `mysql_connected` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) NOT NULL,
  `host` varchar(30) NOT NULL,
  `port` varchar(10) NOT NULL,
  `tags` varchar(50) NOT NULL DEFAULT '',
  `connect_server` varchar(100) NOT NULL,
  `connect_user` varchar(50) DEFAULT NULL,
  `connect_db` varchar(50) DEFAULT NULL,
  `connect_count` int(10) NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43215471 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for mysql_processlist
-- ----------------------------
DROP TABLE IF EXISTS `mysql_processlist`;
CREATE TABLE `mysql_processlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) DEFAULT NULL,
  `host` varchar(30) NOT NULL,
  `port` varchar(10) NOT NULL,
  `tags` varchar(50) NOT NULL DEFAULT '',
  `pid` int(10) DEFAULT NULL,
  `p_user` varchar(50) DEFAULT NULL,
  `p_host` varchar(50) DEFAULT NULL,
  `p_db` varchar(30) DEFAULT NULL,
  `command` varchar(30) DEFAULT NULL,
  `time` varchar(200) NOT NULL DEFAULT '0',
  `status` varchar(50) DEFAULT NULL,
  `info` text,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_create_time` (`create_time`) USING BTREE,
  KEY `idx_server_id` (`server_id`) USING BTREE,
  KEY `idx_application_id` (`tags`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=892428 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for mysql_replication
-- ----------------------------
DROP TABLE IF EXISTS `mysql_replication`;
CREATE TABLE `mysql_replication` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) DEFAULT NULL,
  `tags` varchar(50) NOT NULL DEFAULT '',
  `host` varchar(30) DEFAULT NULL,
  `port` varchar(20) DEFAULT NULL,
  `is_master` tinyint(2) DEFAULT '0',
  `is_slave` tinyint(2) unsigned DEFAULT '0',
  `read_only` varchar(10) DEFAULT NULL,
  `gtid_mode` varchar(10) DEFAULT NULL,
  `master_server` varchar(30) DEFAULT NULL,
  `master_port` varchar(20) DEFAULT NULL,
  `slave_io_run` varchar(20) DEFAULT NULL,
  `slave_sql_run` varchar(20) DEFAULT NULL,
  `delay` varchar(20) DEFAULT NULL,
  `current_binlog_file` varchar(30) DEFAULT NULL,
  `current_binlog_pos` varchar(30) DEFAULT NULL,
  `master_binlog_file` varchar(30) DEFAULT NULL,
  `master_binlog_pos` varchar(30) DEFAULT NULL,
  `master_binlog_space` bigint(18) NOT NULL DEFAULT '0',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1390197 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for mysql_replication_history
-- ----------------------------
DROP TABLE IF EXISTS `mysql_replication_history`;
CREATE TABLE `mysql_replication_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) NOT NULL,
  `tags` varchar(50) NOT NULL DEFAULT '',
  `host` varchar(30) DEFAULT NULL,
  `port` varchar(20) DEFAULT NULL,
  `is_master` tinyint(2) DEFAULT '0',
  `is_slave` tinyint(2) DEFAULT '0',
  `read_only` varchar(10) DEFAULT NULL,
  `gtid_mode` varchar(10) DEFAULT NULL,
  `master_server` varchar(30) DEFAULT NULL,
  `master_port` varchar(20) DEFAULT NULL,
  `slave_io_run` varchar(20) DEFAULT NULL,
  `slave_sql_run` varchar(20) DEFAULT NULL,
  `delay` varchar(20) DEFAULT NULL,
  `current_binlog_file` varchar(30) DEFAULT NULL,
  `current_binlog_pos` varchar(30) DEFAULT NULL,
  `master_binlog_file` varchar(30) DEFAULT NULL,
  `master_binlog_pos` varchar(30) DEFAULT NULL,
  `master_binlog_space` bigint(18) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `YmdHi` bigint(18) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_application_id` (`tags`),
  KEY `idx_create_time` (`create_time`),
  KEY `idx_union_1` (`server_id`,`YmdHi`) USING BTREE,
  KEY `idx_ymdhi` (`YmdHi`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1390192 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for mysql_slow_query_review
-- ----------------------------
DROP TABLE IF EXISTS `mysql_slow_query_review`;
CREATE TABLE `mysql_slow_query_review` (
  `checksum` bigint(20) unsigned NOT NULL,
  `fingerprint` text NOT NULL,
  `sample` text NOT NULL,
  `first_seen` datetime DEFAULT NULL,
  `last_seen` datetime DEFAULT NULL,
  `reviewed_by` varchar(20) DEFAULT NULL,
  `reviewed_on` datetime DEFAULT NULL,
  `comments` text,
  PRIMARY KEY (`checksum`),
  KEY `idx_checksum` (`checksum`) USING BTREE,
  KEY `idx_last_seen` (`last_seen`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for mysql_slow_query_review_history
-- ----------------------------
DROP TABLE IF EXISTS `mysql_slow_query_review_history`;
CREATE TABLE `mysql_slow_query_review_history` (
  `serverid_max` smallint(4) NOT NULL DEFAULT '0',
  `db_max` varchar(100) DEFAULT NULL,
  `user_max` varchar(100) DEFAULT NULL,
  `checksum` bigint(20) unsigned NOT NULL,
  `sample` text NOT NULL,
  `ts_min` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ts_max` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ts_cnt` float DEFAULT NULL,
  `Query_time_sum` float DEFAULT NULL,
  `Query_time_min` float DEFAULT NULL,
  `Query_time_max` float DEFAULT NULL,
  `Query_time_pct_95` float DEFAULT NULL,
  `Query_time_stddev` float DEFAULT NULL,
  `Query_time_median` float DEFAULT NULL,
  `Lock_time_sum` float DEFAULT NULL,
  `Lock_time_min` float DEFAULT NULL,
  `Lock_time_max` float DEFAULT NULL,
  `Lock_time_pct_95` float DEFAULT NULL,
  `Lock_time_stddev` float DEFAULT NULL,
  `Lock_time_median` float DEFAULT NULL,
  `Rows_sent_sum` float DEFAULT NULL,
  `Rows_sent_min` float DEFAULT NULL,
  `Rows_sent_max` float DEFAULT NULL,
  `Rows_sent_pct_95` float DEFAULT NULL,
  `Rows_sent_stddev` float DEFAULT NULL,
  `Rows_sent_median` float DEFAULT NULL,
  `Rows_examined_sum` float DEFAULT NULL,
  `Rows_examined_min` float DEFAULT NULL,
  `Rows_examined_max` float DEFAULT NULL,
  `Rows_examined_pct_95` float DEFAULT NULL,
  `Rows_examined_stddev` float DEFAULT NULL,
  `Rows_examined_median` float DEFAULT NULL,
  `Rows_affected_sum` float DEFAULT NULL,
  `Rows_affected_min` float DEFAULT NULL,
  `Rows_affected_max` float DEFAULT NULL,
  `Rows_affected_pct_95` float DEFAULT NULL,
  `Rows_affected_stddev` float DEFAULT NULL,
  `Rows_affected_median` float DEFAULT NULL,
  `Rows_read_sum` float DEFAULT NULL,
  `Rows_read_min` float DEFAULT NULL,
  `Rows_read_max` float DEFAULT NULL,
  `Rows_read_pct_95` float DEFAULT NULL,
  `Rows_read_stddev` float DEFAULT NULL,
  `Rows_read_median` float DEFAULT NULL,
  `Merge_passes_sum` float DEFAULT NULL,
  `Merge_passes_min` float DEFAULT NULL,
  `Merge_passes_max` float DEFAULT NULL,
  `Merge_passes_pct_95` float DEFAULT NULL,
  `Merge_passes_stddev` float DEFAULT NULL,
  `Merge_passes_median` float DEFAULT NULL,
  `InnoDB_IO_r_ops_min` float DEFAULT NULL,
  `InnoDB_IO_r_ops_max` float DEFAULT NULL,
  `InnoDB_IO_r_ops_pct_95` float DEFAULT NULL,
  `InnoDB_IO_r_ops_stddev` float DEFAULT NULL,
  `InnoDB_IO_r_ops_median` float DEFAULT NULL,
  `InnoDB_IO_r_bytes_min` float DEFAULT NULL,
  `InnoDB_IO_r_bytes_max` float DEFAULT NULL,
  `InnoDB_IO_r_bytes_pct_95` float DEFAULT NULL,
  `InnoDB_IO_r_bytes_stddev` float DEFAULT NULL,
  `InnoDB_IO_r_bytes_median` float DEFAULT NULL,
  `InnoDB_IO_r_wait_min` float DEFAULT NULL,
  `InnoDB_IO_r_wait_max` float DEFAULT NULL,
  `InnoDB_IO_r_wait_pct_95` float DEFAULT NULL,
  `InnoDB_IO_r_wait_stddev` float DEFAULT NULL,
  `InnoDB_IO_r_wait_median` float DEFAULT NULL,
  `InnoDB_rec_lock_wait_min` float DEFAULT NULL,
  `InnoDB_rec_lock_wait_max` float DEFAULT NULL,
  `InnoDB_rec_lock_wait_pct_95` float DEFAULT NULL,
  `InnoDB_rec_lock_wait_stddev` float DEFAULT NULL,
  `InnoDB_rec_lock_wait_median` float DEFAULT NULL,
  `InnoDB_queue_wait_min` float DEFAULT NULL,
  `InnoDB_queue_wait_max` float DEFAULT NULL,
  `InnoDB_queue_wait_pct_95` float DEFAULT NULL,
  `InnoDB_queue_wait_stddev` float DEFAULT NULL,
  `InnoDB_queue_wait_median` float DEFAULT NULL,
  `InnoDB_pages_distinct_min` float DEFAULT NULL,
  `InnoDB_pages_distinct_max` float DEFAULT NULL,
  `InnoDB_pages_distinct_pct_95` float DEFAULT NULL,
  `InnoDB_pages_distinct_stddev` float DEFAULT NULL,
  `InnoDB_pages_distinct_median` float DEFAULT NULL,
  `QC_Hit_cnt` float DEFAULT NULL,
  `QC_Hit_sum` float DEFAULT NULL,
  `Full_scan_cnt` float DEFAULT NULL,
  `Full_scan_sum` float DEFAULT NULL,
  `Full_join_cnt` float DEFAULT NULL,
  `Full_join_sum` float DEFAULT NULL,
  `Tmp_table_cnt` float DEFAULT NULL,
  `Tmp_table_sum` float DEFAULT NULL,
  `Tmp_table_on_disk_cnt` float DEFAULT NULL,
  `Tmp_table_on_disk_sum` float DEFAULT NULL,
  `Filesort_cnt` float DEFAULT NULL,
  `Filesort_sum` float DEFAULT NULL,
  `Filesort_on_disk_cnt` float DEFAULT NULL,
  `Filesort_on_disk_sum` float DEFAULT NULL,
  PRIMARY KEY (`checksum`,`ts_min`,`ts_max`),
  KEY `idx_serverid_max` (`serverid_max`) USING BTREE,
  KEY `idx_checksum` (`checksum`) USING BTREE,
  KEY `idx_query_time_max` (`Query_time_max`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for mysql_slow_query_sendmail_log
-- ----------------------------
DROP TABLE IF EXISTS `mysql_slow_query_sendmail_log`;
CREATE TABLE `mysql_slow_query_sendmail_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) NOT NULL,
  `sendmail_status` tinyint(2) NOT NULL DEFAULT '0',
  `sendmail_info` varchar(50) DEFAULT NULL,
  `sendmail_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_sendmail_time` (`sendmail_time`) USING BTREE,
  KEY `idx_server_id` (`server_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for mysql_status
-- ----------------------------
DROP TABLE IF EXISTS `mysql_status`;
CREATE TABLE `mysql_status` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) NOT NULL DEFAULT '0',
  `host` varchar(30) NOT NULL,
  `port` varchar(10) NOT NULL,
  `tags` varchar(50) NOT NULL DEFAULT '',
  `connect` smallint(4) NOT NULL DEFAULT '0',
  `role` varchar(30) NOT NULL DEFAULT '-1',
  `uptime` int(11) NOT NULL DEFAULT '-1',
  `version` varchar(50) NOT NULL DEFAULT '-1',
  `max_connections` smallint(4) NOT NULL DEFAULT '-1',
  `max_connect_errors` smallint(4) NOT NULL DEFAULT '-1',
  `open_files_limit` int(10) NOT NULL DEFAULT '-1',
  `open_files` smallint(4) NOT NULL DEFAULT '-1',
  `table_open_cache` smallint(4) NOT NULL DEFAULT '-1',
  `open_tables` smallint(4) NOT NULL DEFAULT '-1',
  `max_tmp_tables` smallint(4) NOT NULL DEFAULT '-1',
  `max_heap_table_size` int(10) NOT NULL DEFAULT '-1',
  `max_allowed_packet` int(10) NOT NULL DEFAULT '-1',
  `threads_connected` int(10) NOT NULL DEFAULT '-1',
  `threads_running` int(10) NOT NULL DEFAULT '-1',
  `threads_waits` int(10) NOT NULL DEFAULT '-1',
  `threads_created` int(10) NOT NULL DEFAULT '-1',
  `threads_cached` int(10) NOT NULL DEFAULT '-1',
  `connections` int(10) NOT NULL DEFAULT '-1',
  `aborted_clients` int(10) NOT NULL DEFAULT '-1',
  `aborted_connects` int(10) NOT NULL DEFAULT '-1',
  `connections_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `bytes_received_persecond` int(10) NOT NULL DEFAULT '-1',
  `bytes_sent_persecond` int(10) NOT NULL DEFAULT '-1',
  `com_select_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `com_insert_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `com_update_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `com_delete_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `com_commit_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `com_rollback_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `questions_persecond` int(10) NOT NULL DEFAULT '-1',
  `queries_persecond` int(10) NOT NULL DEFAULT '-1',
  `transaction_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `created_tmp_tables_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `created_tmp_disk_tables_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `created_tmp_files_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `table_locks_immediate_persecond` int(4) NOT NULL DEFAULT '-1',
  `table_locks_waited_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `key_buffer_size` bigint(18) NOT NULL DEFAULT '-1',
  `sort_buffer_size` int(10) NOT NULL DEFAULT '-1',
  `join_buffer_size` int(10) NOT NULL DEFAULT '-1',
  `key_blocks_not_flushed` int(10) NOT NULL DEFAULT '-1',
  `key_blocks_unused` int(10) NOT NULL DEFAULT '-1',
  `key_blocks_used` int(10) NOT NULL DEFAULT '-1',
  `key_read_requests_persecond` int(10) NOT NULL DEFAULT '-1',
  `key_reads_persecond` int(10) NOT NULL DEFAULT '-1',
  `key_write_requests_persecond` int(10) NOT NULL DEFAULT '-1',
  `key_writes_persecond` int(10) NOT NULL DEFAULT '-1',
  `innodb_version` varchar(30) NOT NULL DEFAULT '-1',
  `innodb_buffer_pool_instances` smallint(4) NOT NULL DEFAULT '-1',
  `innodb_buffer_pool_size` bigint(18) NOT NULL DEFAULT '-1',
  `innodb_doublewrite` char(10) NOT NULL DEFAULT '-1',
  `innodb_file_per_table` char(10) NOT NULL DEFAULT '-1',
  `innodb_flush_log_at_trx_commit` tinyint(2) NOT NULL DEFAULT '-1',
  `innodb_flush_method` varchar(30) NOT NULL DEFAULT '-1',
  `innodb_force_recovery` tinyint(2) NOT NULL DEFAULT '-1',
  `innodb_io_capacity` int(10) NOT NULL DEFAULT '-1',
  `innodb_read_io_threads` tinyint(2) NOT NULL DEFAULT '-1',
  `innodb_write_io_threads` tinyint(2) NOT NULL DEFAULT '-1',
  `innodb_buffer_pool_pages_total` int(10) NOT NULL DEFAULT '-1' COMMENT '页总数目',
  `innodb_buffer_pool_pages_data` int(10) NOT NULL DEFAULT '-1' COMMENT '缓存池中包含数据的页的数目，包括脏页,单位page',
  `innodb_buffer_pool_pages_dirty` int(10) NOT NULL DEFAULT '-1' COMMENT '缓存池中脏页的数目-单位page',
  `innodb_buffer_pool_pages_flushed` bigint(18) NOT NULL DEFAULT '-1' COMMENT '缓存池中刷新页请求的数目-单位page',
  `innodb_buffer_pool_pages_free` int(10) NOT NULL DEFAULT '-1' COMMENT '剩余的页数目-单位是page',
  `innodb_buffer_pool_pages_misc` int(10) NOT NULL DEFAULT '-1' COMMENT '缓存池中当前已经被用作管理用途或hash index而不能用作为普通数据页的数目',
  `innodb_page_size` int(10) NOT NULL DEFAULT '-1',
  `innodb_pages_created` bigint(18) NOT NULL DEFAULT '-1',
  `innodb_pages_read` bigint(18) NOT NULL DEFAULT '-1',
  `innodb_pages_written` bigint(18) NOT NULL DEFAULT '-1',
  `innodb_row_lock_current_waits` varchar(100) NOT NULL DEFAULT '-1',
  `innodb_buffer_pool_pages_flushed_persecond` int(10) NOT NULL DEFAULT '-1',
  `innodb_buffer_pool_read_requests_persecond` int(10) NOT NULL DEFAULT '-1',
  `innodb_buffer_pool_reads_persecond` int(10) NOT NULL DEFAULT '-1',
  `innodb_buffer_pool_write_requests_persecond` int(10) NOT NULL DEFAULT '-1',
  `innodb_rows_read_persecond` int(10) NOT NULL DEFAULT '-1',
  `innodb_rows_inserted_persecond` int(10) NOT NULL DEFAULT '-1',
  `innodb_rows_updated_persecond` int(10) NOT NULL DEFAULT '-1',
  `innodb_rows_deleted_persecond` int(10) NOT NULL DEFAULT '-1',
  `query_cache_hitrate` varchar(10) NOT NULL DEFAULT '-1',
  `thread_cache_hitrate` varchar(10) NOT NULL DEFAULT '-1',
  `key_buffer_read_rate` varchar(10) NOT NULL DEFAULT '-1',
  `key_buffer_write_rate` varchar(10) NOT NULL DEFAULT '-1',
  `key_blocks_used_rate` varchar(10) NOT NULL DEFAULT '-1',
  `created_tmp_disk_tables_rate` varchar(10) NOT NULL DEFAULT '-1',
  `connections_usage_rate` varchar(10) NOT NULL DEFAULT '-1',
  `open_files_usage_rate` varchar(10) NOT NULL DEFAULT '-1',
  `open_tables_usage_rate` varchar(10) NOT NULL DEFAULT '-1',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_connections` (`threads_connected`) USING BTREE,
  KEY `idx_active` (`threads_running`) USING BTREE,
  KEY `idx_server_id` (`server_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1659296 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for mysql_status_history
-- ----------------------------
DROP TABLE IF EXISTS `mysql_status_history`;
CREATE TABLE `mysql_status_history` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) NOT NULL DEFAULT '0',
  `host` varchar(30) NOT NULL,
  `port` varchar(10) NOT NULL,
  `tags` varchar(50) NOT NULL DEFAULT '',
  `connect` smallint(4) NOT NULL DEFAULT '0',
  `role` varchar(30) NOT NULL DEFAULT '-1',
  `uptime` int(11) NOT NULL DEFAULT '-1',
  `version` varchar(50) NOT NULL DEFAULT '-1',
  `max_connections` smallint(4) NOT NULL DEFAULT '-1',
  `max_connect_errors` smallint(4) NOT NULL DEFAULT '-1',
  `open_files_limit` int(10) NOT NULL DEFAULT '-1',
  `open_files` smallint(4) NOT NULL DEFAULT '-1',
  `table_open_cache` smallint(4) NOT NULL DEFAULT '-1',
  `open_tables` smallint(4) NOT NULL DEFAULT '-1',
  `max_tmp_tables` smallint(4) NOT NULL DEFAULT '-1',
  `max_heap_table_size` int(10) NOT NULL DEFAULT '-1',
  `max_allowed_packet` int(10) NOT NULL DEFAULT '-1',
  `threads_connected` int(10) NOT NULL DEFAULT '-1',
  `threads_running` int(10) NOT NULL DEFAULT '-1',
  `threads_waits` int(10) NOT NULL DEFAULT '-1',
  `threads_created` int(10) NOT NULL DEFAULT '-1',
  `threads_cached` int(10) NOT NULL DEFAULT '-1',
  `connections` int(10) NOT NULL DEFAULT '-1',
  `aborted_clients` int(10) NOT NULL DEFAULT '-1',
  `aborted_connects` int(10) NOT NULL DEFAULT '-1',
  `connections_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `bytes_received_persecond` int(10) NOT NULL DEFAULT '-1',
  `bytes_sent_persecond` int(10) NOT NULL DEFAULT '-1',
  `com_select_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `com_insert_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `com_update_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `com_delete_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `com_commit_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `com_rollback_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `questions_persecond` int(10) NOT NULL DEFAULT '-1',
  `queries_persecond` int(10) NOT NULL DEFAULT '-1',
  `transaction_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `created_tmp_tables_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `created_tmp_disk_tables_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `created_tmp_files_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `table_locks_immediate_persecond` int(4) NOT NULL DEFAULT '-1',
  `table_locks_waited_persecond` smallint(4) NOT NULL DEFAULT '-1',
  `key_buffer_size` bigint(18) NOT NULL DEFAULT '-1',
  `sort_buffer_size` int(10) NOT NULL DEFAULT '-1',
  `join_buffer_size` int(10) NOT NULL DEFAULT '-1',
  `key_blocks_not_flushed` int(10) NOT NULL DEFAULT '-1',
  `key_blocks_unused` int(10) NOT NULL DEFAULT '-1',
  `key_blocks_used` int(10) NOT NULL DEFAULT '-1',
  `key_read_requests_persecond` int(10) NOT NULL DEFAULT '-1',
  `key_reads_persecond` int(10) NOT NULL DEFAULT '-1',
  `key_write_requests_persecond` int(10) NOT NULL DEFAULT '-1',
  `key_writes_persecond` int(10) NOT NULL DEFAULT '-1',
  `innodb_version` varchar(30) NOT NULL DEFAULT '-1',
  `innodb_buffer_pool_instances` smallint(4) NOT NULL DEFAULT '-1',
  `innodb_buffer_pool_size` bigint(18) NOT NULL DEFAULT '-1',
  `innodb_doublewrite` char(10) NOT NULL DEFAULT '-1',
  `innodb_file_per_table` char(10) NOT NULL DEFAULT '-1',
  `innodb_flush_log_at_trx_commit` tinyint(2) NOT NULL DEFAULT '-1',
  `innodb_flush_method` varchar(30) NOT NULL DEFAULT '-1',
  `innodb_force_recovery` tinyint(2) NOT NULL DEFAULT '-1',
  `innodb_io_capacity` int(10) NOT NULL DEFAULT '-1',
  `innodb_read_io_threads` tinyint(2) NOT NULL DEFAULT '-1',
  `innodb_write_io_threads` tinyint(2) NOT NULL DEFAULT '-1',
  `innodb_buffer_pool_pages_total` int(10) NOT NULL DEFAULT '-1' COMMENT '页总数目',
  `innodb_buffer_pool_pages_data` int(10) NOT NULL DEFAULT '-1' COMMENT '缓存池中包含数据的页的数目，包括脏页,单位page',
  `innodb_buffer_pool_pages_dirty` int(10) NOT NULL DEFAULT '-1' COMMENT '缓存池中脏页的数目-单位page',
  `innodb_buffer_pool_pages_flushed` bigint(18) NOT NULL DEFAULT '-1' COMMENT '缓存池中刷新页请求的数目-单位page',
  `innodb_buffer_pool_pages_free` int(10) NOT NULL DEFAULT '-1' COMMENT '剩余的页数目-单位是page',
  `innodb_buffer_pool_pages_misc` int(10) NOT NULL DEFAULT '-1' COMMENT '缓存池中当前已经被用作管理用途或hash index而不能用作为普通数据页的数目',
  `innodb_page_size` int(10) NOT NULL DEFAULT '-1',
  `innodb_pages_created` bigint(18) NOT NULL DEFAULT '-1',
  `innodb_pages_read` bigint(18) NOT NULL DEFAULT '-1',
  `innodb_pages_written` bigint(18) NOT NULL DEFAULT '-1',
  `innodb_row_lock_current_waits` varchar(100) NOT NULL DEFAULT '-1',
  `innodb_buffer_pool_pages_flushed_persecond` int(10) NOT NULL DEFAULT '-1',
  `innodb_buffer_pool_read_requests_persecond` int(10) NOT NULL DEFAULT '-1',
  `innodb_buffer_pool_reads_persecond` int(10) NOT NULL DEFAULT '-1',
  `innodb_buffer_pool_write_requests_persecond` int(10) NOT NULL DEFAULT '-1',
  `innodb_rows_read_persecond` int(10) NOT NULL DEFAULT '-1',
  `innodb_rows_inserted_persecond` int(10) NOT NULL DEFAULT '-1',
  `innodb_rows_updated_persecond` int(10) NOT NULL DEFAULT '-1',
  `innodb_rows_deleted_persecond` int(10) NOT NULL DEFAULT '-1',
  `query_cache_hitrate` varchar(10) NOT NULL DEFAULT '-1',
  `thread_cache_hitrate` varchar(10) NOT NULL DEFAULT '-1',
  `key_buffer_read_rate` varchar(10) NOT NULL DEFAULT '-1',
  `key_buffer_write_rate` varchar(10) NOT NULL DEFAULT '-1',
  `key_blocks_used_rate` varchar(10) NOT NULL DEFAULT '-1',
  `created_tmp_disk_tables_rate` varchar(10) NOT NULL DEFAULT '-1',
  `connections_usage_rate` varchar(10) NOT NULL DEFAULT '-1',
  `open_files_usage_rate` varchar(10) NOT NULL DEFAULT '-1',
  `open_tables_usage_rate` varchar(10) NOT NULL DEFAULT '-1',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `YmdHi` bigint(18) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_connections` (`threads_connected`) USING BTREE,
  KEY `idx_active` (`threads_running`) USING BTREE,
  KEY `idx_server_id_ymdhi` (`server_id`,`YmdHi`) USING BTREE,
  KEY `idx_application_id` (`tags`) USING BTREE,
  KEY `idx_create_time` (`create_time`) USING BTREE,
  KEY `idx_yhdmi` (`YmdHi`)
) ENGINE=InnoDB AUTO_INCREMENT=1659296 DEFAULT CHARSET=utf8;

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
-- Table structure for oracle_status
-- ----------------------------
DROP TABLE IF EXISTS `oracle_status`;
CREATE TABLE `oracle_status` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) NOT NULL DEFAULT '0',
  `host` varchar(50) NOT NULL,
  `port` varchar(10) NOT NULL,
  `tags` varchar(100) DEFAULT '',
  `connect` tinyint(2) NOT NULL DEFAULT '0',
  `instance_name` varchar(30) NOT NULL DEFAULT '-1',
  `instance_role` varchar(50) NOT NULL DEFAULT '-1',
  `instance_status` varchar(50) NOT NULL DEFAULT '-1',
  `database_role` varchar(50) NOT NULL DEFAULT '-1',
  `open_mode` varchar(30) NOT NULL DEFAULT '-1',
  `protection_mode` varchar(30) NOT NULL DEFAULT '-1',
  `host_name` varchar(50) NOT NULL DEFAULT '-1',
  `database_status` varchar(30) NOT NULL DEFAULT '-1',
  `startup_time` varchar(100) NOT NULL DEFAULT '-1',
  `uptime` varchar(100) NOT NULL DEFAULT '-1',
  `version` varchar(50) NOT NULL DEFAULT '-1',
  `archiver` varchar(50) NOT NULL DEFAULT '-1',
  `session_total` int(10) NOT NULL DEFAULT '-1',
  `session_actives` smallint(4) NOT NULL DEFAULT '-1',
  `session_waits` smallint(4) NOT NULL DEFAULT '-1',
  `dg_stats` varchar(255) NOT NULL DEFAULT '-1',
  `dg_delay` int(10) NOT NULL DEFAULT '-1',
  `processes` int(10) NOT NULL DEFAULT '-1',
  `session_logical_reads_persecond` int(10) NOT NULL DEFAULT '-1',
  `physical_reads_persecond` int(10) NOT NULL DEFAULT '-1',
  `physical_writes_persecond` int(10) NOT NULL DEFAULT '-1',
  `physical_read_io_requests_persecond` int(10) NOT NULL DEFAULT '-1',
  `physical_write_io_requests_persecond` int(10) NOT NULL DEFAULT '-1',
  `db_block_changes_persecond` int(10) NOT NULL DEFAULT '-1',
  `os_cpu_wait_time` int(10) NOT NULL DEFAULT '-1',
  `logons_persecond` int(10) NOT NULL DEFAULT '-1',
  `logons_current` int(10) NOT NULL DEFAULT '-1',
  `opened_cursors_persecond` int(10) NOT NULL DEFAULT '-1',
  `opened_cursors_current` int(10) NOT NULL DEFAULT '-1',
  `user_commits_persecond` int(10) NOT NULL DEFAULT '-1',
  `user_rollbacks_persecond` int(10) NOT NULL DEFAULT '-1',
  `user_calls_persecond` int(10) NOT NULL DEFAULT '-1',
  `db_block_gets_persecond` int(10) NOT NULL DEFAULT '-1',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_server_id` (`server_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=440226 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oracle_status_history
-- ----------------------------
DROP TABLE IF EXISTS `oracle_status_history`;
CREATE TABLE `oracle_status_history` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) NOT NULL DEFAULT '0',
  `host` varchar(50) NOT NULL,
  `port` varchar(10) NOT NULL,
  `tags` varchar(100) DEFAULT '',
  `connect` tinyint(2) NOT NULL DEFAULT '0',
  `instance_name` varchar(30) NOT NULL DEFAULT '-1',
  `instance_role` varchar(50) NOT NULL DEFAULT '-1',
  `instance_status` varchar(50) NOT NULL DEFAULT '-1',
  `database_role` varchar(50) NOT NULL DEFAULT '-1',
  `open_mode` varchar(30) NOT NULL DEFAULT '-1',
  `protection_mode` varchar(30) NOT NULL DEFAULT '-1',
  `host_name` varchar(50) NOT NULL DEFAULT '-1',
  `database_status` varchar(30) NOT NULL DEFAULT '-1',
  `startup_time` varchar(100) NOT NULL DEFAULT '-1',
  `uptime` varchar(100) NOT NULL DEFAULT '-1',
  `version` varchar(50) NOT NULL DEFAULT '-1',
  `archiver` varchar(50) NOT NULL DEFAULT '-1',
  `session_total` int(10) NOT NULL DEFAULT '-1',
  `session_actives` smallint(4) NOT NULL DEFAULT '-1',
  `session_waits` smallint(4) NOT NULL DEFAULT '-1',
  `dg_stats` varchar(255) NOT NULL DEFAULT '-1',
  `dg_delay` int(10) NOT NULL DEFAULT '-1',
  `processes` int(10) NOT NULL DEFAULT '-1',
  `session_logical_reads_persecond` int(10) NOT NULL DEFAULT '-1',
  `physical_reads_persecond` int(10) NOT NULL DEFAULT '-1',
  `physical_writes_persecond` int(10) NOT NULL DEFAULT '-1',
  `physical_read_io_requests_persecond` int(10) NOT NULL DEFAULT '-1',
  `physical_write_io_requests_persecond` int(10) NOT NULL DEFAULT '-1',
  `db_block_changes_persecond` int(10) NOT NULL DEFAULT '-1',
  `os_cpu_wait_time` int(10) NOT NULL DEFAULT '-1',
  `logons_persecond` int(10) NOT NULL DEFAULT '-1',
  `logons_current` int(10) NOT NULL DEFAULT '-1',
  `opened_cursors_persecond` int(10) NOT NULL DEFAULT '-1',
  `opened_cursors_current` int(10) NOT NULL DEFAULT '-1',
  `user_commits_persecond` int(10) NOT NULL DEFAULT '-1',
  `user_rollbacks_persecond` int(10) NOT NULL DEFAULT '-1',
  `user_calls_persecond` int(10) NOT NULL DEFAULT '-1',
  `db_block_gets_persecond` int(10) NOT NULL DEFAULT '-1',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ymdhi` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_server_id` (`server_id`) USING BTREE,
  KEY `idx_ymdhi` (`ymdhi`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=440225 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oracle_tablespace
-- ----------------------------
DROP TABLE IF EXISTS `oracle_tablespace`;
CREATE TABLE `oracle_tablespace` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) NOT NULL DEFAULT '0',
  `host` varchar(50) NOT NULL DEFAULT '0',
  `port` varchar(30) NOT NULL DEFAULT '0',
  `tags` varchar(50) NOT NULL DEFAULT '',
  `tablespace_name` varchar(100) NOT NULL,
  `total_size` bigint(18) NOT NULL DEFAULT '0',
  `used_size` bigint(18) NOT NULL DEFAULT '0',
  `avail_size` bigint(18) NOT NULL DEFAULT '0',
  `used_rate` varchar(255) NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_server_id` (`server_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2986229 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for oracle_tablespace_history
-- ----------------------------
DROP TABLE IF EXISTS `oracle_tablespace_history`;
CREATE TABLE `oracle_tablespace_history` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) NOT NULL DEFAULT '0',
  `host` varchar(50) NOT NULL DEFAULT '0',
  `port` varchar(30) NOT NULL DEFAULT '0',
  `tags` varchar(50) NOT NULL DEFAULT '',
  `tablespace_name` varchar(100) NOT NULL,
  `total_size` bigint(18) NOT NULL DEFAULT '0',
  `used_size` bigint(18) NOT NULL DEFAULT '0',
  `avail_size` bigint(18) NOT NULL DEFAULT '0',
  `used_rate` varchar(255) NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ymdhi` bigint(18) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_server_id` (`server_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2986224 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for os_disk
-- ----------------------------
DROP TABLE IF EXISTS `os_disk`;
CREATE TABLE `os_disk` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  `tags` varchar(100) DEFAULT NULL,
  `mounted` varchar(50) NOT NULL DEFAULT '0',
  `total_size` bigint(18) NOT NULL DEFAULT '0',
  `used_size` bigint(18) NOT NULL DEFAULT '0',
  `avail_size` bigint(18) NOT NULL DEFAULT '0',
  `used_rate` varchar(255) NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_ip` (`ip`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1382420 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for os_disk_history
-- ----------------------------
DROP TABLE IF EXISTS `os_disk_history`;
CREATE TABLE `os_disk_history` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  `tags` varchar(100) DEFAULT NULL,
  `mounted` varchar(50) NOT NULL DEFAULT '0',
  `total_size` bigint(18) NOT NULL DEFAULT '0',
  `used_size` bigint(18) NOT NULL DEFAULT '0',
  `avail_size` bigint(18) NOT NULL DEFAULT '0',
  `used_rate` varchar(255) NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `YmdHi` bigint(18) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_ip` (`ip`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1382414 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for os_diskio
-- ----------------------------
DROP TABLE IF EXISTS `os_diskio`;
CREATE TABLE `os_diskio` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  `tags` varchar(100) DEFAULT NULL,
  `fdisk` varchar(50) NOT NULL DEFAULT '0',
  `disk_io_reads` bigint(18) NOT NULL DEFAULT '0',
  `disk_io_writes` bigint(18) NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3502353 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for os_diskio_history
-- ----------------------------
DROP TABLE IF EXISTS `os_diskio_history`;
CREATE TABLE `os_diskio_history` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  `tags` varchar(100) DEFAULT NULL,
  `fdisk` varchar(50) NOT NULL DEFAULT '0',
  `disk_io_reads` bigint(18) NOT NULL DEFAULT '0',
  `disk_io_writes` bigint(18) NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `YmdHi` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_ymdhi` (`YmdHi`) USING BTREE,
  KEY `idx_ip_ymdhi` (`ip`,`YmdHi`),
  KEY `idx_io_reads` (`disk_io_reads`),
  KEY `idx_io_writes` (`disk_io_writes`)
) ENGINE=InnoDB AUTO_INCREMENT=3502336 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for os_net
-- ----------------------------
DROP TABLE IF EXISTS `os_net`;
CREATE TABLE `os_net` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  `tags` varchar(100) DEFAULT NULL,
  `if_descr` varchar(50) NOT NULL DEFAULT '0',
  `in_bytes` bigint(18) NOT NULL DEFAULT '0',
  `out_bytes` bigint(18) NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_ip` (`ip`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2318790 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for os_net_history
-- ----------------------------
DROP TABLE IF EXISTS `os_net_history`;
CREATE TABLE `os_net_history` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  `tags` varchar(100) DEFAULT NULL,
  `if_descr` varchar(50) NOT NULL DEFAULT '0',
  `in_bytes` bigint(18) NOT NULL DEFAULT '0',
  `out_bytes` bigint(18) NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `YmdHi` bigint(18) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_ip` (`ip`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2318779 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for os_status
-- ----------------------------
DROP TABLE IF EXISTS `os_status`;
CREATE TABLE `os_status` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  `snmp` tinyint(2) NOT NULL DEFAULT '0',
  `tags` varchar(100) DEFAULT NULL,
  `hostname` varchar(100) NOT NULL DEFAULT '-1',
  `kernel` varchar(50) NOT NULL DEFAULT '-1',
  `system_date` varchar(50) NOT NULL DEFAULT '-1',
  `system_uptime` varchar(50) NOT NULL DEFAULT '-1',
  `process` smallint(4) NOT NULL DEFAULT '-1',
  `load_1` decimal(4,2) NOT NULL DEFAULT '-1.00',
  `load_5` decimal(4,2) NOT NULL DEFAULT '-1.00',
  `load_15` decimal(4,2) NOT NULL DEFAULT '-1.00',
  `cpu_user_time` tinyint(4) NOT NULL DEFAULT '-1',
  `cpu_system_time` tinyint(4) NOT NULL DEFAULT '-1',
  `cpu_idle_time` tinyint(4) NOT NULL DEFAULT '-1',
  `swap_total` int(11) NOT NULL DEFAULT '-1',
  `swap_avail` int(11) NOT NULL DEFAULT '-1',
  `mem_total` int(11) NOT NULL DEFAULT '-1',
  `mem_used` int(11) NOT NULL DEFAULT '-1',
  `mem_free` int(11) NOT NULL DEFAULT '-1',
  `mem_shared` int(11) NOT NULL DEFAULT '-1',
  `mem_buffered` int(11) NOT NULL DEFAULT '-1',
  `mem_cached` int(11) NOT NULL DEFAULT '-1',
  `mem_usage_rate` varchar(50) NOT NULL DEFAULT '-1',
  `mem_available` varchar(50) NOT NULL DEFAULT '-1',
  `disk_io_reads_total` int(10) NOT NULL DEFAULT '-1',
  `disk_io_writes_total` int(10) NOT NULL DEFAULT '-1',
  `net_in_bytes_total` bigint(18) NOT NULL DEFAULT '-1',
  `net_out_bytes_total` bigint(18) NOT NULL DEFAULT '-1',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_ip_create_time` (`ip`,`create_time`) USING BTREE,
  KEY `idx_create_time` (`create_time`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=75613 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for os_status_history
-- ----------------------------
DROP TABLE IF EXISTS `os_status_history`;
CREATE TABLE `os_status_history` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  `snmp` tinyint(2) NOT NULL DEFAULT '0',
  `tags` varchar(100) DEFAULT NULL,
  `hostname` varchar(100) NOT NULL DEFAULT '-1',
  `kernel` varchar(50) NOT NULL DEFAULT '-1',
  `system_date` varchar(50) NOT NULL DEFAULT '-1',
  `system_uptime` varchar(50) NOT NULL DEFAULT '-1',
  `process` smallint(4) NOT NULL DEFAULT '-1',
  `load_1` decimal(4,2) NOT NULL DEFAULT '-1.00',
  `load_5` decimal(4,2) NOT NULL DEFAULT '-1.00',
  `load_15` decimal(4,2) NOT NULL DEFAULT '-1.00',
  `cpu_user_time` tinyint(4) NOT NULL DEFAULT '-1',
  `cpu_system_time` tinyint(4) NOT NULL DEFAULT '-1',
  `cpu_idle_time` tinyint(4) NOT NULL DEFAULT '-1',
  `swap_total` int(11) NOT NULL DEFAULT '-1',
  `swap_avail` int(11) NOT NULL DEFAULT '-1',
  `mem_total` int(11) NOT NULL DEFAULT '-1',
  `mem_used` int(11) NOT NULL DEFAULT '-1',
  `mem_free` int(11) NOT NULL DEFAULT '-1',
  `mem_shared` int(11) NOT NULL DEFAULT '-1',
  `mem_buffered` int(11) NOT NULL DEFAULT '-1',
  `mem_cached` int(11) NOT NULL DEFAULT '-1',
  `mem_usage_rate` varchar(50) NOT NULL DEFAULT '-1',
  `mem_available` varchar(50) NOT NULL DEFAULT '-1',
  `disk_io_reads_total` int(10) NOT NULL DEFAULT '-1',
  `disk_io_writes_total` int(10) NOT NULL DEFAULT '-1',
  `net_in_bytes_total` bigint(18) NOT NULL DEFAULT '-1',
  `net_out_bytes_total` bigint(18) NOT NULL DEFAULT '-1',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `YmdHi` bigint(18) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_host_ymdhi` (`ip`,`YmdHi`),
  KEY `idx_ymdhi` (`YmdHi`) USING BTREE,
  KEY `idx_createtime` (`create_time`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=75610 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for redis_replication
-- ----------------------------
DROP TABLE IF EXISTS `redis_replication`;
CREATE TABLE `redis_replication` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) NOT NULL DEFAULT '0',
  `tags` varchar(50) NOT NULL DEFAULT '',
  `host` varchar(30) DEFAULT '0',
  `port` smallint(4) DEFAULT '0',
  `role` varchar(20) DEFAULT '0',
  `master_server_id` smallint(4) NOT NULL DEFAULT '0',
  `master_host` varchar(20) DEFAULT '0',
  `master_port` varchar(20) DEFAULT '0',
  `master_link_status` varchar(20) DEFAULT '0',
  `master_last_io_seconds_ago` varchar(20) DEFAULT '0',
  `master_sync_in_progress` varchar(20) DEFAULT '0',
  `slave_priority` varchar(20) DEFAULT '0',
  `slave_read_only` varchar(20) DEFAULT '0',
  `connected_slaves` smallint(4) DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=454260 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for redis_replication_history
-- ----------------------------
DROP TABLE IF EXISTS `redis_replication_history`;
CREATE TABLE `redis_replication_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) NOT NULL DEFAULT '0',
  `tags` varchar(50) NOT NULL DEFAULT '',
  `host` varchar(20) DEFAULT '0',
  `port` smallint(4) DEFAULT '0',
  `role` varchar(20) DEFAULT '0',
  `master_server_id` smallint(4) NOT NULL DEFAULT '0',
  `master_host` varchar(20) DEFAULT '0',
  `master_port` varchar(20) DEFAULT '0',
  `master_link_status` varchar(20) DEFAULT '0',
  `master_last_io_seconds_ago` varchar(20) DEFAULT '0',
  `master_sync_in_progress` varchar(20) DEFAULT '0',
  `slave_priority` varchar(20) DEFAULT '0',
  `slave_read_only` varchar(20) DEFAULT '0',
  `connected_slaves` smallint(4) DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ymdhi` bigint(18) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=454256 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for redis_status
-- ----------------------------
DROP TABLE IF EXISTS `redis_status`;
CREATE TABLE `redis_status` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) NOT NULL DEFAULT '0',
  `host` varchar(30) NOT NULL,
  `port` varchar(10) NOT NULL,
  `tags` varchar(50) NOT NULL DEFAULT '',
  `connect` smallint(4) NOT NULL DEFAULT '0',
  `redis_role` varchar(30) NOT NULL DEFAULT '-1',
  `redis_version` varchar(50) NOT NULL DEFAULT '-1',
  `redis_git_sha1` varchar(255) NOT NULL DEFAULT '-1',
  `redis_git_dirty` varchar(255) NOT NULL DEFAULT '-1',
  `redis_mode` varchar(255) NOT NULL DEFAULT '-1',
  `os` varchar(255) NOT NULL DEFAULT '-1',
  `arch_bits` varchar(10) NOT NULL DEFAULT '-1',
  `multiplexing_api` varchar(20) NOT NULL DEFAULT '-1',
  `gcc_version` varchar(20) NOT NULL DEFAULT '-1',
  `process_id` int(10) NOT NULL DEFAULT '-1',
  `run_id` varchar(255) NOT NULL DEFAULT '-1',
  `tcp_port` int(11) NOT NULL DEFAULT '-1',
  `uptime_in_seconds` int(11) NOT NULL DEFAULT '-1',
  `uptime_in_days` int(11) NOT NULL DEFAULT '-1',
  `hz` int(11) NOT NULL DEFAULT '-1',
  `lru_clock` bigint(20) NOT NULL DEFAULT '-1',
  `connected_clients` smallint(4) NOT NULL DEFAULT '-1',
  `client_longest_output_list` smallint(4) NOT NULL DEFAULT '-1',
  `client_biggest_input_buf` smallint(4) NOT NULL DEFAULT '-1',
  `blocked_clients` smallint(4) NOT NULL DEFAULT '-1',
  `used_memory` bigint(10) NOT NULL DEFAULT '-1',
  `used_memory_human` varchar(50) NOT NULL DEFAULT '-1',
  `used_memory_rss` varchar(50) NOT NULL DEFAULT '-1',
  `used_memory_peak` varchar(50) NOT NULL DEFAULT '-1',
  `used_memory_peak_human` varchar(50) NOT NULL DEFAULT '-1',
  `used_memory_lua` varchar(50) NOT NULL DEFAULT '-1',
  `mem_fragmentation_ratio` varchar(50) NOT NULL DEFAULT '-1',
  `mem_allocator` varchar(50) NOT NULL DEFAULT '-1',
  `loading` smallint(4) NOT NULL DEFAULT '-1',
  `rdb_changes_since_last_save` smallint(4) NOT NULL DEFAULT '-1',
  `rdb_bgsave_in_progress` smallint(4) NOT NULL DEFAULT '-1',
  `rdb_last_save_time` bigint(18) NOT NULL DEFAULT '-1',
  `rdb_last_bgsave_status` varchar(10) NOT NULL DEFAULT '-1',
  `rdb_last_bgsave_time_sec` smallint(4) NOT NULL DEFAULT '-1',
  `rdb_current_bgsave_time_sec` smallint(4) NOT NULL DEFAULT '-1',
  `aof_enabled` smallint(4) NOT NULL DEFAULT '-1',
  `aof_rewrite_in_progress` smallint(4) NOT NULL DEFAULT '-1',
  `aof_rewrite_scheduled` smallint(4) NOT NULL DEFAULT '-1',
  `aof_last_rewrite_time_sec` smallint(4) NOT NULL DEFAULT '-1',
  `aof_current_rewrite_time_sec` smallint(4) NOT NULL DEFAULT '-1',
  `aof_last_bgrewrite_status` varchar(10) NOT NULL DEFAULT '-1',
  `total_connections_received` bigint(18) NOT NULL DEFAULT '-1',
  `total_commands_processed` bigint(18) NOT NULL DEFAULT '-1',
  `current_commands_processed` smallint(4) NOT NULL DEFAULT '-1',
  `instantaneous_ops_per_sec` smallint(4) NOT NULL DEFAULT '-1',
  `rejected_connections` smallint(4) NOT NULL DEFAULT '-1',
  `expired_keys` int(10) NOT NULL DEFAULT '-1',
  `evicted_keys` int(10) NOT NULL DEFAULT '-1',
  `keyspace_hits` int(10) NOT NULL DEFAULT '-1',
  `keyspace_misses` int(10) NOT NULL DEFAULT '-1',
  `pubsub_channels` int(10) NOT NULL DEFAULT '-1',
  `pubsub_patterns` int(10) NOT NULL DEFAULT '-1',
  `latest_fork_usec` int(10) NOT NULL DEFAULT '-1',
  `used_cpu_sys` decimal(10,2) NOT NULL DEFAULT '-1.00',
  `used_cpu_user` double(10,2) NOT NULL DEFAULT '-1.00',
  `used_cpu_sys_children` int(10) NOT NULL DEFAULT '-1',
  `used_cpu_user_children` int(10) NOT NULL DEFAULT '-1',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_server_id` (`server_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=528742 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for redis_status_history
-- ----------------------------
DROP TABLE IF EXISTS `redis_status_history`;
CREATE TABLE `redis_status_history` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `server_id` smallint(4) NOT NULL DEFAULT '0',
  `host` varchar(30) NOT NULL,
  `port` varchar(10) NOT NULL,
  `tags` varchar(50) NOT NULL DEFAULT '',
  `connect` smallint(4) NOT NULL DEFAULT '0',
  `redis_role` varchar(30) NOT NULL DEFAULT '-1',
  `redis_version` varchar(50) NOT NULL DEFAULT '0',
  `redis_git_sha1` varchar(255) NOT NULL DEFAULT '-1',
  `redis_git_dirty` varchar(255) NOT NULL DEFAULT '-1',
  `redis_mode` varchar(255) NOT NULL DEFAULT '-1',
  `os` varchar(255) NOT NULL DEFAULT '-1',
  `arch_bits` varchar(10) NOT NULL DEFAULT '-1',
  `multiplexing_api` varchar(20) NOT NULL DEFAULT '-1',
  `gcc_version` varchar(20) NOT NULL DEFAULT '-1',
  `process_id` int(10) NOT NULL DEFAULT '-1',
  `run_id` varchar(255) NOT NULL DEFAULT '-1',
  `tcp_port` int(11) NOT NULL DEFAULT '-1',
  `uptime_in_seconds` int(11) NOT NULL DEFAULT '-1',
  `uptime_in_days` int(11) NOT NULL DEFAULT '-1',
  `hz` int(11) NOT NULL DEFAULT '-1',
  `lru_clock` bigint(20) NOT NULL DEFAULT '-1',
  `connected_clients` smallint(4) NOT NULL DEFAULT '-1',
  `client_longest_output_list` smallint(4) NOT NULL DEFAULT '-1',
  `client_biggest_input_buf` smallint(4) NOT NULL DEFAULT '-1',
  `blocked_clients` smallint(4) NOT NULL DEFAULT '-1',
  `used_memory` bigint(10) NOT NULL DEFAULT '-1',
  `used_memory_human` varchar(50) NOT NULL DEFAULT '-1',
  `used_memory_rss` varchar(50) NOT NULL DEFAULT '-1',
  `used_memory_peak` varchar(50) NOT NULL DEFAULT '-1',
  `used_memory_peak_human` varchar(50) NOT NULL DEFAULT '-1',
  `used_memory_lua` varchar(50) NOT NULL DEFAULT '-1',
  `mem_fragmentation_ratio` varchar(50) NOT NULL DEFAULT '-1',
  `mem_allocator` varchar(50) NOT NULL DEFAULT '-1',
  `loading` smallint(4) NOT NULL DEFAULT '-1',
  `rdb_changes_since_last_save` smallint(4) NOT NULL DEFAULT '-1',
  `rdb_bgsave_in_progress` smallint(4) NOT NULL DEFAULT '-1',
  `rdb_last_save_time` bigint(18) NOT NULL DEFAULT '-1',
  `rdb_last_bgsave_status` varchar(10) NOT NULL DEFAULT '-1',
  `rdb_last_bgsave_time_sec` smallint(4) NOT NULL DEFAULT '-1',
  `rdb_current_bgsave_time_sec` smallint(4) NOT NULL DEFAULT '-1',
  `aof_enabled` smallint(4) NOT NULL DEFAULT '-1',
  `aof_rewrite_in_progress` smallint(4) NOT NULL DEFAULT '-1',
  `aof_rewrite_scheduled` smallint(4) NOT NULL DEFAULT '-1',
  `aof_last_rewrite_time_sec` smallint(4) NOT NULL DEFAULT '-1',
  `aof_current_rewrite_time_sec` smallint(4) NOT NULL DEFAULT '-1',
  `aof_last_bgrewrite_status` varchar(10) NOT NULL DEFAULT '-1',
  `total_connections_received` bigint(18) NOT NULL DEFAULT '-1',
  `total_commands_processed` bigint(18) NOT NULL DEFAULT '-1',
  `current_commands_processed` smallint(4) NOT NULL DEFAULT '-1',
  `instantaneous_ops_per_sec` smallint(4) NOT NULL DEFAULT '-1',
  `rejected_connections` smallint(4) NOT NULL DEFAULT '-1',
  `expired_keys` int(10) NOT NULL DEFAULT '-1',
  `evicted_keys` int(10) NOT NULL DEFAULT '-1',
  `keyspace_hits` int(10) NOT NULL DEFAULT '-1',
  `keyspace_misses` int(10) NOT NULL DEFAULT '-1',
  `pubsub_channels` int(10) NOT NULL DEFAULT '-1',
  `pubsub_patterns` int(10) NOT NULL DEFAULT '-1',
  `latest_fork_usec` int(10) NOT NULL DEFAULT '-1',
  `used_cpu_sys` decimal(10,2) NOT NULL DEFAULT '-1.00',
  `used_cpu_user` double(10,2) NOT NULL DEFAULT '-1.00',
  `used_cpu_sys_children` int(10) NOT NULL DEFAULT '-1',
  `used_cpu_user_children` int(10) NOT NULL DEFAULT '-1',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ymdhi` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_server_id` (`server_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=528736 DEFAULT CHARSET=utf8;
