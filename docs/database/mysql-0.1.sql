SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `api_key` (
  `key` varchar(40) NOT NULL,
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `logbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `serverid` int(11) NOT NULL,
  `serviceid` int(11) NOT NULL,
  `status` varchar(8) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `serverinfo` (
  `id` int(11) NOT NULL,
  `os` varchar(32) NOT NULL,
  `kernel` varchar(64) NOT NULL,
  `cputype` varchar(32) NOT NULL,
  `cpucount` int(11) NOT NULL,
  `memory` int(11) NOT NULL,
  `swap` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `servers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(32) NOT NULL,
  `groups` varchar(32) NOT NULL,
  `hostname` varchar(64) NOT NULL,
  `port` int(8) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `defaultproxy` tinyint(1) NOT NULL DEFAULT '0',
  `proxyhost` varchar(64) NOT NULL,
  `proxyport` int(11) NOT NULL DEFAULT '0',
  `proxytype` varchar(16) NOT NULL,
  `proxyuser` varchar(32) NOT NULL,
  `proxypassword` varchar(32) NOT NULL,
  `desc` text NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serverid` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `settings` (
  `name` varchar(32) NOT NULL,
  `value` varchar(64) NOT NULL,
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `settings` (`name`, `value`) VALUES
('proxyhost', 'localhost'),
('proxyport', '8080'),
('proxytype', 'socks5'),
('proxyuser', ''),
('proxypassword', '');

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(8) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `status_services` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(8) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(16) NOT NULL,
  `password` varchar(40) NOT NULL,
  `fname` varchar(32) NOT NULL,
  `lname` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `users` (`username`, `password`, `fname`, `lname`, `email`) VALUES
('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '', '', '');

