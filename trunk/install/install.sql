# phpMyAdmin SQL Dump
# version 2.5.6
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Jul 13, 2005 at 12:02 AM
# Server version: 4.0.18
# PHP Version: 4.3.4
# 
# Database : `mygovernance`
# 
# Data Custodian: Samuel Moffatt (sam.moffatt@toowoombarc.qld.gov.au)

# --------------------------------------------------------

#
# Table structure for table `documents`
#

CREATE TABLE `documents` (
  `drf` varchar(15) NOT NULL default '',
  `title` text NOT NULL,
  `project` int(11) NOT NULL default '0',
  PRIMARY KEY  (`drf`,`project`)
) COMMENT='Documents Table (Docs)';

# --------------------------------------------------------

#
# Table structure for table `plugins`
#
CREATE TABLE `plugins` (
  `id` int(11) NOT NULL auto_increment,
  `name` TEXT NOT NULL default '',
  `element` TEXT NOT NULL default '',
  `folder` varchar(100) NOT NULL default '',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `published` tinyint(3) NOT NULL default '0',
  `iscore` tinyint(3) NOT NULL default '0',
  `client_id` tinyint(3) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_folder` (`published`,`client_id`,`access`,`folder`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Dumping data for table `plugins`
#

INSERT INTO `plugins` VALUES(1, 'LDAP Authenticator', 'ldap_userbot', 'auth', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'host=yeda.toowoomba.qld.gov.au
port=389
base_dn=0=tccdir');
INSERT INTO `plugins` VALUES(2, 'ACL Response', 'response', 'acl', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `plugins` VALUES(3, 'LDAP SSO', 'ldap_sso', 'auth', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `plugins` VALUES(4, 'dotProject Display', 'dotproject', 'display', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `plugins` VALUES(5, 'dotProject Export', 'dotproject', 'export', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `plugins` VALUES (6, 'Authentication - Joomla', 'joomla', 'authentication', 0, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `plugins` VALUES (7, 'Authentication - LDAP', 'ldap', 'authentication', 0, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', 'host=\nport=389\nuse_ldapV3=0\nnegotiate_tls=0\nno_referrals=0\nauth_method=bind\nbase_dn=\nsearch_string=\nusers_dn=\nusername=\npassword=\nldap_fullname=fullName\nldap_email=mail\nldap_uid=uid\n\n');
INSERT INTO `plugins` VALUES (8, 'User - Joomla!', 'joomla', 'user', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'autoregister=1\n\n');


# --------------------------------------------------------

#
# Table structure for table `session`
#

CREATE TABLE `session` (
  `username` varchar(150) default '',
  `time` varchar(14) default '',
  `session_id` varchar(200) NOT NULL default '0',
  `guest` tinyint(4) default '1',
  `userid` int(11) default '0',
  `usertype` varchar(150) default '',
  `gid` tinyint(3) unsigned NOT NULL default '0',
  `client_id` tinyint(3) unsigned NOT NULL default '0',
  `data` text,
  PRIMARY KEY  (`session_id`),
  KEY `whosonline` (`guest`,`usertype`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `menu`
#

CREATE TABLE `menu` (
  `id` int(11) NOT NULL auto_increment,
  `menutype` varchar(225) default NULL,
  `name` TEXT default NULL,
  `alias` VARCHAR(255) NOT NULL,
  `link` text,
  `type` varchar(150) NOT NULL default '',
  `published` tinyint(1) NOT NULL default 0,
  `parent` int(11) unsigned NOT NULL default 0,
  `componentid` int(11) unsigned NOT NULL default 0,
  `sublevel` int(11) default 0,
  `ordering` int(11) default 0,
  `checked_out` int(11) unsigned NOT NULL default 0,
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `pollid` int(11) NOT NULL default 0,
  `browserNav` tinyint(4) default 0,
  `access` tinyint(3) unsigned NOT NULL default 0,
  `utaccess` tinyint(3) unsigned NOT NULL default 0,
  `params` text NOT NULL,
  `lft` int(11) unsigned NOT NULL default 0,
  `rgt` int(11) unsigned NOT NULL default 0,
  `home` INTEGER(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`),
  KEY `componentid` (`componentid`,`menutype`,`published`,`access`),
  KEY `menutype` (`menutype`)
) TYPE=MyISAM;

INSERT INTO `menu` VALUES (1, 'mainmenu', 'Home', 'home', 'index.php?option=com_project', 'component', 1, 0, 20, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, '', 0, 0, 1);

# --------------------------------------------------------

#
# Table structure for table `components`
#

CREATE TABLE `components` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(150) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `menuid` int(11) unsigned NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `admin_menu_link` varchar(255) NOT NULL default '',
  `admin_menu_alt` TEXT NOT NULL default '',
  `option` varchar(50) NOT NULL default '',
  `ordering` int(11) NOT NULL default '0',
  `admin_menu_img` varchar(255) NOT NULL default '',
  `iscore` tinyint(4) NOT NULL default '0',
  `params` text NOT NULL,
  `enabled` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;


INSERT INTO components VALUES(1,"Projects","index.php?option=com_project",1,0,"","","com_project",1,"",0,"",1);
INSERT INTO components VALUES(2,"Administration","index.php?option=com_admin",1,0,"","","com_admin",2,"",0,"",1);


# --------------------------------------------------------

#
# Table structure for table `users`
#

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `username` varchar(25) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `usertype` varchar(25) NOT NULL default '',
  `block` tinyint(4) NOT NULL default '0',
  `sendEmail` tinyint(4) default '0',
  `gid` tinyint(3) unsigned NOT NULL default '1',
  `registerDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`)
) TYPE=MyISAM ;

# --------------------------------------------------------

#
# Table structure for table `panswers`
#

CREATE TABLE `panswers` (
  `pid` int(11) NOT NULL default '0',
  `qid` int(11) NOT NULL default '0',
  `score` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pid`,`qid`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `pquestions`
#

CREATE TABLE `pquestions` (
  `qid` int(6) unsigned NOT NULL auto_increment,
  `qtype` enum('Risk','Strategic Alignment','Direct Value Return','Business Process Impact','Architecture','Technical Risk','Compliance') NOT NULL default 'Risk',
  `qtext` varchar(255) NOT NULL default '',
  `qv0` varchar(128) NOT NULL default '',
  `qv1` varchar(128) NOT NULL default '',
  `qv2` varchar(128) NOT NULL default '',
  `qv3` varchar(128) NOT NULL default '',
  `qv4` varchar(128) NOT NULL default '',
  `qwt` tinyint(2) NOT NULL default '10',
  PRIMARY KEY  (`qid`)
) TYPE=MyISAM ;

# --------------------------------------------------------

#
# Table structure for table `projects`
#

CREATE TABLE `projects` (
  `pid` int(8) unsigned NOT NULL auto_increment,
  `proj_name` varchar(255) NOT NULL default '',
  `proj_desc` longtext NOT NULL,
  `proj_type` enum('Infrastructure','Corporate','Business') NOT NULL default 'Infrastructure',
  `proj_status` enum('Inception','Assessment','Design','Development','Testing','Deployment','PIR','Product','Postponed') NOT NULL default 'Inception',
  `proj_benefits` mediumtext NOT NULL,
  `proj_benefits_compliance` text,
  `proj_benefits_riskmitig` text,
  `proj_nousers` int(11) NOT NULL default '0',
  `proj_capital_y1` decimal(8,0) NOT NULL default '0',
  `proj_other_y1` decimal(8,0) NOT NULL default '0',
  `proj_savings_y1` decimal(8,0) NOT NULL default '0',
  `proj_funding_y1` varchar(255) NOT NULL default 'Recurrent',
  `proj_capital_y2` decimal(8,0) NOT NULL default '0',
  `proj_other_y2` decimal(8,0) NOT NULL default '0',
  `proj_savings_y2` decimal(8,0) NOT NULL default '0',
  `proj_funding_y2` varchar(255) NOT NULL default 'Recurrent',
  `proj_capital_y3` decimal(8,0) NOT NULL default '0',
  `proj_other_y3` decimal(8,0) NOT NULL default '0',
  `proj_savings_y3` decimal(8,0) NOT NULL default '0',
  `proj_funding_y3` varchar(255) NOT NULL default 'Recurrent',
  `proj_capital_y4` decimal(8,0) NOT NULL default '0',
  `proj_other_y4` decimal(8,0) NOT NULL default '0',
  `proj_savings_y4` decimal(8,0) NOT NULL default '0',
  `proj_funding_y4` varchar(255) NOT NULL default 'Recurrent',
  `proj_timetable` mediumtext NOT NULL,
  `proj_owner` varchar(30) NOT NULL default '',
  `proj_board` varchar(60) NOT NULL default '',
  `proj_commenced` date default NULL,
  `proj_completed` date default NULL,
  `proj_createdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `proj_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `proj_benefit_recs` char(1) binary NOT NULL default '',
  `proj_risks_exist` char(1) binary NOT NULL default '',
  `proj_outcome_type` enum('Compliance','Strategic','Core','Speculative','Support') NOT NULL default 'Compliance',
  `proj_hide` int(11) NOT NULL default '0',
  `proj_staffreq_y1` INT NOT NULL ,
 `proj_staffreq_y2` INT NOT NULL ,
 `proj_staffreq_y3` INT NOT NULL ,
 `proj_applications_y1` INT NOT NULL ,
 `proj_applications_y2` INT NOT NULL ,
 `proj_applications_y3` INT NOT NULL ,
 `proj_consultants_y1` INT NOT NULL ,
 `proj_consultants_y2` INT NOT NULL ,
 `proj_consultants_y3` INT NOT NULL ,
 `proj_technical_y1` INT NOT NULL ,
 `proj_technical_y2` INT NOT NULL ,
 `proj_technical_y3` INT NOT NULL ,
 `proj_buexpert_y1` INT NOT NULL ,
 `proj_buexpert_y2` INT NOT NULL ,
 `proj_buexpert_y3` INT NOT NULL ,
 `proj_assessment` INT NOT NULL,
 `proj_shortname` VARCHAR(10),
 `businessunit` TINYTEXT,
 `proj_deliverables` TEXT NOT NULL,
 `proj_impacts` TEXT NOT NULL,
 `proj_begin` DATE NOT NULL,
 `proj_end` DATE NOT NULL,
 `bus_owner` VARCHAR(30) NOT NULL ,
 `proj_dotprojectid` INT NOT NULL,
 `proj_notify` TEXT NOT NULL DEFAULT '',
  `financialyear` varchar(10), 
  `recommended` varchar(10),
 # `proj_status` ENUM('On Schedule', 'Behind Schedule', 'Postponed', 'Achieved', 'Not Achieved', 'Overbudget'),
  PRIMARY KEY  (`pid`),
  KEY `proj_createdate` (`proj_createdate`)
) TYPE=MyISAM PACK_KEYS=0 COMMENT='Main project table';

# --------------------------------------------------------

#
# Dumping data for table `pquestions`
#

INSERT INTO `pquestions` VALUES (1, 'Risk', 'Sponsor', 'One', '', '', '', 'None/Many', 10);
INSERT INTO `pquestions` VALUES (2, 'Risk', 'Objectives', 'SMART', '', '', '', 'VAGUE', 10);
INSERT INTO `pquestions` VALUES (3, 'Risk', 'Unresolved Issues', 'Few', '', '', '', 'Many', 15);
INSERT INTO `pquestions` VALUES (4, 'Risk', 'Business Team', 'Experienced', '', '', '', 'Inexperienced', 15);
INSERT INTO `pquestions` VALUES (5, 'Risk', 'Time to completion', 'Loose/Flexible', '', '', '', 'Tight', 10);
INSERT INTO `pquestions` VALUES (6, 'Risk', 'Business Units impacted', 'One', '', '', '', 'More than 5', 10);
INSERT INTO `pquestions` VALUES (7, 'Risk', 'Business Rules', 'Established and no change', '', '', '', 'Non-existent', 15);
INSERT INTO `pquestions` VALUES (8, 'Risk', 'Policy', 'Established and no change', '', '', '', 'Non-existent and needs creation', 15);
INSERT INTO `pquestions` VALUES (9, 'Strategic Alignment', 'Improved Stakeholder Relationship', 'No Impacts', 'Some impact on a small number of stakeholders', 'Some impact on a large number of stakeholders', 'Significant impact on a small number of stakeholders', 'Significant  impact on a large number of stakeholders', 20);
INSERT INTO `pquestions` VALUES (10, 'Strategic Alignment', 'Contribution ot achievement of whole of government objectives for integrated service delivery', 'No contribution', '', 'Limited contribution to whole of government objectives for integrated service delivery', '', 'Demonstrable contribution to whole of government objectives for integrated service delivery', 20);
INSERT INTO `pquestions` VALUES (11, 'Strategic Alignment', 'Contribution/improvement in client trust and confidence in services', 'No improvement', 'Some improvement in client trust and confidence in services to a small number of clients', 'Some improvement in client trust and confidence in services to a large number of clients', 'Significat improvement in client trust and confidence in aservices to a small number of clients', 'Significant improvement in client trust and confidence in aservices to a large number of clients', 20);
INSERT INTO `pquestions` VALUES (12, 'Strategic Alignment', 'Improved client and constituent understanding of Council Policies and Porgrammes', 'No improvement', 'Some improvement to a small number of clients and their understanding of Government Policies and Programs', 'Some improvement to a large number of clients and their understanding of Government Policies and Programs', 'Significant improvement to a small number of clients and their understanding of Government Policies and Programs', 'Significant improvement to a large number of clients and their understanding of Government Policies and Programs', 20);
INSERT INTO `pquestions` VALUES (13, 'Direct Value Return', 'Cost to Internal Benefits ratio; Cost = additional costs incured by project; Internal Benefits = Measurable and realisable improvement in internal operational efficientcy and/or prodcutivity minus cost reduction, cost avoidancer', 'Less that 0.5', '0.5', '1', '1.5', '2 or Better', 20);
INSERT INTO `pquestions` VALUES (14, 'Direct Value Return', 'Cost to external Benefits ration:; cost= additional costs incurred by project; External Benefits = Measurable NET improvement in client and/or business partner operational efficiency  and/ or prodcuticuty - cost reduction, cost avoidance', 'Less than 0.5', '0.5', '1', '1.5', '2 or better', 15);
INSERT INTO `pquestions` VALUES (15, 'Direct Value Return', 'Improvement in client service quality - faster delivery, improved client satisfaction and/or reduced client complaints or problems', 'None', 'Identifiable improvments in client service quality to a small number of clients', 'Identifiable improvments in client service quality to a large number of clients', 'Measurable and considerable improvments in client service quality to a small number of clients', 'Measurable and considerable improvments in client service quality to a large number of clients', 25);
INSERT INTO `pquestions` VALUES (16, 'Direct Value Return', 'Client demand for service improvement', 'Low', '', 'Medium', '', 'High', 25);
INSERT INTO `pquestions` VALUES (17, 'Business Process Impact', 'Use of existing data to support multi-service delivery', 'No re-use of existing data', 'Minimal re-use of existing data to support multi-service delivery', 'Some use of existing data to support multi-service delivery', 'Significant use of existing data to support multi-service delivery', 'Full use of relevant existing data to support multi-service delivery', 15);
INSERT INTO `pquestions` VALUES (18, 'Business Process Impact', 'Reduction in non value adding activities, support for economies of scale, reduction in data duplication', 'No reduction', 'Some reduction to the proportion of value added to non value added acticty for a few business processes', 'Some reduction to the proportion of value added to non value added acticty for many business processes', 'Significant reduction to the proportion of value added to non value added acticty for a few business processes', 'Significant reduction to the proportion of value added to non value added acticty for many business processes', 15);
INSERT INTO `pquestions` VALUES (19, 'Business Process Impact', 'Adabtibility of technology to changes in busienss processes eg Flexibility to regflext new regulatory and/or Government Policy changes; new organisational structures', 'Negative - impedes busines process change', 'Provides process change support for core transactions', 'Allows for configuration of some key process areas', 'Allows for configuration  of all key process areas', 'Provides totally configurable business process support', 15);
INSERT INTO `pquestions` VALUES (20, 'Business Process Impact', 'Simplifies business processess', 'Introduces new complexities into the majority of  existing business processes', 'Introduces new complexities into a small number of the existing business processes', 'No change in  overall complexity', 'Some simplifciation of business processes', 'Significant simplifciation of the majority of existing business processes', 15);
INSERT INTO `pquestions` VALUES (21, 'Business Process Impact', 'Standardises Business processes', 'No Impacts', 'Some standardisation of business processes across one business unit', 'Substantial standardisation of business processes across one business unit', 'Some standardisation of business processes across more than one business uni', 'Substantial standardisation of business processes across more than one business uni', 15);
INSERT INTO `pquestions` VALUES (22, 'Strategic Alignment', 'Improved client access to information and services (e.g. new service channels and increased traffic/usage)', 'No improvement', 'Some improvement to access to information and services for a small number of clients', 'Some improvement to access to information and services for a large number of clients', 'Demonstrable and significant improvement to information and services to a small number of clients', 'Demonstrable and significant improvement to information and services to a large number of clients', 15);
INSERT INTO `pquestions` VALUES (23, 'Business Process Impact', 'Integration of business processes with clients/and or business partners', 'No integration', 'Partial integration accross some business processes for some clients', 'Partial integration accross all business processes for all clients', 'Fully integrated across some business processes for some clients', 'Fully integrated across all business processes for all clients', 15);
INSERT INTO `pquestions` VALUES (24, 'Architecture', 'Enablement of future initiatives', 'Low flexibility, scalability or potential reusability of applications architecture', 'Medium flexibility, scalability and identified potential reusability of applications architecture or busines model', 'High flexibility, scalability and identified potential reusability of applications architecture', 'Enablement of identified future initative(s)', 'Enablement of identified future initiative(s) as project deleiverable(s)', 25);
INSERT INTO `pquestions` VALUES (25, 'Architecture', 'Use of common /standard applications componetns and/or shared infrastructure and data management systems', 'Use of non standard infrastructure or data management systems', 'Use of shared infrastructure and shared data management systems', 'Use of common/standard applications components through cloning and customisation', 'Use of common/standard application components and share infrastructue and data management with some customisation of components', 'Use of common/standard applications components and shared infrastructure and data management systems without customisation', 25);
INSERT INTO `pquestions` VALUES (26, 'Architecture', 'Integration with other TCC service delivery channel(s) including consistency in web interface', 'None', 'Identified potential future integration with existing channels', 'Future integration with existing channels planned', 'Integration with existing channels with some need to customise these', 'Integration with existing channels with no need to customise these', 25);
INSERT INTO `pquestions` VALUES (27, 'Architecture', 'Integrationwith shared service systems', 'None', 'Development of new interface', 'Development of new interface that will be reused', 'Use of standard interfaces with some customisation of these needed', 'Use of standard interfaces with no customisation of these needed', 25);
INSERT INTO `pquestions` VALUES (28, 'Technical Risk', 'Technical Novelty', 'Proven', '', '', '', 'New', 15);
INSERT INTO `pquestions` VALUES (29, 'Technical Risk', 'Alignment with architecture', 'Strong', '', '', '', 'Weak', 10);
INSERT INTO `pquestions` VALUES (30, 'Technical Risk', 'Technical team', 'Experienced', '', '', '', 'Inexperienced', 20);
INSERT INTO `pquestions` VALUES (31, 'Technical Risk', 'Team location', 'One', '', '', '', 'Many', 10);
INSERT INTO `pquestions` VALUES (32, 'Technical Risk', 'System Platforms', 'One', '', '', '', 'Many', 10);
INSERT INTO `pquestions` VALUES (33, 'Technical Risk', 'Level of integration', 'Stand-Alone', '', '', '', 'Fully Integrated', 15);
INSERT INTO `pquestions` VALUES (34, 'Technical Risk', 'Transaction Volume', 'Low', '', '', '', 'High', 10);
INSERT INTO `pquestions` VALUES (35, 'Technical Risk', 'Fault tolerance', 'high', '', '', '', 'low', 10);
INSERT INTO `pquestions` VALUES (36, 'Compliance', 'Proposed business processes and technical system seeks to correct inadequate corporate governance capabilities', 'Current business processes complies with legislative and regulative requirements', 'Minimal risk of loss of reputation or punitive action if Council continues non compliance', 'Non complaince will result in significant loss of reputation within Community', 'Non complaince will result in punitive legal action being taken against Council', 'Major loss of reputation and punitive action against Council  if non compliance not corrected', 30);
INSERT INTO `pquestions` VALUES (37, 'Compliance', 'Proposed business processes and technical system seeks to correct inadequate corporate governance capabilities that could result in loss of income or financial punishement', 'Current business processes complies with legislative and regulative requirements', 'Marginal likelihood of finanical loss or fines. Maximum loss would not excess of $200,000 per annum', 'Significant likelihood (.1-.6 probability) of finanical loss or fines.  Maximum loss wont exceed $200,000 per annum', 'Significant likelihood (.1-.6 probability) of finanical loss or fines.  Maximum loss will exceed $200,000 per annum', 'Highly unlikely that Council will not avoid finanical losses or fines exceeding $1million per annum', 30);
INSERT INTO `pquestions` VALUES (38, 'Compliance', 'Proposed business processes and technical system seeks to mitigate risks to Council and/or the community\'s reputation', 'Inherrent risks in the current business processes are acceptable and managed', 'A small number of risks exist that  are not effectively managed but the threat to Council\'s reputation is minimal', 'A significant proportion of the risks are not effectively managed & are a significant threat to Council\'s reputation', 'The current business processes contain unmanaged risks that could cause serious loss of reputation if realised', 'The current business processes contain unmanaged risks that would cause unrecoverable loss to Council\'s reputation', 3);
INSERT INTO `pquestions` VALUES (39, 'Compliance', 'Proposed business processes and technical system seeks to mitigate risks to Council and/or the community financial status', 'Inherrent risks in the current business processes are acceptable and managed', 'A small number of risks exist that  are not effectively managed but the threat to Council\'s financial situation is minimal', 'A significant proportion of the risks are not effectively managed & are a significant threat to Council\'s financial situation', 'The current business processes contain unmanaged risks that would cause serious financial  loss  if realised', 'The current business processes contain unmanaged risks that would cause unrecoverable financial loss to Council', 10);
INSERT INTO `pquestions` VALUES (40, 'Compliance', 'Proposed business processes and technical system seeks to mitigate risks to Council\'s business capabilities', 'Inherrent risks in the current business processes are acceptable and managed', 'A small number of risks exist that  are not effectively managed but the threat to Council\'s operations is minimal', 'A significant proportion of the risks are not effectively managed & are a significant threat to Council\'s operational capability', 'The current business processes contain unmanaged risks that would cause serious loss of core operational capability if realised', 'The current business processes contain unmanaged risks that would cause unrecoverable loss of core operational capability', 3);
