-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: wd
-- ------------------------------------------------------
-- Server version	5.6.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `userid` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `roleid` smallint(5) DEFAULT '0',
  `encrypt` varchar(6) DEFAULT NULL,
  `lastloginip` varchar(15) DEFAULT NULL,
  `lastlogintime` int(10) unsigned DEFAULT '0',
  `email` varchar(40) DEFAULT NULL,
  `realname` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`userid`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','6af16a2c7485335013ff41a38dabe681',1,'AETsyO','0.0.0.0',1442538303,'admin@admin.com','');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_log`
--

DROP TABLE IF EXISTS `admin_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_log` (
  `logid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` varchar(20) NOT NULL,
  `httpuseragent` text NOT NULL,
  `sessionid` varchar(30) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` varchar(30) NOT NULL,
  PRIMARY KEY (`logid`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_log`
--

LOCK TABLES `admin_log` WRITE;
/*!40000 ALTER TABLE `admin_log` DISABLE KEYS */;
INSERT INTO `admin_log` VALUES (1,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36','mrg5umq3i99aibpbg60g7r6ne1','127.0.0.1','2015-08-26 23:36:07','login'),(2,1,'admin','Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E; InfoPath.3)','r2ppc36nl8mrdha2jtj349ae21','127.0.0.1','2015-08-27 00:36:53','login'),(3,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.155 Safari/537.36','8uug9348cl9sqnsd9c5rikq2b6','127.0.0.1','2015-08-27 09:01:24','login'),(4,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36','uraqeiqahfphqog792g44ql5i6','127.0.0.1','2015-09-03 13:18:27','login'),(5,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36','uraqeiqahfphqog792g44ql5i6','127.0.0.1','2015-09-03 18:20:39','login'),(6,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36','uraqeiqahfphqog792g44ql5i6','127.0.0.1','2015-09-04 00:16:31','login'),(7,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36','f13ves9nj5518c448hipuu94u7','127.0.0.1','2015-09-04 20:19:54','login'),(8,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36','f13ves9nj5518c448hipuu94u7','127.0.0.1','2015-09-04 23:50:41','login'),(9,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36','b9llmqogcpr74q4ns7jg57g9p3','127.0.0.1','2015-09-05 11:34:07','login'),(10,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36','b9llmqogcpr74q4ns7jg57g9p3','127.0.0.1','2015-09-05 14:09:19','login'),(11,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36','b9llmqogcpr74q4ns7jg57g9p3','127.0.0.1','2015-09-05 14:10:05','login'),(12,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36','j3h9eaa45oikplc9uc3hd6gr94','127.0.0.1','2015-09-06 23:33:18','login'),(13,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36','j3h9eaa45oikplc9uc3hd6gr94','127.0.0.1','2015-09-06 23:45:46','login'),(14,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36','lhs3unpgpjthvrrfnuhtnvkui5','0.0.0.0','2015-09-07 13:40:09','login'),(15,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36','cqk5cmua0tnphms4s7j738l272','0.0.0.0','2015-09-08 09:27:10','login'),(16,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36','litnlim3e1ml1ev4bcuja5mgj5','0.0.0.0','2015-09-08 17:45:30','login'),(17,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36','bhc7pbtngfki5sr3cleephq4n1','0.0.0.0','2015-09-09 08:59:06','login'),(18,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36','p6eqma9i7ckcqsmuiessb23e74','0.0.0.0','2015-09-11 09:11:16','login'),(19,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36','p6eqma9i7ckcqsmuiessb23e74','0.0.0.0','2015-09-11 10:28:04','login'),(20,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36','57md3i6mnuasp86qk1c46n3bf1','0.0.0.0','2015-09-14 09:10:31','login'),(21,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36','c35doo0hk9pq2f0n4efqo8j7i6','0.0.0.0','2015-09-15 10:46:57','login'),(22,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36','5t15dm55ar4p9f45ju9aj9abn7','0.0.0.0','2015-09-15 16:24:35','login'),(23,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36','orbk9d15irh5vqft696ssnk931','0.0.0.0','2015-09-16 08:50:27','login'),(24,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36','6fg9l8fhjrq2ba0hsobsanq8f2','0.0.0.0','2015-09-17 09:51:25','login'),(25,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36','sepnqk6ug244suu5314a6l9om1','0.0.0.0','2015-09-18 09:05:03','login');
/*!40000 ALTER TABLE `admin_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_role`
--

DROP TABLE IF EXISTS `admin_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_role` (
  `roleid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `rolename` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`roleid`),
  KEY `listorder` (`listorder`),
  KEY `disabled` (`disabled`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_role`
--

LOCK TABLES `admin_role` WRITE;
/*!40000 ALTER TABLE `admin_role` DISABLE KEYS */;
INSERT INTO `admin_role` VALUES (1,'超级管理员','超级管理员',99,0),(2,'普通用户','普通用户',0,0);
/*!40000 ALTER TABLE `admin_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_role_priv`
--

DROP TABLE IF EXISTS `admin_role_priv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_role_priv` (
  `roleid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `c` varchar(20) NOT NULL,
  `a` varchar(20) NOT NULL,
  KEY `roleid` (`roleid`,`c`,`a`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_role_priv`
--

LOCK TABLES `admin_role_priv` WRITE;
/*!40000 ALTER TABLE `admin_role_priv` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_role_priv` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `catid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `parentid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `catname` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `setting` text,
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁用',
  PRIMARY KEY (`catid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (2,1,0,'消息素材1','撒地方',NULL,0,0),(3,2,0,'凡事都方1','撒地方',NULL,0,0),(4,2,3,'撒地方撒地方11','',NULL,0,0),(6,2,0,'发斯蒂芬','',NULL,0,0),(7,2,6,'撒地方撒地方','',NULL,0,0),(8,1,0,'消息素材2','',NULL,0,0),(9,1,0,'消息素材3','',NULL,0,0),(10,1,9,'消息素材31','',NULL,0,0),(11,1,10,'消息素材311','',NULL,0,0),(12,1,2,'消息素材11','',NULL,0,0);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_priv`
--

DROP TABLE IF EXISTS `category_priv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_priv` (
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `roleid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `action` varchar(30) NOT NULL,
  KEY `catid` (`catid`,`roleid`,`is_admin`,`action`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_priv`
--

LOCK TABLES `category_priv` WRITE;
/*!40000 ALTER TABLE `category_priv` DISABLE KEYS */;
/*!40000 ALTER TABLE `category_priv` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email`
--

DROP TABLE IF EXISTS `email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(40) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `addtime` int(10) DEFAULT '0',
  `edittime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email`
--

LOCK TABLES `email` WRITE;
/*!40000 ALTER TABLE `email` DISABLE KEYS */;
/*!40000 ALTER TABLE `email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `logid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `controller` varchar(15) NOT NULL,
  `action` varchar(20) NOT NULL,
  `querystring` mediumtext NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` varchar(20) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`logid`),
  KEY `module` (`controller`,`action`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `match_tag`
--

DROP TABLE IF EXISTS `match_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `match_tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) DEFAULT NULL,
  `opt` varchar(45) DEFAULT NULL,
  `val` text,
  `pool_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `match_tag`
--

LOCK TABLES `match_tag` WRITE;
/*!40000 ALTER TABLE `match_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `match_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `media_id` int(11) NOT NULL AUTO_INCREMENT,
  `media_type` int(2) DEFAULT NULL COMMENT '媒体类型',
  `path` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `create_date` int(11) DEFAULT NULL,
  `md5` varchar(255) DEFAULT NULL,
  `sha1` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_id`
--

DROP TABLE IF EXISTS `media_id`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media_id` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `media_id` varchar(64) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `is_use` int(1) DEFAULT '1',
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`mid`),
  KEY `ix_file_path` (`file_path`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_id`
--

LOCK TABLES `media_id` WRITE;
/*!40000 ALTER TABLE `media_id` DISABLE KEYS */;
INSERT INTO `media_id` VALUES (2,'h6nvCJzFWtoupiKfXSsbunLMKqzJmj3KeT72onJn0JY','image','/wechat/Upload/files/Chrysanthemum.jpg',1,1442391447),(3,'h6nvCJzFWtoupiKfXSsbutKAUZlKXGQZQPdUT6QdWyk','image','/wechat/Upload/files/c2e63.jpg',1,1442391503);
/*!40000 ALTER TABLE `media_id` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member` (
  `memberid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL COMMENT '帐号',
  `head` varchar(255) DEFAULT NULL COMMENT '头像',
  `nick` varchar(50) DEFAULT NULL COMMENT '昵称',
  `gender` tinyint(1) DEFAULT '0' COMMENT '0:保密,1:男,2:女',
  `password` varchar(32) NOT NULL,
  `encrypt` varchar(6) NOT NULL,
  `typeid` smallint(5) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0' COMMENT '0:待认证1:已认证',
  `remark` text COMMENT '备注',
  `lastloginip` varchar(15) DEFAULT NULL,
  `lastlogintime` int(10) DEFAULT '0',
  `regip` varchar(15) NOT NULL,
  `regtime` int(10) NOT NULL DEFAULT '0' COMMENT '注册时间',
  PRIMARY KEY (`memberid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member`
--

LOCK TABLES `member` WRITE;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;
/*!40000 ALTER TABLE `member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_oauth`
--

DROP TABLE IF EXISTS `member_oauth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member_oauth` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `memberid` int(11) NOT NULL COMMENT '本站用户id',
  `openid` varchar(50) NOT NULL DEFAULT '' COMMENT '唯一标识',
  `email` varchar(40) DEFAULT NULL COMMENT '邮箱',
  `nick` varchar(80) DEFAULT NULL COMMENT '昵称',
  `head` varchar(255) DEFAULT NULL COMMENT '用户图像',
  `gender` varchar(10) DEFAULT NULL COMMENT '性别',
  `link` varchar(255) DEFAULT NULL COMMENT '用户链接',
  `type` varchar(50) NOT NULL DEFAULT '' COMMENT '类型',
  `addtime` int(10) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_oauth`
--

LOCK TABLES `member_oauth` WRITE;
/*!40000 ALTER TABLE `member_oauth` DISABLE KEYS */;
/*!40000 ALTER TABLE `member_oauth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_type`
--

DROP TABLE IF EXISTS `member_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member_type` (
  `typeid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `typename` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`typeid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_type`
--

LOCK TABLES `member_type` WRITE;
/*!40000 ALTER TABLE `member_type` DISABLE KEYS */;
INSERT INTO `member_type` VALUES (1,'普通用户','本地用户',0,0);
/*!40000 ALTER TABLE `member_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  `parentid` smallint(6) NOT NULL DEFAULT '0',
  `c` varchar(20) NOT NULL DEFAULT '',
  `a` varchar(20) NOT NULL DEFAULT '',
  `data` varchar(255) NOT NULL DEFAULT '',
  `listorder` smallint(6) unsigned NOT NULL DEFAULT '0',
  `display` enum('1','0') NOT NULL DEFAULT '1',
  `icon` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `listorder` (`listorder`),
  KEY `parentid` (`parentid`),
  KEY `module` (`c`,`a`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'首页',0,'Admin','top','',1,'1','icon-tabicons_12_11'),(2,'系统管理',0,'System','top','',2,'1','icon-tabicons_06_02'),(3,'微信管理',0,'Content','top','',3,'1','icon-tabicons_06_06'),(6,'安全记录',1,'Admin','userLeft','',0,'1','icon-tabicons_01_04'),(7,'登录日志',6,'Admin','loginLog','',1,'1','icon-tabicons_03_19'),(8,'删除登录日志',7,'Admin','loginLogDelete','',1,'1',NULL),(9,'系统设置',2,'System','settingLeft','',1,'1','icon-tabicons_04_17'),(10,'系统设置',9,'System','setting','',1,'1','icon-tabicons_08_01'),(11,'菜单设置',9,'System','menuList','',2,'1','icon-tabicons_05_07'),(12,'查看列表',11,'System','menuViewList','',0,'1',NULL),(13,'添加菜单',11,'System','menuAdd','',0,'1',NULL),(14,'修改菜单',11,'System','menuEdit','',0,'1',NULL),(15,'删除菜单',11,'System','menuDelete','',0,'1',NULL),(16,'菜单排序',11,'System','menuOrder','',0,'1',NULL),(17,'菜单导出',11,'System','menuExport','',0,'1',NULL),(18,'菜单导入',11,'System','menuImport','',0,'1',NULL),(19,'用户设置',2,'Admin','left','',2,'1','icon-tabicons_25_06'),(20,'用户管理',19,'Admin','memberList','',1,'1','icon-tabicons_25_13'),(21,'查看列表',20,'Admin','memberViewList','',0,'1',NULL),(22,'添加用户',20,'Admin','memberAdd','',0,'1',NULL),(23,'编辑用户',20,'Admin','memberEdit','',0,'1',NULL),(24,'删除用户',20,'Admin','memberDelete','',0,'1',NULL),(25,'角色管理',19,'Admin','roleList','',2,'1','icon-tabicons_11_19'),(26,'查看列表',25,'Admin','roleViewList','',0,'1',NULL),(27,'添加角色',25,'Admin','roleAdd','',0,'1',NULL),(28,'编辑角色',25,'Admin','roleEdit','',0,'1',NULL),(29,'删除角色',25,'Admin','roleDelete','',0,'1',NULL),(30,'角色排序',25,'Admin','roleOrder','',0,'1',NULL),(31,'权限设置',25,'Admin','rolePermission','',0,'1',NULL),(32,'栏目权限',25,'Admin','roleCategory','',0,'1',NULL),(33,'系统记录',2,'System','recordLeft','',3,'1','icon-tabicons_19_10'),(34,'日志管理',33,'System','logList','',3,'1','icon-tabicons_03_19'),(35,'查看列表',34,'System','logViewList','',0,'1',NULL),(36,'删除日志',34,'System','logDelete','',0,'1',NULL),(37,'缓存管理',33,'System','fileList','',1,'1','icon-tabicons_11_14'),(72,'消息素材',3,'Message','left','',0,'1','icon-tabicons_17_18'),(39,'内容管理',38,'Content','index','',0,'1',NULL),(40,'栏目管理',38,'Category','categoryList','',0,'1',NULL),(41,'查看列表',40,'Category','categoryViewList','',0,'1',NULL),(42,'添加栏目',40,'Category','categoryAdd','',0,'1',NULL),(43,'编辑栏目',40,'Category','categoryEdit','',0,'1',NULL),(44,'删除栏目',40,'Category','categoryDelete','',0,'1',NULL),(45,'栏目排序',40,'Category','categoryOrder','',0,'1',NULL),(46,'栏目导出',40,'Category','categoryExport','',0,'1',NULL),(47,'栏目导入',40,'Category','categoryImport','',0,'1',NULL),(49,'会员列表',48,'Member','memberList','',0,'1',NULL),(50,'会员分类',48,'Member','typeList','',0,'1',NULL),(51,'查看列表',49,'Member','memberViewList','',0,'1',NULL),(52,'添加会员',49,'Member','memberAdd','',0,'1',NULL),(53,'编辑用户',49,'Member','memberEdit','',0,'1',NULL),(54,'删除用户',49,'Member','memberDelete','',0,'1',NULL),(55,'用户详情',49,'Member','memberView','',0,'1',NULL),(56,'添加分类',50,'Member','typeAdd','',0,'1',NULL),(57,'编辑分类',50,'Member','typeEdit','',0,'1',NULL),(58,'删除分类',50,'Member','typeDelete','',0,'1',NULL),(59,'分类排序',50,'Member','typeOrder','',0,'1',NULL),(60,'查看列表',50,'Member','typeViewList','',0,'1',NULL),(61,'重置密码',20,'Admin','memberResetPassword','',0,'1',NULL),(62,'重置密码',49,'Member','memberResetPassword','',0,'1',NULL),(64,'模版添加',63,'System','emailAdd','',0,'1',NULL),(65,'模版编辑',63,'System','emailEdit','',0,'1',NULL),(66,'模版删除',63,'System','emailDelete','',0,'1',NULL),(67,'模版列表',63,'System','emailList','',0,'1',NULL),(68,'上传管理',38,'Storage','index','',0,'1',NULL),(69,'数据管理',2,'Database','exportlist','',0,'1','icon-tabicons_01_04'),(70,'备份数据库',69,'Database','exportlist','',0,'1','icon-tabicons_08_09'),(71,'还原数据库',69,'Database','importlist','',0,'1','icon-tabicons_03_07'),(73,'文本消息',72,'MessageText','index','',1,'1','icon-tabicons_13_06'),(75,'图片消息',72,'MessageImage','index','',1,'1','icon-tabicons_14_07'),(76,'图文消息',72,'MessageNews','index','',1,'1','icon-tabicons_13_14'),(77,'消息池管理',3,'MessagePool','null','',0,'1','icon-tabicons_04_14'),(78,'消息包管理',77,'MessageBag','index','',0,'1','icon-tabicons_01_18'),(79,'消息池配置',77,'MessagePool','index','',0,'1','icon-tabicons_02_15'),(85,'分类管理',83,'Category','categoryList','',0,'1','icon-tabicons_01_07'),(83,'全局管理',3,'Global','index','',0,'1','icon-tabicons_06_02'),(84,'素材池管理',83,'MediaId','index','',0,'1','icon-tabicons_08_01');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msg_bag`
--

DROP TABLE IF EXISTS `msg_bag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msg_bag` (
  `msg_bag_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `msg_json` text,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`msg_bag_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msg_bag`
--

LOCK TABLES `msg_bag` WRITE;
/*!40000 ALTER TABLE `msg_bag` DISABLE KEYS */;
INSERT INTO `msg_bag` VALUES (17,'只有一个图片的消息包','撒地方','[{\"uuid\":\"1442364805200_5759\",\"msg_type\":\"image\",\"interval\":\"00:00\",\"msg_id\":\"73\"}]',1442364813);
/*!40000 ALTER TABLE `msg_bag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msg_base`
--

DROP TABLE IF EXISTS `msg_base`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msg_base` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `msg_type` varchar(45) DEFAULT NULL,
  `catid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msg_base`
--

LOCK TABLES `msg_base` WRITE;
/*!40000 ALTER TABLE `msg_base` DISABLE KEYS */;
INSERT INTO `msg_base` VALUES (73,'个地方官',1441609277,'image',8),(75,'史蒂芬孙',1442391008,'image',9),(76,'撒地方',1442565337,'text',10),(77,'sdfsdf',1442568608,'text',8),(78,'sdfsdf撒地方是否',1442568619,'text',9);
/*!40000 ALTER TABLE `msg_base` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msg_image`
--

DROP TABLE IF EXISTS `msg_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msg_image` (
  `base_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `image_url_lt` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`base_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msg_image`
--

LOCK TABLES `msg_image` WRITE;
/*!40000 ALTER TABLE `msg_image` DISABLE KEYS */;
INSERT INTO `msg_image` VALUES (75,'/wechat/Upload/files/Chrysanthemum.jpg','/wechat/Upload/thumbs/files/Chrysanthemum.jpg'),(73,'/wechat/Upload/files/c2e63.jpg','/wechat/Upload/thumbs/files/c2e63.jpg');
/*!40000 ALTER TABLE `msg_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msg_news`
--

DROP TABLE IF EXISTS `msg_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msg_news` (
  `base_id` int(11) NOT NULL,
  `item_ids` text,
  PRIMARY KEY (`base_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msg_news`
--

LOCK TABLES `msg_news` WRITE;
/*!40000 ALTER TABLE `msg_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `msg_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msg_pool`
--

DROP TABLE IF EXISTS `msg_pool`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msg_pool` (
  `pool_id` int(11) NOT NULL AUTO_INCREMENT,
  `fire_event` varchar(45) DEFAULT NULL,
  `rule_json` text,
  `msg_bag_json` text,
  `create_time` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pool_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msg_pool`
--

LOCK TABLES `msg_pool` WRITE;
/*!40000 ALTER TABLE `msg_pool` DISABLE KEYS */;
INSERT INTO `msg_pool` VALUES (11,'click_menu','[{\"uuid\":\"1442367669807_8432\",\"tag\":\"\\u6492\\u5730\\u65b9\",\"opt\":\"EQ\",\"val\":\"\\u6492\\u5730\\u65b9\"},{\"uuid\":\"1442458349961_1186\",\"tag\":\"\\u51e1\\u4e8b\\u90fd\",\"opt\":\"BTW\",\"val\":\"10,12\"}]','[{\"uuid\":\"1442367673811_7288\",\"msg_bag_id\":\"17\",\"prob\":\"0.00\",\"freq\":\"00:00\"}]',1442367675,'撒地方','撒地方');
/*!40000 ALTER TABLE `msg_pool` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msg_text`
--

DROP TABLE IF EXISTS `msg_text`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msg_text` (
  `base_id` int(11) NOT NULL,
  `content` tinytext,
  PRIMARY KEY (`base_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msg_text`
--

LOCK TABLES `msg_text` WRITE;
/*!40000 ALTER TABLE `msg_text` DISABLE KEYS */;
INSERT INTO `msg_text` VALUES (78,'发斯蒂芬'),(77,'sdfsdf'),(76,'撒地方撒地方是的');
/*!40000 ALTER TABLE `msg_text` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `new_table`
--

DROP TABLE IF EXISTS `new_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `new_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `avatar_id` int(11) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `new_table`
--

LOCK TABLES `new_table` WRITE;
/*!40000 ALTER TABLE `new_table` DISABLE KEYS */;
INSERT INTO `new_table` VALUES (1,1,'史蒂芬孙',1,1,'发斯蒂芬',2),(2,1,'史蒂芬孙',1,1,'发斯蒂芬',1),(3,1,'史蒂芬孙',1,1,'发斯蒂芬',4),(4,1,'史蒂芬孙',1,1,'发斯蒂芬',3),(5,1,'史蒂芬孙',2,1,'发斯蒂芬',5),(6,1,'史蒂芬孙',2,1,'发斯蒂芬',6),(7,2,'史蒂芬孙',2,1,'发斯蒂芬',8),(8,3,'史蒂芬孙',2,1,'发斯蒂芬',7),(9,1,'sdfsdf',1,1,NULL,2);
/*!40000 ALTER TABLE `new_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_item`
--

DROP TABLE IF EXISTS `news_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_item` (
  `news_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `intro` varchar(255) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `content` text,
  `jump_url` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`news_item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_item`
--

LOCK TABLES `news_item` WRITE;
/*!40000 ALTER TABLE `news_item` DISABLE KEYS */;
INSERT INTO `news_item` VALUES (8,'公司东风公司法国','的双方各','/wechat/Upload/files/Chrysanthemum.jpg','&lt;p&gt;撒地方公司的风格&lt;/p&gt;\r\n','',1441604463),(9,'史蒂夫史蒂夫','史蒂夫史蒂夫','/wechat/Upload/files/c2e63.jpg','&lt;h2&gt;&lt;strong&gt;史蒂夫史蒂夫撒地方是的撒地方&lt;/strong&gt;&lt;/h2&gt;\r\n','',1441604536),(10,'复合弓灌灌灌灌灌灌灌灌灌','方灌灌灌灌灌哥哥哥哥哥哥哥哥哥哥哥','/wechat/Upload/files/79a00895gw1etw7oy1ky4g204b02ex6p.gif','&lt;p&gt;法国恢复规划法规和法国恢复规划法国恢复&lt;/p&gt;\r\n','',1441604804),(11,'大范甘迪发公司分公司地方官是大法官','撒地方公司的风格','/wechat/Upload/files/79a00895gw1etw7s217thg206o03vnik.gif','&lt;p&gt;撒地方公司的风格&lt;/p&gt;\r\n','',1441610022);
/*!40000 ALTER TABLE `news_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page` (
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `uuid` varchar(40) NOT NULL,
  `title` varchar(160) NOT NULL,
  `keywords` varchar(40) NOT NULL,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page`
--

LOCK TABLES `page` WRITE;
/*!40000 ALTER TABLE `page` DISABLE KEYS */;
/*!40000 ALTER TABLE `page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting` (
  `key` varchar(50) NOT NULL,
  `value` varchar(5000) DEFAULT '',
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting`
--

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` VALUES ('SITE_TITLE','微信后台管理');
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `times`
--

DROP TABLE IF EXISTS `times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `times` (
  `username` char(40) NOT NULL,
  `ip` char(15) NOT NULL,
  `logintime` int(10) unsigned NOT NULL DEFAULT '0',
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `times` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`,`isadmin`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `times`
--

LOCK TABLES `times` WRITE;
/*!40000 ALTER TABLE `times` DISABLE KEYS */;
/*!40000 ALTER TABLE `times` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'wd'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-09-18 17:55:03
