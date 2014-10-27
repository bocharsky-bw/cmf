-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 27, 2014 at 09:35 PM
-- Server version: 5.5.37-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cmf`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `heading` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `published` tinyint(1) NOT NULL,
  `ordering` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `route_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `root` int(11) DEFAULT NULL,
  `lvl` int(11) NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3AF346683DA5256D` (`image_id`),
  KEY `IDX_3AF34668727ACA70` (`parent_id`),
  KEY `IDX_3AF3466834ECB4E6` (`route_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=39 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `heading`, `slug`, `title`, `meta_description`, `short_description`, `description`, `published`, `ordering`, `created`, `updated`, `route_id`, `image_id`, `root`, `lvl`, `lft`, `rgt`, `class`) VALUES
(37, NULL, 'News', 'news', '', '', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>', '', 1, 0, '2014-09-09 23:44:00', '2014-10-14 23:50:52', 48, NULL, 37, 0, 1, 4, ''),
(38, 37, 'Kiev', 'kiev', '', '', '<p><span style="line-height: 20.7999992370605px;">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '', 1, 0, '2014-09-09 23:44:00', '2014-10-14 23:50:59', 49, NULL, 37, 1, 2, 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `category_widgets`
--

CREATE TABLE IF NOT EXISTS `category_widgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `widget_id` int(11) DEFAULT NULL,
  `exclude` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_5A80A4BFFBE885E2` (`widget_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `category_widgets`
--

INSERT INTO `category_widgets` (`id`, `widget_id`, `exclude`) VALUES
(1, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category_widget_category`
--

CREATE TABLE IF NOT EXISTS `category_widget_category` (
  `category_widget_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`category_widget_id`,`category_id`),
  KEY `IDX_B2A898B23C8857D2` (`category_widget_id`),
  KEY `IDX_B2A898B212469DE2` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category_widget_category`
--

INSERT INTO `category_widget_category` (`category_widget_id`, `category_id`) VALUES
(1, 38);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `name_en` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `alpha2` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `alpha3` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `numeric_code` smallint(6) NOT NULL,
  `code` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `feedback_form_widgets`
--

CREATE TABLE IF NOT EXISTS `feedback_form_widgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `widget_id` int(11) DEFAULT NULL,
  `fields` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:json_array)',
  `redirect_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message_subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message_body` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_30B660E6FBE885E2` (`widget_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `feedback_form_widgets`
--

INSERT INTO `feedback_form_widgets` (`id`, `widget_id`, `fields`, `redirect_url`, `email_to`, `message_subject`, `message_body`) VALUES
(1, 4, '[{"child":"phone","type":"text","options":{"label":"\\u0422\\u0435\\u043b\\u0435\\u0444\\u043e\\u043d","attr":{"class":"form-control"}}},{"child":"question","type":"textarea","options":{"label":"\\u0412\\u043e\\u043f\\u0440\\u043e\\u0441","attr":{"class":"form-control"}}},{"child":"send","type":"submit","options":{"label":"\\u041e\\u0442\\u043f\\u0440\\u0430\\u0432\\u0438\\u0442\\u044c","attr":{"class":"btn btn-primary"}}}]', '', 'bocharsky.bw@gmail.com', 'Тест', '<p><strong>Телефон</strong>: {phone}</p>\r\n\r\n<p><strong>Вопрос</strong>: {question}</p>');

-- --------------------------------------------------------

--
-- Table structure for table `html_widgets`
--

CREATE TABLE IF NOT EXISTS `html_widgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `widget_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9A018D0CFBE885E2` (`widget_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `html_widgets`
--

INSERT INTO `html_widgets` (`id`, `description`, `widget_id`) VALUES
(1, '<p>Widget 1 description...</p>', 1),
(3, '<p>Widget 2 description...</p>', 2),
(11, '<p>Widget 3 description...</p>', 3);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_folder` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `filename`, `sub_folder`, `title`, `alt`) VALUES
(1, '44ac8c5660ea797dbab7f4c642eecd348cea02e5.jpeg', 'posts', 'Ford', 'Fiesta'),
(3, '60f201d3804af542ec2793fbfbc1322392e7de05.jpeg', 'posts', 'Bionic University', 'Bionic University'),
(4, 'b56765842b15c1a1cb886afa30eb8b87245e7e72.jpeg', 'categories', 'Downhill', 'Downhill');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ordering` int(11) NOT NULL,
  `root` int(11) DEFAULT NULL,
  `lvl` int(11) NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `route_id` int(11) DEFAULT NULL,
  `published` tinyint(1) NOT NULL,
  `blank` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E11EE94DCCD7E912` (`menu_id`),
  KEY `IDX_E11EE94D727ACA70` (`parent_id`),
  KEY `IDX_E11EE94D34ECB4E6` (`route_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `menu_id`, `parent_id`, `name`, `uri`, `title`, `class`, `ordering`, `root`, `lvl`, `lft`, `rgt`, `route_id`, `published`, `blank`) VALUES
(1, 1, NULL, 'Home', '/', 'Home page', 'home', 0, 1, 0, 1, 4, NULL, 1, 0),
(7, 1, 1, 'News', '', '', '', 0, 1, 1, 2, 3, 48, 1, 0),
(8, 1, NULL, 'Symfony', 'http://symfony.com/', 'Symfony Framework', 'symfony', 0, 8, 0, 1, 2, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `alias`, `description`) VALUES
(1, 'Main menu', 'main_menu', 'Main menu description...');

-- --------------------------------------------------------

--
-- Table structure for table `menu_widgets`
--

CREATE TABLE IF NOT EXISTS `menu_widgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `widget_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1583F97FFBE885E2` (`widget_id`),
  KEY `IDX_1583F97FCCD7E912` (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `menu_widgets`
--

INSERT INTO `menu_widgets` (`id`, `widget_id`, `menu_id`) VALUES
(1, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE IF NOT EXISTS `positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `name`, `description`, `alias`) VALUES
(1, 'Pre Content', 'Position before main content', 'pre_content'),
(2, 'Post Content', 'Position after main content', 'post_content');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `heading` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `published` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `route_id` int(11) DEFAULT NULL,
  `ordering` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_885DBAFA3DA5256D` (`image_id`),
  KEY `IDX_885DBAFA12469DE2` (`category_id`),
  KEY `IDX_885DBAFA34ECB4E6` (`route_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `category_id`, `heading`, `slug`, `title`, `meta_description`, `short_description`, `description`, `published`, `created`, `updated`, `route_id`, `ordering`, `image_id`, `class`) VALUES
(1, 38, 'News Kiev 1', 'news-kiev-1', 'News Kiev 1', 'News Kiev 1 description...', '<p>News Kiev 1 description...</p>', '<p>News Kiev 1 description...</p>', 1, '2014-07-13 20:53:00', '2014-10-17 23:05:05', 1, 0, 1, ''),
(2, 38, 'News Kiev 2', 'news-kiev-2', 'News Kiev 2', 'News Kiev 2...', '<p>News Kiev 1 description...</p>', '<p>News Kiev 2&nbsp;description...</p>', 1, '2014-07-13 20:54:00', '2014-10-17 23:05:12', 2, 0, 3, ''),
(4, NULL, 'Home page', 'home', 'Home page', 'Home page...', '<p>Home page description...</p>', '<p>Home page description...</p>', 1, '2014-08-25 14:18:00', '2014-10-04 00:06:30', 10, 0, NULL, ''),
(5, 37, 'News 1', 'news-1', '', '', '<p>News 1</p>', '<p>News 1</p>', 1, '2014-10-17 23:01:00', '2014-10-17 23:04:35', 50, 0, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `patronymic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `house` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apartment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8B308530A76ED395` (`user_id`),
  KEY `IDX_8B308530F92F3E70` (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B63E2EC757698A6A` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `role`, `description`) VALUES
(2, 'Administrator', 'ROLE_ADMIN', 'All rights allowed'),
(3, 'User', 'ROLE_USER', 'Control panel access denied');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE IF NOT EXISTS `routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `defaults` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_32D5C2B3B548B0F` (`path`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=51 ;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `path`, `defaults`) VALUES
(1, '/news/kiev/news-kiev-1', 'a:2:{s:11:"_controller";s:22:"BWBlogBundle:Post:show";s:2:"id";i:1;}'),
(2, '/news/kiev/news-kiev-2', 'a:2:{s:11:"_controller";s:22:"BWBlogBundle:Post:show";s:2:"id";i:2;}'),
(10, '/home', 'a:2:{s:11:"_controller";s:22:"BWBlogBundle:Post:show";s:2:"id";i:4;}'),
(48, '/news', 'a:2:{s:11:"_controller";s:26:"BWBlogBundle:Category:show";s:2:"id";i:37;}'),
(49, '/news/kiev', 'a:2:{s:11:"_controller";s:26:"BWBlogBundle:Category:show";s:2:"id";i:38;}'),
(50, '/news/news-1', 'a:2:{s:11:"_controller";s:22:"BWBlogBundle:Post:show";s:2:"id";i:5;}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL,
  `confirmed` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vk_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9F85E0677` (`username`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`),
  UNIQUE KEY `UNIQ_1483A5E99BE8FD98` (`facebook_id`),
  UNIQUE KEY `UNIQ_1483A5E976F5C865` (`google_id`),
  UNIQUE KEY `UNIQ_1483A5E9C5978E52` (`vk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `email`, `enabled`, `confirmed`, `created`, `updated`, `hash`, `facebook_id`, `google_id`, `vk_id`) VALUES
(1, 'admin', '6f4543daf80d71ea0c3d2e12bedf80e307cc275c', 'afdcc157e1c98fb95f006e86d8abcef5', 'bocharsky.bw@gmail.com', 1, 1, '2014-08-09 11:46:00', '2014-08-25 00:14:10', '61c8296e67aa11bb5aca7b97083fc967', NULL, NULL, NULL),
(8, 'user', 'e1e9645a401fdde892f6c3d6af43bb3b6a2e2ea4', '59596e9a68480bfe891a443bcdb2658a', 'user@local.host', 1, 1, '2014-08-25 10:59:00', '2014-08-25 11:02:52', 'f48b99e2938428720c9f4cb3c67e85f1', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `IDX_2DE8C6A3A76ED395` (`user_id`),
  KEY `IDX_2DE8C6A3D60322AC` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`user_id`, `role_id`) VALUES
(1, 2),
(1, 3),
(8, 3);

-- --------------------------------------------------------

--
-- Table structure for table `widgets`
--

CREATE TABLE IF NOT EXISTS `widgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_id` int(11) DEFAULT NULL,
  `heading` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `published` tinyint(1) NOT NULL,
  `ordering` int(11) NOT NULL,
  `visibility` tinyint(1) NOT NULL,
  `short_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9D58E4C1DD842E46` (`position_id`),
  KEY `IDX_9D58E4C1C54C8C93` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `widgets`
--

INSERT INTO `widgets` (`id`, `position_id`, `heading`, `published`, `ordering`, `visibility`, `short_description`, `type_id`, `class`) VALUES
(1, 1, 'HTML Widget 1', 1, 1, 1, 'HTML Widget 1 description...', 1, ''),
(2, 2, 'HTML Widget 2', 1, 0, 0, 'HTML Widget 2 description...', 1, ''),
(3, 1, 'Menu Widget 1', 1, 0, 1, 'Menu Widget 1 description...', 2, ''),
(4, 2, 'Feedback Form Widget 1', 1, 0, 1, 'Feedback Form Widget 1 description...', 3, ''),
(5, 1, 'Список категорий', 1, 0, 1, 'Категории...', 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `widget_route`
--

CREATE TABLE IF NOT EXISTS `widget_route` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `widget_id` int(11) DEFAULT NULL,
  `route_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5982796FFBE885E2` (`widget_id`),
  KEY `IDX_5982796F34ECB4E6` (`route_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `widget_route`
--

INSERT INTO `widget_route` (`id`, `widget_id`, `route_id`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `widget_types`
--

CREATE TABLE IF NOT EXISTS `widget_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inversed_property` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `form_type_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `entity_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `service_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `form_type_template` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_276D026E16C6B94` (`alias`),
  UNIQUE KEY `UNIQ_276D0269060CAEA` (`service_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `widget_types`
--

INSERT INTO `widget_types` (`id`, `name`, `alias`, `inversed_property`, `form_type_class`, `entity_class`, `service_name`, `form_type_template`) VALUES
(1, 'HTML', 'html', 'htmlWidget', 'BW\\ModuleBundle\\Form\\HtmlWidgetType', 'BW\\ModuleBundle\\Entity\\HtmlWidget', 'bw_module.service.html_widget', ''),
(2, 'Меню', 'menu', 'menuWidget', 'BW\\MenuBundle\\Form\\MenuWidgetType', 'BW\\MenuBundle\\Entity\\MenuWidget', 'bw_menu.service.menu_widget', ''),
(3, 'Форма обратной связи', 'feedback_form', 'feedbackFormWidget', 'BW\\ModuleBundle\\Form\\FeedbackFormWidgetType', 'BW\\ModuleBundle\\Entity\\FeedbackFormWidget', 'bw_module.service.feedback_form_widget', 'BWModuleBundle:FeedbackFormWidget:form.html.twig'),
(4, 'Категории', 'category', 'categoryWidget', 'BW\\BlogBundle\\Form\\CategoryWidgetType', 'BW\\BlogBundle\\Entity\\CategoryWidget', 'bw_blog.service.category_widget', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `FK_3AF3466834ECB4E6` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`),
  ADD CONSTRAINT `FK_3AF346683DA5256D` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
  ADD CONSTRAINT `FK_3AF34668727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `category_widgets`
--
ALTER TABLE `category_widgets`
  ADD CONSTRAINT `FK_5A80A4BFFBE885E2` FOREIGN KEY (`widget_id`) REFERENCES `widgets` (`id`);

--
-- Constraints for table `category_widget_category`
--
ALTER TABLE `category_widget_category`
  ADD CONSTRAINT `FK_B2A898B212469DE2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B2A898B23C8857D2` FOREIGN KEY (`category_widget_id`) REFERENCES `category_widgets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feedback_form_widgets`
--
ALTER TABLE `feedback_form_widgets`
  ADD CONSTRAINT `FK_30B660E6FBE885E2` FOREIGN KEY (`widget_id`) REFERENCES `widgets` (`id`);

--
-- Constraints for table `html_widgets`
--
ALTER TABLE `html_widgets`
  ADD CONSTRAINT `FK_9A018D0CFBE885E2` FOREIGN KEY (`widget_id`) REFERENCES `widgets` (`id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `FK_E11EE94D34ECB4E6` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`),
  ADD CONSTRAINT `FK_E11EE94D727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `FK_E11EE94DCCD7E912` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`);

--
-- Constraints for table `menu_widgets`
--
ALTER TABLE `menu_widgets`
  ADD CONSTRAINT `FK_1583F97FCCD7E912` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  ADD CONSTRAINT `FK_1583F97FFBE885E2` FOREIGN KEY (`widget_id`) REFERENCES `widgets` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FK_885DBAFA12469DE2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `FK_885DBAFA34ECB4E6` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`),
  ADD CONSTRAINT `FK_885DBAFA3DA5256D` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`);

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `FK_8B308530A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_8B308530F92F3E70` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `FK_2DE8C6A3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_2DE8C6A3D60322AC` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `widgets`
--
ALTER TABLE `widgets`
  ADD CONSTRAINT `FK_9D58E4C1C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `widget_types` (`id`),
  ADD CONSTRAINT `FK_9D58E4C1DD842E46` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`);

--
-- Constraints for table `widget_route`
--
ALTER TABLE `widget_route`
  ADD CONSTRAINT `FK_5982796F34ECB4E6` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`),
  ADD CONSTRAINT `FK_5982796FFBE885E2` FOREIGN KEY (`widget_id`) REFERENCES `widgets` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
