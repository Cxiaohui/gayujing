# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: rm-wz9wg8c638x6se200vo.mysql.rds.aliyuncs.com (MySQL 5.7.20-log)
# Database: ga_yujing
# Generation Time: 2019-02-27 11:22:24 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table ga_app_tokens
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ga_app_tokens`;

CREATE TABLE `ga_app_tokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1用户',
  `api_token` varchar(33) NOT NULL DEFAULT '',
  `token_expiry` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '过期时间',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_type` (`user_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='app token';

LOCK TABLES `ga_app_tokens` WRITE;
/*!40000 ALTER TABLE `ga_app_tokens` DISABLE KEYS */;

INSERT INTO `ga_app_tokens` (`id`, `user_id`, `user_type`, `api_token`, `token_expiry`, `update_time`)
VALUES
	(1,1,1,'ebfc0ea599dfc815cb2eaf4edb86ba56','2019-04-28 18:31:30','2019-02-27 18:31:30'),
	(2,2,1,'99a09977324fd18bfd6b6d109a455529','2019-04-28 18:44:52','2019-02-27 18:44:52'),
	(3,3,1,'1dc1def9531b294d43d7dbed05ee01d3','2019-04-28 18:31:48','2019-02-27 18:31:49');

/*!40000 ALTER TABLE `ga_app_tokens` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ga_daliyworks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ga_daliyworks`;

CREATE TABLE `ga_daliyworks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `people_name` varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
  `people_idnumber` varchar(32) NOT NULL DEFAULT '' COMMENT '身份证号',
  `people_mobile` varchar(32) NOT NULL DEFAULT '' COMMENT '通讯号码',
  `people_idcardpic0` varchar(125) NOT NULL DEFAULT '' COMMENT '身份证正面照',
  `people_idcardpic1` varchar(125) NOT NULL DEFAULT '' COMMENT '身份证反面照',
  `gobeijing_path` varchar(32) NOT NULL DEFAULT '' COMMENT '进京途径',
  `gobeijing_path_id` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text COMMENT '详细诉求',
  `gotype` varchar(32) NOT NULL DEFAULT '' COMMENT '上访方式',
  `gotype_id` int(10) unsigned NOT NULL DEFAULT '0',
  `action_name` varchar(32) NOT NULL DEFAULT '' COMMENT '过激行为',
  `action_name_id` int(10) unsigned NOT NULL DEFAULT '0',
  `suqiu_content` text COMMENT '上访诉求',
  `action_desn` text COMMENT '行为描述',
  `work_content` text COMMENT '上访工作',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `isdel` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除标记：0否，1是',
  `suqiu_type_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '信访诉求类型id',
  `suqiu_type` varchar(32) NOT NULL DEFAULT '' COMMENT '信访诉求类型',
  `xinfang_type_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '信访行为id',
  `xinfang_type` varchar(32) NOT NULL DEFAULT '' COMMENT '信访行为',
  `gobeijing_act_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '进京行为类型id',
  `gobeijing_act` varchar(32) NOT NULL DEFAULT '' COMMENT '进京行为类型',
  `raodao_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '绕道id',
  `raodao` varchar(32) NOT NULL DEFAULT '' COMMENT '绕道',
  PRIMARY KEY (`id`),
  KEY `post_user_id` (`post_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='日常性工作';

LOCK TABLES `ga_daliyworks` WRITE;
/*!40000 ALTER TABLE `ga_daliyworks` DISABLE KEYS */;

INSERT INTO `ga_daliyworks` (`id`, `post_user_id`, `status`, `people_name`, `people_idnumber`, `people_mobile`, `people_idcardpic0`, `people_idcardpic1`, `gobeijing_path`, `gobeijing_path_id`, `content`, `gotype`, `gotype_id`, `action_name`, `action_name_id`, `suqiu_content`, `action_desn`, `work_content`, `create_time`, `update_time`, `isdel`, `suqiu_type_id`, `suqiu_type`, `xinfang_type_id`, `xinfang_type`, `gobeijing_act_id`, `gobeijing_act`, `raodao_id`, `raodao`)
VALUES
	(1,1,1,'陈生','00000000000','2423432424','people_idcardpic000000','people_idcardpic111111','长途客运',0,'有人要上访有人要上访有人要上访有人要上访有人要上访有人要上访有人要上访有人要上访有人要上访','赴省上访',0,'扬言报复',0,NULL,'扬言报复扬言报复扬言报复','正常33','2019-01-31 21:19:34','2019-01-31 21:23:44',0,0,'0',0,'0',0,'0',0,'0'),
	(2,1,1,'31212313','31231231','31231231','gongan/id/201902241254200.jpg','gongan/id/201902241254250.jpg','自驾车',3,'31231','直达',1,'扬言自杀',1,'上访诉求','哦请问哦请问','哦请问哦去','2019-02-26 22:38:02','2019-02-26 22:38:02',0,2,'0',1,'0',1,'0',0,'0'),
	(3,1,1,'31212313','31231231','31231231','gongan/id/201902241254200.jpg','gongan/id/201902241254250.jpg','自驾车',3,'31231','直达',1,'扬言自杀',1,'上访诉求','哦请问哦请问','哦请问哦去','2019-02-26 22:38:30','2019-02-26 22:38:30',0,2,'0',1,'0',1,'0',0,'0'),
	(4,1,1,'31212313','31231231','31231231','gongan/id/201902241254200.jpg','gongan/id/201902241254250.jpg','自驾车',3,'31231','直达',1,'扬言自杀',1,'上访诉求','哦请问哦请问','哦请问哦去','2019-02-26 22:42:27','2019-02-26 22:42:27',0,2,'军队退役人员',1,'进京上访',1,'外围查找',0,'');

/*!40000 ALTER TABLE `ga_daliyworks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ga_event_peoples
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ga_event_peoples`;

CREATE TABLE `ga_event_peoples` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
  `idnumber` varchar(32) NOT NULL DEFAULT '' COMMENT '身份证号',
  `mobile` varchar(32) NOT NULL DEFAULT '' COMMENT '通讯号码',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `isdel` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除标记：0否，1是',
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='事件采集人员信息';

LOCK TABLES `ga_event_peoples` WRITE;
/*!40000 ALTER TABLE `ga_event_peoples` DISABLE KEYS */;

INSERT INTO `ga_event_peoples` (`id`, `event_id`, `name`, `idnumber`, `mobile`, `create_time`, `update_time`, `isdel`)
VALUES
	(1,1,'王五5','5555555555','1115555','2019-02-26 22:33:05','2019-02-26 22:48:09',1),
	(2,1,'王五5','5555555555','1115555','2019-02-26 22:49:10','2019-02-26 22:49:10',0),
	(3,1,'赵六6','66666666','1116666','2019-02-26 22:49:10','2019-02-26 22:49:10',0),
	(4,1,'胡八8','8888888888','1118888','2019-02-26 22:49:10','2019-02-26 22:49:10',0);

/*!40000 ALTER TABLE `ga_event_peoples` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ga_events
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ga_events`;

CREATE TABLE `ga_events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型：1已/正发生的，2预报的',
  `group_name` varchar(32) NOT NULL DEFAULT '' COMMENT '涉及群体',
  `group_name_id` int(10) unsigned NOT NULL DEFAULT '0',
  `event_cate` varchar(32) NOT NULL DEFAULT '' COMMENT '事件类别',
  `event_cate_id` int(10) unsigned NOT NULL DEFAULT '0',
  `happen_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `address` varchar(125) NOT NULL DEFAULT '' COMMENT '地点',
  `people_number` varchar(32) NOT NULL DEFAULT '' COMMENT '人数规模',
  `people_number_id` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text COMMENT '事因诉求',
  `do_unit_name` varchar(125) NOT NULL DEFAULT '' COMMENT '处置单位',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `isdel` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除标记：0否，1是',
  PRIMARY KEY (`id`),
  KEY `post_user_id` (`post_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='事件采集';

LOCK TABLES `ga_events` WRITE;
/*!40000 ALTER TABLE `ga_events` DISABLE KEYS */;

INSERT INTO `ga_events` (`id`, `post_user_id`, `status`, `type`, `group_name`, `group_name_id`, `event_cate`, `event_cate_id`, `happen_time`, `address`, `people_number`, `people_number_id`, `content`, `do_unit_name`, `create_time`, `update_time`, `isdel`)
VALUES
	(1,1,0,1,'企业改制',3,'堵塞公共道路\\场所',2,'2019-02-26 22:49:09','在那很远的地方','50-100',2,'闲的没事干','那个单位的','2019-02-26 22:33:05','2019-02-27 18:43:02',0);

/*!40000 ALTER TABLE `ga_events` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ga_peoples
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ga_peoples`;

CREATE TABLE `ga_peoples` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
  `idnumber` varchar(32) NOT NULL DEFAULT '' COMMENT '身份证号',
  `mobile` varchar(32) NOT NULL DEFAULT '' COMMENT '通讯号码',
  `idcardpic0` varchar(125) NOT NULL DEFAULT '' COMMENT '身份证正面照',
  `idcardpic1` varchar(125) NOT NULL DEFAULT '' COMMENT '身份证反面照',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='人员信息';



# Dump of table ga_sysusers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ga_sysusers`;

CREATE TABLE `ga_sysusers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '账号状态',
  `utype` tinyint(4) NOT NULL DEFAULT '3' COMMENT '权限：1超级2浏览3个人',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
  `gender` tinyint(4) NOT NULL DEFAULT '0' COMMENT '性别：0未知，1男，2女',
  `mobile` varchar(16) NOT NULL DEFAULT '' COMMENT '手机号',
  `education` varchar(16) NOT NULL DEFAULT '' COMMENT '学历',
  `logaccount` varchar(32) NOT NULL DEFAULT '' COMMENT '登录账号',
  `logpwd` varchar(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `logstat` varchar(10) NOT NULL DEFAULT '',
  `headpic` varchar(125) NOT NULL DEFAULT '' COMMENT '头像',
  `province_id` int(10) unsigned NOT NULL DEFAULT '0',
  `province` varchar(32) NOT NULL DEFAULT '' COMMENT '省',
  `city_id` int(10) unsigned NOT NULL DEFAULT '0',
  `city` varchar(32) NOT NULL DEFAULT '' COMMENT '市',
  `county_id` int(10) unsigned NOT NULL DEFAULT '0',
  `county` varchar(32) NOT NULL DEFAULT '' COMMENT '县/区',
  `district_id` int(10) unsigned NOT NULL DEFAULT '0',
  `district` varchar(32) NOT NULL DEFAULT '' COMMENT '乡镇',
  `isdel` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除标记：0否，1是',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统使用用户表';

LOCK TABLES `ga_sysusers` WRITE;
/*!40000 ALTER TABLE `ga_sysusers` DISABLE KEYS */;

INSERT INTO `ga_sysusers` (`id`, `status`, `utype`, `name`, `gender`, `mobile`, `education`, `logaccount`, `logpwd`, `logstat`, `headpic`, `province_id`, `province`, `city_id`, `city`, `county_id`, `county`, `district_id`, `district`, `isdel`, `create_time`, `update_time`)
VALUES
	(1,1,3,'张格权',0,'13344445555','','testman','cd689a788200baae1f6d6ade43f6b52c','3DJkxD','http://pnd68waxi.bkt.clouddn.com/head_pic/wefspfsdlldmv2.png',0,'',0,'',0,'',0,'',0,'2019-01-31 01:29:32','2019-01-31 01:29:32'),
	(2,1,3,'刘格权',0,'13322223333','','testman1','51a019a9a6af50f86da150ed32e4a03b','0fIZHM','http://pnd68waxi.bkt.clouddn.com/head_pic/pwefjpjfssivp1.png',0,'',0,'',0,'',0,'',0,'2019-02-26 21:49:23','2019-02-26 21:49:23'),
	(3,1,2,'王柳权',0,'13355556666','','testman2','e02a120fcf5d90918b6a845d72466d6e','qqIKpZ','http://pnd68waxi.bkt.clouddn.com/head_pic/sofpwvojowjg3.png',0,'',0,'',0,'',0,'',0,'2019-02-26 21:50:54','2019-02-26 21:50:54');

/*!40000 ALTER TABLE `ga_sysusers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ga_tehuworks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ga_tehuworks`;

CREATE TABLE `ga_tehuworks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `xinfang_name` varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
  `xinfang_idnumber` varchar(32) NOT NULL DEFAULT '' COMMENT '身份证号',
  `xinfang_mobile` varchar(32) NOT NULL DEFAULT '' COMMENT '通讯号码',
  `xinfang_idcardpic0` varchar(125) NOT NULL DEFAULT '' COMMENT '身份证正面照',
  `xinfang_idcardpic1` varchar(125) NOT NULL DEFAULT '' COMMENT '身份证反面照',
  `tongxi_name` varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
  `tongxi_idnumber` varchar(32) NOT NULL DEFAULT '' COMMENT '身份证号',
  `tongxi_mobile` varchar(32) NOT NULL DEFAULT '' COMMENT '通讯号码',
  `tongxi_idcardpic0` varchar(125) NOT NULL DEFAULT '' COMMENT '身份证正面照',
  `tongxi_idcardpic1` varchar(125) NOT NULL DEFAULT '' COMMENT '身份证反面照',
  `gobeijing_path` varchar(32) NOT NULL DEFAULT '' COMMENT '进京途径',
  `gobeijing_path_id` int(10) unsigned NOT NULL DEFAULT '0',
  `gobeijing_type` varchar(32) NOT NULL DEFAULT '' COMMENT '进京方式',
  `gobeijing_type_id` int(10) unsigned NOT NULL DEFAULT '0',
  `acttype_inbeijing` varchar(32) NOT NULL DEFAULT '' COMMENT '在京行为类型',
  `acttype_inbeijing_id` int(10) unsigned NOT NULL DEFAULT '0',
  `address_inbeijing` varchar(125) NOT NULL DEFAULT '' COMMENT '在京巡回地点',
  `lost_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '失联时间',
  `find_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '找到时间',
  `content` text,
  `create_time` datetime DEFAULT '0000-00-00 00:00:00',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `isdel` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除标记：0否，1是',
  `raodao_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '绕道id',
  `raodao` varchar(32) NOT NULL DEFAULT '' COMMENT '绕道',
  PRIMARY KEY (`id`),
  KEY `post_user_id` (`post_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='特护期工作表';

LOCK TABLES `ga_tehuworks` WRITE;
/*!40000 ALTER TABLE `ga_tehuworks` DISABLE KEYS */;

INSERT INTO `ga_tehuworks` (`id`, `post_user_id`, `status`, `xinfang_name`, `xinfang_idnumber`, `xinfang_mobile`, `xinfang_idcardpic0`, `xinfang_idcardpic1`, `tongxi_name`, `tongxi_idnumber`, `tongxi_mobile`, `tongxi_idcardpic0`, `tongxi_idcardpic1`, `gobeijing_path`, `gobeijing_path_id`, `gobeijing_type`, `gobeijing_type_id`, `acttype_inbeijing`, `acttype_inbeijing_id`, `address_inbeijing`, `lost_time`, `find_time`, `content`, `create_time`, `update_time`, `isdel`, `raodao_id`, `raodao`)
VALUES
	(2,1,1,'张三2','12345678900987654','122222222222','xinfang_idcardpic0','xinfang_idcardpic1','李四3','9876543298765','144555555555','tongxi_idcardpic0','tongxi_idcardpic1','自驾车',0,'直达',0,'北京分流',0,'北京三里屯','0000-00-00 00:00:00','0000-00-00 00:00:00','我要上报我要上报我要上报我要上报我要上报我要上报我要上报我要上报我要上报','2019-01-31 17:02:52','2019-01-31 17:04:31',0,0,'0'),
	(3,1,0,'312','3123','3123','gaqn/id/201902241557220.jpg','gaqn/id/201902241557260.jpg','哦请问哦请问','123123131','31231','gaqn/id/201902241557460.jpg','gaqn/id/201902241557500.jpg','自驾车',3,'绕道',2,'北京分流',2,'3123123','2019-02-24 00:00:00','2019-02-24 00:00:00','','2019-02-26 22:45:24','2019-02-27 18:43:32',0,2,'河北');

/*!40000 ALTER TABLE `ga_tehuworks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ga_works_photos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ga_works_photos`;

CREATE TABLE `ga_works_photos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `work_id` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型：1现场工作照，2信访人生活照',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '排序',
  `path` varchar(125) NOT NULL DEFAULT '' COMMENT '图片',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `isdel` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除标记：0否，1是',
  PRIMARY KEY (`id`),
  KEY `work_id` (`work_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='日常性工作';

LOCK TABLES `ga_works_photos` WRITE;
/*!40000 ALTER TABLE `ga_works_photos` DISABLE KEYS */;

INSERT INTO `ga_works_photos` (`id`, `work_id`, `type`, `sort`, `path`, `create_time`, `isdel`)
VALUES
	(1,1,1,0,'live_photos-11','2019-01-31 21:23:44',0),
	(2,1,1,1,'live_photos-22','2019-01-31 21:23:44',0),
	(3,1,1,2,'live_photos33','2019-01-31 21:23:44',0),
	(4,1,2,0,'life_photo-11','2019-01-31 21:23:44',0),
	(5,1,2,1,'life_photos-22','2019-01-31 21:23:44',0),
	(6,1,2,2,'life_photos-33','2019-01-31 21:23:44',0),
	(7,3,1,0,'gongan/work/201902241254530.jpg','2019-02-26 22:38:30',0),
	(8,3,1,1,'gongan/work/201902241254531.jpg','2019-02-26 22:38:30',0),
	(9,3,1,2,'gongan/work/201902241254533.jpg','2019-02-26 22:38:30',0),
	(10,3,1,3,'gongan/work/201902241254532.jpg','2019-02-26 22:38:30',0),
	(11,3,2,0,'gongan/life/201902241255001.jpg','2019-02-26 22:38:30',0),
	(12,3,2,1,'gongan/life/201902241255000.jpg','2019-02-26 22:38:30',0),
	(13,3,2,2,'gongan/life/201902241255003.jpg','2019-02-26 22:38:30',0),
	(14,3,2,3,'gongan/life/201902241255002.jpg','2019-02-26 22:38:30',0),
	(15,4,1,0,'gongan/work/201902241254530.jpg','2019-02-26 22:42:27',0),
	(16,4,1,1,'gongan/work/201902241254531.jpg','2019-02-26 22:42:27',0),
	(17,4,1,2,'gongan/work/201902241254533.jpg','2019-02-26 22:42:27',0),
	(18,4,1,3,'gongan/work/201902241254532.jpg','2019-02-26 22:42:27',0),
	(19,4,2,0,'gongan/life/201902241255001.jpg','2019-02-26 22:42:27',0),
	(20,4,2,1,'gongan/life/201902241255000.jpg','2019-02-26 22:42:27',0),
	(21,4,2,2,'gongan/life/201902241255003.jpg','2019-02-26 22:42:27',0),
	(22,4,2,3,'gongan/life/201902241255002.jpg','2019-02-26 22:42:27',0);

/*!40000 ALTER TABLE `ga_works_photos` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
