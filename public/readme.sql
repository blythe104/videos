/*
SQLyog Ultimate v11.3 (64 bit)
MySQL - 5.6.16 : Database - videos
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`videos` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `videos`;

/*Table structure for table `vcomment` */

DROP TABLE IF EXISTS `vcomment`;

CREATE TABLE `vcomment` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '视频评论ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `content` varchar(1000) DEFAULT '什么都没有说！' COMMENT '评论内容信息',
  `comment_Pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级评论ID',
  `Vlevel` float NOT NULL COMMENT '评论星级',
  `create_time` int(11) DEFAULT NULL COMMENT '评论时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `vcomment` */

/*Table structure for table `vcontent` */

DROP TABLE IF EXISTS `vcontent`;

CREATE TABLE `vcontent` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '视频ID',
  `title` varchar(50) NOT NULL COMMENT '视频标题',
  `instroduct` text COMMENT '视频简介',
  `path` varchar(255) DEFAULT NULL COMMENT '视频路径',
  `avatar_path` varchar(255) DEFAULT NULL COMMENT '图片路径',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `vcontent` */

/*Table structure for table `vdetail` */

DROP TABLE IF EXISTS `vdetail`;

CREATE TABLE `vdetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '视频附表ID',
  `Vid` int(11) DEFAULT NULL COMMENT '视频ID',
  `support_count` int(11) DEFAULT '0' COMMENT '点赞数',
  `comment_count` int(11) DEFAULT '0' COMMENT '评论数',
  `repost_count` int(11) DEFAULT '0' COMMENT '转发数',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `vdetail` */

/* Function  structure for function  `getdate` */

/*!50003 DROP FUNCTION IF EXISTS `getdate` */;
DELIMITER $$

CREATE DEFINER=`root`@`localhost` FUNCTION `getdate`(gdate datetime) RETURNS varchar(255) CHARSET UTF8
begin 
declare x varchar(255) default '';
set x=date_format(gdate,'%Y年%m月%d日%h时%i分%s秒');
return x;
end $$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
