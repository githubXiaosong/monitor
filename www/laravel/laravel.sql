/*
Navicat MySQL Data Transfer

Source Server         : 服务器
Source Server Version : 50505
Source Host           : 123.206.65.137:3306
Source Database       : laravel

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-10-01 18:39:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `intervals`
-- ----------------------------
DROP TABLE IF EXISTS `intervals`;
CREATE TABLE `intervals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of intervals
-- ----------------------------
INSERT INTO `intervals` VALUES ('1', '2', null, null);
INSERT INTO `intervals` VALUES ('2', '5', null, null);
INSERT INTO `intervals` VALUES ('3', '10', null, null);
INSERT INTO `intervals` VALUES ('4', '30', null, null);

-- ----------------------------
-- Table structure for `jobs`
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_reserved_at_index` (`queue`,`reserved_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('2017_09_07_133107_create_intervals_table', '2');
INSERT INTO `migrations` VALUES ('2017_09_07_133121_create_streams_table', '3');
INSERT INTO `migrations` VALUES ('2017_09_09_012538_rename_interval_id_to_streams', '4');
INSERT INTO `migrations` VALUES ('2017_09_09_020839_add_start_time_and_end_time_to_streams', '5');
INSERT INTO `migrations` VALUES ('2017_09_10_202618_create_policies_table', '6');
INSERT INTO `migrations` VALUES ('2017_09_11_203129_add_global_interval_id_to_streams', '7');
INSERT INTO `migrations` VALUES ('2017_09_22_172146_create_jobs_table', '8');
INSERT INTO `migrations` VALUES ('2017_09_26_082750_create_servers_table', '9');
INSERT INTO `migrations` VALUES ('2017_09_27_084003_create_validate_cycles_table', '10');
INSERT INTO `migrations` VALUES ('2017_09_27_161705_create_notifications_table', '11');

-- ----------------------------
-- Table structure for `notifications`
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_id` int(10) unsigned NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_id_notifiable_type_index` (`notifiable_id`,`notifiable_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of notifications
-- ----------------------------
INSERT INTO `notifications` VALUES ('01b34053-9c11-4cdc-bb46-84d62d763368', 'App\\Notifications\\ServerError', '1', 'App\\User', '{\"ip\":\"123.206.65.137\",\"msg\":\"script run error!  error is: name \'confi\' is not defined\"}', '2017-09-28 17:53:59', '2017-09-28 17:46:41', '2017-09-28 17:53:59');
INSERT INTO `notifications` VALUES ('08c900f1-1d3b-48af-89f4-a0ee0c0cf7c4', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":56,\"per_status\":0,\"to_status\":100}', null, '2017-09-29 20:39:01', '2017-09-29 20:39:01');
INSERT INTO `notifications` VALUES ('09b18099-cc66-489d-8c0f-ab79ad9c6f53', 'App\\Notifications\\ServerError', '1', 'App\\User', '{\"ip\":\"123.206.65.137\",\"msg\":\"Server breakdown!\"}', '2017-09-28 17:36:02', '2017-09-28 16:29:02', '2017-09-28 17:36:02');
INSERT INTO `notifications` VALUES ('09f96168-2312-438e-a15c-2ae527ef9eeb', 'App\\Notifications\\ServerError', '1', 'App\\User', '{\"ip\":\"123.206.65.137\",\"msg\":\"script run error!  error is: module \'config\' has no attribute \'SERVER_STATUS_CALLBACK_ADD\'\"}', '2017-09-28 17:53:59', '2017-09-28 17:48:24', '2017-09-28 17:53:59');
INSERT INTO `notifications` VALUES ('0a8aae0c-a4d2-4eea-bee8-0909fa703787', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":40,\"per_status\":0,\"to_status\":100}', '2017-09-28 17:35:58', '2017-09-28 16:23:01', '2017-09-28 17:35:58');
INSERT INTO `notifications` VALUES ('0bb3024c-692d-42e1-937b-4010347819c5', 'App\\Notifications\\ServerError', '1', 'App\\User', '{\"ip\":\"123.206.65.137\",\"msg\":\"Server breakdown!\"}', '2017-09-28 17:36:02', '2017-09-28 16:40:02', '2017-09-28 17:36:02');
INSERT INTO `notifications` VALUES ('0f2ce406-309a-487c-9987-6fce3d0c9411', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":54,\"per_status\":0,\"to_status\":100}', null, '2017-09-29 11:39:02', '2017-09-29 11:39:02');
INSERT INTO `notifications` VALUES ('11401c00-edb6-4215-9286-d07a25f481ed', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":42,\"per_status\":0,\"to_status\":100}', '2017-09-28 17:35:58', '2017-09-28 16:36:01', '2017-09-28 17:35:58');
INSERT INTO `notifications` VALUES ('134c726d-457f-41d8-bedb-b5a4c837e5d1', 'App\\Notifications\\StreamError', '1', 'App\\User', '{\"stream_id\":56,\"msg\":\"\\u6536\\u96c6(\\u622a\\u56fe)\\u56fe\\u7247\\u8fdb\\u7a0b\\u6267\\u884c\\u5931\\u8d25\",\"status\":\"\\u6536\\u96c6(\\u622a\\u56fe)\\u56fe\\u7247\\u8fdb\\u7a0b\\u6267\\u884c\\u5931\\u8d25\"}', null, '2017-09-29 20:43:15', '2017-09-29 20:43:15');
INSERT INTO `notifications` VALUES ('154b76a9-8e58-4ad6-89cd-5c566a8127fb', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":44,\"per_status\":0,\"to_status\":100}', '2017-09-29 09:04:13', '2017-09-28 20:43:02', '2017-09-29 09:04:13');
INSERT INTO `notifications` VALUES ('2082cc17-6456-49d9-a042-b0f92f27ee64', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"2\",\"per_status\":100,\"to_status\":150}', '2017-09-28 16:21:28', '2017-09-28 11:53:46', '2017-09-28 16:21:28');
INSERT INTO `notifications` VALUES ('24d74285-7993-43b7-bb83-89ce6ff727d4', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":55,\"per_status\":0,\"to_status\":100}', null, '2017-09-29 20:25:02', '2017-09-29 20:25:02');
INSERT INTO `notifications` VALUES ('2646f6ed-7346-4d5d-b6d4-e61053b000b8', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":43,\"per_status\":0,\"to_status\":100}', '2017-09-29 09:04:13', '2017-09-28 17:55:02', '2017-09-29 09:04:13');
INSERT INTO `notifications` VALUES ('2825ddc9-e913-4dd5-a4ba-f2a087d3770c', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"4\",\"per_status\":100,\"to_status\":150}', '2017-09-28 11:53:24', '2017-09-28 11:53:02', '2017-09-28 11:53:24');
INSERT INTO `notifications` VALUES ('28785e32-8a53-4a25-8a0c-3ae66c14ae49', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"6\",\"per_status\":100,\"to_status\":150}', '2017-09-28 16:21:28', '2017-09-28 11:53:47', '2017-09-28 16:21:28');
INSERT INTO `notifications` VALUES ('2f01ed99-3dec-4d91-953e-b4da51029dae', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":43,\"per_status\":100,\"to_status\":150}', '2017-09-29 09:04:13', '2017-09-28 17:58:01', '2017-09-29 09:04:13');
INSERT INTO `notifications` VALUES ('3055af1d-56f6-4b6e-b190-87ac5d20772d', 'App\\Notifications\\ServerError', '1', 'App\\User', '{\"ip\":\"123.206.65.137\",\"msg\":\"Server off Line!\"}', '2017-09-29 08:53:11', '2017-09-28 23:31:02', '2017-09-29 08:53:11');
INSERT INTO `notifications` VALUES ('31902a33-11c8-47c2-97aa-268c5273fb11', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":49,\"per_status\":100,\"to_status\":150}', '2017-09-29 10:58:42', '2017-09-29 09:53:01', '2017-09-29 10:58:42');
INSERT INTO `notifications` VALUES ('34973182-86c4-4c14-9448-e1b61a9d7275', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":49,\"per_status\":0,\"to_status\":100}', '2017-09-29 10:58:42', '2017-09-29 09:45:01', '2017-09-29 10:58:42');
INSERT INTO `notifications` VALUES ('3f9afdef-91ba-481f-855f-13b7f2b0de45', 'App\\Notifications\\StreamError', '1', 'App\\User', '{\"stream_id\":52,\"msg\":\"\\u6536\\u96c6(\\u622a\\u56fe)\\u56fe\\u7247\\u8fdb\\u7a0b\\u6267\\u884c\\u5931\\u8d25\",\"status\":\"\\u6536\\u96c6(\\u622a\\u56fe)\\u56fe\\u7247\\u8fdb\\u7a0b\\u6267\\u884c\\u5931\\u8d25\"}', '2017-09-29 11:41:46', '2017-09-29 11:22:01', '2017-09-29 11:41:46');
INSERT INTO `notifications` VALUES ('400bba5c-5db8-4568-a854-bd58e63ccf2e', 'App\\Notifications\\ServerError', '1', 'App\\User', '{\"ip\":\"123.206.65.137\",\"msg\":\"\\u9519\\u8bef\"}', '2017-09-28 11:59:13', '2017-09-28 11:53:18', '2017-09-28 11:59:13');
INSERT INTO `notifications` VALUES ('47f5f545-89df-4421-afb5-6c19524692d9', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"6\",\"per_status\":100,\"to_status\":150}', '2017-09-28 11:53:24', '2017-09-28 11:53:02', '2017-09-28 11:53:24');
INSERT INTO `notifications` VALUES ('5485d8f8-64cf-4f66-906b-ac596c02f1e1', 'App\\Notifications\\StreamError', '1', 'App\\User', '{\"stream_id\":1,\"msg\":\"\\u6d4b\\u8bd5\\u9519\\u8bef\",\"status\":\"\\u6d4b\\u8bd5\\u9519\\u8bef\"}', '2017-09-28 11:53:06', '2017-09-28 11:49:01', '2017-09-28 11:53:06');
INSERT INTO `notifications` VALUES ('556274ff-b7e8-405c-a55e-13b74d222a09', 'App\\Notifications\\StreamError', '1', 'App\\User', '{\"stream_id\":55,\"msg\":\"\\u7ed3\\u675f\\u65f6retry_num\\u4e0d\\u4e3a0\",\"status\":\"\\u7ed3\\u675f\\u65f6retry_num\\u4e0d\\u4e3a0\"}', null, '2017-09-29 20:36:57', '2017-09-29 20:36:57');
INSERT INTO `notifications` VALUES ('56b541de-cbc8-4984-a682-a804efb7a372', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"4\",\"per_status\":100,\"to_status\":150}', '2017-09-28 11:53:24', '2017-09-28 11:53:18', '2017-09-28 11:53:24');
INSERT INTO `notifications` VALUES ('58beebcd-c4ea-4115-99c4-bebd5c0c379f', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"2\",\"per_status\":100,\"to_status\":150}', '2017-09-28 11:52:26', '2017-09-28 11:49:01', '2017-09-28 11:52:26');
INSERT INTO `notifications` VALUES ('598ec935-baeb-4a75-8b72-43fe95d9ba97', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":51,\"per_status\":100,\"to_status\":150}', null, '2017-09-29 11:41:01', '2017-09-29 11:41:01');
INSERT INTO `notifications` VALUES ('5ae44781-6c77-4082-aac8-1ff89301abf2', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":48,\"per_status\":100,\"to_status\":150}', '2017-09-29 10:58:42', '2017-09-29 09:52:01', '2017-09-29 10:58:42');
INSERT INTO `notifications` VALUES ('5b5738ac-bab9-4255-8b9b-516cfa55c81a', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"5\",\"per_status\":100,\"to_status\":150}', '2017-09-28 16:21:28', '2017-09-28 11:53:46', '2017-09-28 16:21:28');
INSERT INTO `notifications` VALUES ('64a5348a-1e7d-4774-abf0-b23a1a09fd86', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":51,\"per_status\":0,\"to_status\":100}', null, '2017-09-29 11:14:02', '2017-09-29 11:14:02');
INSERT INTO `notifications` VALUES ('6657bd2f-c1bb-4351-845c-a509da13ae81', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"1\",\"per_status\":100,\"to_status\":150}', '2017-09-28 11:53:24', '2017-09-28 11:53:18', '2017-09-28 11:53:24');
INSERT INTO `notifications` VALUES ('6cf76e2f-68bc-455e-9d6c-4a799540c853', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":46,\"per_status\":0,\"to_status\":100}', '2017-09-29 09:04:13', '2017-09-29 09:03:01', '2017-09-29 09:04:13');
INSERT INTO `notifications` VALUES ('6d507e95-da1a-410f-9e99-88765c31d1b4', 'App\\Notifications\\ServerError', '1', 'App\\User', '{\"ip\":\"123.206.65.137\",\"msg\":\"\\u9519\\u8bef\"}', '2017-09-28 11:53:06', '2017-09-28 11:49:01', '2017-09-28 11:53:06');
INSERT INTO `notifications` VALUES ('6e13f143-5eba-487c-9952-3897ccd028b3', 'App\\Notifications\\StreamError', '1', 'App\\User', '{\"stream_id\":1,\"msg\":\"\\u6d4b\\u8bd5\\u9519\\u8bef\",\"status\":\"\\u6d4b\\u8bd5\\u9519\\u8bef\"}', '2017-09-28 10:11:12', '2017-09-28 09:25:28', '2017-09-28 10:11:12');
INSERT INTO `notifications` VALUES ('718eb74f-ba57-48e4-844c-c751f7abedc2', 'App\\Notifications\\StreamError', '1', 'App\\User', '{\"stream_id\":44,\"msg\":\" \\u7ebf\\u4e0a\\u6267\\u884c\\u51fa\\u9519\",\"status\":\" \\u7ebf\\u4e0a\\u6267\\u884c\\u51fa\\u9519\"}', '2017-09-29 09:03:17', '2017-09-29 08:59:33', '2017-09-29 09:03:17');
INSERT INTO `notifications` VALUES ('733c3c6d-e47f-4410-b624-c857de91c247', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"5\",\"per_status\":100,\"to_status\":150}', '2017-09-28 11:53:24', '2017-09-28 11:53:02', '2017-09-28 11:53:24');
INSERT INTO `notifications` VALUES ('750b262e-e68b-4dcc-8f49-b4a5f9fc0b5a', 'App\\Notifications\\ServerError', '1', 'App\\User', '{\"ip\":\"123.206.65.137\",\"msg\":\"Server breakdown!\"}', '2017-09-28 17:36:02', '2017-09-28 17:01:02', '2017-09-28 17:36:02');
INSERT INTO `notifications` VALUES ('858c3f76-37f4-40ab-8e9f-f9b3125f1fbc', 'App\\Notifications\\StreamError', '1', 'App\\User', '{\"stream_id\":50,\"msg\":\"\\u6536\\u96c6(\\u622a\\u56fe)\\u56fe\\u7247\\u8fdb\\u7a0b\\u6267\\u884c\\u5931\\u8d25\",\"status\":\"\\u6536\\u96c6(\\u622a\\u56fe)\\u56fe\\u7247\\u8fdb\\u7a0b\\u6267\\u884c\\u5931\\u8d25\"}', '2017-09-29 11:09:33', '2017-09-29 11:05:23', '2017-09-29 11:09:33');
INSERT INTO `notifications` VALUES ('8b357552-41ab-4c4e-a739-abd7d20c8a67', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"1\",\"per_status\":100,\"to_status\":150}', '2017-09-28 10:11:12', '2017-09-28 09:25:14', '2017-09-28 10:11:12');
INSERT INTO `notifications` VALUES ('8b902d8f-dabe-4636-908c-d9b4a46a0798', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":42,\"per_status\":100,\"to_status\":150}', '2017-09-28 17:35:58', '2017-09-28 16:53:01', '2017-09-28 17:35:58');
INSERT INTO `notifications` VALUES ('8ca8505b-fff1-454e-9cc1-edbba3039235', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"1\",\"per_status\":100,\"to_status\":150}', '2017-09-28 10:11:12', '2017-09-28 09:07:43', '2017-09-28 10:11:12');
INSERT INTO `notifications` VALUES ('8d8ec58f-757b-4e0b-a569-cf14d6eb1288', 'App\\Notifications\\StreamError', '1', 'App\\User', '{\"stream_id\":1,\"msg\":\"\\u6d4b\\u8bd5\\u9519\\u8bef\",\"status\":\"\\u6d4b\\u8bd5\\u9519\\u8bef\"}', '2017-09-28 11:59:13', '2017-09-28 11:53:17', '2017-09-28 11:59:13');
INSERT INTO `notifications` VALUES ('8e52a903-cd22-40ce-b046-65e750c36b8e', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":48,\"per_status\":0,\"to_status\":100}', '2017-09-29 10:58:42', '2017-09-29 09:45:01', '2017-09-29 10:58:42');
INSERT INTO `notifications` VALUES ('94e2be78-4072-4972-92b4-a1ecae3f1dc0', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"3\",\"per_status\":100,\"to_status\":150}', '2017-09-28 11:52:26', '2017-09-28 11:49:02', '2017-09-28 11:52:26');
INSERT INTO `notifications` VALUES ('98ef057f-b74a-4d3b-8747-e841c3df8c70', 'App\\Notifications\\ServerError', '1', 'App\\User', '{\"ip\":\"123.206.65.137\",\"msg\":\"\\u9519\\u8bef\"}', '2017-09-28 10:11:12', '2017-09-28 08:54:24', '2017-09-28 10:11:12');
INSERT INTO `notifications` VALUES ('a1ba92d5-d202-4f64-952e-fe42df600120', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":50,\"per_status\":0,\"to_status\":100}', '2017-09-29 10:58:42', '2017-09-29 10:58:01', '2017-09-29 10:58:42');
INSERT INTO `notifications` VALUES ('aef58e21-3c83-4aa6-8d35-640defcd50e1', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"2\",\"per_status\":100,\"to_status\":150}', '2017-09-28 11:53:24', '2017-09-28 11:53:18', '2017-09-28 11:53:24');
INSERT INTO `notifications` VALUES ('af0aba6a-497c-4805-b7e3-24606dd811d4', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"1\",\"per_status\":100,\"to_status\":150}', '2017-09-28 11:52:26', '2017-09-28 11:49:01', '2017-09-28 11:52:26');
INSERT INTO `notifications` VALUES ('b1bbc9c2-538f-4b77-9ab2-828f388f01a1', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"3\",\"per_status\":100,\"to_status\":150}', '2017-09-28 11:53:24', '2017-09-28 11:53:02', '2017-09-28 11:53:24');
INSERT INTO `notifications` VALUES ('b47efff3-238c-45da-81c1-e4f2cdb73cd2', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"2\",\"per_status\":100,\"to_status\":150}', '2017-09-28 11:53:24', '2017-09-28 11:53:02', '2017-09-28 11:53:24');
INSERT INTO `notifications` VALUES ('b76852ed-e34c-42c7-8ace-fe9adee51410', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":47,\"per_status\":100,\"to_status\":150}', '2017-09-29 10:58:42', '2017-09-29 09:47:02', '2017-09-29 10:58:42');
INSERT INTO `notifications` VALUES ('bc784736-c2d9-483f-a898-b5331d00b67c', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":53,\"per_status\":100,\"to_status\":150}', null, '2017-09-29 11:43:01', '2017-09-29 11:43:01');
INSERT INTO `notifications` VALUES ('c1682add-ec40-4814-9e89-e23e19431528', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":52,\"per_status\":0,\"to_status\":100}', null, '2017-09-29 11:17:01', '2017-09-29 11:17:01');
INSERT INTO `notifications` VALUES ('c28dd4ce-1f6d-4da1-992d-81d36accf7c7', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"3\",\"per_status\":100,\"to_status\":150}', '2017-09-28 16:21:28', '2017-09-28 11:53:46', '2017-09-28 16:21:28');
INSERT INTO `notifications` VALUES ('c3ff3ea7-b5f7-4148-b771-6d3264aad3ad', 'App\\Notifications\\StreamError', '1', 'App\\User', '{\"stream_id\":50,\"msg\":\"\\u7ed3\\u675f\\u65f6retry_num\\u4e0d\\u4e3a0\",\"status\":\"\\u7ed3\\u675f\\u65f6retry_num\\u4e0d\\u4e3a0\"}', '2017-09-29 11:10:25', '2017-09-29 11:10:10', '2017-09-29 11:10:25');
INSERT INTO `notifications` VALUES ('c58b9d3d-c503-4625-890e-075a7649d570', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"4\",\"per_status\":100,\"to_status\":150}', '2017-09-28 16:21:28', '2017-09-28 11:53:46', '2017-09-28 16:21:28');
INSERT INTO `notifications` VALUES ('cabc01fe-761d-4cb7-9a34-313f36e59097', 'App\\Notifications\\StreamError', '1', 'App\\User', '{\"stream_id\":54,\"msg\":\"\\u6536\\u96c6(\\u622a\\u56fe)\\u56fe\\u7247\\u8fdb\\u7a0b\\u6267\\u884c\\u5931\\u8d25\",\"status\":\"\\u6536\\u96c6(\\u622a\\u56fe)\\u56fe\\u7247\\u8fdb\\u7a0b\\u6267\\u884c\\u5931\\u8d25\"}', '2017-09-29 20:30:40', '2017-09-29 11:43:59', '2017-09-29 20:30:40');
INSERT INTO `notifications` VALUES ('ce85f855-ad5d-4243-a99b-06c392423b0c', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"6\",\"per_status\":100,\"to_status\":150}', '2017-09-28 11:53:24', '2017-09-28 11:53:18', '2017-09-28 11:53:24');
INSERT INTO `notifications` VALUES ('cf7f6524-0781-42d3-880c-e526cce73f85', 'App\\Notifications\\ServerError', '1', 'App\\User', '{\"ip\":\"123.206.65.137\",\"msg\":\"Server off Line!\"}', '2017-09-28 17:53:59', '2017-09-28 17:36:02', '2017-09-28 17:53:59');
INSERT INTO `notifications` VALUES ('d3c57972-ae97-45a5-8c99-382fdb63bb21', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":41,\"per_status\":0,\"to_status\":100}', '2017-09-28 17:35:58', '2017-09-28 16:25:01', '2017-09-28 17:35:58');
INSERT INTO `notifications` VALUES ('d71ad283-3ad1-4b1b-a726-1f0ebbbf036a', 'App\\Notifications\\StreamError', '1', 'App\\User', '{\"stream_id\":1,\"msg\":\"\\u6d4b\\u8bd5\\u9519\\u8bef\",\"status\":\"\\u6d4b\\u8bd5\\u9519\\u8bef\"}', '2017-09-28 10:11:12', '2017-09-28 08:38:03', '2017-09-28 10:11:12');
INSERT INTO `notifications` VALUES ('dac35722-ea6b-4453-9e7a-509199a61df5', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"1\",\"per_status\":100,\"to_status\":150}', '2017-09-28 16:21:28', '2017-09-28 11:53:46', '2017-09-28 16:21:28');
INSERT INTO `notifications` VALUES ('dc0faa0f-0c88-4964-99f2-1e898d59dfa7', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"1\",\"per_status\":100,\"to_status\":150}', '2017-09-28 11:53:24', '2017-09-28 11:53:01', '2017-09-28 11:53:24');
INSERT INTO `notifications` VALUES ('e90c1ee2-7431-4a94-815f-cbe6b4e37dff', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":46,\"per_status\":100,\"to_status\":150}', '2017-09-29 10:58:42', '2017-09-29 09:08:02', '2017-09-29 10:58:42');
INSERT INTO `notifications` VALUES ('eb727459-c062-4506-9ec5-973066206489', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"5\",\"per_status\":100,\"to_status\":150}', '2017-09-28 11:53:24', '2017-09-28 11:53:18', '2017-09-28 11:53:24');
INSERT INTO `notifications` VALUES ('ecbe6cfd-e63c-4544-baf5-4d4f2795edf0', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":53,\"per_status\":0,\"to_status\":100}', null, '2017-09-29 11:39:02', '2017-09-29 11:39:02');
INSERT INTO `notifications` VALUES ('f23ed845-58a1-47ec-912b-6cdf7f4e759f', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":\"3\",\"per_status\":100,\"to_status\":150}', '2017-09-28 11:53:24', '2017-09-28 11:53:18', '2017-09-28 11:53:24');
INSERT INTO `notifications` VALUES ('f317ef2c-37f4-497c-82e3-aaa8e5300b3c', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":44,\"per_status\":100,\"to_status\":150}', '2017-09-29 09:04:13', '2017-09-28 20:51:02', '2017-09-29 09:04:13');
INSERT INTO `notifications` VALUES ('fe3b8670-f5b5-49a4-ab1a-4e505bd772bc', 'App\\Notifications\\StreamStatusChange', '1', 'App\\User', '{\"stream_id\":47,\"per_status\":0,\"to_status\":100}', '2017-09-29 10:58:42', '2017-09-29 09:42:02', '2017-09-29 10:58:42');

-- ----------------------------
-- Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`) USING BTREE,
  KEY `password_resets_token_index` (`token`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------
INSERT INTO `password_resets` VALUES ('1098030258@qq.com', '39f54b355a64ff1b475e3d99d78d134c29b9a86a516cd7dbf0d14fd32353405e', '2017-10-01 18:30:46');

-- ----------------------------
-- Table structure for `policies`
-- ----------------------------
DROP TABLE IF EXISTS `policies`;
CREATE TABLE `policies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` int(10) unsigned NOT NULL,
  `interval_id` int(10) unsigned NOT NULL,
  `stream_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `policies_interval_id_foreign` (`interval_id`) USING BTREE,
  KEY `policies_stream_id_foreign` (`stream_id`) USING BTREE,
  CONSTRAINT `policies_ibfk_1` FOREIGN KEY (`interval_id`) REFERENCES `intervals` (`id`),
  CONSTRAINT `policies_ibfk_2` FOREIGN KEY (`stream_id`) REFERENCES `streams` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of policies
-- ----------------------------

-- ----------------------------
-- Table structure for `servers`
-- ----------------------------
DROP TABLE IF EXISTS `servers`;
CREATE TABLE `servers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `call_live_count` tinyint(4) NOT NULL DEFAULT '0',
  `status` mediumint(4) NOT NULL DEFAULT '200',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip_index` (`ip`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of servers
-- ----------------------------
INSERT INTO `servers` VALUES ('3', '123.206.65.137', '0', '200', '2017-09-26 10:13:56', '2017-10-01 18:40:02');
INSERT INTO `servers` VALUES ('6', '123.106.65.138', '4', '500', '2017-09-26 21:38:19', '2017-09-26 23:41:01');

-- ----------------------------
-- Table structure for `streams`
-- ----------------------------
DROP TABLE IF EXISTS `streams`;
CREATE TABLE `streams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `server_id` int(10) unsigned NOT NULL,
  `collect_current_interval_id` int(10) unsigned DEFAULT NULL,
  `collect_global_interval_id` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `online_interval_id` int(10) unsigned NOT NULL DEFAULT '1',
  `image_num_current_val` int(10) unsigned DEFAULT '0',
  `image_num_current` int(10) unsigned DEFAULT '0',
  `acc_expected` int(10) unsigned NOT NULL DEFAULT '1',
  `acc_current` int(10) unsigned DEFAULT NULL,
  `validate_cycle_id` int(10) unsigned NOT NULL DEFAULT '1',
  `is_forbidden` tinyint(4) NOT NULL DEFAULT '0',
  `retry_num` tinyint(4) NOT NULL DEFAULT '0',
  `status` smallint(5) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `start_timestamp` int(10) unsigned NOT NULL,
  `end_timestamp` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `streams_current_interval_id_foreign` (`collect_current_interval_id`) USING BTREE,
  KEY `streams_global_interval_id_foreign` (`collect_global_interval_id`) USING BTREE,
  KEY `streams_ibfk_3` (`server_id`),
  KEY `streams_ibfk_4` (`validate_cycle_id`),
  KEY `streams_ibfk_5` (`online_interval_id`),
  CONSTRAINT `streams_ibfk_1` FOREIGN KEY (`collect_global_interval_id`) REFERENCES `intervals` (`id`),
  CONSTRAINT `streams_ibfk_2` FOREIGN KEY (`collect_current_interval_id`) REFERENCES `intervals` (`id`),
  CONSTRAINT `streams_ibfk_3` FOREIGN KEY (`server_id`) REFERENCES `servers` (`id`),
  CONSTRAINT `streams_ibfk_4` FOREIGN KEY (`validate_cycle_id`) REFERENCES `validate_cycles` (`id`),
  CONSTRAINT `streams_ibfk_5` FOREIGN KEY (`online_interval_id`) REFERENCES `intervals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of streams
-- ----------------------------
INSERT INTO `streams` VALUES ('43', 'rtmp://live.hkstv.hk.lxdns.com/live/hks', '3', null, '0000000001', '2', '0', '90', '10', null, '1', '0', '0', '250', null, '2017-09-29 09:48:29', '1506592500', '1506592680');
INSERT INTO `streams` VALUES ('46', 'rtmp://live.hkstv.hk.lxdns.com/live/hks', '3', null, '0000000002', '1', '0', '60', '10', null, '1', '0', '0', '250', null, '2017-09-29 09:48:33', '1506646980', '1506647280');
INSERT INTO `streams` VALUES ('47', 'rtmp://live.hkstv.hk.lxdns.com/live/hks', '3', null, '0000000002', '1', '0', '48', '10', null, '1', '0', '0', '200', null, '2017-09-29 09:47:59', '1506649320', '1506649620');
INSERT INTO `streams` VALUES ('48', 'rtmp://live.hkstv.hk.lxdns.com/live/hks', '3', null, '0000000001', '1', '0', '210', '10', null, '1', '0', '0', '150', null, '2017-09-29 09:52:01', '1506649500', '1506649920');
INSERT INTO `streams` VALUES ('49', 'rtmp://live.hkstv.hk.lxdns.com/live/hks', '3', null, '0000000001', '1', '0', '210', '10', null, '1', '0', '0', '150', null, '2017-09-29 09:53:01', '1506649500', '1506649980');
INSERT INTO `streams` VALUES ('51', 'rtmp://live.hkstv.hk.lxdns.com/live/hks', '3', null, '0000000001', '1', '0', '780', '10', null, '1', '0', '0', '150', null, '2017-09-29 11:41:01', '1506654840', '1506656460');
INSERT INTO `streams` VALUES ('52', 'rtmp://live.hkstv.hk.lxdns.com/live/hk', '3', '1', '0000000001', '1', '0', '0', '10', null, '1', '0', '3', '932', null, '2017-09-29 11:21:58', '1506654960', '1506655380');
INSERT INTO `streams` VALUES ('53', 'rtmp://live.hkstv.hk.lxdns.com/live/hks', '3', null, '0000000001', '1', '0', '90', '10', null, '1', '0', '0', '250', null, '2017-09-29 11:51:07', '1506656340', '1506656580');
INSERT INTO `streams` VALUES ('54', 'rtmp://live.hkstv.hk.lxdns.com/live/hk', '3', '1', '0000000001', '1', '0', '0', '10', null, '1', '0', '3', '932', null, '2017-09-29 11:43:58', '1506656340', '1506656700');
INSERT INTO `streams` VALUES ('55', 'rtmp://live.hkstv.hk.lxdns.com/live/hk', '3', null, '0000000001', '1', '0', '0', '9', null, '1', '0', '3', '932', null, '2017-09-29 20:29:01', '1506687900', '1506688140');
INSERT INTO `streams` VALUES ('56', 'rtmp://live.hkstv.hk.lxdns.com/live/hk', '3', '1', '0000000001', '1', '0', '0', '9', null, '1', '0', '3', '932', null, '2017-09-29 20:43:12', '1506688740', '1506689040');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'xiaosong', '1098030258@qq.com', '$2y$10$IXW9UdIVqTPWZai2z74WnOP7l81drM9Xs5nMutRNfZJFuPZNkoGJO', '9AQ2dUieBOokIDUKvk0Jy4HY5127wAsNII5gUEjrc2mkv57Ei2a1yqzLa6in', '2017-09-07 11:09:40', '2017-09-13 20:04:13');
INSERT INTO `users` VALUES ('2', 'xiaosong', '1098030257@qq.com', '$2y$10$COSwnO8a4yaxZLI7PtBBaubVWPBUrMdMGXUjTx1nPR.HzTK27ftC6', 'E6YgAfry5wcXwOIcm4GQUaFHWz3GmBYpWtaP5d4dfhq64iQILXgaHCcHigFt', '2017-10-01 18:16:30', '2017-10-01 18:16:35');

-- ----------------------------
-- Table structure for `validate_cycles`
-- ----------------------------
DROP TABLE IF EXISTS `validate_cycles`;
CREATE TABLE `validate_cycles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `days` smallint(5) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of validate_cycles
-- ----------------------------
INSERT INTO `validate_cycles` VALUES ('1', '1', '2017-09-27 08:53:31', '2017-09-27 08:53:34');
INSERT INTO `validate_cycles` VALUES ('2', '2', '2017-09-27 09:26:13', '2017-09-27 09:26:16');
INSERT INTO `validate_cycles` VALUES ('3', '3', '2017-09-27 09:26:38', '2017-09-27 09:26:41');
