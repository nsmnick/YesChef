#
# SQL Export
# Created by Querious (201069)
# Created: 13 April 2020 at 20:44:48 BST
# Encoding: Unicode (UTF-8)
#


SET @PREVIOUS_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS;
SET FOREIGN_KEY_CHECKS = 0;


DROP TABLE IF EXISTS `as_users`;
DROP TABLE IF EXISTS `as_usermeta`;
DROP TABLE IF EXISTS `as_terms`;
DROP TABLE IF EXISTS `as_termmeta`;
DROP TABLE IF EXISTS `as_term_taxonomy`;
DROP TABLE IF EXISTS `as_term_relationships`;
DROP TABLE IF EXISTS `as_posts`;
DROP TABLE IF EXISTS `as_postmeta`;
DROP TABLE IF EXISTS `as_options`;
DROP TABLE IF EXISTS `as_links`;
DROP TABLE IF EXISTS `as_comments`;
DROP TABLE IF EXISTS `as_commentmeta`;


CREATE TABLE `as_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


CREATE TABLE `as_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_author_email` (`comment_author_email`(10))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


CREATE TABLE `as_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


CREATE TABLE `as_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `option_value` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`),
  KEY `autoload` (`autoload`)
) ENGINE=InnoDB AUTO_INCREMENT=242 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


CREATE TABLE `as_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=210 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


CREATE TABLE `as_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_title` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_excerpt` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `to_ping` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `pinged` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`(191)),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


CREATE TABLE `as_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


CREATE TABLE `as_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


CREATE TABLE `as_termmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `term_id` (`term_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


CREATE TABLE `as_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  KEY `slug` (`slug`(191)),
  KEY `name` (`name`(191))
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


CREATE TABLE `as_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


CREATE TABLE `as_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`),
  KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;




SET FOREIGN_KEY_CHECKS = @PREVIOUS_FOREIGN_KEY_CHECKS;


SET @PREVIOUS_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS;
SET FOREIGN_KEY_CHECKS = 0;


LOCK TABLES `as_commentmeta` WRITE;
ALTER TABLE `as_commentmeta` DISABLE KEYS;
ALTER TABLE `as_commentmeta` ENABLE KEYS;
UNLOCK TABLES;


LOCK TABLES `as_comments` WRITE;
ALTER TABLE `as_comments` DISABLE KEYS;
INSERT INTO `as_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES 
	(1,1,'A WordPress Commenter','wapuu@wordpress.example','https://wordpress.org/','','2020-04-09 11:47:43','2020-04-09 10:47:43','Hi, this is a comment.\nTo get started with moderating, editing, and deleting comments, please visit the Comments screen in the dashboard.\nCommenter avatars come from <a href="https://gravatar.com">Gravatar</a>.',0,'1','','',0,0);
ALTER TABLE `as_comments` ENABLE KEYS;
UNLOCK TABLES;


LOCK TABLES `as_links` WRITE;
ALTER TABLE `as_links` DISABLE KEYS;
ALTER TABLE `as_links` ENABLE KEYS;
UNLOCK TABLES;


LOCK TABLES `as_options` WRITE;
ALTER TABLE `as_options` DISABLE KEYS;
INSERT INTO `as_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES 
	(1,'siteurl','http://amberstone','yes'),
	(2,'home','http://amberstone','yes'),
	(3,'blogname','Amberstone','yes'),
	(4,'blogdescription','','yes'),
	(5,'users_can_register','0','yes'),
	(6,'admin_email','nick@nsmdigital.com','yes'),
	(7,'start_of_week','1','yes'),
	(8,'use_balanceTags','0','yes'),
	(9,'use_smilies','1','yes'),
	(10,'require_name_email','1','yes'),
	(11,'comments_notify','1','yes'),
	(12,'posts_per_rss','10','yes'),
	(13,'rss_use_excerpt','0','yes'),
	(14,'mailserver_url','mail.example.com','yes'),
	(15,'mailserver_login','login@example.com','yes'),
	(16,'mailserver_pass','password','yes'),
	(17,'mailserver_port','110','yes'),
	(18,'default_category','1','yes'),
	(19,'default_comment_status','open','yes'),
	(20,'default_ping_status','open','yes'),
	(21,'default_pingback_flag','0','yes'),
	(22,'posts_per_page','10','yes'),
	(23,'date_format','j F Y','yes'),
	(24,'time_format','g:i a','yes'),
	(25,'links_updated_date_format','j F Y H:i','yes'),
	(26,'comment_moderation','0','yes'),
	(27,'moderation_notify','1','yes'),
	(28,'permalink_structure','/%year%/%monthnum%/%day%/%postname%/','yes'),
	(29,'rewrite_rules','a:92:{s:11:"^wp-json/?$";s:22:"index.php?rest_route=/";s:14:"^wp-json/(.*)?";s:33:"index.php?rest_route=/$matches[1]";s:21:"^index.php/wp-json/?$";s:22:"index.php?rest_route=/";s:24:"^index.php/wp-json/(.*)?";s:33:"index.php?rest_route=/$matches[1]";s:47:"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$";s:52:"index.php?category_name=$matches[1]&feed=$matches[2]";s:42:"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$";s:52:"index.php?category_name=$matches[1]&feed=$matches[2]";s:23:"category/(.+?)/embed/?$";s:46:"index.php?category_name=$matches[1]&embed=true";s:35:"category/(.+?)/page/?([0-9]{1,})/?$";s:53:"index.php?category_name=$matches[1]&paged=$matches[2]";s:17:"category/(.+?)/?$";s:35:"index.php?category_name=$matches[1]";s:44:"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?tag=$matches[1]&feed=$matches[2]";s:39:"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?tag=$matches[1]&feed=$matches[2]";s:20:"tag/([^/]+)/embed/?$";s:36:"index.php?tag=$matches[1]&embed=true";s:32:"tag/([^/]+)/page/?([0-9]{1,})/?$";s:43:"index.php?tag=$matches[1]&paged=$matches[2]";s:14:"tag/([^/]+)/?$";s:25:"index.php?tag=$matches[1]";s:45:"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?post_format=$matches[1]&feed=$matches[2]";s:40:"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?post_format=$matches[1]&feed=$matches[2]";s:21:"type/([^/]+)/embed/?$";s:44:"index.php?post_format=$matches[1]&embed=true";s:33:"type/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?post_format=$matches[1]&paged=$matches[2]";s:15:"type/([^/]+)/?$";s:33:"index.php?post_format=$matches[1]";s:12:"robots\\.txt$";s:18:"index.php?robots=1";s:13:"favicon\\.ico$";s:19:"index.php?favicon=1";s:48:".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$";s:18:"index.php?feed=old";s:20:".*wp-app\\.php(/.*)?$";s:19:"index.php?error=403";s:18:".*wp-register.php$";s:23:"index.php?register=true";s:32:"feed/(feed|rdf|rss|rss2|atom)/?$";s:27:"index.php?&feed=$matches[1]";s:27:"(feed|rdf|rss|rss2|atom)/?$";s:27:"index.php?&feed=$matches[1]";s:8:"embed/?$";s:21:"index.php?&embed=true";s:20:"page/?([0-9]{1,})/?$";s:28:"index.php?&paged=$matches[1]";s:27:"comment-page-([0-9]{1,})/?$";s:38:"index.php?&page_id=7&cpage=$matches[1]";s:41:"comments/feed/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?&feed=$matches[1]&withcomments=1";s:36:"comments/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?&feed=$matches[1]&withcomments=1";s:17:"comments/embed/?$";s:21:"index.php?&embed=true";s:44:"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:40:"index.php?s=$matches[1]&feed=$matches[2]";s:39:"search/(.+)/(feed|rdf|rss|rss2|atom)/?$";s:40:"index.php?s=$matches[1]&feed=$matches[2]";s:20:"search/(.+)/embed/?$";s:34:"index.php?s=$matches[1]&embed=true";s:32:"search/(.+)/page/?([0-9]{1,})/?$";s:41:"index.php?s=$matches[1]&paged=$matches[2]";s:14:"search/(.+)/?$";s:23:"index.php?s=$matches[1]";s:47:"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?author_name=$matches[1]&feed=$matches[2]";s:42:"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?author_name=$matches[1]&feed=$matches[2]";s:23:"author/([^/]+)/embed/?$";s:44:"index.php?author_name=$matches[1]&embed=true";s:35:"author/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?author_name=$matches[1]&paged=$matches[2]";s:17:"author/([^/]+)/?$";s:33:"index.php?author_name=$matches[1]";s:69:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$";s:80:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]";s:64:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$";s:80:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]";s:45:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$";s:74:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true";s:57:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$";s:81:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]";s:39:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$";s:63:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]";s:56:"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$";s:64:"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]";s:51:"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$";s:64:"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]";s:32:"([0-9]{4})/([0-9]{1,2})/embed/?$";s:58:"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true";s:44:"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$";s:65:"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]";s:26:"([0-9]{4})/([0-9]{1,2})/?$";s:47:"index.php?year=$matches[1]&monthnum=$matches[2]";s:43:"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?year=$matches[1]&feed=$matches[2]";s:38:"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?year=$matches[1]&feed=$matches[2]";s:19:"([0-9]{4})/embed/?$";s:37:"index.php?year=$matches[1]&embed=true";s:31:"([0-9]{4})/page/?([0-9]{1,})/?$";s:44:"index.php?year=$matches[1]&paged=$matches[2]";s:13:"([0-9]{4})/?$";s:26:"index.php?year=$matches[1]";s:58:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:68:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:88:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:83:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:83:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:64:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:53:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/embed/?$";s:91:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&embed=true";s:57:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/trackback/?$";s:85:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&tb=1";s:77:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:97:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]";s:72:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:97:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]";s:65:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/page/?([0-9]{1,})/?$";s:98:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&paged=$matches[5]";s:72:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/comment-page-([0-9]{1,})/?$";s:98:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&cpage=$matches[5]";s:61:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)(?:/([0-9]+))?/?$";s:97:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&page=$matches[5]";s:47:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:57:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:77:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:72:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:72:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:53:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:64:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$";s:81:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&cpage=$matches[4]";s:51:"([0-9]{4})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$";s:65:"index.php?year=$matches[1]&monthnum=$matches[2]&cpage=$matches[3]";s:38:"([0-9]{4})/comment-page-([0-9]{1,})/?$";s:44:"index.php?year=$matches[1]&cpage=$matches[2]";s:27:".?.+?/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:37:".?.+?/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:57:".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:33:".?.+?/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:16:"(.?.+?)/embed/?$";s:41:"index.php?pagename=$matches[1]&embed=true";s:20:"(.?.+?)/trackback/?$";s:35:"index.php?pagename=$matches[1]&tb=1";s:40:"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?pagename=$matches[1]&feed=$matches[2]";s:35:"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?pagename=$matches[1]&feed=$matches[2]";s:28:"(.?.+?)/page/?([0-9]{1,})/?$";s:48:"index.php?pagename=$matches[1]&paged=$matches[2]";s:35:"(.?.+?)/comment-page-([0-9]{1,})/?$";s:48:"index.php?pagename=$matches[1]&cpage=$matches[2]";s:24:"(.?.+?)(?:/([0-9]+))?/?$";s:47:"index.php?pagename=$matches[1]&page=$matches[2]";}','yes'),
	(30,'hack_file','0','yes'),
	(31,'blog_charset','UTF-8','yes'),
	(32,'moderation_keys','','no'),
	(33,'active_plugins','a:3:{i:0;s:29:"acf-repeater/acf-repeater.php";i:1;s:30:"advanced-custom-fields/acf.php";i:2;s:33:"classic-editor/classic-editor.php";}','yes'),
	(34,'category_base','','yes'),
	(35,'ping_sites','http://rpc.pingomatic.com/','yes'),
	(36,'comment_max_links','2','yes'),
	(37,'gmt_offset','','yes'),
	(38,'default_email_category','1','yes'),
	(39,'recently_edited','','no'),
	(40,'template','amberstone','yes'),
	(41,'stylesheet','amberstone','yes'),
	(42,'comment_whitelist','1','yes'),
	(43,'blacklist_keys','','no'),
	(44,'comment_registration','0','yes'),
	(45,'html_type','text/html','yes'),
	(46,'use_trackback','0','yes'),
	(47,'default_role','subscriber','yes'),
	(48,'db_version','47018','yes'),
	(49,'uploads_use_yearmonth_folders','1','yes'),
	(50,'upload_path','','yes'),
	(51,'blog_public','0','yes'),
	(52,'default_link_category','2','yes'),
	(53,'show_on_front','page','yes'),
	(54,'tag_base','','yes'),
	(55,'show_avatars','1','yes'),
	(56,'avatar_rating','G','yes'),
	(57,'upload_url_path','','yes'),
	(58,'thumbnail_size_w','150','yes'),
	(59,'thumbnail_size_h','150','yes'),
	(60,'thumbnail_crop','1','yes'),
	(61,'medium_size_w','300','yes'),
	(62,'medium_size_h','300','yes'),
	(63,'avatar_default','mystery','yes'),
	(64,'large_size_w','1024','yes'),
	(65,'large_size_h','1024','yes'),
	(66,'image_default_link_type','none','yes'),
	(67,'image_default_size','','yes'),
	(68,'image_default_align','','yes'),
	(69,'close_comments_for_old_posts','0','yes'),
	(70,'close_comments_days_old','14','yes'),
	(71,'thread_comments','1','yes'),
	(72,'thread_comments_depth','5','yes'),
	(73,'page_comments','0','yes'),
	(74,'comments_per_page','50','yes'),
	(75,'default_comments_page','newest','yes'),
	(76,'comment_order','asc','yes'),
	(77,'sticky_posts','a:0:{}','yes'),
	(78,'widget_categories','a:2:{i:2;a:4:{s:5:"title";s:0:"";s:5:"count";i:0;s:12:"hierarchical";i:0;s:8:"dropdown";i:0;}s:12:"_multiwidget";i:1;}','yes'),
	(79,'widget_text','a:0:{}','yes'),
	(80,'widget_rss','a:0:{}','yes'),
	(81,'uninstall_plugins','a:1:{s:33:"classic-editor/classic-editor.php";a:2:{i:0;s:14:"Classic_Editor";i:1;s:9:"uninstall";}}','no'),
	(82,'timezone_string','Europe/London','yes'),
	(83,'page_for_posts','0','yes'),
	(84,'page_on_front','7','yes'),
	(85,'default_post_format','0','yes'),
	(86,'link_manager_enabled','0','yes'),
	(87,'finished_splitting_shared_terms','1','yes'),
	(88,'site_icon','0','yes'),
	(89,'medium_large_size_w','768','yes'),
	(90,'medium_large_size_h','0','yes'),
	(91,'wp_page_for_privacy_policy','3','yes'),
	(92,'show_comments_cookies_opt_in','1','yes'),
	(93,'admin_email_lifespan','1601981263','yes'),
	(94,'initial_db_version','47018','yes'),
	(95,'as_user_roles','a:5:{s:13:"administrator";a:2:{s:4:"name";s:13:"Administrator";s:12:"capabilities";a:61:{s:13:"switch_themes";b:1;s:11:"edit_themes";b:1;s:16:"activate_plugins";b:1;s:12:"edit_plugins";b:1;s:10:"edit_users";b:1;s:10:"edit_files";b:1;s:14:"manage_options";b:1;s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:6:"import";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:8:"level_10";b:1;s:7:"level_9";b:1;s:7:"level_8";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;s:12:"delete_users";b:1;s:12:"create_users";b:1;s:17:"unfiltered_upload";b:1;s:14:"edit_dashboard";b:1;s:14:"update_plugins";b:1;s:14:"delete_plugins";b:1;s:15:"install_plugins";b:1;s:13:"update_themes";b:1;s:14:"install_themes";b:1;s:11:"update_core";b:1;s:10:"list_users";b:1;s:12:"remove_users";b:1;s:13:"promote_users";b:1;s:18:"edit_theme_options";b:1;s:13:"delete_themes";b:1;s:6:"export";b:1;}}s:6:"editor";a:2:{s:4:"name";s:6:"Editor";s:12:"capabilities";a:34:{s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;}}s:6:"author";a:2:{s:4:"name";s:6:"Author";s:12:"capabilities";a:10:{s:12:"upload_files";b:1;s:10:"edit_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:4:"read";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;s:22:"delete_published_posts";b:1;}}s:11:"contributor";a:2:{s:4:"name";s:11:"Contributor";s:12:"capabilities";a:5:{s:10:"edit_posts";b:1;s:4:"read";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;}}s:10:"subscriber";a:2:{s:4:"name";s:10:"Subscriber";s:12:"capabilities";a:2:{s:4:"read";b:1;s:7:"level_0";b:1;}}}','yes'),
	(96,'fresh_site','0','yes'),
	(97,'WPLANG','en_GB','yes'),
	(98,'widget_search','a:2:{i:2;a:1:{s:5:"title";s:0:"";}s:12:"_multiwidget";i:1;}','yes'),
	(99,'widget_recent-posts','a:2:{i:2;a:2:{s:5:"title";s:0:"";s:6:"number";i:5;}s:12:"_multiwidget";i:1;}','yes'),
	(100,'widget_recent-comments','a:2:{i:2;a:2:{s:5:"title";s:0:"";s:6:"number";i:5;}s:12:"_multiwidget";i:1;}','yes'),
	(101,'widget_archives','a:2:{i:2;a:3:{s:5:"title";s:0:"";s:5:"count";i:0;s:8:"dropdown";i:0;}s:12:"_multiwidget";i:1;}','yes'),
	(102,'widget_meta','a:2:{i:2;a:1:{s:5:"title";s:0:"";}s:12:"_multiwidget";i:1;}','yes'),
	(103,'sidebars_widgets','a:4:{s:19:"wp_inactive_widgets";a:3:{i:0;s:10:"archives-2";i:1;s:12:"categories-2";i:2;s:6:"meta-2";}s:15:"default-sidebar";a:3:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";}s:4:"blog";a:0:{}s:13:"array_version";i:3;}','yes'),
	(104,'cron','a:7:{i:1586807264;a:1:{s:34:"wp_privacy_delete_old_export_files";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:6:"hourly";s:4:"args";a:0:{}s:8:"interval";i:3600;}}}i:1586818064;a:3:{s:16:"wp_version_check";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}s:17:"wp_update_plugins";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}s:16:"wp_update_themes";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1586861263;a:1:{s:32:"recovery_mode_clean_expired_keys";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1586861340;a:2:{s:19:"wp_scheduled_delete";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}s:25:"delete_expired_transients";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1586861341;a:1:{s:30:"wp_scheduled_auto_draft_delete";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1587120463;a:1:{s:30:"wp_site_health_scheduled_check";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:6:"weekly";s:4:"args";a:0:{}s:8:"interval";i:604800;}}}s:7:"version";i:2;}','yes'),
	(105,'widget_pages','a:1:{s:12:"_multiwidget";i:1;}','yes'),
	(106,'widget_calendar','a:1:{s:12:"_multiwidget";i:1;}','yes'),
	(107,'widget_media_audio','a:1:{s:12:"_multiwidget";i:1;}','yes'),
	(108,'widget_media_image','a:1:{s:12:"_multiwidget";i:1;}','yes'),
	(109,'widget_media_gallery','a:1:{s:12:"_multiwidget";i:1;}','yes'),
	(110,'widget_media_video','a:1:{s:12:"_multiwidget";i:1;}','yes'),
	(111,'widget_tag_cloud','a:1:{s:12:"_multiwidget";i:1;}','yes'),
	(112,'widget_nav_menu','a:1:{s:12:"_multiwidget";i:1;}','yes'),
	(113,'widget_custom_html','a:1:{s:12:"_multiwidget";i:1;}','yes'),
	(115,'recovery_keys','a:0:{}','yes'),
	(126,'_site_transient_timeout_browser_95be41247dd05122a994bb1a7aff6d9a','1587034141','no'),
	(127,'_site_transient_browser_95be41247dd05122a994bb1a7aff6d9a','a:10:{s:4:"name";s:6:"Chrome";s:7:"version";s:13:"80.0.3987.149";s:8:"platform";s:9:"Macintosh";s:10:"update_url";s:29:"https://www.google.com/chrome";s:7:"img_src";s:43:"http://s.w.org/images/browsers/chrome.png?1";s:11:"img_src_ssl";s:44:"https://s.w.org/images/browsers/chrome.png?1";s:15:"current_version";s:2:"18";s:7:"upgrade";b:0;s:8:"insecure";b:0;s:6:"mobile";b:0;}','no'),
	(128,'_site_transient_timeout_php_check_cd0d3c01d5de47172fb0980b9e484085','1587034141','no'),
	(129,'_site_transient_php_check_cd0d3c01d5de47172fb0980b9e484085','a:5:{s:19:"recommended_version";s:3:"7.3";s:15:"minimum_version";s:6:"5.6.20";s:12:"is_supported";b:1;s:9:"is_secure";b:1;s:13:"is_acceptable";b:1;}','no'),
	(137,'can_compress_scripts','1','no'),
	(144,'theme_mods_twentytwenty','a:1:{s:16:"sidebars_widgets";a:2:{s:4:"time";i:1586429347;s:4:"data";a:3:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:3:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";}s:9:"sidebar-2";a:3:{i:0;s:10:"archives-2";i:1;s:12:"categories-2";i:2;s:6:"meta-2";}}}}','yes'),
	(145,'current_theme','TateResidences','yes'),
	(146,'theme_mods_amberstone','a:3:{i:0;b:0;s:18:"nav_menu_locations";a:6:{s:9:"main-menu";i:2;s:17:"footer-menu-about";i:3;s:20:"footer-menu-services";i:4;s:19:"footer-menu-company";i:5;s:21:"footer-menu-company-1";i:5;s:21:"footer-menu-company-2";i:6;}s:18:"custom_css_post_id";i:-1;}','yes'),
	(147,'theme_switched','','yes'),
	(171,'new_admin_email','nick@nsmdigital.com','yes'),
	(174,'recently_activated','a:0:{}','yes'),
	(175,'acf_version','5.8.9','yes'),
	(178,'nav_menu_options','a:2:{i:0;b:0;s:8:"auto_add";a:0:{}}','yes'),
	(182,'_transient_health-check-site-status-result','{"good":10,"recommended":7,"critical":0}','yes'),
	(235,'_site_transient_update_core','O:8:"stdClass":4:{s:7:"updates";a:1:{i:0;O:8:"stdClass":10:{s:8:"response";s:6:"latest";s:8:"download";s:63:"https://downloads.wordpress.org/release/en_GB/wordpress-5.4.zip";s:6:"locale";s:5:"en_GB";s:8:"packages";O:8:"stdClass":5:{s:4:"full";s:63:"https://downloads.wordpress.org/release/en_GB/wordpress-5.4.zip";s:10:"no_content";b:0;s:11:"new_bundled";b:0;s:7:"partial";b:0;s:8:"rollback";b:0;}s:7:"current";s:3:"5.4";s:7:"version";s:3:"5.4";s:11:"php_version";s:6:"5.6.20";s:13:"mysql_version";s:3:"5.0";s:11:"new_bundled";s:3:"5.3";s:15:"partial_version";s:0:"";}}s:12:"last_checked";i:1586775195;s:15:"version_checked";s:3:"5.4";s:12:"translations";a:1:{i:0;a:7:{s:4:"type";s:4:"core";s:4:"slug";s:7:"default";s:8:"language";s:5:"en_GB";s:7:"version";s:3:"5.4";s:7:"updated";s:19:"2020-04-07 15:53:44";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/5.4/en_GB.zip";s:10:"autoupdate";b:1;}}}','no'),
	(236,'_site_transient_update_themes','O:8:"stdClass":4:{s:12:"last_checked";i:1586783961;s:7:"checked";a:1:{s:10:"amberstone";s:1:"1";}s:8:"response";a:0:{}s:12:"translations";a:0:{}}','no'),
	(237,'_site_transient_update_plugins','O:8:"stdClass":5:{s:12:"last_checked";i:1586775198;s:7:"checked";a:6:{s:30:"advanced-custom-fields/acf.php";s:5:"5.8.9";s:29:"acf-repeater/acf-repeater.php";s:5:"2.1.0";s:33:"classic-editor/classic-editor.php";s:3:"1.5";s:41:"better-wp-security/better-wp-security.php";s:5:"7.6.1";s:41:"password-protected/password-protected.php";s:5:"2.2.5";s:24:"wordpress-seo/wp-seo.php";s:6:"12.9.1";}s:8:"response";a:1:{s:24:"wordpress-seo/wp-seo.php";O:8:"stdClass":12:{s:2:"id";s:27:"w.org/plugins/wordpress-seo";s:4:"slug";s:13:"wordpress-seo";s:6:"plugin";s:24:"wordpress-seo/wp-seo.php";s:11:"new_version";s:6:"13.4.1";s:3:"url";s:44:"https://wordpress.org/plugins/wordpress-seo/";s:7:"package";s:63:"https://downloads.wordpress.org/plugin/wordpress-seo.13.4.1.zip";s:5:"icons";a:3:{s:2:"2x";s:66:"https://ps.w.org/wordpress-seo/assets/icon-256x256.png?rev=1834347";s:2:"1x";s:58:"https://ps.w.org/wordpress-seo/assets/icon.svg?rev=1946641";s:3:"svg";s:58:"https://ps.w.org/wordpress-seo/assets/icon.svg?rev=1946641";}s:7:"banners";a:2:{s:2:"2x";s:69:"https://ps.w.org/wordpress-seo/assets/banner-1544x500.png?rev=1843435";s:2:"1x";s:68:"https://ps.w.org/wordpress-seo/assets/banner-772x250.png?rev=1843435";}s:11:"banners_rtl";a:2:{s:2:"2x";s:73:"https://ps.w.org/wordpress-seo/assets/banner-1544x500-rtl.png?rev=1843435";s:2:"1x";s:72:"https://ps.w.org/wordpress-seo/assets/banner-772x250-rtl.png?rev=1843435";}s:6:"tested";s:3:"5.4";s:12:"requires_php";s:6:"5.6.20";s:13:"compatibility";O:8:"stdClass":0:{}}}s:12:"translations";a:2:{i:0;a:7:{s:4:"type";s:6:"plugin";s:4:"slug";s:18:"password-protected";s:8:"language";s:5:"en_GB";s:7:"version";s:5:"2.2.5";s:7:"updated";s:19:"2019-01-10 14:27:46";s:7:"package";s:85:"https://downloads.wordpress.org/translation/plugin/password-protected/2.2.5/en_GB.zip";s:10:"autoupdate";b:1;}i:1;a:7:{s:4:"type";s:6:"plugin";s:4:"slug";s:13:"wordpress-seo";s:8:"language";s:5:"en_GB";s:7:"version";s:6:"12.9.1";s:7:"updated";s:19:"2020-01-21 12:25:26";s:7:"package";s:81:"https://downloads.wordpress.org/translation/plugin/wordpress-seo/12.9.1/en_GB.zip";s:10:"autoupdate";b:1;}}s:9:"no_update";a:4:{s:30:"advanced-custom-fields/acf.php";O:8:"stdClass":9:{s:2:"id";s:36:"w.org/plugins/advanced-custom-fields";s:4:"slug";s:22:"advanced-custom-fields";s:6:"plugin";s:30:"advanced-custom-fields/acf.php";s:11:"new_version";s:5:"5.8.9";s:3:"url";s:53:"https://wordpress.org/plugins/advanced-custom-fields/";s:7:"package";s:71:"https://downloads.wordpress.org/plugin/advanced-custom-fields.5.8.9.zip";s:5:"icons";a:2:{s:2:"2x";s:75:"https://ps.w.org/advanced-custom-fields/assets/icon-256x256.png?rev=1082746";s:2:"1x";s:75:"https://ps.w.org/advanced-custom-fields/assets/icon-128x128.png?rev=1082746";}s:7:"banners";a:2:{s:2:"2x";s:78:"https://ps.w.org/advanced-custom-fields/assets/banner-1544x500.jpg?rev=1729099";s:2:"1x";s:77:"https://ps.w.org/advanced-custom-fields/assets/banner-772x250.jpg?rev=1729102";}s:11:"banners_rtl";a:0:{}}s:33:"classic-editor/classic-editor.php";O:8:"stdClass":9:{s:2:"id";s:28:"w.org/plugins/classic-editor";s:4:"slug";s:14:"classic-editor";s:6:"plugin";s:33:"classic-editor/classic-editor.php";s:11:"new_version";s:3:"1.5";s:3:"url";s:45:"https://wordpress.org/plugins/classic-editor/";s:7:"package";s:61:"https://downloads.wordpress.org/plugin/classic-editor.1.5.zip";s:5:"icons";a:2:{s:2:"2x";s:67:"https://ps.w.org/classic-editor/assets/icon-256x256.png?rev=1998671";s:2:"1x";s:67:"https://ps.w.org/classic-editor/assets/icon-128x128.png?rev=1998671";}s:7:"banners";a:2:{s:2:"2x";s:70:"https://ps.w.org/classic-editor/assets/banner-1544x500.png?rev=1998671";s:2:"1x";s:69:"https://ps.w.org/classic-editor/assets/banner-772x250.png?rev=1998676";}s:11:"banners_rtl";a:0:{}}s:41:"better-wp-security/better-wp-security.php";O:8:"stdClass":9:{s:2:"id";s:32:"w.org/plugins/better-wp-security";s:4:"slug";s:18:"better-wp-security";s:6:"plugin";s:41:"better-wp-security/better-wp-security.php";s:11:"new_version";s:5:"7.6.1";s:3:"url";s:49:"https://wordpress.org/plugins/better-wp-security/";s:7:"package";s:67:"https://downloads.wordpress.org/plugin/better-wp-security.7.6.1.zip";s:5:"icons";a:3:{s:2:"2x";s:70:"https://ps.w.org/better-wp-security/assets/icon-256x256.jpg?rev=969999";s:2:"1x";s:62:"https://ps.w.org/better-wp-security/assets/icon.svg?rev=970042";s:3:"svg";s:62:"https://ps.w.org/better-wp-security/assets/icon.svg?rev=970042";}s:7:"banners";a:1:{s:2:"1x";s:72:"https://ps.w.org/better-wp-security/assets/banner-772x250.png?rev=881897";}s:11:"banners_rtl";a:0:{}}s:41:"password-protected/password-protected.php";O:8:"stdClass":9:{s:2:"id";s:32:"w.org/plugins/password-protected";s:4:"slug";s:18:"password-protected";s:6:"plugin";s:41:"password-protected/password-protected.php";s:11:"new_version";s:5:"2.2.5";s:3:"url";s:49:"https://wordpress.org/plugins/password-protected/";s:7:"package";s:67:"https://downloads.wordpress.org/plugin/password-protected.2.2.5.zip";s:5:"icons";a:2:{s:2:"2x";s:70:"https://ps.w.org/password-protected/assets/icon-256x256.png?rev=993628";s:2:"1x";s:70:"https://ps.w.org/password-protected/assets/icon-128x128.png?rev=993628";}s:7:"banners";a:2:{s:2:"2x";s:73:"https://ps.w.org/password-protected/assets/banner-1544x500.png?rev=993628";s:2:"1x";s:72:"https://ps.w.org/password-protected/assets/banner-772x250.png?rev=993628";}s:11:"banners_rtl";a:0:{}}}}','no'),
	(239,'_site_transient_timeout_theme_roots','1586785761','no'),
	(240,'_site_transient_theme_roots','a:1:{s:10:"amberstone";s:7:"/themes";}','no');
ALTER TABLE `as_options` ENABLE KEYS;
UNLOCK TABLES;


LOCK TABLES `as_postmeta` WRITE;
ALTER TABLE `as_postmeta` DISABLE KEYS;
INSERT INTO `as_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES 
	(1,2,'_wp_page_template','default'),
	(2,3,'_wp_page_template','default'),
	(3,5,'_edit_lock','1586509015:1'),
	(4,6,'_edit_lock','1586509041:1'),
	(5,7,'_edit_last','1'),
	(6,7,'_edit_lock','1586509069:1'),
	(7,7,'_wp_page_template','page-home.php'),
	(8,9,'_edit_last','1'),
	(9,9,'_wp_page_template','default'),
	(10,9,'_edit_lock','1586509558:1'),
	(11,11,'_edit_last','1'),
	(12,11,'_wp_page_template','default'),
	(13,11,'_edit_lock','1586509832:1'),
	(14,14,'_edit_last','1'),
	(15,14,'_wp_page_template','default'),
	(16,14,'_edit_lock','1586509584:1'),
	(17,16,'_edit_last','1'),
	(18,16,'_wp_page_template','default'),
	(19,16,'_edit_lock','1586509596:1'),
	(20,18,'_edit_last','1'),
	(21,18,'_edit_lock','1586509709:1'),
	(22,18,'_wp_page_template','default'),
	(23,20,'_edit_last','1'),
	(24,20,'_edit_lock','1586509699:1'),
	(25,20,'_wp_page_template','default'),
	(26,22,'_edit_last','1'),
	(27,22,'_edit_lock','1586509724:1'),
	(28,22,'_wp_page_template','default'),
	(29,24,'_edit_last','1'),
	(30,24,'_edit_lock','1586509737:1'),
	(31,24,'_wp_page_template','default'),
	(32,26,'_menu_item_type','post_type'),
	(33,26,'_menu_item_menu_item_parent','0'),
	(34,26,'_menu_item_object_id','20'),
	(35,26,'_menu_item_object','page'),
	(36,26,'_menu_item_target',''),
	(37,26,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(38,26,'_menu_item_xfn',''),
	(39,26,'_menu_item_url',''),
	(41,27,'_menu_item_type','post_type'),
	(42,27,'_menu_item_menu_item_parent','0'),
	(43,27,'_menu_item_object_id','16'),
	(44,27,'_menu_item_object','page'),
	(45,27,'_menu_item_target',''),
	(46,27,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(47,27,'_menu_item_xfn',''),
	(48,27,'_menu_item_url',''),
	(50,28,'_menu_item_type','post_type'),
	(51,28,'_menu_item_menu_item_parent','0'),
	(52,28,'_menu_item_object_id','14'),
	(53,28,'_menu_item_object','page'),
	(54,28,'_menu_item_target',''),
	(55,28,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(56,28,'_menu_item_xfn',''),
	(57,28,'_menu_item_url',''),
	(59,29,'_menu_item_type','post_type'),
	(60,29,'_menu_item_menu_item_parent','0'),
	(61,29,'_menu_item_object_id','11'),
	(62,29,'_menu_item_object','page'),
	(63,29,'_menu_item_target',''),
	(64,29,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(65,29,'_menu_item_xfn',''),
	(66,29,'_menu_item_url',''),
	(68,30,'_menu_item_type','post_type'),
	(69,30,'_menu_item_menu_item_parent','0'),
	(70,30,'_menu_item_object_id','9'),
	(71,30,'_menu_item_object','page'),
	(72,30,'_menu_item_target',''),
	(73,30,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(74,30,'_menu_item_xfn',''),
	(75,30,'_menu_item_url',''),
	(77,31,'_menu_item_type','post_type'),
	(78,31,'_menu_item_menu_item_parent','26'),
	(79,31,'_menu_item_object_id','24'),
	(80,31,'_menu_item_object','page'),
	(81,31,'_menu_item_target',''),
	(82,31,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(83,31,'_menu_item_xfn',''),
	(84,31,'_menu_item_url',''),
	(86,32,'_menu_item_type','post_type'),
	(87,32,'_menu_item_menu_item_parent','26'),
	(88,32,'_menu_item_object_id','22'),
	(89,32,'_menu_item_object','page'),
	(90,32,'_menu_item_target',''),
	(91,32,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(92,32,'_menu_item_xfn',''),
	(93,32,'_menu_item_url',''),
	(95,33,'_menu_item_type','post_type'),
	(96,33,'_menu_item_menu_item_parent','26'),
	(97,33,'_menu_item_object_id','18'),
	(98,33,'_menu_item_object','page'),
	(99,33,'_menu_item_target',''),
	(100,33,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(101,33,'_menu_item_xfn',''),
	(102,33,'_menu_item_url',''),
	(103,34,'_menu_item_type','post_type'),
	(104,34,'_menu_item_menu_item_parent','0'),
	(105,34,'_menu_item_object_id','11'),
	(106,34,'_menu_item_object','page'),
	(107,34,'_menu_item_target',''),
	(108,34,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(109,34,'_menu_item_xfn',''),
	(110,34,'_menu_item_url',''),
	(112,35,'_menu_item_type','post_type'),
	(113,35,'_menu_item_menu_item_parent','0'),
	(114,35,'_menu_item_object_id','9'),
	(115,35,'_menu_item_object','page'),
	(116,35,'_menu_item_target',''),
	(117,35,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(118,35,'_menu_item_xfn',''),
	(119,35,'_menu_item_url',''),
	(121,36,'_menu_item_type','post_type'),
	(122,36,'_menu_item_menu_item_parent','0'),
	(123,36,'_menu_item_object_id','9'),
	(124,36,'_menu_item_object','page'),
	(125,36,'_menu_item_target',''),
	(126,36,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(127,36,'_menu_item_xfn',''),
	(128,36,'_menu_item_url',''),
	(130,37,'_menu_item_type','post_type'),
	(131,37,'_menu_item_menu_item_parent','0'),
	(132,37,'_menu_item_object_id','24'),
	(133,37,'_menu_item_object','page'),
	(134,37,'_menu_item_target',''),
	(135,37,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(136,37,'_menu_item_xfn',''),
	(137,37,'_menu_item_url',''),
	(139,38,'_menu_item_type','post_type'),
	(140,38,'_menu_item_menu_item_parent','0'),
	(141,38,'_menu_item_object_id','22'),
	(142,38,'_menu_item_object','page'),
	(143,38,'_menu_item_target',''),
	(144,38,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(145,38,'_menu_item_xfn',''),
	(146,38,'_menu_item_url',''),
	(148,39,'_menu_item_type','post_type'),
	(149,39,'_menu_item_menu_item_parent','0'),
	(150,39,'_menu_item_object_id','18'),
	(151,39,'_menu_item_object','page'),
	(152,39,'_menu_item_target',''),
	(153,39,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(154,39,'_menu_item_xfn',''),
	(155,39,'_menu_item_url',''),
	(157,40,'_menu_item_type','post_type'),
	(158,40,'_menu_item_menu_item_parent','0'),
	(159,40,'_menu_item_object_id','2'),
	(160,40,'_menu_item_object','page'),
	(161,40,'_menu_item_target',''),
	(162,40,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(163,40,'_menu_item_xfn',''),
	(164,40,'_menu_item_url',''),
	(166,41,'_menu_item_type','post_type'),
	(167,41,'_menu_item_menu_item_parent','0'),
	(168,41,'_menu_item_object_id','2'),
	(169,41,'_menu_item_object','page'),
	(170,41,'_menu_item_target',''),
	(171,41,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(172,41,'_menu_item_xfn',''),
	(173,41,'_menu_item_url',''),
	(175,42,'_menu_item_type','post_type'),
	(176,42,'_menu_item_menu_item_parent','0'),
	(177,42,'_menu_item_object_id','2'),
	(178,42,'_menu_item_object','page'),
	(179,42,'_menu_item_target',''),
	(180,42,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(181,42,'_menu_item_xfn',''),
	(182,42,'_menu_item_url',''),
	(184,43,'_menu_item_type','post_type'),
	(185,43,'_menu_item_menu_item_parent','0'),
	(186,43,'_menu_item_object_id','2'),
	(187,43,'_menu_item_object','page'),
	(188,43,'_menu_item_target',''),
	(189,43,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(190,43,'_menu_item_xfn',''),
	(191,43,'_menu_item_url',''),
	(193,44,'_menu_item_type','post_type'),
	(194,44,'_menu_item_menu_item_parent','0'),
	(195,44,'_menu_item_object_id','2'),
	(196,44,'_menu_item_object','page'),
	(197,44,'_menu_item_target',''),
	(198,44,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(199,44,'_menu_item_xfn',''),
	(200,44,'_menu_item_url',''),
	(202,45,'_menu_item_type','post_type'),
	(203,45,'_menu_item_menu_item_parent','0'),
	(204,45,'_menu_item_object_id','2'),
	(205,45,'_menu_item_object','page'),
	(206,45,'_menu_item_target',''),
	(207,45,'_menu_item_classes','a:1:{i:0;s:0:"";}'),
	(208,45,'_menu_item_xfn',''),
	(209,45,'_menu_item_url','');
ALTER TABLE `as_postmeta` ENABLE KEYS;
UNLOCK TABLES;


LOCK TABLES `as_posts` WRITE;
ALTER TABLE `as_posts` DISABLE KEYS;
INSERT INTO `as_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES 
	(1,1,'2020-04-09 11:47:43','2020-04-09 10:47:43','<!-- wp:paragraph -->\n<p>Welcome to WordPress. This is your first post. Edit or delete it, then start writing!</p>\n<!-- /wp:paragraph -->','Hello world!','','publish','open','open','','hello-world','','','2020-04-09 11:47:43','2020-04-09 10:47:43','',0,'http://amberstone/?p=1',0,'post','',1),
	(2,1,'2020-04-09 11:47:43','2020-04-09 10:47:43','<!-- wp:paragraph -->\n<p>This is an example page. It\'s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class="wp-block-quote"><p>Hi there! I\'m a bike messenger by day, aspiring actor by night, and this is my website. I live in Los Angeles, have a great dog named Jack, and I like pi&#241;a coladas. (And gettin\' caught in the rain.)</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>...or something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class="wp-block-quote"><p>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>As a new WordPress user, you should go to <a href="http://amberstone/wp-admin/">your dashboard</a> to delete this page and create new pages for your content. Have fun!</p>\n<!-- /wp:paragraph -->','Sample Page','','publish','closed','open','','sample-page','','','2020-04-09 11:47:43','2020-04-09 10:47:43','',0,'http://amberstone/?page_id=2',0,'page','',0),
	(3,1,'2020-04-09 11:47:43','2020-04-09 10:47:43','<!-- wp:heading --><h2>Who we are</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Our website address is: http://amberstone.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>What personal data we collect and why we collect it</h2><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>Comments</h3><!-- /wp:heading --><!-- wp:paragraph --><p>When visitors leave comments on the site we collect the data shown in the comments form, and also the visitor&#8217;s IP address and browser user agent string to help spam detection.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>An anonymised string created from your email address (also called a hash) may be provided to the Gravatar service to see if you are using it. The Gravatar service Privacy Policy is available here: https://automattic.com/privacy/. After approval of your comment, your profile picture is visible to the public in the context of your comment.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>Media</h3><!-- /wp:heading --><!-- wp:paragraph --><p>If you upload images to the website, you should avoid uploading images with embedded location data (EXIF GPS) included. Visitors to the website can download and extract any location data from images on the website.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>Contact forms</h3><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>Cookies</h3><!-- /wp:heading --><!-- wp:paragraph --><p>If you leave a comment on our site you may opt in to saving your name, email address and website in cookies. These are for your convenience so that you do not have to fill in your details again when you leave another comment. These cookies will last for one year.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you visit our login page, we will set a temporary cookie to determine if your browser accepts cookies. This cookie contains no personal data and is discarded when you close your browser.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>When you log in, we will also set up several cookies to save your login information and your screen display choices. Login cookies last for two days, and screen options cookies last for a year. If you select &quot;Remember Me&quot;, your login will persist for two weeks. If you log out of your account, the login cookies will be removed.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you edit or publish an article, an additional cookie will be saved in your browser. This cookie includes no personal data and simply indicates the post ID of the article you just edited. It expires after 1 day.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>Embedded content from other websites</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Articles on this site may include embedded content (e.g. videos, images, articles, etc.). Embedded content from other websites behaves in the exact same way as if the visitor has visited the other website.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>These websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with that embedded content, including tracking your interaction with the embedded content if you have an account and are logged in to that website.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>Analytics</h3><!-- /wp:heading --><!-- wp:heading --><h2>Who we share your data with</h2><!-- /wp:heading --><!-- wp:heading --><h2>How long we retain your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p>If you leave a comment, the comment and its metadata are retained indefinitely. This is so we can recognise and approve any follow-up comments automatically instead of holding them in a moderation queue.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>For users that register on our website (if any), we also store the personal information they provide in their user profile. All users can see, edit, or delete their personal information at any time (except they cannot change their username). Website administrators can also see and edit that information.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>What rights you have over your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p>If you have an account on this site, or have left comments, you can request to receive an exported file of the personal data we hold about you, including any data you have provided to us. You can also request that we erase any personal data we hold about you. This does not include any data we are obliged to keep for administrative, legal, or security purposes.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Where we send your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Visitor comments may be checked through an automated spam detection service.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Your contact information</h2><!-- /wp:heading --><!-- wp:heading --><h2>Additional information</h2><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>How we protect your data</h3><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>What data breach procedures we have in place</h3><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>What third parties we receive data from</h3><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>What automated decision making and/or profiling we do with user data</h3><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>Industry regulatory disclosure requirements</h3><!-- /wp:heading -->','Privacy Policy','','draft','closed','open','','privacy-policy','','','2020-04-09 11:47:43','2020-04-09 10:47:43','',0,'http://amberstone/?page_id=3',0,'page','',0),
	(4,1,'2020-04-09 11:49:01','0000-00-00 00:00:00','','Auto Draft','','auto-draft','open','open','','','','','2020-04-09 11:49:01','0000-00-00 00:00:00','',0,'http://amberstone/?p=4',0,'post','',0),
	(5,1,'2020-04-10 09:59:15','0000-00-00 00:00:00','','Auto Draft','','auto-draft','closed','closed','','','','','2020-04-10 09:59:15','0000-00-00 00:00:00','',0,'http://amberstone/?page_id=5',0,'page','',0),
	(6,1,'2020-04-10 09:59:43','0000-00-00 00:00:00','','Auto Draft','','auto-draft','closed','closed','','','','','2020-04-10 09:59:43','0000-00-00 00:00:00','',0,'http://amberstone/?page_id=6',0,'page','',0),
	(7,1,'2020-04-10 10:00:12','2020-04-10 09:00:12','','Home Page','','publish','closed','closed','','home-page','','','2020-04-10 10:00:12','2020-04-10 09:00:12','',0,'http://amberstone/?page_id=7',0,'page','',0),
	(8,1,'2020-04-10 10:00:12','2020-04-10 09:00:12','','Home Page','','inherit','closed','closed','','7-revision-v1','','','2020-04-10 10:00:12','2020-04-10 09:00:12','',7,'http://amberstone/2020/04/10/7-revision-v1/',0,'revision','',0),
	(9,1,'2020-04-10 10:08:19','2020-04-10 09:08:19','','About Us','','publish','closed','closed','','about-us','','','2020-04-10 10:08:19','2020-04-10 09:08:19','',0,'http://amberstone/?page_id=9',0,'page','',0),
	(10,1,'2020-04-10 10:08:19','2020-04-10 09:08:19','','About Us','','inherit','closed','closed','','9-revision-v1','','','2020-04-10 10:08:19','2020-04-10 09:08:19','',9,'http://amberstone/2020/04/10/9-revision-v1/',0,'revision','',0),
	(11,1,'2020-04-10 10:08:26','2020-04-10 09:08:26','','Our Approach','','publish','closed','closed','','our-approach','','','2020-04-10 10:10:32','2020-04-10 09:10:32','',0,'http://amberstone/?page_id=11',0,'page','',0),
	(12,1,'2020-04-10 10:08:26','2020-04-10 09:08:26','','Services','','inherit','closed','closed','','11-revision-v1','','','2020-04-10 10:08:26','2020-04-10 09:08:26','',11,'http://amberstone/2020/04/10/11-revision-v1/',0,'revision','',0),
	(13,1,'2020-04-10 10:08:34','2020-04-10 09:08:34','','Our Approach','','inherit','closed','closed','','11-revision-v1','','','2020-04-10 10:08:34','2020-04-10 09:08:34','',11,'http://amberstone/2020/04/10/11-revision-v1/',0,'revision','',0),
	(14,1,'2020-04-10 10:08:44','2020-04-10 09:08:44','','Case Studies','','publish','closed','closed','','case-studies','','','2020-04-10 10:08:44','2020-04-10 09:08:44','',0,'http://amberstone/?page_id=14',0,'page','',0),
	(15,1,'2020-04-10 10:08:44','2020-04-10 09:08:44','','Case Studies','','inherit','closed','closed','','14-revision-v1','','','2020-04-10 10:08:44','2020-04-10 09:08:44','',14,'http://amberstone/2020/04/10/14-revision-v1/',0,'revision','',0),
	(16,1,'2020-04-10 10:08:55','2020-04-10 09:08:55','','Industry News','','publish','closed','closed','','industry-news','','','2020-04-10 10:08:55','2020-04-10 09:08:55','',0,'http://amberstone/?page_id=16',0,'page','',0),
	(17,1,'2020-04-10 10:08:55','2020-04-10 09:08:55','','Industry News','','inherit','closed','closed','','16-revision-v1','','','2020-04-10 10:08:55','2020-04-10 09:08:55','',16,'http://amberstone/2020/04/10/16-revision-v1/',0,'revision','',0),
	(18,1,'2020-04-10 10:09:48','2020-04-10 09:09:48','','Electronic Security Products','','publish','closed','closed','','electronic-security-products','','','2020-04-10 10:10:51','2020-04-10 09:10:51','',20,'http://amberstone/?page_id=18',0,'page','',0),
	(19,1,'2020-04-10 10:09:48','2020-04-10 09:09:48','','Electronic Security Products','','inherit','closed','closed','','18-revision-v1','','','2020-04-10 10:09:48','2020-04-10 09:09:48','',18,'http://amberstone/2020/04/10/18-revision-v1/',0,'revision','',0),
	(20,1,'2020-04-10 10:10:41','2020-04-10 09:10:41','','Services','','publish','closed','closed','','services','','','2020-04-10 10:10:41','2020-04-10 09:10:41','',0,'http://amberstone/?page_id=20',0,'page','',0),
	(21,1,'2020-04-10 10:10:41','2020-04-10 09:10:41','','Services','','inherit','closed','closed','','20-revision-v1','','','2020-04-10 10:10:41','2020-04-10 09:10:41','',20,'http://amberstone/2020/04/10/20-revision-v1/',0,'revision','',0),
	(22,1,'2020-04-10 10:11:04','2020-04-10 09:11:04','','Manned Guarding','','publish','closed','closed','','manned-guarding','','','2020-04-10 10:11:04','2020-04-10 09:11:04','',20,'http://amberstone/?page_id=22',0,'page','',0),
	(23,1,'2020-04-10 10:11:04','2020-04-10 09:11:04','','Manned Guarding','','inherit','closed','closed','','22-revision-v1','','','2020-04-10 10:11:04','2020-04-10 09:11:04','',22,'http://amberstone/2020/04/10/22-revision-v1/',0,'revision','',0),
	(24,1,'2020-04-10 10:11:18','2020-04-10 09:11:18','','Support & Maintenance','','publish','closed','closed','','support-maintenance','','','2020-04-10 10:11:18','2020-04-10 09:11:18','',20,'http://amberstone/?page_id=24',0,'page','',0),
	(25,1,'2020-04-10 10:11:18','2020-04-10 09:11:18','','Support & Maintenance','','inherit','closed','closed','','24-revision-v1','','','2020-04-10 10:11:18','2020-04-10 09:11:18','',24,'http://amberstone/2020/04/10/24-revision-v1/',0,'revision','',0),
	(26,1,'2020-04-10 10:12:38','2020-04-10 09:12:38',' ','','','publish','closed','closed','','26','','','2020-04-10 10:12:38','2020-04-10 09:12:38','',0,'http://amberstone/?p=26',3,'nav_menu_item','',0),
	(27,1,'2020-04-10 10:12:38','2020-04-10 09:12:38',' ','','','publish','closed','closed','','27','','','2020-04-10 10:12:38','2020-04-10 09:12:38','',0,'http://amberstone/?p=27',8,'nav_menu_item','',0),
	(28,1,'2020-04-10 10:12:38','2020-04-10 09:12:38',' ','','','publish','closed','closed','','28','','','2020-04-10 10:12:38','2020-04-10 09:12:38','',0,'http://amberstone/?p=28',7,'nav_menu_item','',0),
	(29,1,'2020-04-10 10:12:38','2020-04-10 09:12:38',' ','','','publish','closed','closed','','29','','','2020-04-10 10:12:38','2020-04-10 09:12:38','',0,'http://amberstone/?p=29',2,'nav_menu_item','',0),
	(30,1,'2020-04-10 10:12:38','2020-04-10 09:12:38',' ','','','publish','closed','closed','','30','','','2020-04-10 10:12:38','2020-04-10 09:12:38','',0,'http://amberstone/?p=30',1,'nav_menu_item','',0),
	(31,1,'2020-04-10 10:12:38','2020-04-10 09:12:38',' ','','','publish','closed','closed','','31','','','2020-04-10 10:12:38','2020-04-10 09:12:38','',20,'http://amberstone/?p=31',6,'nav_menu_item','',0),
	(32,1,'2020-04-10 10:12:38','2020-04-10 09:12:38',' ','','','publish','closed','closed','','32','','','2020-04-10 10:12:38','2020-04-10 09:12:38','',20,'http://amberstone/?p=32',5,'nav_menu_item','',0),
	(33,1,'2020-04-10 10:12:38','2020-04-10 09:12:38',' ','','','publish','closed','closed','','33','','','2020-04-10 10:12:38','2020-04-10 09:12:38','',20,'http://amberstone/?p=33',4,'nav_menu_item','',0),
	(34,1,'2020-04-13 14:21:04','2020-04-13 13:21:04',' ','','','publish','closed','closed','','34','','','2020-04-13 14:21:04','2020-04-13 13:21:04','',0,'http://amberstone/?p=34',3,'nav_menu_item','',0),
	(35,1,'2020-04-13 14:21:04','2020-04-13 13:21:04','','Our Team','','publish','closed','closed','','our-team','','','2020-04-13 14:21:04','2020-04-13 13:21:04','',0,'http://amberstone/?p=35',1,'nav_menu_item','',0),
	(36,1,'2020-04-13 14:21:04','2020-04-13 13:21:04','','Our Partners','','publish','closed','closed','','our-partners','','','2020-04-13 14:21:04','2020-04-13 13:21:04','',0,'http://amberstone/?p=36',2,'nav_menu_item','',0),
	(37,1,'2020-04-13 14:21:37','2020-04-13 13:21:37',' ','','','publish','closed','closed','','37','','','2020-04-13 14:21:37','2020-04-13 13:21:37','',20,'http://amberstone/?p=37',3,'nav_menu_item','',0),
	(38,1,'2020-04-13 14:21:37','2020-04-13 13:21:37',' ','','','publish','closed','closed','','38','','','2020-04-13 14:21:37','2020-04-13 13:21:37','',20,'http://amberstone/?p=38',2,'nav_menu_item','',0),
	(39,1,'2020-04-13 14:21:37','2020-04-13 13:21:37',' ','','','publish','closed','closed','','39','','','2020-04-13 14:21:37','2020-04-13 13:21:37','',20,'http://amberstone/?p=39',1,'nav_menu_item','',0),
	(40,1,'2020-04-13 14:23:15','2020-04-13 13:23:15','','Contact Us','','publish','closed','closed','','contact-us','','','2020-04-13 14:23:34','2020-04-13 13:23:34','',0,'http://amberstone/?p=40',1,'nav_menu_item','',0),
	(41,1,'2020-04-13 14:23:15','2020-04-13 13:23:15','','Privacy Policy','','publish','closed','closed','','privacy-policy','','','2020-04-13 14:23:34','2020-04-13 13:23:34','',0,'http://amberstone/?p=41',2,'nav_menu_item','',0),
	(42,1,'2020-04-13 14:23:15','2020-04-13 13:23:15','','Terms & Conditions','','publish','closed','closed','','terms-conditions','','','2020-04-13 14:23:34','2020-04-13 13:23:34','',0,'http://amberstone/?p=42',3,'nav_menu_item','',0),
	(43,1,'2020-04-13 14:25:03','2020-04-13 13:25:03','','Gender Gap','','publish','closed','closed','','gender-gap','','','2020-04-13 14:25:03','2020-04-13 13:25:03','',0,'http://amberstone/?p=43',1,'nav_menu_item','',0),
	(44,1,'2020-04-13 14:25:03','2020-04-13 13:25:03','','Anti-Slavery Policy','','publish','closed','closed','','anti-slavery-policy','','','2020-04-13 14:25:03','2020-04-13 13:25:03','',0,'http://amberstone/?p=44',3,'nav_menu_item','',0),
	(45,1,'2020-04-13 14:25:03','2020-04-13 13:25:03','','Quality Policy','','publish','closed','closed','','quality-policy','','','2020-04-13 14:25:03','2020-04-13 13:25:03','',0,'http://amberstone/?p=45',2,'nav_menu_item','',0);
ALTER TABLE `as_posts` ENABLE KEYS;
UNLOCK TABLES;


LOCK TABLES `as_term_relationships` WRITE;
ALTER TABLE `as_term_relationships` DISABLE KEYS;
INSERT INTO `as_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES 
	(1,1,0),
	(26,2,0),
	(27,2,0),
	(28,2,0),
	(29,2,0),
	(30,2,0),
	(31,2,0),
	(32,2,0),
	(33,2,0),
	(34,3,0),
	(35,3,0),
	(36,3,0),
	(37,4,0),
	(38,4,0),
	(39,4,0),
	(40,5,0),
	(41,5,0),
	(42,5,0),
	(43,6,0),
	(44,6,0),
	(45,6,0);
ALTER TABLE `as_term_relationships` ENABLE KEYS;
UNLOCK TABLES;


LOCK TABLES `as_term_taxonomy` WRITE;
ALTER TABLE `as_term_taxonomy` DISABLE KEYS;
INSERT INTO `as_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES 
	(1,1,'category','',0,1),
	(2,2,'nav_menu','',0,8),
	(3,3,'nav_menu','',0,3),
	(4,4,'nav_menu','',0,3),
	(5,5,'nav_menu','',0,3),
	(6,6,'nav_menu','',0,3);
ALTER TABLE `as_term_taxonomy` ENABLE KEYS;
UNLOCK TABLES;


LOCK TABLES `as_termmeta` WRITE;
ALTER TABLE `as_termmeta` DISABLE KEYS;
ALTER TABLE `as_termmeta` ENABLE KEYS;
UNLOCK TABLES;


LOCK TABLES `as_terms` WRITE;
ALTER TABLE `as_terms` DISABLE KEYS;
INSERT INTO `as_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES 
	(1,'Uncategorised','uncategorised',0),
	(2,'Main Menu','main-menu',0),
	(3,'Footer About Us Menu','footer-about-us-menu',0),
	(4,'Footer Services Menu','footer-services-menu',0),
	(5,'Footer Company Menu 1','footer-company-menu-1',0),
	(6,'Company Footer Menu 2','company-footer-menu-2',0);
ALTER TABLE `as_terms` ENABLE KEYS;
UNLOCK TABLES;


LOCK TABLES `as_usermeta` WRITE;
ALTER TABLE `as_usermeta` DISABLE KEYS;
INSERT INTO `as_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES 
	(1,1,'nickname','nsmdigital'),
	(2,1,'first_name',''),
	(3,1,'last_name',''),
	(4,1,'description',''),
	(5,1,'rich_editing','true'),
	(6,1,'syntax_highlighting','true'),
	(7,1,'comment_shortcuts','false'),
	(8,1,'admin_color','fresh'),
	(9,1,'use_ssl','0'),
	(10,1,'show_admin_bar_front','true'),
	(11,1,'locale',''),
	(12,1,'as_capabilities','a:1:{s:13:"administrator";b:1;}'),
	(13,1,'as_user_level','10'),
	(14,1,'dismissed_wp_pointers',''),
	(15,1,'show_welcome_panel','1'),
	(16,1,'session_tokens','a:1:{s:64:"a6b23d8e32aa6bc956b9333ff1860660ef0eb791a338d0c882108c3f92d3a717";a:4:{s:10:"expiration";i:1586956758;s:2:"ip";s:3:"::1";s:2:"ua";s:121:"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36";s:5:"login";i:1586783958;}}'),
	(17,1,'as_dashboard_quick_press_last_post_id','4'),
	(18,1,'managenav-menuscolumnshidden','a:5:{i:0;s:11:"link-target";i:1;s:11:"css-classes";i:2;s:3:"xfn";i:3;s:11:"description";i:4;s:15:"title-attribute";}'),
	(19,1,'metaboxhidden_nav-menus','a:1:{i:0;s:12:"add-post_tag";}'),
	(20,1,'nav_menu_recently_edited','6');
ALTER TABLE `as_usermeta` ENABLE KEYS;
UNLOCK TABLES;


LOCK TABLES `as_users` WRITE;
ALTER TABLE `as_users` DISABLE KEYS;
INSERT INTO `as_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES 
	(1,'nsmdigital','$P$BnIzRd3Zcoxci99FrunNtSd1rCrvM5/','nsmdigital','nick@nsmdigital.com','http://amberstone','2020-04-09 10:47:43','',0,'nsmdigital');
ALTER TABLE `as_users` ENABLE KEYS;
UNLOCK TABLES;




SET FOREIGN_KEY_CHECKS = @PREVIOUS_FOREIGN_KEY_CHECKS;


