-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jul 03, 2007 at 12:03 AM
-- Server version: 3.23.58
-- PHP Version: 4.3.2

-- 
-- Database: `Obsedb_test`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_announcements`
-- 

DROP TABLE IF EXISTS `Obsedb_announcements`;
CREATE TABLE `Obsedb_announcements` (
  `id` int(11) NOT NULL auto_increment,
  `user` varchar(200) NOT NULL default '',
  `date` varchar(200) NOT NULL default '',
  `title` text NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `Obsedb_announcements`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_cheats`
-- 

DROP TABLE IF EXISTS `Obsedb_cheats`;
CREATE TABLE `Obsedb_cheats` (
  `id` int(11) NOT NULL auto_increment,
  `Modid` int(11) NOT NULL default '0',
  `title` text NOT NULL,
  `cheat` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `Obsedb_cheats`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_companies`
-- 

DROP TABLE IF EXISTS `Obsedb_companies`;
CREATE TABLE `Obsedb_companies` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  `description` text NOT NULL,
  `homepage` varchar(250) NOT NULL default '',
  `logo` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `Obsedb_companies`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_configuration`
-- 

DROP TABLE IF EXISTS `Obsedb_configuration`;
CREATE TABLE `Obsedb_configuration` (
  `id` int(11) NOT NULL auto_increment,
  `key` varchar(250) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=17 ;

-- 
-- Dumping data for table `Obsedb_configuration`
-- 

INSERT INTO `Obsedb_configuration` (`id`, `key`, `value`) VALUES 
(1, 'site_title', 'Obsedb CMS'),
(2, 'meta_description', 'Obsedb CMS - Gaming Content Management System'),
(3, 'meta_keywords', 'Obsedb cms, Obsedb, gaming, cms, content management'),
(4, 'date_format', 'Y.m.d'),
(5, 'true_refresh', '1'),
(7, 'Mod_tools', '1'),
(8, 'Mod_tools_popups', '1'),
(9, 'screenshots_thumbnailing', '1'),
(10, 'screenshots_upload', '1'),
(11, 'frontpage_news_limit', '10'),
(12, 'frontpage_popular_Mods_limit', '10'),
(13, 'frontpage_latest_Mods_limit', '10'),
(14, 'frontpage_reviews_limit', '5'),
(15, 'frontpage_previews_limit', '5'),
(16, 'cphome_recent_Mods', '5');

-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_customfields`
-- 

DROP TABLE IF EXISTS `Obsedb_customfields`;
CREATE TABLE `Obsedb_customfields` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `module` varchar(255) NOT NULL default '',
  `type` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Obsedb_customfields`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_downloads`
-- 

DROP TABLE IF EXISTS `Obsedb_downloads`;
CREATE TABLE `Obsedb_downloads` (
  `id` int(11) NOT NULL auto_increment,
  `Modid` int(11) NOT NULL default '0',
  `title` text NOT NULL,
  `download` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Obsedb_downloads`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_Mods`
-- 

DROP TABLE IF EXISTS `Obsedb_Mods`;
CREATE TABLE `Obsedb_Mods` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  `section` varchar(250) NOT NULL default '0',
  `description` text NOT NULL,
  `developer` varchar(250) NOT NULL default '0',
  `publisher` varchar(250) NOT NULL default '0',
  `genre` text NOT NULL,
  `release_date` text,
  `multiplayer` text NOT NULL,
  `boxshot` text NOT NULL,
  `views` int(11) NOT NULL default '0',
  `esrb` varchar(255) NOT NULL default '',
  `coop` varchar(255) NOT NULL default '',
  `req_system` varchar(255) NOT NULL default '',
  `req_ram` varchar(255) NOT NULL default '',
  `req_video` varchar(255) NOT NULL default '',
  `req_space` varchar(255) NOT NULL default '',
  `req_mouse` varchar(255) NOT NULL default '',
  `req_directx` varchar(255) NOT NULL default '',
  `req_sound` varchar(255) NOT NULL default '',
  `published` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=30 ;

-- 
-- Dumping data for table `Obsedb_Mods`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_Mods_comments`
-- 

DROP TABLE IF EXISTS `Obsedb_Mods_comments`;
CREATE TABLE `Obsedb_Mods_comments` (
  `id` int(11) NOT NULL default '0',
  `Mod_id` int(11) NOT NULL default '0',
  `username` varchar(255) NOT NULL default '',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `comment` text NOT NULL
) TYPE=MyISAM;

-- 
-- Dumping data for table `Obsedb_Mods_comments`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_Mods_customdata`
-- 

DROP TABLE IF EXISTS `Obsedb_Mods_customdata`;
CREATE TABLE `Obsedb_Mods_customdata` (
  `id` int(11) NOT NULL auto_increment,
  `fieldid` int(11) NOT NULL default '0',
  `Modid` int(11) NOT NULL default '0',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Obsedb_Mods_customdata`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_Mods_sections`
-- 

DROP TABLE IF EXISTS `Obsedb_Mods_sections`;
CREATE TABLE `Obsedb_Mods_sections` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `Obsedb_Mods_sections`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_links`
-- 

DROP TABLE IF EXISTS `Obsedb_links`;
CREATE TABLE `Obsedb_links` (
  `id` int(11) NOT NULL auto_increment,
  `url` text NOT NULL,
  `title` text NOT NULL,
  `section` int(11) NOT NULL default '0',
  `Modid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Obsedb_links`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_links_sections`
-- 

DROP TABLE IF EXISTS `Obsedb_links_sections`;
CREATE TABLE `Obsedb_links_sections` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Obsedb_links_sections`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_mailbag`
-- 

DROP TABLE IF EXISTS `Obsedb_mailbag`;
CREATE TABLE `Obsedb_mailbag` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  `message` text NOT NULL,
  `reply` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `Obsedb_mailbag`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_matrix`
-- 

DROP TABLE IF EXISTS `Obsedb_matrix`;
CREATE TABLE `Obsedb_matrix` (
  `id` int(11) NOT NULL auto_increment,
  `ctype` varchar(250) NOT NULL default '',
  `cid` varchar(250) NOT NULL default '',
  `reltype` varchar(250) NOT NULL default '',
  `relid` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Obsedb_matrix`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_members`
-- 

DROP TABLE IF EXISTS `Obsedb_members`;
CREATE TABLE `Obsedb_members` (
  `ID` int(11) NOT NULL auto_increment,
  `USERNAME` varchar(255) NOT NULL default '',
  `PASSWORD` varchar(255) NOT NULL default '',
  `EMAIL` varchar(255) NOT NULL default '',
  `NOM` tinytext NOT NULL,
  `PRIV` tinyint(2) NOT NULL default '0',
  `ACTIF` tinyint(1) NOT NULL default '1',
  `LASTLOG` datetime NOT NULL default '0000-00-00 00:00:00',
  `EXPIRE` datetime NOT NULL default '0000-00-00 00:00:00',
  `FNAME` varchar(255) NOT NULL default '',
  `LNAME` varchar(255) NOT NULL default '',
  `PHONE` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `ID` (`ID`)
) TYPE=MyISAM PACK_KEYS=1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `Obsedb_members`
-- 

INSERT INTO `Obsedb_members` (`ID`, `USERNAME`, `PASSWORD`, `EMAIL`, `NOM`, `PRIV`, `ACTIF`, `LASTLOG`, `EXPIRE`, `FNAME`, `LNAME`, `PHONE`) VALUES 
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'you@yoursite.com', 'Administrator', 0, 1, '2007-07-02 15:54:20', '0000-00-00 00:00:00', '', '', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_menu_items`
-- 

DROP TABLE IF EXISTS `Obsedb_menu_items`;
CREATE TABLE `Obsedb_menu_items` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  `url` varchar(250) NOT NULL default '',
  `active` int(11) NOT NULL default '0',
  `location` varchar(250) NOT NULL default '',
  `ordering` int(11) NOT NULL default '0',
  `target` varchar(250) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=11 ;

-- 
-- Dumping data for table `Obsedb_menu_items`
-- 

INSERT INTO `Obsedb_menu_items` (`id`, `title`, `url`, `active`, `location`, `ordering`, `target`) VALUES 
(1, 'Home', 'index.php', 1, 'left', 1, NULL),
(2, 'Home', 'index.php', 1, 'top', 1, NULL),
(3, 'Mods', 'Mods.php', 1, 'top', 2, NULL),
(4, 'Mods', 'Mods.php', 1, 'left', 2, NULL),
(5, 'Companies', 'companies.php', 1, 'left', 3, NULL),
(6, 'Reviews', 'reviews.php', 1, 'left', 4, NULL),
(7, 'Previews', 'previews.php', 1, 'left', 5, NULL),
(8, 'obsedb.co.cc', 'http://obsedb.co.cc/', 1, 'left', 6, '_blank'),
(9, 'News RSS', 'rss_news.php', 1, 'bottom', 1, NULL),
(10, 'Register', 'register.php', 1, 'top', 3, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_modules`
-- 

DROP TABLE IF EXISTS `Obsedb_modules`;
CREATE TABLE `Obsedb_modules` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `active` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=19 ;

-- 
-- Dumping data for table `Obsedb_modules`
-- 

INSERT INTO `Obsedb_modules` (`id`, `title`, `url`, `active`) VALUES 
(1, 'Cheats', 'cheats.php', 1),
(2, 'Companies', 'companies.php', 1),
(3, 'Mods', 'Mods.php', 1),
(4, 'Link Manager', 'links.php', 0),
(5, 'Mailbag', 'mailbag.php', 1),
(6, 'News', 'news.php', 1),
(7, 'Static Pages', 'pages.php', 1),
(8, 'Plugins', 'plugins.php', 1),
(9, 'Previews', 'previews.php', 1),
(10, 'Reviews', 'reviews.php', 1),
(11, 'Related Content Manager', 'rcm_matrix.php', 1),
(12, 'Screenshots', 'screenshots.php', 1),
(13, 'Polls', 'polls.php', 1),
(14, 'Content Download Service', 'content.php', 1),
(15, 'Downloads', 'downloads.php', 1),
(16, 'Custom Fields', 'customfields.php', 1),
(18, 'Sections', 'sections.php', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_news`
-- 

DROP TABLE IF EXISTS `Obsedb_news`;
CREATE TABLE `Obsedb_news` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  `author` varchar(255) NOT NULL default '',
  `section` text NOT NULL,
  `intro` text NOT NULL,
  `text` text NOT NULL,
  `date` varchar(250) NOT NULL default '',
  `published` int(11) NOT NULL default '0',
  `newsimage` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `Obsedb_news`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_news_sections`
-- 

DROP TABLE IF EXISTS `Obsedb_news_sections`;
CREATE TABLE `Obsedb_news_sections` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `Obsedb_news_sections`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_pages`
-- 

DROP TABLE IF EXISTS `Obsedb_pages`;
CREATE TABLE `Obsedb_pages` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Obsedb_pages`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_phrases`
-- 

DROP TABLE IF EXISTS `Obsedb_phrases`;
CREATE TABLE `Obsedb_phrases` (
  `id` int(11) NOT NULL auto_increment,
  `category` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `phrase` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `group` (`category`)
) TYPE=MyISAM AUTO_INCREMENT=68 ;

-- 
-- Dumping data for table `Obsedb_phrases`
-- 

INSERT INTO `Obsedb_phrases` (`id`, `category`, `name`, `phrase`) VALUES 
(1, 'adminIndex', 'post_announcement', 'Post Announcement'),
(2, 'adminIndex', 'announcements', 'Announcements'),
(3, 'adminIndex', 'welcome', 'Welcome, '),
(4, 'adminIndex', 'no_announcements', 'No announcements have been posted.'),
(5, 'adminIndex', 'recent_Mods', 'Recent Mods'),
(6, 'adminIndex', 'no_content', 'No content to display.'),
(7, 'adminIndex', 'recent_news', 'Recent News'),
(8, 'adminIndex', 'recent_previews', 'Recent Previews'),
(9, 'adminIndex', 'username', 'Username'),
(10, 'adminIndex', 'title', 'Title'),
(11, 'adminIndex', 'post_announcement', 'Post New Announcement'),
(12, 'adminIndex', 'message', 'Message'),
(13, 'adminIndex', 'editAnnouncementCommit', 'Success | Announcement has been updated.'),
(14, 'adminIndex', 'addAnnouncementCommit', 'Success | Announcement has been added.'),
(15, 'adminIndex', 'deleteAnnouncementCommit', 'Success | Announcement has been deleted.'),
(16, 'adminAdministrators', 'account_deleted', '<center>Admin account has been removed, <a href="administrators.php">click here to continue</a>.</center>'),
(17, 'adminAdministrators', 'add_user', 'Add User'),
(18, 'adminAdministrators', 'administrators', 'Administrators'),
(19, 'adminAdministrators', 'manage_users', 'Manage Users'),
(20, 'adminCheats', 'manage_cheats', 'Manage Cheats'),
(21, 'adminCheats', 'add_cheat', 'Add Cheat'),
(22, 'adminCheats', 'cheats_header', 'Cheats'),
(23, 'adminCompanies', 'manage_companies', 'Manage Companies'),
(24, 'adminIndex', 'control_panel_title_bar', 'Obsedb CMS - Logged in as '),
(25, 'adminIndex', 'control_panel_header', 'Obsedb CMS Admin Control Panel'),
(26, 'adminIndex', 'control_panel_home', 'Control Panel Home'),
(28, 'adminIndex', 'edit_profile', 'Edit Profile'),
(29, 'adminIndex', 'log_out', 'Log out'),
(30, 'adminIndex', 'modules', 'Modules'),
(31, 'adminIndex', 'admin_tools', 'Administrator Tools'),
(32, 'adminIndex', 'menu_settings', 'Settings & Phrases'),
(33, 'adminIndex', 'menu_menumanager', 'Menu Manager'),
(34, 'adminIndex', 'menu_modules', 'Module Manager'),
(35, 'adminIndex', 'menu_templates', 'Template Manager'),
(36, 'adminIndex', 'menu_administrators', 'Administrators'),
(37, 'adminIndex', 'menu_users', 'User Management'),
(38, 'adminIndex', 'menu_utilities', 'Database Utilities'),
(39, 'adminIndex', 'menu_updates', 'Obsedb Upgrades'),
(40, 'adminAdministrators', 'addAdministratorCommit', '<center>Admin account has been created, <a href="administrators.php">click here to continue</a>.</center>'),
(41, 'adminConfiguration', 'module_header', 'Obsedb CMS Configuration'),
(42, 'adminConfiguration', 'module_header_links', 'Configure the settings of Obsedb CMS'),
(43, 'adminConfiguration', 'settings', 'Settings'),
(44, 'adminContent', 'module_header', 'Content Download System'),
(45, 'adminCustomFields', 'module_header', 'Custom Field Manager'),
(46, 'adminCustomFields', 'custom_fields', 'Custom Fields'),
(47, 'adminCustomFields', 'add_custom_field', 'Add Custom Field'),
(48, 'adminCustomFields', 'field_name', 'Field Name'),
(49, 'adminCustomFields', 'module', 'Module'),
(50, 'adminCustomFields', 'Mods_manager', 'Mods Manager'),
(51, 'adminAdministrators', 'resetPasswordCommit', '<center>Password has been updated, <a href="administrators.php">click here to continue</a>.</center>'),
(52, 'adminAdministrators', 'editAccountCommit', '<center>Admin account has been updated, <a href="administrators.php">click here to continue</a>.</center>'),
(53, 'adminAdministrators', 'add_admin', 'Add Admin'),
(54, '', '', ''),
(55, 'adminAdministrators', 'username', 'Username'),
(56, 'adminAdministrators', 'email_address', 'Email Address'),
(57, 'adminAdministrators', 'first_name', 'First Name'),
(58, 'adminAdministrators', 'last_name', 'Last Name'),
(59, 'adminAdministrators', 'password', 'Password'),
(60, 'adminAdministrators', 'confirm', 'Confirm'),
(61, 'adminAdministrators', 'edit_admin', 'Edit Admin'),
(62, 'adminAdministrators', 'change_password', 'Change Password'),
(63, 'adminAdministrators', 'save_changes', 'Save Changes'),
(64, 'adminAdministrators', 'new_password', 'New Password'),
(65, 'adminAdministrators', 'do_edit_user', 'Edit User'),
(66, 'adminAdministrators', 'do_delete_user', 'Delete User'),
(67, 'adminAdministrators', 'do_reset_password', 'Reset Password');

-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_polls`
-- 

DROP TABLE IF EXISTS `Obsedb_polls`;
CREATE TABLE `Obsedb_polls` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `Obsedb_polls`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_polls_iplog`
-- 

DROP TABLE IF EXISTS `Obsedb_polls_iplog`;
CREATE TABLE `Obsedb_polls_iplog` (
  `id` int(11) NOT NULL auto_increment,
  `pollid` int(11) NOT NULL default '0',
  `ip` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `Obsedb_polls_iplog`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_polls_options`
-- 

DROP TABLE IF EXISTS `Obsedb_polls_options`;
CREATE TABLE `Obsedb_polls_options` (
  `id` int(11) NOT NULL auto_increment,
  `poll_id` int(11) NOT NULL default '0',
  `text` text NOT NULL,
  `count` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `Obsedb_polls_options`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_previews`
-- 

DROP TABLE IF EXISTS `Obsedb_previews`;
CREATE TABLE `Obsedb_previews` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  `section` text NOT NULL,
  `intro` text NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Obsedb_previews`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_previews_sections`
-- 

DROP TABLE IF EXISTS `Obsedb_previews_sections`;
CREATE TABLE `Obsedb_previews_sections` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Obsedb_previews_sections`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_reviews`
-- 

DROP TABLE IF EXISTS `Obsedb_reviews`;
CREATE TABLE `Obsedb_reviews` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  `section` text NOT NULL,
  `Modid` int(11) NOT NULL default '0',
  `intro` text NOT NULL,
  `text` text NOT NULL,
  `Modplay` int(11) NOT NULL default '0',
  `graphics` int(11) NOT NULL default '0',
  `sound` int(11) NOT NULL default '0',
  `value` int(11) NOT NULL default '0',
  `tilt` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Obsedb_reviews`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_reviews_sections`
-- 

DROP TABLE IF EXISTS `Obsedb_reviews_sections`;
CREATE TABLE `Obsedb_reviews_sections` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `Obsedb_reviews_sections`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_screenshots`
-- 

DROP TABLE IF EXISTS `Obsedb_screenshots`;
CREATE TABLE `Obsedb_screenshots` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `section` int(11) NOT NULL default '0',
  `thumb` text NOT NULL,
  `screen` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=18 ;

-- 
-- Dumping data for table `Obsedb_screenshots`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_screenshots_sections`
-- 

DROP TABLE IF EXISTS `Obsedb_screenshots_sections`;
CREATE TABLE `Obsedb_screenshots_sections` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `Obsedb_screenshots_sections`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_support`
-- 

DROP TABLE IF EXISTS `Obsedb_support`;
CREATE TABLE `Obsedb_support` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `supportid` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `Obsedb_support`
-- 

INSERT INTO `Obsedb_support` (`id`, `title`, `link`, `supportid`) VALUES 
(1, 'Add Announcement', 'http://www.kzoo6forums.com/showthread.php?t=651', 'CPHOME'),
(2, 'Edit Announcement', 'http://www.kzoo6forums.com/showthread.php?t=652', 'CPHOME');

-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_templates`
-- 

DROP TABLE IF EXISTS `Obsedb_templates`;
CREATE TABLE `Obsedb_templates` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `template` varchar(255) NOT NULL default '',
  `html` text NOT NULL,
  `custom` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=22 ;

-- 
-- Dumping data for table `Obsedb_templates`
-- 

INSERT INTO `Obsedb_templates` (`id`, `title`, `template`, `html`, `custom`) VALUES 
(1, 'header', 'default', '<!DOCTYPE HTML PUBLIC \\"-//W3C//DTD HTML 4.01 Transitional//EN\\" \\"http://www.w3.org/TR/html4/loose.dtd\\">\r\n<html>\r\n<head>\r\n<title>{title}</title>\r\n<META NAME=\\"description\\" CONTENT=\\"{meta_description}\\">\r\n<META NAME=\\"keywords\\" CONTENT=\\"{meta_keywords}\\">\r\n<style type=\\"text/css\\">\r\n<!--\r\n{stylesheet}\r\n-->\r\n</style>\r\n</head>\r\n\r\n<body>\r\n\r\n<table border=\\''0\\'' cellspacing=\\''0\\'' cellpadding=\\''0\\'' width=\\''780\\'' align=\\''center\\''>\r\n	<tr>\r\n		<td colspan=\\"2\\" class=\\''header\\''><img src=\\''images/logo.jpg\\''></td>\r\n	</tr>\r\n	<tr>\r\n		<td colspan=\\"2\\" class=\\''tdnavbar\\''>\r\n		<div class=\\''navbar\\''>\r\n			<div class=\\''navbartop\\''><img src=\\''images/corners/navbar_tlc.gif\\'' width=\\''10\\'' height=\\''10\\'' class=\\''corner\\'' style=\\''display: none;\\''></div>\r\n			<p>{menu_top}</p>\r\n			<div class=\\''navbarbottom\\''><img src=\\''images/corners/navbar_blc.gif\\'' width=\\''10\\'' height=\\''10\\'' class=\\''corner\\'' style=\\''display: none;\\''></div>\r\n		</div>\r\n\r\n		</td>\r\n	</tr>\r\n	<tr>\r\n		<td width=\\''180\\'' class=\\''main_left\\'' valign=\\''top\\''>\r\n		<div class=\\''menu_left\\''>\r\n			<div class=\\''menu_left_top\\''>\r\n			<img src=\\''images/corners/leftmenu_tlc.gif\\'' width=\\''10\\'' height=\\''10\\'' class=\\''corner\\'' style=\\''display: none;\\''>\r\n			</div>\r\n			<p>\r\n			{menu_left}\r\n			</p>\r\n			<div class=\\''menu_left_bottom\\''>\r\n			<img src=\\''images/corners/leftmenu_blc.gif\\'' width=\\''10\\'' height=\\''10\\'' class=\\''corner\\'' style=\\''display: none;\\''>\r\n			</div>\r\n		</div><br />\r\n\r\n		<div class=\\''menu_left\\''>\r\n			<div class=\\''menu_left_top\\''>\r\n			<img src=\\''images/corners/leftmenu_tlc.gif\\'' width=\\''10\\'' height=\\''10\\'' class=\\''corner\\'' style=\\''display: none;\\''>\r\n			</div>\r\n			<p>\r\n\r\n			{menu_right}\r\n			<form method=\\"post\\" action=\\"poll_vote.php\\">\r\n			{menu_poll}\r\n			<input type=\\"submit\\" value=\\"Vote\\"></p>\r\n			</form>\r\n			</p>\r\n			<div class=\\''menu_left_bottom\\''>\r\n			<img src=\\''images/corners/leftmenu_blc.gif\\'' width=\\''10\\'' height=\\''10\\'' class=\\''corner\\'' style=\\''display: none;\\''>\r\n			</div>\r\n		</div><br />\r\n		\r\n		<div class=\\''menu_left\\''>\r\n			<div class=\\''menu_left_top\\''>\r\n			<img src=\\''images/corners/leftmenu_tlc.gif\\'' width=\\''10\\'' height=\\''10\\'' class=\\''corner\\'' style=\\''display: none;\\''>\r\n			</div>\r\n                        {login_box}\r\n			<div class=\\''menu_left_bottom\\''>\r\n			<img src=\\''images/corners/leftmenu_blc.gif\\'' width=\\''10\\'' height=\\''10\\'' class=\\''corner\\'' style=\\''display: none;\\''>\r\n			</div>\r\n		</div>\r\n\r\n		</td>\r\n		<td width=\\''600\\'' class=\\''main_center\\'' valign=\\''top\\''>', 0),
(2, 'footer', 'default', '\r\n	</td>\r\n	</tr>\r\n	<tr>\r\n		<td colspan="2" class=''tdnavbar2''>\r\n\r\n		<div class=''navbar''>\r\n			<div class=''navbartop''><img src=''images/corners/navbar_tlc.gif'' width=''10'' height=''10'' class=''corner'' style=''display: none;''></div>\r\n			<p>Powered by <a href="http://obsedb.co.cc" target="_blank">Obsedb CMS 0.0.1 Alpha</a> | {bottom}</p>\r\n			<div class=''navbarbottom''><img src=''images/corners/navbar_blc.gif'' width=''10'' height=''10'' class=''corner'' style=''display: none;''></div>\r\n		</div>\r\n\r\n		</td>\r\n	</tr>\r\n</table>', 0),
(3, 'log_in_box', 'default', '<form method="post" action="{action}"><p>\r\n<b>Username:</b><br />\r\n<input type="text" name="username" size="10" /><br />\r\n<b>Password:</b><br />\r\n<input type="password" name="password" size="10" /><br />\r\n<input type="submit" name="submit" value="Log in" />\r\n</p></form>', 0),
(4, 'logged_in_box', 'default', '<p>\r\n<b>{username}</b><br />\r\n<a href="logout.php">Log out</a>\r\n</p>', 0),
(5, 'Modlist_footer', 'default', '</table>', 0),
(6, 'Modlist_header', 'default', '<table border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"4\\" width=\\"100%\\">\r\n	<tr>\r\n		<td><b>{title}</b></td>\r\n      <td><b>{genre}</b></td>\r\n      <td><b>{release}</b></td>\r\n      <td><b>{section}</b></td>\r\n   </tr>\r\n	<tr>\r\n		<td colspan=\\"6\\" height=\\"1\\" bgcolor=\\"#C0C0C0\\"></td>\r\n	</tr>', 0),
(7, 'Modlist_row', 'default', '<tr>\r\n\r\n	<td bgcolor=\\"{bgcolor}\\" style=\\"font-size: 11px;\\">\r\n		<a href=\\"Moddetails.php?id={id}\\">{title}</a>\r\n	</td>\r\n\r\n	<td bgcolor=\\"{bgcolor}\\" style=\\"font-size: 11px;\\">\r\n		{genre}\r\n	</td>\r\n\r\n	<td bgcolor=\\"{bgcolor}\\" style=\\"font-size: 11px;\\">\r\n		{release}\r\n	</td>\r\n\r\n	<td bgcolor=\\"{bgcolor}\\" style=\\"font-size: 11px;\\">\r\n		{section}\r\n	</td>\r\n\r\n</tr>', 0),
(8, 'Mod_profile', 'default', '<div class=\\"alt1\\">\r\n  <div class=\\"alt1_top\\">\r\n    <img src=\\"images/corners/alt1_tlc.gif\\" class=\\"corner\\" width=\\"10\\" height=\\"10\\" style=\\"display: none;\\">\r\n    </div>\r\n  <p>\r\n    <b>{title}\r\n    <br />\r\n    <a href=\\"Moddetails.php?id=\\"{id}\\">Mod Info</a> | \r\n    {cheat_link} | \r\n    {download_link} | \r\n    <a href=\\"screenshots.php?do=list&id={id}\\">Screenshots</a></b>\r\n  </p>\r\n  <div class=\\"alt1_bottom\\">\r\n    <img src=\\"images/corners/alt1_blc.gif\\" class=\\"corner\\" width=\\"10\\" height=\\"10\\" style=\\"display: none;\\">\r\n    </div>\r\n</div><br />\r\n\r\n<div class=\\"alt2\\">\r\n  <div class=\\"alt2_top\\">\r\n    <img src=\\"images/corners/alt2_tlc.gif\\" class=\\"corner\\" width=\\"10\\" height=\\"10\\" style=\\"display: none;\\">\r\n    </div>\r\n  <p>\r\n    <b>Mod Details</b>\r\n  </p>\r\n  <div class=\\"alt2_bottom\\">\r\n    <img src=\\"images/corners/alt2_blc.gif\\" class=\\"corner\\" width=\\"10\\" height=\\"10\\" style=\\"display: none;\\">\r\n    </div>\r\n</div>\r\n\r\n   <table border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"5\\" width=\\"100%\\">\r\n   	<tr>\r\n        \r\n\r\n        \r\n   		<td valign=\\"top\\" width=\\"100%\\">\r\n   		<table border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"2\\">\r\n\r\n         \r\n         <tr>\r\n            <td><b>Developer:</b> {developer}</td>\r\n         </tr>\r\n         \r\n\r\n         \r\n         <tr>\r\n            <td><b>Publisher:</b> {publisher}</td>\r\n         </tr>\r\n         \r\n\r\n         \r\n         <tr>\r\n            <td><b>Genre:</b> {genre}</td>\r\n         </tr>\r\n         \r\n\r\n         \r\n         <tr>\r\n            <td><b>Release Date:</b> {release}</td>\r\n         </tr>\r\n         \r\n\r\n        \r\n         <tr>\r\n            <td><b>Multiplayer:</b> {multiplayer}</td>\r\n         </tr>\r\n         \r\n\r\n         {custom_fields}\r\n\r\n      </table>\r\n   		</td>\r\n        <td valign=\\"top\\">\r\n        {boxshot}\r\n        </td>\r\n   	</tr>\r\n   	<tr>\r\n   		<td colspan=\\"2\\">\r\n   		<table border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"2\\">\r\n\r\n   			<tr>\r\n   				<td><b>Minimum System Requirements</b></td>\r\n   			</tr>\r\n   			<tr>\r\n   				<td><b>Platform:</b> {platform}</td>\r\n   			</tr>\r\n\r\n         \r\n         <tr>\r\n            <td><b>System:</b> {system}</td>\r\n         </tr>\r\n         \r\n\r\n         \r\n         <tr>\r\n            <td><b>RAM:</b> {ram}</td>\r\n         </tr>\r\n         \r\n\r\n         \r\n         <tr>\r\n            <td><b>Video Memory:</b> {video}</td>\r\n         </tr>\r\n         \r\n\r\n         \r\n         <tr>\r\n            <td><b>Hard Drive Space:</b> {space}</td>\r\n         </tr>\r\n         \r\n\r\n         \r\n         <tr>\r\n            <td><b>Mouse:</b> {mouse}</td>\r\n         </tr>\r\n         \r\n\r\n         \r\n         <tr>\r\n            <td><b>DirectX:</b> {directx}</td>\r\n         </tr>\r\n         \r\n\r\n         \r\n         <tr>\r\n            <td><b>Sound Card:</b> {sound}</td>\r\n         </tr>\r\n         \r\n\r\n      </table>\r\n   		</td>\r\n   	</tr>\r\n   </table><br />\r\n\r\n   <div style=\\"border: 1px solid #C0C0C0; padding: 0px; background: #FFFFFF; \\">\r\n      <table border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"2\\" width=\\"100%\\" style=\\"background: #F1F1F1; color: #000000;\\">\r\n         <tr>\r\n            <td style=\\"padding-left: 4px;\\">\r\n               <font style=\\"font-size: 11px;\\">Description</font>\r\n            </td>\r\n         </tr>\r\n      </table>\r\n      <div style=\\"padding: 3px;\\">\r\n         <table border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"3\\" >\r\n            <tr>\r\n\r\n               <td valign=\\"top\\">\r\n               {description}\r\n               </td>\r\n            </tr>\r\n         </table>\r\n      </div>\r\n   </div>\r\n<br />\r\n<div class=\\"alt2\\">\r\n  <div class=\\"alt2_top\\">\r\n    <img src=\\"images/corners/alt2_tlc.gif\\" class=\\"corner\\" width=\\"10\\" height=\\"10\\" style=\\"display: none;\\">\r\n    </div>\r\n  <p>\r\n    This Mod has been viewed {views} times.\r\n  </p>\r\n  <div class=\\"alt2_bottom\\">\r\n    <img src=\\"images/corners/alt2_blc.gif\\" class=\\"corner\\" width=\\"10\\" height=\\"10\\" style=\\"display: none;\\">\r\n    </div>\r\n</div>\r\n<br />\r\n', 0),
(9, 'cheats_header', 'default', '<table border="0" cellspacing="1" cellpadding="3" width="100%">\r\n	<tr>\r\n		<td style="font-size: 9pt;"><b>{title}</b></td>\r\n	</tr>\r\n	<tr>\r\n		<td height="1" bgcolor="#808080"></td>\r\n	</tr>\r\n	<tr>\r\n		<td style="font-size: 8pt;">\r\n		<a href="Moddetails.php?id={id}">Mod Info</a> |\r\n		Cheats\r\n		</td>\r\n	</tr>\r\n</table><br />\r\n\r\n<font style="font-size: 11px;">', 0),
(10, 'company_profile', 'default', '<b>{title}</b><br />\r\n{homepage}<br /><br />\r\n\r\n{logo}\r\n\r\n{description}', 0),
(11, 'company_profile_devlinks', 'default', '			<table border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"5\\" width=\\"100%\\">\r\n				<tr>\r\n					<td background=\\"images/gradient_1.jpg\\" style=\\"color:#FFF;font-size: 11px;\\">\r\n					<b>Developer</b>\r\n					</td>\r\n				</tr>\r\n				<tr>\r\n					<td>\r\n\r\n					{links}\r\n\r\n					</td>\r\n				</tr>\r\n			</table>', 0),
(12, 'company_profile_publinks', 'default', '<table border="0" cellspacing="0" cellpadding="5" width="100%">\r\n<tr>\r\n<td background="images/gradient_1.jpg" style="color:#FFF;font-size: 11px;">\r\n<b>Publisher</b>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n\r\n{links}\r\n\r\n</td>\r\n</tr>\r\n</table>', 0),
(13, 'stylesheet', 'default', 'body { font-size: 10pt; font-family: arial, tahoma, verdana; padding: 0px; margin: 0px; background-color: #002f2f; }\r\ntd, p, div { font-size: 8pt; font-family: arial, tahoma, verdana; }\r\n\r\n.header { background-color: #ffffff; }\r\n.main_center { background-color: #ffffff; width: 600px; padding-right: 10px; padding-top: 10px; }\r\n.main_left { background-color: #ffffff; width: 150px; padding: 10px;}\r\n.tdnavbar { padding-left: 10px; padding-right: 10px; background-color: #ffffff; }\r\n.tdnavbar2 { padding: 10px; background-color: #ffffff; }\r\n.menu_left { width: 150px; background-color: #a7a37e; color: #002f2f; }\r\n.menu_left p { margin: 0 10px; font-size: 11px; font-weight: bold; line-height: 150%; color: #ffffff; }\r\n.menu_left a:link { color: #ffffff; }\r\n.menu_left a:visited { color: #ffffff; }\r\n.menu_left a:active { color: #ffffff; }\r\n.menu_left a:hover { color: #ffffff; }\r\n.menu_left_top { background: url(images/corners/leftmenu_trc.gif) no-repeat top right; }\r\n.menu_left_bottom { background: url(images/corners/leftmenu_brc.gif) no-repeat top right; }\r\n.alt1 { width: 600px; background-color: #efecca; color: #002f2f; }\r\n.alt1 p { margin: 0 10px; font-size: 11px; line-height: 150%; color: #002f2f; }\r\n.alt1 a:link { color: #046380; }\r\n.alt1 a:visited { color: #046380; }\r\n.alt1 a:active { color: #046380; }\r\n.alt1 a:hover { color: #046380; }\r\n.alt1_top { background: url(images/corners/alt1_trc.gif) no-repeat top right; }\r\n.alt1_bottom { background: url(images/corners/alt1_brc.gif) no-repeat top right; }\r\n.alt2 { width: 600px; background-color: #e6e2af; color: #002f2f; }\r\n.alt2 p { margin: 0 10px; font-size: 11px; line-height: 150%; color: #002f2f; }\r\n.alt2 a:link { color: #046380; }\r\n.alt2 a:visited { color: #046380; }\r\n.alt2 a:active { color: #046380; }\r\n.alt2 a:hover { color: #046380; }\r\n.alt2_top { background: url(images/corners/alt2_trc.gif) no-repeat top right; }\r\n.alt2_bottom { background: url(images/corners/alt2_brc.gif) no-repeat top right; }\r\n.navbar {\r\n	width: 760px;\r\n	background-color: #046380;\r\n	color: #fff;\r\n}\r\n\r\n.navbar p {\r\n	margin: 0 10px;\r\n	font-size: 11px;\r\n	font-weight: bold;\r\n}\r\n\r\n.navbar a:link { color: #ffffff; }\r\n.navbar a:visited { color: #ffffff; }\r\n.navbar a:active { color: #ffffff; }\r\n.navbar a:hover { color: #ffffff; }\r\n\r\n.navbartop {\r\n	background: url(images/corners/navbar_trc.gif) no-repeat top right;\r\n}\r\n\r\n.navbarbottom {\r\n	background: url(images/corners/navbar_brc.gif) no-repeat top right;\r\n}\r\n\r\nimg.corner {\r\n   width: 10px;\r\n   height: 10px;\r\n   border: none;\r\n   display: block !important;\r\n}', 0),
(14, 'company_list', 'default', '<br />\r\n\r\n<table border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"5\\" width=\\"100%\\">\r\n	<tr>\r\n		<td background=\\"images/gradient_1.jpg\\" style=\\"color:#FFF;font-size: 11px;\\">\r\n		<b>Company Profiles</b>\r\n		</td>\r\n	</tr>\r\n	<tr>\r\n		<td>\r\n		{company_list}\r\n		</td>\r\n	</tr>\r\n</table>', 0),
(15, 'downloads_header', 'default', '<table border=\\"0\\" cellspacing=\\"1\\" cellpadding=\\"3\\" width=\\"100%\\">\r\n	<tr>\r\n		<td style=\\"font-size: 9pt;\\"><b>{title}</b></td>\r\n	</tr>\r\n	<tr>\r\n		<td height=\\"1\\" bgcolor=\\"#808080\\"></td>\r\n	</tr>\r\n	<tr>\r\n		<td style=\\"font-size: 8pt;\\">\r\n		<a href=\\"Moddetails.php?id={id}\\">Mod Info</a> |\r\n		{cheat_link} |\r\n                Downloads\r\n		</td>\r\n	</tr>\r\n        <tr>\r\n           <td>', 0),
(17, 'mailbag_header', 'default', '', 0),
(16, 'downloads_footer', 'default', '</table>', 0),
(18, 'mailbag_footer', 'default', '', 0),
(19, 'mailbag_item', 'default', '<div class="alt1">\r\n    <div class="alt1_top">\r\n    <img src="images/corners/alt1_tlc.gif" class="corner" width="10" height="10" style="display: none;">\r\n    </div>\r\n    <p>Subject: {title}<br /><br />\r\n\r\n{message}</p>\r\n    <div class="alt1_bottom">\r\n    <img src="images/corners/alt1_blc.gif" class="corner" width="10" height="10" style="display: none;">\r\n    </div>\r\n</div><br />\r\n<div class="alt2">\r\n    <div class="alt2_top">\r\n    <img src="images/corners/alt2_tlc.gif" class="corner" width="10" height="10" style="display: none;">\r\n    </div>\r\n    <p>{reply}</p>\r\n    <div class="alt2_bottom">\r\n    <img src="images/corners/alt2_blc.gif" class="corner" width="10" height="10" style="display: none;">\r\n    </div>\r\n</div><br />', 0),
(20, 'frontpage_latest_Mods', 'default', '<div>\r\n<b>Latest Mods</b>\r\n</div>\r\n\r\n{Mods}', 0),
(21, 'frontpage_popular_Mods', 'default', '<div style="padding-left: 10px;">\r\n\r\n<div><b>Most Popular Mods</b></div>\r\n\r\n{Mods}\r\n\r\n</div>', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `Obsedb_users`
-- 

DROP TABLE IF EXISTS `Obsedb_users`;
CREATE TABLE `Obsedb_users` (
  `ID` int(11) NOT NULL auto_increment,
  `USERNAME` varchar(255) NOT NULL default '',
  `PASSWORD` varchar(255) NOT NULL default '',
  `EMAIL` varchar(255) NOT NULL default '',
  `LASTLOG` datetime NOT NULL default '0000-00-00 00:00:00',
  `EXPIRE` datetime NOT NULL default '0000-00-00 00:00:00',
  `FNAME` varchar(255) NOT NULL default '',
  `LNAME` varchar(255) NOT NULL default '',
  `PHONE` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `USERNAME` (`USERNAME`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `Obsedb_users`
-- 