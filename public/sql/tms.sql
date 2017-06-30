/*
SQLyog 企业版 - MySQL GUI v8.14 
MySQL - 5.5.47 : Database - tms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tms` /*!40100 DEFAULT CHARACTER SET gbk */;

USE `tms`;

/*Table structure for table `tms_folders` */

DROP TABLE IF EXISTS `tms_folders`;

CREATE TABLE `tms_folders` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一识别ID',
  `title` varchar(30) NOT NULL COMMENT '目录名称',
  `u_id` int(11) NOT NULL COMMENT '创建人ID',
  `parent_id` int(1) NOT NULL DEFAULT '0' COMMENT '父ID',
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0表示删除，1表示正常',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=gbk;

/*Data for the table `tms_folders` */

insert  into `tms_folders`(`id`,`title`,`u_id`,`parent_id`,`active`,`created_at`,`updated_at`) values (1,'前端',5,0,0,1498446366,1498449153),(2,'H5',2,0,1,1498450684,1498450684),(3,'css',2,1,1,1498450791,1498450791),(4,'IOS',2,0,1,1498463200,1498463200),(5,'Android',2,0,1,1498463210,1498463210),(6,'pure',2,3,1,1498463252,1498463252),(7,'swift',2,4,1,1498463274,1498463274),(8,'object-c',2,4,1,1498463286,1498463286),(9,'layout',2,5,1,1498463309,1498463309),(10,'service',2,5,1,1498463556,1498463556),(11,'canvance',2,2,1,1498463571,1498463571),(12,'你好',2,0,1,1498535394,1498535394),(13,'你好1',2,0,1,1498535446,1498535446),(14,'你好2',2,0,1,1498535488,1498535488),(15,'testxxx',2,0,1,1498704112,1498704125);

/*Table structure for table `tms_migrations` */

DROP TABLE IF EXISTS `tms_migrations`;

CREATE TABLE `tms_migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tms_migrations` */

insert  into `tms_migrations`(`id`,`migration`,`batch`) values (1,'2014_10_12_000000_create_users_table',1),(2,'2017_06_20_093128_create_users_token_table',1);

/*Table structure for table `tms_notes` */

DROP TABLE IF EXISTS `tms_notes`;

CREATE TABLE `tms_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL COMMENT '标题',
  `origin_content` text COMMENT '源内容',
  `content` text COMMENT '内容',
  `u_id` int(11) NOT NULL COMMENT '创建人ID',
  `f_id` int(11) NOT NULL COMMENT '所属目录',
  `isPrivate` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1公开0私有',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1md文档2表示普通文档',
  `active` tinyint(1) DEFAULT '1' COMMENT '1显示0删除',
  `export_count` int(11) DEFAULT NULL COMMENT '导出次数',
  `explore_count` int(11) DEFAULT NULL COMMENT '浏览次数',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '最后更新时间',
  `last_update_id` int(11) DEFAULT NULL COMMENT '最后更新人id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=gbk;

/*Data for the table `tms_notes` */

insert  into `tms_notes`(`id`,`title`,`origin_content`,`content`,`u_id`,`f_id`,`isPrivate`,`type`,`active`,`export_count`,`explore_count`,`created_at`,`updated_at`,`last_update_id`) values (1,'第一个标题',NULL,'修改后的内容',2,1,1,1,0,NULL,NULL,1498475649,1498478385,NULL),(2,'修改后的标题',NULL,'修改后的内容',2,1,1,1,1,NULL,NULL,1498478061,1498478061,NULL),(3,'test',NULL,'弄好',1,1,1,1,1,NULL,NULL,1498721431,1498721431,NULL),(4,'test1',NULL,'dsas',1,1,1,1,1,NULL,NULL,1498721440,1498721440,NULL),(5,'test2',NULL,'dsas',1,1,1,1,1,NULL,NULL,1498721449,1498721449,NULL),(6,'test3',NULL,'dsas',1,1,1,1,1,NULL,NULL,1498721459,1498721459,NULL),(7,'test4',NULL,'dsas',1,1,1,1,1,NULL,NULL,1498721466,1498721466,NULL),(8,'test5',NULL,'dsas',1,1,1,1,1,NULL,NULL,1498721470,1498721470,NULL),(9,'test6',NULL,'dsas',1,1,1,1,1,NULL,NULL,1498721475,1498721475,NULL),(10,'test7',NULL,'dsas',1,1,1,1,1,NULL,NULL,1498721478,1498721478,NULL),(11,'test8',NULL,'dsas',1,1,1,1,1,NULL,NULL,1498721481,1498721481,NULL),(12,'test9',NULL,'dsas',1,1,1,1,1,NULL,NULL,1498721484,1498721484,NULL),(13,'test10',NULL,'dsas',1,1,1,1,1,NULL,NULL,1498721493,1498721493,NULL),(14,'test11',NULL,'dsas',1,1,1,1,1,NULL,NULL,1498721597,1498721597,NULL),(15,'test33',NULL,'弄好',1,1,1,1,1,NULL,NULL,1498812583,1498812583,NULL),(16,'test333',NULL,'弄好',1,1,1,1,1,NULL,NULL,1498812623,1498812623,NULL),(17,'test334',NULL,'弄好',1,1,1,1,1,NULL,NULL,1498812978,1498812978,NULL),(18,'test335',NULL,'弄好',1,1,1,1,1,NULL,NULL,1498813192,1498813192,NULL),(19,'test336',NULL,'弄好',1,1,1,1,1,NULL,NULL,1498813205,1498813205,NULL),(20,'test3367',NULL,'弄好',1,1,1,1,1,NULL,NULL,1498813326,1498813326,NULL),(21,'test3368',NULL,'弄好',1,1,1,1,1,NULL,NULL,1498813360,1498813360,NULL),(22,'test3369',NULL,'弄好',1,1,1,1,1,NULL,NULL,1498813377,1498813377,NULL),(23,'testa33',NULL,'弄好',1,1,1,1,1,NULL,NULL,1498813397,1498813397,NULL),(24,'testb33',NULL,'弄好',1,1,1,1,1,NULL,NULL,1498813464,1498813464,NULL);

/*Table structure for table `tms_todolist` */

DROP TABLE IF EXISTS `tms_todolist`;

CREATE TABLE `tms_todolist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '标题',
  `desc` text COMMENT '描述',
  `u_id` int(11) DEFAULT NULL COMMENT '用户ID',
  `state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态1正常 2完成 3废弃 ',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Data for the table `tms_todolist` */

/*Table structure for table `tms_users` */

DROP TABLE IF EXISTS `tms_users`;

CREATE TABLE `tms_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `auth` tinyint(4) NOT NULL DEFAULT '1' COMMENT '权限1普通2管理员',
  `username` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` char(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tms_users` */

insert  into `tms_users`(`id`,`auth`,`username`,`password`,`email`,`avatar`,`created_at`,`updated_at`) values (1,1,'admin','$2y$10$oGu4D.1xrKodgJXIN0y7q.h9oEVGK9s0DehdYkPrx3OKjShEOxqEe','admin@163.com','/uploads/avatar/github.jpg',1498704546,1498704546);

/*Table structure for table `tms_users_token` */

DROP TABLE IF EXISTS `tms_users_token`;

CREATE TABLE `tms_users_token` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `token` char(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token_expired` int(11) NOT NULL,
  `ip` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tms_users_token` */

insert  into `tms_users_token`(`id`,`uid`,`token`,`token_expired`,`ip`,`add_time`) values (1,1,'ctPLUBCCLjv6mz71g5SdkxvLm8SmyGUJ',1498711760,'127.0.0.1',1498704560),(2,1,'DNFI5AoRRJAuJ1ZwjtAg70Ouiarlwsfh',1498711791,'127.0.0.1',1498704591),(3,1,'CPsTW3O8Alk9M6yK2ENYf4CseXUV7U8q',1498727507,'127.0.0.1',1498720307),(4,1,'rh49NvRwBbhPS24Hs6Z5zI1MlpWJRfuH',1498734748,'127.0.0.1',1498727548),(5,1,'GyZZ61tdjbjV1daKfN9knLpIIyr8IDKn',1498743955,'127.0.0.1',1498736755),(6,1,'W87jwLbsC3lMhSSwjpEds0sDR5Z0U77t',1498819767,'127.0.0.1',1498812567);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
