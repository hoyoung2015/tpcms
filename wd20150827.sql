-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: wd
-- ------------------------------------------------------
-- Server version	5.6.17

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
INSERT INTO `admin` VALUES (1,'admin','6af16a2c7485335013ff41a38dabe681',1,'AETsyO','127.0.0.1',1440637284,'admin@admin.com','');
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_log`
--

LOCK TABLES `admin_log` WRITE;
/*!40000 ALTER TABLE `admin_log` DISABLE KEYS */;
INSERT INTO `admin_log` VALUES (1,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36','mrg5umq3i99aibpbg60g7r6ne1','127.0.0.1','2015-08-26 23:36:07','login'),(2,1,'admin','Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E; InfoPath.3)','r2ppc36nl8mrdha2jtj349ae21','127.0.0.1','2015-08-27 00:36:53','login'),(3,1,'admin','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.155 Safari/537.36','8uug9348cl9sqnsd9c5rikq2b6','127.0.0.1','2015-08-27 09:01:24','login');
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
  `model` varchar(50) NOT NULL DEFAULT 'article' COMMENT '模型',
  `setting` text,
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁用',
  `ismenu` tinyint(1) NOT NULL DEFAULT '1' COMMENT '前台显示',
  PRIMARY KEY (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
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
  PRIMARY KEY (`id`),
  KEY `listorder` (`listorder`),
  KEY `parentid` (`parentid`),
  KEY `module` (`c`,`a`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'首页',0,'Admin','top','',1,'1'),(2,'系统管理',0,'System','top','',2,'1'),(3,'微信管理',0,'Content','top','',3,'1'),(6,'安全记录',1,'Admin','userLeft','',0,'1'),(7,'登录日志',6,'Admin','loginLog','',1,'1'),(8,'删除登录日志',7,'Admin','loginLogDelete','',1,'1'),(9,'系统设置',2,'System','settingLeft','',1,'1'),(10,'系统设置',9,'System','setting','',1,'1'),(11,'菜单设置',9,'System','menuList','',2,'1'),(12,'查看列表',11,'System','menuViewList','',0,'1'),(13,'添加菜单',11,'System','menuAdd','',0,'1'),(14,'修改菜单',11,'System','menuEdit','',0,'1'),(15,'删除菜单',11,'System','menuDelete','',0,'1'),(16,'菜单排序',11,'System','menuOrder','',0,'1'),(17,'菜单导出',11,'System','menuExport','',0,'1'),(18,'菜单导入',11,'System','menuImport','',0,'1'),(19,'用户设置',2,'Admin','left','',2,'1'),(20,'用户管理',19,'Admin','memberList','',1,'1'),(21,'查看列表',20,'Admin','memberViewList','',0,'1'),(22,'添加用户',20,'Admin','memberAdd','',0,'1'),(23,'编辑用户',20,'Admin','memberEdit','',0,'1'),(24,'删除用户',20,'Admin','memberDelete','',0,'1'),(25,'角色管理',19,'Admin','roleList','',2,'1'),(26,'查看列表',25,'Admin','roleViewList','',0,'1'),(27,'添加角色',25,'Admin','roleAdd','',0,'1'),(28,'编辑角色',25,'Admin','roleEdit','',0,'1'),(29,'删除角色',25,'Admin','roleDelete','',0,'1'),(30,'角色排序',25,'Admin','roleOrder','',0,'1'),(31,'权限设置',25,'Admin','rolePermission','',0,'1'),(32,'栏目权限',25,'Admin','roleCategory','',0,'1'),(33,'系统记录',2,'System','recordLeft','',3,'1'),(34,'日志管理',33,'System','logList','',3,'1'),(35,'查看列表',34,'System','logViewList','',0,'1'),(36,'删除日志',34,'System','logDelete','',0,'1'),(37,'缓存管理',33,'System','fileList','',1,'1'),(72,'消息素材',3,'Message','left','',0,'1'),(39,'内容管理',38,'Content','index','',0,'1'),(40,'栏目管理',38,'Category','categoryList','',0,'1'),(41,'查看列表',40,'Category','categoryViewList','',0,'1'),(42,'添加栏目',40,'Category','categoryAdd','',0,'1'),(43,'编辑栏目',40,'Category','categoryEdit','',0,'1'),(44,'删除栏目',40,'Category','categoryDelete','',0,'1'),(45,'栏目排序',40,'Category','categoryOrder','',0,'1'),(46,'栏目导出',40,'Category','categoryExport','',0,'1'),(47,'栏目导入',40,'Category','categoryImport','',0,'1'),(48,'会员中心',3,'Member','left','',1,'1'),(49,'会员列表',48,'Member','memberList','',0,'1'),(50,'会员分类',48,'Member','typeList','',0,'1'),(51,'查看列表',49,'Member','memberViewList','',0,'1'),(52,'添加会员',49,'Member','memberAdd','',0,'1'),(53,'编辑用户',49,'Member','memberEdit','',0,'1'),(54,'删除用户',49,'Member','memberDelete','',0,'1'),(55,'用户详情',49,'Member','memberView','',0,'1'),(56,'添加分类',50,'Member','typeAdd','',0,'1'),(57,'编辑分类',50,'Member','typeEdit','',0,'1'),(58,'删除分类',50,'Member','typeDelete','',0,'1'),(59,'分类排序',50,'Member','typeOrder','',0,'1'),(60,'查看列表',50,'Member','typeViewList','',0,'1'),(61,'重置密码',20,'Admin','memberResetPassword','',0,'1'),(62,'重置密码',49,'Member','memberResetPassword','',0,'1'),(63,'邮件模版',9,'System','email','',3,'1'),(64,'模版添加',63,'System','emailAdd','',0,'1'),(65,'模版编辑',63,'System','emailEdit','',0,'1'),(66,'模版删除',63,'System','emailDelete','',0,'1'),(67,'模版列表',63,'System','emailList','',0,'1'),(68,'上传管理',38,'Storage','index','',0,'1'),(69,'数据管理',2,'Database','exportlist','',0,'1'),(70,'备份数据库',69,'Database','exportlist','',0,'1'),(71,'还原数据库',69,'Database','importlist','',0,'1'),(73,'文本消息',72,'MessageText','textlist','',0,'1'),(74,'文本列表',73,'MessageText','list','',0,'1'),(75,'图片消息',72,'MessageImage','left','',0,'1'),(76,'图文消息',72,'MessageNews','infolist','',0,'1');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msg_news`
--

DROP TABLE IF EXISTS `msg_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msg_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `cover` int(11) DEFAULT NULL COMMENT '封面，是媒体表media的id',
  `intro` varchar(255) DEFAULT NULL,
  `content` tinytext,
  `jump_url` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `cate_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msg_news`
--

LOCK TABLES `msg_news` WRITE;
/*!40000 ALTER TABLE `msg_news` DISABLE KEYS */;
INSERT INTO `msg_news` VALUES (1,'个地方官','电饭锅地方',1,'的风格的风格的风格','电饭锅地方鬼地方工地',NULL,1440664037,NULL);
/*!40000 ALTER TABLE `msg_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msg_text`
--

DROP TABLE IF EXISTS `msg_text`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msg_text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `content` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `cate_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2054 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msg_text`
--

LOCK TABLES `msg_text` WRITE;
/*!40000 ALTER TABLE `msg_text` DISABLE KEYS */;
INSERT INTO `msg_text` VALUES (2053,'gdfg ','dfgfdsdf ',1440664037,NULL);
/*!40000 ALTER TABLE `msg_text` ENABLE KEYS */;
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

-- Dump completed on 2015-08-27 17:27:48
