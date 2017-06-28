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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=gbk;

/*Data for the table `tms_folders` */

insert  into `tms_folders`(`id`,`title`,`u_id`,`parent_id`,`active`,`created_at`,`updated_at`) values (1,'前端',5,0,0,1498446366,1498449153),(2,'H5',2,0,1,1498450684,1498450684),(3,'css',2,1,1,1498450791,1498450791),(4,'IOS',2,0,1,1498463200,1498463200),(5,'Android',2,0,1,1498463210,1498463210),(6,'pure',2,3,1,1498463252,1498463252),(7,'swift',2,4,1,1498463274,1498463274),(8,'object-c',2,4,1,1498463286,1498463286),(9,'layout',2,5,1,1498463309,1498463309),(10,'service',2,5,1,1498463556,1498463556),(11,'canvance',2,2,1,1498463571,1498463571),(12,'你好',2,0,1,1498535394,1498535394),(13,'你好1',2,0,1,1498535446,1498535446),(14,'你好2',2,0,1,1498535488,1498535488);

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=gbk;

/*Data for the table `tms_notes` */

insert  into `tms_notes`(`id`,`title`,`origin_content`,`content`,`u_id`,`f_id`,`isPrivate`,`type`,`active`,`export_count`,`explore_count`,`created_at`,`updated_at`,`last_update_id`) values (1,'第一个标题',NULL,'修改后的内容',2,1,1,1,0,NULL,NULL,1498475649,1498478385,NULL),(2,'修改后的标题',NULL,'修改后的内容',2,1,1,1,1,NULL,NULL,1498478061,1498478061,NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tms_users` */

insert  into `tms_users`(`id`,`auth`,`username`,`password`,`email`,`avatar`,`created_at`,`updated_at`) values (1,1,'aaa','$2y$10$zf7HCWNNYI/eSUt9sTOoQuHDbpWXAOo9c6ybFCLZgiHjD4oA5kgUS','aaaa@163.com','/uploads/avatar/github.jpg',1498096607,1498096607),(2,1,'admin','$2y$10$hxxeOrcbrh/Kjt1L3B8sv.YlUsEfw4f/xpuRiuONgsXPZiYI1AENC','admin@163.com','/uploads/avatar/github.jpg',1498097686,1498097686),(3,1,'admin1','$2y$10$dXcp4Lyp.FYV2BBqV9uIvuydIOCMyf2/khmqtW/6.as3xZw5Wl3fS','admin1@163.com','/uploads/avatar/github.jpg',1498097741,1498097741),(4,1,'bbb','$2y$10$k1KU56njrN8kerQuaT6VIOnxPREYhAuqlZRBR9ru3UkkSEiiaXere','bbb@163.com','/uploads/avatar/github.jpg',1498098069,1498098069),(5,1,'xxx','$2y$10$3bqiY0jnISwmUfZfim4M7uznVemMsurlYcjygWWKmoBeBdYdytLJG','xxx@163.com','/uploads/avatar/github.jpg',1498442935,1498442935);

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
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tms_users_token` */

insert  into `tms_users_token`(`id`,`uid`,`token`,`token_expired`,`ip`,`add_time`) values (1,2,'gQgdstNeru04Z758cXDOdhP9EDiTqgkT',1498189051,'127.0.0.1',1498102651),(2,2,'XjkmOmPp59QtC9skrKCXYuD5HpagiQR4',1498189112,'127.0.0.1',1498102712),(3,2,'RfjWMaTiP3qrQ9oZfyuJ7gbyxSZ5Cn3B',1498189157,'127.0.0.1',1498102757),(4,2,'B80LNy3YdGDFhTUMZuoSp5lSPIa2Ytgf',1498189164,'127.0.0.1',1498102764),(5,2,'DF8e7DnXAfX1j7GU4zDmYjUBBrOaWn9M',1498189327,'127.0.0.1',1498102927),(6,2,'6NPRNkfCSQoRwYZIeoP54AwEyesPsINi',1498189562,'127.0.0.1',1498103162),(7,3,'j5umlDgWoXrqDISjj9P95WEKW5xZitwR',1498189586,'127.0.0.1',1498103186),(8,3,'EgEczwEWXAlFWOxY1VjfX78SS5fbVd61',1498189853,'127.0.0.1',1498103453),(9,3,'EZN6Kpu9mXNw5gyJshpo5d8DPuQipQLJ',1498190058,'127.0.0.1',1498103658),(10,2,'7aa5hQNTFM0BkUePbb9itE1cY1JPThgm',1498206736,'127.0.0.1',1498120336),(11,2,'q98Zt7N6RX6QX86yvQsHP10kKDlxfPrs',1498265234,'127.0.0.1',1498178834),(12,2,'yuRsKc2pMgST6wifA8y8sld96ax4Ey3W',1498265303,'127.0.0.1',1498178903),(13,2,'88ba9FDFq5E5LvLGw1lzILsn6gse3Lmf',1498265314,'127.0.0.1',1498178914),(14,2,'Q4n3qDOo16lGX6PwaBG3XbiR1Vkw8RTu',1498265339,'127.0.0.1',1498178939),(15,2,'o5v4tE1rdQZ9rChrDXSo4cxCCygDteZQ',1498297963,'127.0.0.1',1498211563),(16,2,'sc0AsqdJTzeW6uJCuXjoRdYJECBqiCZr',1498305264,'127.0.0.1',1498218864),(17,2,'tOWrvrwREp6YJoJjsF44Y6b3tia3iuE6',1498305286,'127.0.0.1',1498218886),(18,2,'7lzFx6AgWWsCgepaUrtQghMifMDVKP68',1498305517,'127.0.0.1',1498219117),(19,2,'ahrB7oEIeCZ7jlQugns8mchEyNjuaal4',1498305529,'127.0.0.1',1498219129),(20,2,'sDSfoo6UO17C2aA7uGYewqchm7tHPTw7',1498305538,'127.0.0.1',1498219138),(21,2,'ItbmZBvQKQ9bABWIFaa6oI651Vhj8u1h',1498306557,'127.0.0.1',1498220157),(22,2,'WVgmcm6L9EloehQDwpo4rzaUkTthKEYG',1498306572,'127.0.0.1',1498220172),(23,2,'tWHNnpHzzfUpot3ozoWlDtClEeBVNb4j',1498306590,'127.0.0.1',1498220190),(24,2,'Q4cpH2s4CFhSnLk37fySSTzpuElzgLVT',1498306631,'127.0.0.1',1498220231),(25,2,'Fex5zSr63Jjb43BeoZh4VZgcVY9hzKG6',1498306709,'127.0.0.1',1498220309),(26,2,'Iw38UywYTXyL3HF06t2bwRm6yN7qq1aL',1498306716,'127.0.0.1',1498220316),(27,2,'ceXIlQfLSvhKUAPeERlKoW4f7Y5r0oyj',1498306731,'127.0.0.1',1498220331),(28,2,'MaCGX4gCBuJeA0hxBXPsCZjZyVS43xuR',1498354907,'127.0.0.1',1498268507),(29,2,'zyBiNt4WyZCGvADJEKhjLtTx6VweTZzG',1498354979,'127.0.0.1',1498268579),(30,2,'pFKelcNTGkerMZc6BwJcZ0YPvOAuFMaD',1498354985,'127.0.0.1',1498268585),(31,2,'9nsxSNw5mJy9LTV1nSadL3fyFMkiI6z7',1498355025,'127.0.0.1',1498268625),(32,2,'LZizJ8YWWRJoErEG79JraV1ozAgNxXPu',1498355038,'127.0.0.1',1498268638),(33,2,'S8Lc1vJnI9dOCvE6Oudzsg4XRlXW2UZT',1498355062,'127.0.0.1',1498268662),(34,2,'8LIG8244gtm4tej8EAUTy057YmlWH2Y1',1498355158,'127.0.0.1',1498268758),(35,2,'2pnIEkOzafZgM7ZaqbV06NVA9CmUMvtH',1498355202,'127.0.0.1',1498268802),(36,2,'EqT9qT9bDBA0Y82QZZW33eHekHTLRjGi',1498355220,'127.0.0.1',1498268820),(37,2,'5WjUSE0Aj7YB7oAsGrbgoXNA637DIfE7',1498355223,'127.0.0.1',1498268823),(38,2,'fWrkDtjonBj8ZYbVooSC18oV3QHD9A8l',1498355232,'127.0.0.1',1498268832),(39,2,'GGLLxtgEQXOl8Pz82mL7FEPGrFu5yLso',1498355239,'127.0.0.1',1498268839),(40,2,'1bw5H2I6F8DhBkXZdYZgSXuZPLfRr8IZ',1498355281,'127.0.0.1',1498268881),(41,2,'blDrRuftSCnDUx7u5yAYw0mNwQ7O9gb6',1498355398,'127.0.0.1',1498268998),(42,2,'ctWnoTynihWSXhBFQzcDrEtnvUZL5SEL',1498355408,'127.0.0.1',1498269008),(43,2,'DW0yQbr1B3UI3qiQdVzALgFdBQQb1FYU',1498355615,'127.0.0.1',1498269215),(44,2,'YWgY0U4p9wMLNa1EYhafkvQHjY3vNuwp',1498355726,'127.0.0.1',1498269326),(45,2,'T5tALoMqXyaSWFS37XYQHbJWsjAJsnlX',1498355825,'127.0.0.1',1498269425),(46,2,'5YjQiLDug60OzOB1szXLghW2rFMOqIdH',1498355865,'127.0.0.1',1498269465),(47,2,'5LyBdkDz6Af6lMKQHOOhlfbaMIOIfb2V',1498358357,'127.0.0.1',1498271957),(48,2,'bxAKE17pXGzqbYACLK1WZ7txslB5zl56',1498358645,'127.0.0.1',1498272245),(49,2,'78hQx9CSDYhRUTwU721jxNxGa1OLRCkn',1498359620,'127.0.0.1',1498273220),(50,2,'xOI0kgbpLml9bXHaz4Dw0hZ21n5jg482',1498360234,'127.0.0.1',1498273834),(51,5,'jZgVNp96by2CZR0aEG40HKyvYFdGxM84',1498529356,'127.0.0.1',1498442956),(52,2,'73muw4QmJ1qvQybaYKbAxzcZXKLYODSG',1498456006,'127.0.0.1',1498448806),(53,2,'tD5uZEHEOiBnG2aK7nFONQnGC8ALz132',1498470312,'127.0.0.1',1498463112),(54,2,'OSCKIrO5mLi9XRDP93ePnbt2FY349ZdK',1498482580,'127.0.0.1',1498475380),(55,2,'99eHRWCWoRttO0fd6JUYPObP28VxY7Yf',1498488670,'127.0.0.1',1498481470),(56,2,'sK2cim58MdFVS4nW0AsXAzP5gINXETax',1498542584,'127.0.0.1',1498535384),(57,2,'tRFaWGv2n2hrr1qFzkvwMw8J2a7KKT6P',1498543009,'127.0.0.1',1498535809),(58,2,'rmdJgdRhSvY02YOpGQ4qZltUmzDcmtve',1498552755,'127.0.0.1',1498545555);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
