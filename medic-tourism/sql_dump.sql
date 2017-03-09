
CREATE TABLE IF NOT EXISTS `lead` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `content` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p_link` tinytext COLLATE utf8_unicode_ci,
  `link` tinytext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;

