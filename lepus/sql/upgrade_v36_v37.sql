
update `admin_menu` set `menu_url` = CONCAT('lp_', `menu_url`) WHERE `menu_url` LIKE 'mongodb%';
update `admin_menu` set `menu_url` = CONCAT('lp_', `menu_url`) WHERE `menu_url` LIKE 'oracle%';
update `admin_menu` set `menu_url` = CONCAT('lp_', `menu_url`) WHERE `menu_url` LIKE 'os%';
update `admin_menu` set `menu_url` = CONCAT('lp_', `menu_url`) WHERE `menu_url` LIKE 'mysql%';
update `admin_menu` set `menu_url` = CONCAT('lp_', `menu_url`) WHERE `menu_url` LIKE 'redis%';


update `admin_privilege` set `action` = CONCAT('lp_', `action`) WHERE `action` LIKE 'mongodb%';
update `admin_privilege` set `action` = CONCAT('lp_', `action`) WHERE `action` LIKE 'oracle%';
update `admin_privilege` set `action` = CONCAT('lp_', `action`) WHERE `action` LIKE 'os%';
update `admin_privilege` set `action` = CONCAT('lp_', `action`) WHERE `action` LIKE 'mysql%';
update `admin_privilege` set `action` = CONCAT('lp_', `action`) WHERE `action` LIKE 'redis%';


ALTER TABLE `mongodb_status`
MODIFY COLUMN `connections_current`  int(10) NOT NULL DEFAULT '-1' AFTER `version`,
MODIFY COLUMN `connections_available`  int(10) NOT NULL DEFAULT '-1' AFTER `connections_current`;
ALTER TABLE `mongodb_status_history`
MODIFY COLUMN `connections_current`  int(10) NOT NULL DEFAULT '-1' AFTER `version`,
MODIFY COLUMN `connections_available`  int(10) NOT NULL DEFAULT '-1' AFTER `connections_current`;
ALTER TABLE `redis_status`
MODIFY COLUMN `total_connections_received`  bigint(18) NOT NULL DEFAULT '-1' AFTER `aof_last_bgrewrite_status`,
MODIFY COLUMN `total_commands_processed`  bigint(18) NOT NULL DEFAULT '-1' AFTER `total_connections_received`;
ALTER TABLE `redis_status_history`
MODIFY COLUMN `total_connections_received`  bigint(18) NOT NULL DEFAULT '-1' AFTER `aof_last_bgrewrite_status`,
MODIFY COLUMN `total_commands_processed`  bigint(18) NOT NULL DEFAULT '-1' AFTER `total_connections_received`;

update lepus_status set lepus_value='3.7' where lepus_variables='lepus_version';
