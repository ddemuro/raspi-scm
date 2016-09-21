/*
Navicat MySQL Data Transfer

Source Server         : DerekDemuro LOCAL
Source Server Version : 50531
Source Host           : 192.168.5.21:3306
Source Database       : takecms

Target Server Type    : MYSQL
Target Server Version : 50531
File Encoding         : 65001

Date: 2013-08-26 17:20:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `Activity`
-- ----------------------------
DROP TABLE IF EXISTS `Activity`;
CREATE TABLE `Activity` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(125) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `type` char(30) NOT NULL DEFAULT '',
  `userid` bigint(255) NOT NULL DEFAULT '0',
  `created` bigint(255) NOT NULL DEFAULT '0',
  `Message` text,
  `params` text,
  `projectid` bigint(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `userid` (`userid`),
  KEY `projectid` (`projectid`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `ActivityLog`
-- ----------------------------
DROP TABLE IF EXISTS `ActivityLog`;
CREATE TABLE `ActivityLog` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `event` text,
  `page` varchar(100) DEFAULT NULL,
  `date_t` datetime NOT NULL,
  `member` bigint(255) NOT NULL,
  PRIMARY KEY (`id`,`member`),
  UNIQUE KEY `Index_Member_Id` (`id`,`member`) USING BTREE,
  KEY `FK_member_Member_id` (`member`),
  CONSTRAINT `FK_member_Member_id` FOREIGN KEY (`member`) REFERENCES `Members` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for `AuthAssignment`
-- ----------------------------
DROP TABLE IF EXISTS `AuthAssignment`;
CREATE TABLE `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `AuthItem`
-- ----------------------------
DROP TABLE IF EXISTS `AuthItem`;
CREATE TABLE `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `AuthItemChild`
-- ----------------------------
DROP TABLE IF EXISTS `AuthItemChild`;
CREATE TABLE `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `BlogCats`
-- ----------------------------
DROP TABLE IF EXISTS `BlogCats`;
CREATE TABLE `BlogCats` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `parentid` bigint(255) DEFAULT NULL,
  `title` varchar(155) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `language` varchar(125) NOT NULL DEFAULT '',
  `position` bigint(255) NOT NULL DEFAULT '0',
  `metadesc` varchar(255) NOT NULL DEFAULT '',
  `metakeys` varchar(255) NOT NULL DEFAULT '',
  `readonly` tinyint(1) NOT NULL DEFAULT '0',
  `viewperms` text,
  `addpostsperms` text,
  `addcommentsperms` text,
  `addfilesperms` text,
  `autoaddperms` text,
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `parentid` (`parentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `BlogComments`
-- ----------------------------
DROP TABLE IF EXISTS `BlogComments`;
CREATE TABLE `BlogComments` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `postid` varchar(125) NOT NULL DEFAULT '',
  `authorid` bigint(255) NOT NULL DEFAULT '0',
  `postdate` datetime NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  `comment` text,
  PRIMARY KEY (`id`),
  KEY `postid` (`postid`),
  KEY `authorid` (`authorid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `BlogPosts`
-- ----------------------------
DROP TABLE IF EXISTS `BlogPosts`;
CREATE TABLE `BlogPosts` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `catid` bigint(255) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `content` text,
  `alias` varchar(125) NOT NULL DEFAULT '',
  `language` varchar(125) NOT NULL DEFAULT '',
  `metadesc` varchar(255) NOT NULL DEFAULT '',
  `metakeys` varchar(255) NOT NULL DEFAULT '',
  `views` bigint(255) NOT NULL DEFAULT '0',
  `rating` bigint(255) NOT NULL DEFAULT '0',
  `totalvotes` bigint(255) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `authorid` bigint(255) NOT NULL DEFAULT '0',
  `postdate` datetime NOT NULL,
  `last_updated_date` datetime NOT NULL,
  `last_updated_author` bigint(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `catid` (`catid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Categories`
-- ----------------------------
DROP TABLE IF EXISTS `Categories`;
CREATE TABLE `Categories` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `ClientHosting`
-- ----------------------------
DROP TABLE IF EXISTS `ClientHosting`;
CREATE TABLE `ClientHosting` (
  `id` bigint(255) NOT NULL,
  `hostingservers` bigint(255) NOT NULL,
  `memberid` bigint(255) NOT NULL,
  `domainid` bigint(255) NOT NULL,
  `active` bit(1) NOT NULL,
  `date` date NOT NULL,
  `details` text,
  PRIMARY KEY (`id`),
  KEY `FK_ClientHosting_HostingServer` (`hostingservers`),
  KEY `FK_ClientHosting_Member` (`memberid`),
  KEY `FK_ClientHosting_Domain` (`domainid`),
  CONSTRAINT `FK_ClientHosting_HostingServer` FOREIGN KEY (`hostingservers`) REFERENCES `HostingServers` (`id`),
  CONSTRAINT `FK_ClientHosting_Member` FOREIGN KEY (`memberid`) REFERENCES `Members` (`id`),
  CONSTRAINT `FK_ClientHosting_Domain` FOREIGN KEY (`domainid`) REFERENCES `Domains` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `ClientDNS`
-- ----------------------------
DROP TABLE IF EXISTS `ClientDNS`;
CREATE TABLE `ClientDNS` (
  `id` bigint(255) NOT NULL,
  `members_id` bigint(255) NOT NULL,
  `ipaddress` varchar(90) NOT NULL,
  `nameserver` varchar(12) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ClientDNS_Members` (`members_id`),
  CONSTRAINT `FK_ClientDNS_Members` FOREIGN KEY (`members_id`) REFERENCES `Members` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Company`
-- ----------------------------
DROP TABLE IF EXISTS `Company`;
CREATE TABLE `Company` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `username` bigint(255) NOT NULL,
  `companyname` char(15) NOT NULL,
  `ctype` float(3,0) DEFAULT NULL,
  `phone` varchar(12) NOT NULL,
  `address` varchar(255) NOT NULL,
  `country` int(255) DEFAULT NULL,
  `details` char(100) DEFAULT NULL,
  `rut` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Company_Member` (`username`),
  KEY `FK_Company_Country` (`country`),
  CONSTRAINT `FK_Company_Country` FOREIGN KEY (`country`) REFERENCES `Countries` (`country_id`),
  CONSTRAINT `FK_Company_Members` FOREIGN KEY (`username`) REFERENCES `Members` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `ContactUs`
-- ----------------------------
DROP TABLE IF EXISTS `ContactUs`;
CREATE TABLE `ContactUs` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL DEFAULT '',
  `email` varchar(55) NOT NULL DEFAULT '',
  `subject` varchar(55) NOT NULL DEFAULT '',
  `content` text,
  `postdate` datetime NOT NULL,
  `sread` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `subject` (`subject`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Countries`
-- ----------------------------
DROP TABLE IF EXISTS `Countries`;
CREATE TABLE `Countries` (
  `country_id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`country_id`),
  KEY `FK_Autoincrement` (`country_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `CustomPages`
-- ----------------------------
DROP TABLE IF EXISTS `CustomPages`;
CREATE TABLE `CustomPages` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `content` longtext,
  `dateposted` datetime NOT NULL,
  `authorid` bigint(255) NOT NULL DEFAULT '0',
  `last_edited_date` datetime NOT NULL,
  `last_edited_author` bigint(255) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL DEFAULT '',
  `language` varchar(125) NOT NULL DEFAULT '',
  `metadesc` varchar(255) NOT NULL DEFAULT '',
  `metakeys` varchar(255) NOT NULL DEFAULT '',
  `visible` text,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`,`language`),
  KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `DataCenter`
-- ----------------------------
DROP TABLE IF EXISTS `DataCenter`;
CREATE TABLE `DataCenter` (
  `id` bigint(255) NOT NULL,
  `country` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(150) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `supportmail` varchar(90) DEFAULT NULL,
  `skype` varchar(12) DEFAULT NULL,
  `adminaccount` varchar(90) DEFAULT NULL,
  `adminpassword` varchar(90) DEFAULT NULL,
  `website` varchar(90) DEFAULT NULL,
  `webpanel` varchar(90) DEFAULT NULL,
  `apikey` text,
  `details` text,
  PRIMARY KEY (`id`),
  KEY `FK_DataCenter_Country` (`country`),
  CONSTRAINT `FK_DataCenter_Country` FOREIGN KEY (`country`) REFERENCES `Countries` (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Deposit`
-- ----------------------------
DROP TABLE IF EXISTS `Deposit`;
CREATE TABLE `Deposit` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `address` varchar(900) NOT NULL,
  `phone` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Documentations`
-- ----------------------------
DROP TABLE IF EXISTS `Documentations`;
CREATE TABLE `Documentations` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(125) NOT NULL DEFAULT '',
  `mkey` varchar(125) NOT NULL DEFAULT '',
  `description` varchar(125) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `type` char(30) NOT NULL DEFAULT '',
  `language` char(30) NOT NULL DEFAULT '',
  `last_updated` datetime NOT NULL,
  `last_updated_member` bigint(255) NOT NULL DEFAULT '0',
  `views` bigint(255) NOT NULL DEFAULT '0',
  `rating` bigint(255) NOT NULL DEFAULT '0',
  `totalvotes` bigint(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `mkey` (`mkey`),
  KEY `language` (`language`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Documentations_Comments`
-- ----------------------------
DROP TABLE IF EXISTS `Documentations_Comments`;
CREATE TABLE `Documentations_Comments` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `docid` varchar(125) NOT NULL DEFAULT '',
  `authorid` bigint(255) NOT NULL DEFAULT '0',
  `postdate` datetime NOT NULL,
  `comment` text,
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `docid` (`docid`),
  KEY `authorid` (`authorid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Domains`
-- ----------------------------
DROP TABLE IF EXISTS `Domains`;
CREATE TABLE `Domains` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(255) NOT NULL,
  `registrarcontact` bigint(255) NOT NULL,
  `administrativecontact` bigint(255) NOT NULL,
  `technicalcontact` bigint(255) NOT NULL,
  `billingcontact` bigint(255) NOT NULL,
  `domain` varchar(125) NOT NULL DEFAULT '',
  `tld` int(10) NOT NULL DEFAULT '0',
  `expiredate` date NOT NULL,
  `registerdate` date NOT NULL,
  `active` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `domain` (`domain`) USING BTREE,
  KEY `FK1_Domains_Members` (`registrarcontact`),
  KEY `FK2_Domains_Members` (`administrativecontact`),
  KEY `FK3_Domains_Members` (`billingcontact`),
  KEY `FK4_Domains_Members` (`technicalcontact`),
  KEY `tld` (`tld`),
  KEY `member_id` (`member_id`),
  CONSTRAINT `FK1_Domains_Members` FOREIGN KEY (`registrarcontact`) REFERENCES `MemberDetails` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `FK2_Domains_Members` FOREIGN KEY (`administrativecontact`) REFERENCES `MemberDetails` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `FK3_Domains_Members` FOREIGN KEY (`billingcontact`) REFERENCES `MemberDetails` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `FK4_Domains_Members` FOREIGN KEY (`technicalcontact`) REFERENCES `MemberDetails` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `FK_Domains_Members` FOREIGN KEY (`member_id`) REFERENCES `Members` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `DomainDNS`
-- ----------------------------
DROP TABLE IF EXISTS `DomainDNS`;
CREATE TABLE `DomainDNS` (
  `domains_id` bigint(255) NOT NULL,
  `client_dns_id` bigint(255) NOT NULL,
  PRIMARY KEY (`domains_id`),
  KEY `FK_DomainDNS_domain` (`domains_id`),
  KEY `FK_DomainDNS_dns` (`client_dns_id`),
  CONSTRAINT `FK_DomainDNS_dns` FOREIGN KEY (`client_dns_id`) REFERENCES `ClientDNS` (`id`),
  CONSTRAINT `FK_DomainDNS_domain` FOREIGN KEY (`domains_id`) REFERENCES `Domains` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `ErrorHandler`
-- ----------------------------
DROP TABLE IF EXISTS `ErrorHandler`;
CREATE TABLE `ErrorHandler` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `page` text,
  `details` text,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Extensions`
-- ----------------------------
DROP TABLE IF EXISTS `Extensions`;
CREATE TABLE `Extensions` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `catid` bigint(255) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `content` text,
  `alias` varchar(125) NOT NULL DEFAULT '',
  `language` varchar(125) NOT NULL DEFAULT '',
  `metadesc` varchar(255) NOT NULL DEFAULT '',
  `metakeys` varchar(255) NOT NULL DEFAULT '',
  `views` bigint(255) NOT NULL DEFAULT '0',
  `rating` bigint(255) NOT NULL DEFAULT '0',
  `totalvotes` bigint(255) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `authorid` bigint(255) NOT NULL DEFAULT '0',
  `postdate` bigint(255) NOT NULL DEFAULT '0',
  `last_updated_date` bigint(255) NOT NULL DEFAULT '0',
  `last_updated_author` bigint(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `catid` (`catid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `ExtensionsCats`
-- ----------------------------
DROP TABLE IF EXISTS `ExtensionsCats`;
CREATE TABLE `ExtensionsCats` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `parentid` bigint(255) DEFAULT NULL,
  `title` varchar(155) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `language` varchar(125) NOT NULL DEFAULT '',
  `position` bigint(255) NOT NULL DEFAULT '0',
  `metadesc` varchar(255) NOT NULL DEFAULT '',
  `metakeys` varchar(255) NOT NULL DEFAULT '',
  `readonly` tinyint(1) NOT NULL DEFAULT '0',
  `viewperms` text,
  `addpostsperms` text,
  `addcommentsperms` text,
  `addfilesperms` text,
  `autoaddperms` text,
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `parentid` (`parentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `ExtensionsComments`
-- ----------------------------
DROP TABLE IF EXISTS `ExtensionsComments`;
CREATE TABLE `ExtensionsComments` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `postid` datetime NOT NULL,
  `authorid` bigint(255) NOT NULL DEFAULT '0',
  `postdate` datetime NOT NULL,
  `visible` bit(1) NOT NULL,
  `comment` text,
  PRIMARY KEY (`id`),
  KEY `postid` (`postid`),
  KEY `authorid` (`authorid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `ExtensionsFiles`
-- ----------------------------
DROP TABLE IF EXISTS `ExtensionsFiles`;
CREATE TABLE `ExtensionsFiles` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `extensionid` bigint(255) NOT NULL DEFAULT '0',
  `authorid` bigint(255) NOT NULL DEFAULT '0',
  `postdate` bigint(255) NOT NULL DEFAULT '0',
  `size` bigint(255) NOT NULL DEFAULT '0',
  `type` char(10) NOT NULL DEFAULT '',
  `mime` varchar(125) NOT NULL DEFAULT '',
  `location` varchar(125) NOT NULL DEFAULT '',
  `realname` varchar(125) NOT NULL DEFAULT '',
  `alias` varchar(125) NOT NULL DEFAULT '',
  `description` varchar(125) NOT NULL DEFAULT '',
  `downloads` bigint(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `extensionid` (`extensionid`),
  KEY `authorid` (`authorid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `ForumPosts`
-- ----------------------------
DROP TABLE IF EXISTS `ForumPosts`;
CREATE TABLE `ForumPosts` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `topicid` bigint(255) NOT NULL DEFAULT '0',
  `authorid` bigint(255) NOT NULL DEFAULT '0',
  `dateposted` datetime NOT NULL,
  `visible` bit(1) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `ForumTopics`
-- ----------------------------
DROP TABLE IF EXISTS `ForumTopics`;
CREATE TABLE `ForumTopics` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(125) NOT NULL DEFAULT '',
  `alias` varchar(250) NOT NULL DEFAULT '',
  `dateposted` datetime NOT NULL,
  `authorid` bigint(255) NOT NULL DEFAULT '0',
  `language` char(3) NOT NULL DEFAULT '',
  `views` bigint(255) NOT NULL DEFAULT '0',
  `replies` bigint(255) NOT NULL DEFAULT '0',
  `lastpostdate` datetime NOT NULL,
  `lastpostauthorid` bigint(255) NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  `content` text,
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `alias` (`alias`),
  KEY `language` (`language`),
  KEY `lastpostdate` (`lastpostdate`),
  KEY `dateposted` (`dateposted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `HostingServers`
-- ----------------------------
DROP TABLE IF EXISTS `HostingServers`;
CREATE TABLE `HostingServers` (
  `id` bigint(255) NOT NULL,
  `country` int(255) NOT NULL,
  `server_name` varchar(255) NOT NULL,
  `ipaddress1` varchar(90) NOT NULL,
  `nameserver1` varchar(12) NOT NULL,
  `ipaddress2` varchar(90) DEFAULT NULL,
  `nameserver2` varchar(12) DEFAULT NULL,
  `ipaddress3` varchar(90) DEFAULT NULL,
  `nameserver3` varchar(12) DEFAULT NULL,
  `ipaddress4` varchar(90) DEFAULT NULL,
  `nameserver4` varchar(12) DEFAULT NULL,
  `panel` int(12) DEFAULT NULL,
  `apikey` text,
  `details` text,
  PRIMARY KEY (`id`),
  KEY `FK_HostingServers_Country` (`country`),
  CONSTRAINT `FK_HostingServers_Country` FOREIGN KEY (`country`) REFERENCES `Countries` (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Invoice`
-- ----------------------------
DROP TABLE IF EXISTS `Invoice`;
CREATE TABLE `Invoice` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `idOrder` bigint(255) NOT NULL,
  `username` bigint(255) NOT NULL DEFAULT '0',
  `memberdetails` bigint(255) NOT NULL DEFAULT '0',
  `date` bigint(255) NOT NULL DEFAULT '0',
  `rut` int(30) NOT NULL DEFAULT '0',
  `ammount` float NOT NULL,
  `tax` float NOT NULL,
  `total` float NOT NULL,
  `address` varchar(900) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `Invoicenumber` int(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Invoice_Members` (`username`),
  KEY `FK_Invoice_Order` (`idOrder`),
  KEY `FK_Invoice_Memdetails` (`memberdetails`),
  CONSTRAINT `FK_Invoice_Members` FOREIGN KEY (`username`) REFERENCES `Members` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_Invoice_Memdetails` FOREIGN KEY (`memberdetails`) REFERENCES `MemberDetails` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_Invoice_Order` FOREIGN KEY (`idOrder`) REFERENCES `Order` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `InvoiceDetails`
-- ----------------------------
DROP TABLE IF EXISTS `InvoiceDetails`;
CREATE TABLE `InvoiceDetails` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `idProduct` bigint(255) NOT NULL,
  `idService` bigint(255) NOT NULL DEFAULT '0',
  `idInvoice` bigint(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Invoice_Details` (`idInvoice`),
  CONSTRAINT `FK_Invoice_Details` FOREIGN KEY (`idInvoice`) REFERENCES `Invoice` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `MemberDetails`
-- ----------------------------
DROP TABLE IF EXISTS `MemberDetails`;
CREATE TABLE `MemberDetails` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `username` bigint(255) NOT NULL,
  `type` int(3) DEFAULT NULL,
  `firstname` text,
  `lastname` text,
  `organizationname` text,
  `address1` text,
  `address2` text,
  `city` text,
  `email` text,
  `stateprovince` text,
  `zippostalcode` text,
  `phonenumber` int(15) NOT NULL DEFAULT '0',
  `cellphonenumber` int(15) NOT NULL DEFAULT '0',
  `faxnumber` int(15) NOT NULL DEFAULT '0',
  `jobtitle` text,
  `country` int(255) NOT NULL,
  `Company` bigint(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `Company` (`Company`),
  KEY `Country` (`country`),
  CONSTRAINT `FK_MembersDetails_Company` FOREIGN KEY (`Company`) REFERENCES `Company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_MembersDetails_Country` FOREIGN KEY (`country`) REFERENCES `Countries` (`country_id`) ON DELETE NO ACTION,
  CONSTRAINT `FK_MembersDetails_Members` FOREIGN KEY (`username`) REFERENCES `Members` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Members`
-- ----------------------------
DROP TABLE IF EXISTS `Members`;
CREATE TABLE `Members` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(155) NOT NULL DEFAULT '',
  `email` varchar(155) NOT NULL DEFAULT '',
  `password` varchar(40) NOT NULL DEFAULT '',
  `joined` datetime NOT NULL,
  `data` text,
  `passwordreset` char(40) NOT NULL DEFAULT '',
  `role` char(30) NOT NULL DEFAULT 'User',
  `ipaddress` char(30) NOT NULL DEFAULT '',
  `seoname` varchar(155) NOT NULL DEFAULT '',
  `fbuid` bigint(255) NOT NULL DEFAULT '0',
  `fbtoken` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `MembersMail`
-- ----------------------------
DROP TABLE IF EXISTS `MembersMail`;
CREATE TABLE `MembersMail` (
  `usernamefrom` bigint(255) NOT NULL DEFAULT '0',
  `usernameto` bigint(255) NOT NULL DEFAULT '0',
  `messagesubject` longtext NOT NULL,
  `message` longtext NOT NULL,
  `ubication` int(3) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`usernamefrom`,`usernameto`,`date`),
  KEY `FK_MembersMail_Membersfrom` (`usernamefrom`),
  KEY `FK_MembersMail_Membersto` (`usernameto`),
  CONSTRAINT `FK_MembersMail_Membersfrom` FOREIGN KEY (`usernamefrom`) REFERENCES `Members` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `FK_MembersMail_Membersto` FOREIGN KEY (`usernameto`) REFERENCES `Members` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Menu`
-- ----------------------------
DROP TABLE IF EXISTS `Menu`;
CREATE TABLE `Menu` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(128) DEFAULT NULL,
  `view_page` varchar(128) DEFAULT NULL,
  `url` varchar(128) DEFAULT NULL,
  `description` text,
  `status` int(10) DEFAULT NULL,
  `position` int(10) DEFAULT NULL,
  `parent` int(10) DEFAULT NULL,
  `menu_id` int(100) NOT NULL,
  `accesscheck` varchar(128) DEFAULT NULL,
  `translation` varchar(128) DEFAULT NULL,
  `linkoptions` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Message`
-- ----------------------------
DROP TABLE IF EXISTS `Message`;
CREATE TABLE `Message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(16) NOT NULL DEFAULT '',
  `translation` text,
  PRIMARY KEY (`id`,`language`),
  CONSTRAINT `FK_Message_SourceMessage` FOREIGN KEY (`id`) REFERENCES `SourceMessage` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Milestones`
-- ----------------------------
DROP TABLE IF EXISTS `Milestones`;
CREATE TABLE `Milestones` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(125) NOT NULL DEFAULT '',
  `alias` varchar(125) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `News`
-- ----------------------------
DROP TABLE IF EXISTS `News`;
CREATE TABLE `News` (
  `id` bigint(255) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `news` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Newsletter`
-- ----------------------------
DROP TABLE IF EXISTS `Newsletter`;
CREATE TABLE `Newsletter` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `email` varchar(125) NOT NULL DEFAULT '',
  `joined` bigint(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `joined` (`joined`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Order`
-- ----------------------------
DROP TABLE IF EXISTS `Order`;
CREATE TABLE `Order` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `username_id` bigint(255) NOT NULL DEFAULT '0',
  `recurrent` int(1) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Order_Members` (`username_id`),
  KEY `id` (`id`),
  CONSTRAINT `FK_Order_Members` FOREIGN KEY (`username_id`) REFERENCES `Members` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `OrderDetails`
-- ----------------------------
DROP TABLE IF EXISTS `OrderDetails`;
CREATE TABLE `OrderDetails` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `idService` bigint(255) DEFAULT NULL,
  `idProduct` bigint(255) DEFAULT NULL,
  `iddomain` bigint(255) DEFAULT NULL,
  `date` datetime NOT NULL,
  `idOrder` bigint(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_OrderDetails_Service` (`idService`),
  KEY `FK_OrderDetails_Domain` (`iddomain`),
  KEY `FK_OrderDetails_Product` (`idProduct`),
  KEY `FK_OrderDetails_idOrder` (`idOrder`) USING BTREE,
  CONSTRAINT `FK_OrderDetails_Domain` FOREIGN KEY (`iddomain`) REFERENCES `Domains` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `FK_OrderDetails_idOrder` FOREIGN KEY (`idOrder`) REFERENCES `Order` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_OrderDetails_Product` FOREIGN KEY (`idProduct`) REFERENCES `Product` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `FK_OrderDetails_Service` FOREIGN KEY (`idService`) REFERENCES `Service` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Payments`
-- ----------------------------
DROP TABLE IF EXISTS `Payments`;
CREATE TABLE `Payments` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `idInvoice` bigint(255) NOT NULL,
  `username_id` bigint(255) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `ammount` float NOT NULL,
  `paymenttype` bigint(255) NOT NULL,
  `checknumber` varchar(100) NOT NULL,
  `receiptnumber` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Payments_Invoice` (`idInvoice`),
  KEY `FK_Payments_Members` (`username_id`),
  CONSTRAINT `FK_Payments_Invoice` FOREIGN KEY (`idInvoice`) REFERENCES `Invoice` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `FK_Payments_Members` FOREIGN KEY (`username_id`) REFERENCES `Members` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Product`
-- ----------------------------
DROP TABLE IF EXISTS `Product`;
CREATE TABLE `Product` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prodname` char(15) DEFAULT NULL,
  `price` float NOT NULL,
  `available` int(1) DEFAULT NULL,
  `details` char(100) DEFAULT NULL,
  `messagecode` varchar(900) DEFAULT NULL,
  `picture` varchar(1000) DEFAULT NULL,
  `picode` varchar(1000) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Projects`
-- ----------------------------
DROP TABLE IF EXISTS `Projects`;
CREATE TABLE `Projects` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(250) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created` date NOT NULL,
  `userid` bigint(255) unsigned NOT NULL DEFAULT '0',
  `description` varchar(125) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Registrar`
-- ----------------------------
DROP TABLE IF EXISTS `Registrar`;
CREATE TABLE `Registrar` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `registrar` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for `RelationMember`
-- ----------------------------
DROP TABLE IF EXISTS `RelationMember`;
CREATE TABLE `RelationMember` (
  `usernamea_id` bigint(255) NOT NULL DEFAULT '0',
  `usernameb_id` bigint(255) NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `Companyid` bigint(255) DEFAULT NULL,
  `approved` bit(1) DEFAULT NULL,
  PRIMARY KEY (`usernamea_id`,`usernameb_id`),
  KEY `FK_RelationMember_Company` (`Companyid`),
  KEY `FK_RelationMember_Membersto` (`usernamea_id`),
  KEY `FK_MembersMail_Membersto` (`usernameb_id`),
  CONSTRAINT `FK_RelationMember_Company` FOREIGN KEY (`Companyid`) REFERENCES `Company` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `FK_RelationMember_Membersa` FOREIGN KEY (`usernamea_id`) REFERENCES `Members` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `FK_RelationMember_Membersb` FOREIGN KEY (`usernameb_id`) REFERENCES `Members` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Requirement`
-- ----------------------------
DROP TABLE IF EXISTS `Requirement`;
CREATE TABLE `Requirement` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `requirement` varchar(1000) DEFAULT NULL,
  `picture` varchar(1000) DEFAULT NULL,
  `username_id` bigint(255) NOT NULL,
  `status` int(3) DEFAULT '3',
  `priority` int(3) DEFAULT '3',
  `type` int(3) DEFAULT '3',
  PRIMARY KEY (`id`),
  KEY `FK_Requirement_Members` (`username_id`),
  CONSTRAINT `FK_Requirement_Members` FOREIGN KEY (`username_id`) REFERENCES `Members` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Service`
-- ----------------------------
DROP TABLE IF EXISTS `Service`;
CREATE TABLE `Service` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `idServiceType` int(255) NOT NULL,
  `servname` char(15) DEFAULT NULL,
  `price` float NOT NULL,
  `currency` char(5) NOT NULL,
  `available` int(1) DEFAULT NULL,
  `details` char(100) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`,`date`),
  KEY `FK_Service_ServiceType` (`idServiceType`),
  CONSTRAINT `FK_Service_ServiceType` FOREIGN KEY (`idServiceType`) REFERENCES `ServiceType` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `ServiceType`
-- ----------------------------
DROP TABLE IF EXISTS `ServiceType`;
CREATE TABLE `ServiceType` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `details` char(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `sessions`
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Settings`
-- ----------------------------
DROP TABLE IF EXISTS `Settings`;
CREATE TABLE `Settings` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(125) NOT NULL DEFAULT '',
  `description` text,
  `category` bigint(255) NOT NULL DEFAULT '0',
  `type` char(30) NOT NULL DEFAULT 'text',
  `settingkey` varchar(125) NOT NULL DEFAULT '',
  `default_value` text,
  `value` text,
  `extra` text,
  `php` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settingkey` (`settingkey`),
  KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `SettingsCats`
-- ----------------------------
DROP TABLE IF EXISTS `SettingsCats`;
CREATE TABLE `SettingsCats` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(125) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  `groupkey` varchar(125) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `groupkey` (`groupkey`),
  KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `SourceMessage`
-- ----------------------------
DROP TABLE IF EXISTS `SourceMessage`;
CREATE TABLE `SourceMessage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(128) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `indexID` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `StockTaking`
-- ----------------------------
DROP TABLE IF EXISTS `StockTaking`;
CREATE TABLE `StockTaking` (
  `id` bigint(255) NOT NULL,
  `description` varchar(900) NOT NULL,
  `iddeposit` int(255) NOT NULL,
  `ubication` varchar(1000) NOT NULL,
  `codedata` varchar(900) DEFAULT NULL,
  `ammount` int(255) DEFAULT NULL,
  `picode` varchar(1000) DEFAULT NULL,
  `idproduct` bigint(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_StockTaking_Product` (`idproduct`),
  KEY `FK_StockTaking_Deposit` (`iddeposit`),
  CONSTRAINT `FK_StockTaking_Deposit` FOREIGN KEY (`iddeposit`) REFERENCES `Deposit` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_StockTaking_Product` FOREIGN KEY (`idproduct`) REFERENCES `Product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Tickets`
-- ----------------------------
DROP TABLE IF EXISTS `Tickets`;
CREATE TABLE `Tickets` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(125) NOT NULL DEFAULT '',
  `alias` varchar(125) NOT NULL DEFAULT '',
  `content` longtext,
  `posted` datetime NOT NULL,
  `fixedin` smallint(3) DEFAULT NULL,
  `reportedbyid` bigint(255) NOT NULL DEFAULT '0',
  `assignedtoid` bigint(255) NOT NULL DEFAULT '0',
  `tickettype` bigint(255) unsigned DEFAULT NULL,
  `priority` bigint(255) unsigned DEFAULT NULL,
  `Ticketstatus` bigint(255) unsigned DEFAULT NULL,
  `ticketcategory` bigint(255) unsigned DEFAULT NULL,
  `projectid` bigint(255) unsigned DEFAULT NULL,
  `keywords` varchar(125) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `projectid` (`projectid`),
  KEY `reportedbyid` (`reportedbyid`),
  KEY `assignedtoid` (`assignedtoid`),
  KEY `Ticketstatus` (`Ticketstatus`),
  KEY `keywords` (`keywords`),
  KEY `FK_Tickets_TicketCat` (`ticketcategory`),
  KEY `FK_Tickets_TicketPrio` (`priority`),
  CONSTRAINT `FK_TicketsAssigned_Members` FOREIGN KEY (`assignedtoid`) REFERENCES `Members` (`id`),
  CONSTRAINT `FK_TicketsReported_Members` FOREIGN KEY (`reportedbyid`) REFERENCES `Members` (`id`),
  CONSTRAINT `FK_Tickets_Projects` FOREIGN KEY (`projectid`) REFERENCES `Projects` (`id`),
  CONSTRAINT `FK_Tickets_TicketCat` FOREIGN KEY (`ticketcategory`) REFERENCES `Tickets_Categories` (`id`),
  CONSTRAINT `FK_Tickets_TicketPrio` FOREIGN KEY (`priority`) REFERENCES `Tickets_Priorities` (`id`),
  CONSTRAINT `FK_Tickets_TicketStat` FOREIGN KEY (`Ticketstatus`) REFERENCES `Tickets_Statuses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Tickets_Categories`
-- ----------------------------
DROP TABLE IF EXISTS `Tickets_Categories`;
CREATE TABLE `Tickets_Categories` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(125) NOT NULL DEFAULT '',
  `alias` varchar(125) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Tickets_Changes`
-- ----------------------------
DROP TABLE IF EXISTS `Tickets_Changes`;
CREATE TABLE `Tickets_Changes` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `ticketid` bigint(255) unsigned NOT NULL,
  `commentid` bigint(255) unsigned NOT NULL,
  `posted` datetime NOT NULL,
  `userid` bigint(255) NOT NULL DEFAULT '0',
  `content` text,
  PRIMARY KEY (`id`),
  KEY `ticketid` (`ticketid`),
  KEY `commentid` (`commentid`),
  KEY `userid` (`userid`),
  CONSTRAINT `FK_TicketChanges_Ticket` FOREIGN KEY (`ticketid`) REFERENCES `Tickets` (`id`),
  CONSTRAINT `FK_TicketsChanges_Members` FOREIGN KEY (`userid`) REFERENCES `Members` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Tickets_Comments`
-- ----------------------------
DROP TABLE IF EXISTS `Tickets_Comments`;
CREATE TABLE `Tickets_Comments` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `ticketid` bigint(255) unsigned NOT NULL,
  `posted` datetime NOT NULL,
  `userid` bigint(255) NOT NULL,
  `content` longtext,
  `firstcomment` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ticketid` (`ticketid`),
  KEY `firstcomment` (`firstcomment`),
  KEY `userid` (`userid`),
  CONSTRAINT `FK_TicketComments_Members` FOREIGN KEY (`userid`) REFERENCES `Members` (`id`),
  CONSTRAINT `FK_TicketComments_Tickets` FOREIGN KEY (`ticketid`) REFERENCES `Tickets` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Tickets_Priorities`
-- ----------------------------
DROP TABLE IF EXISTS `Tickets_Priorities`;
CREATE TABLE `Tickets_Priorities` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(125) NOT NULL DEFAULT '',
  `backgroundcolor` char(30) NOT NULL DEFAULT '#ffffff',
  `color` char(30) NOT NULL DEFAULT '#ffffff',
  `alias` varchar(125) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Tickets_Statuses`
-- ----------------------------
DROP TABLE IF EXISTS `Tickets_Statuses`;
CREATE TABLE `Tickets_Statuses` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(125) NOT NULL DEFAULT '',
  `backgroundcolor` char(30) NOT NULL DEFAULT '#ffffff',
  `color` char(30) NOT NULL DEFAULT '#ffffff',
  `alias` varchar(125) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Tickets_Types`
-- ----------------------------
DROP TABLE IF EXISTS `Tickets_Types`;
CREATE TABLE `Tickets_Types` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(125) NOT NULL DEFAULT '',
  `alias` varchar(125) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `TLD`
-- ----------------------------
DROP TABLE IF EXISTS `TLD`;
CREATE TABLE `TLD` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `tld` varchar(10) DEFAULT NULL,
  `registrar` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tld_registrar` (`registrar`),
  CONSTRAINT `FK_tld_registrar` FOREIGN KEY (`registrar`) REFERENCES `Registrar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `Tutorials`
-- ----------------------------
DROP TABLE IF EXISTS `Tutorials`;
CREATE TABLE `Tutorials` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `catid` bigint(255) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `content` text,
  `alias` varchar(250) NOT NULL DEFAULT '',
  `language` varchar(125) NOT NULL DEFAULT '',
  `metadesc` varchar(255) NOT NULL DEFAULT '',
  `metakeys` varchar(255) NOT NULL DEFAULT '',
  `views` bigint(255) NOT NULL DEFAULT '0',
  `rating` bigint(255) NOT NULL DEFAULT '0',
  `totalvotes` bigint(255) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `authorid` bigint(255) NOT NULL DEFAULT '0',
  `postdate` datetime NOT NULL,
  `last_updated_date` datetime NOT NULL,
  `last_updated_author` bigint(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `catid` (`catid`),
  KEY `FK_Tutorials_AuthorT` (`authorid`),
  KEY `FK_Tutorials_LastAuthor` (`last_updated_author`),
  CONSTRAINT `FK_Tutorials_AuthorT` FOREIGN KEY (`authorid`) REFERENCES `Members` (`id`),
  CONSTRAINT `FK_Tutorials_LastAuthor` FOREIGN KEY (`last_updated_author`) REFERENCES `Members` (`id`),
  CONSTRAINT `FK_Tutorials_TutCats` FOREIGN KEY (`catid`) REFERENCES `TutorialsCats` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `TutorialsCats`
-- ----------------------------
DROP TABLE IF EXISTS `TutorialsCats`;
CREATE TABLE `TutorialsCats` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `parentid` bigint(255) DEFAULT NULL,
  `title` varchar(155) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `language` varchar(125) NOT NULL DEFAULT '',
  `position` bigint(255) NOT NULL DEFAULT '0',
  `metadesc` varchar(255) NOT NULL DEFAULT '',
  `metakeys` varchar(255) NOT NULL DEFAULT '',
  `readonly` tinyint(1) NOT NULL DEFAULT '0',
  `viewperms` text,
  `addtutorialperms` text,
  `addcommentsperms` text,
  `addfilesperms` text,
  `autoaddperms` text,
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `parentid` (`parentid`),
  CONSTRAINT `FK_Tutorials` FOREIGN KEY (`parentid`) REFERENCES `TutorialsCats` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `TutorialsComments`
-- ----------------------------
DROP TABLE IF EXISTS `TutorialsComments`;
CREATE TABLE `TutorialsComments` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `tutorialid` bigint(255) NOT NULL,
  `authorid` bigint(255) NOT NULL DEFAULT '0',
  `postdate` datetime NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  `comment` text,
  PRIMARY KEY (`id`),
  KEY `tutorialid` (`tutorialid`),
  KEY `authorid` (`authorid`),
  CONSTRAINT `FK_TutorialComments_Members` FOREIGN KEY (`authorid`) REFERENCES `Members` (`id`),
  CONSTRAINT `FK_TutorialsComments_Tutid` FOREIGN KEY (`tutorialid`) REFERENCES `Tutorials` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `UserComments`
-- ----------------------------
DROP TABLE IF EXISTS `UserComments`;
CREATE TABLE `UserComments` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `userid` bigint(255) NOT NULL,
  `authorid` bigint(255) NOT NULL,
  `postdate` datetime NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  `comment` text,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `authorid` (`authorid`),
  CONSTRAINT `FK_UserComments_AuthorMembers` FOREIGN KEY (`authorid`) REFERENCES `Members` (`id`),
  CONSTRAINT `FK_UserComments_Members` FOREIGN KEY (`userid`) REFERENCES `Members` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `VirtualServers`
-- ----------------------------
DROP TABLE IF EXISTS `VirtualServers`;
CREATE TABLE `VirtualServers` (
  `id` bigint(255) NOT NULL,
  `server_name` varchar(255) NOT NULL,
  `memberid` bigint(255) NOT NULL,
  `datacenterid` bigint(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `diskspace` varchar(255) NOT NULL,
  `bandwidth` varchar(255) NOT NULL,
  `rootuser` varchar(255) NOT NULL,
  `rootpassword` varchar(255) NOT NULL,
  `operatingsystem` int(50) NOT NULL,
  `details` longtext,
  PRIMARY KEY (`id`),
  KEY `FK_VirtualServers_Members` (`memberid`),
  KEY `FK_VirtualServers_Datacenter` (`datacenterid`),
  CONSTRAINT `FK_VirtualServers_Members` FOREIGN KEY (`memberid`) REFERENCES `Members` (`id`),
  CONSTRAINT `FK_VirtualServers_Datacenter` FOREIGN KEY (`datacenterid`) REFERENCES `DataCenter` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `VirtualServersIp`
-- ----------------------------
DROP TABLE IF EXISTS `VirtualServersIp`;
CREATE TABLE `VirtualServersIp` (
  `idvirtualserver` bigint(255) NOT NULL,
  `ipaddress` varchar(90) NOT NULL,
  `nameserver` varchar(12) NOT NULL,
  PRIMARY KEY (`idvirtualserver`),
  KEY `FK_VirtualServersIP_VirtualServersID` (`idvirtualserver`),
  CONSTRAINT `FK_VirtualServersIP_VSID` FOREIGN KEY (`idvirtualserver`) REFERENCES `VirtualServers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;