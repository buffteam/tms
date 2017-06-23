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
  `folder_name` varchar(30) NOT NULL COMMENT '目录名称',
  `u_id` int(11) NOT NULL COMMENT '创建人ID',
  `level` char(1) NOT NULL DEFAULT '1' COMMENT '目录级别',
  `active` char(1) NOT NULL DEFAULT '1' COMMENT '0表示删除，1表示正常',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Data for the table `tms_folders` */

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
  `content` text COMMENT '内容',
  `u_id` int(11) NOT NULL COMMENT '创建人ID',
  `f_id` int(11) NOT NULL COMMENT '所属目录',
  `isPrivate` char(1) NOT NULL DEFAULT '1' COMMENT '1公开0私有',
  `type` char(1) NOT NULL DEFAULT '1' COMMENT '1md文档2表示普通文档',
  `active` char(1) DEFAULT '1' COMMENT '1显示0删除',
  `export_count` int(11) DEFAULT NULL COMMENT '导出次数',
  `explore_count` int(11) DEFAULT NULL COMMENT '浏览次数',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `last_update_time` int(11) NOT NULL COMMENT '最后更新时间',
  `last_update_id` int(11) DEFAULT NULL COMMENT '最后更新人id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Data for the table `tms_notes` */

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tms_users` */

insert  into `tms_users`(`id`,`auth`,`username`,`password`,`email`,`avatar`,`created_at`,`updated_at`) values (1,1,'aaa','$2y$10$zf7HCWNNYI/eSUt9sTOoQuHDbpWXAOo9c6ybFCLZgiHjD4oA5kgUS','aaaa@163.com','/uploads/avatar/github.jpg',1498096607,1498096607),(2,1,'admin','$2y$10$hxxeOrcbrh/Kjt1L3B8sv.YlUsEfw4f/xpuRiuONgsXPZiYI1AENC','admin@163.com','/uploads/avatar/github.jpg',1498097686,1498097686),(3,1,'admin1','$2y$10$dXcp4Lyp.FYV2BBqV9uIvuydIOCMyf2/khmqtW/6.as3xZw5Wl3fS','admin1@163.com','/uploads/avatar/github.jpg',1498097741,1498097741),(4,1,'bbb','$2y$10$k1KU56njrN8kerQuaT6VIOnxPREYhAuqlZRBR9ru3UkkSEiiaXere','bbb@163.com','/uploads/avatar/github.jpg',1498098069,1498098069);

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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tms_users_token` */

insert  into `tms_users_token`(`id`,`uid`,`token`,`token_expired`,`ip`,`add_time`) values (1,2,'gQgdstNeru04Z758cXDOdhP9EDiTqgkT',1498189051,'127.0.0.1',1498102651),(2,2,'XjkmOmPp59QtC9skrKCXYuD5HpagiQR4',1498189112,'127.0.0.1',1498102712),(3,2,'RfjWMaTiP3qrQ9oZfyuJ7gbyxSZ5Cn3B',1498189157,'127.0.0.1',1498102757),(4,2,'B80LNy3YdGDFhTUMZuoSp5lSPIa2Ytgf',1498189164,'127.0.0.1',1498102764),(5,2,'DF8e7DnXAfX1j7GU4zDmYjUBBrOaWn9M',1498189327,'127.0.0.1',1498102927),(6,2,'6NPRNkfCSQoRwYZIeoP54AwEyesPsINi',1498189562,'127.0.0.1',1498103162),(7,3,'j5umlDgWoXrqDISjj9P95WEKW5xZitwR',1498189586,'127.0.0.1',1498103186),(8,3,'EgEczwEWXAlFWOxY1VjfX78SS5fbVd61',1498189853,'127.0.0.1',1498103453),(9,3,'EZN6Kpu9mXNw5gyJshpo5d8DPuQipQLJ',1498190058,'127.0.0.1',1498103658),(10,2,'7aa5hQNTFM0BkUePbb9itE1cY1JPThgm',1498206736,'127.0.0.1',1498120336),(11,2,'q98Zt7N6RX6QX86yvQsHP10kKDlxfPrs',1498265234,'127.0.0.1',1498178834),(12,2,'yuRsKc2pMgST6wifA8y8sld96ax4Ey3W',1498265303,'127.0.0.1',1498178903),(13,2,'88ba9FDFq5E5LvLGw1lzILsn6gse3Lmf',1498265314,'127.0.0.1',1498178914),(14,2,'Q4n3qDOo16lGX6PwaBG3XbiR1Vkw8RTu',1498265339,'127.0.0.1',1498178939);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
