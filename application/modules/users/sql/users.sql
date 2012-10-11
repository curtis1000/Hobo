CREATE TABLE `users` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` char(60) NOT NULL,
  `salt` char(22) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `status` enum('enabled','disabled','inactive','pending') NOT NULL,
  `forgotPasswordCode` char(32) default NULL,
  `forgotPasswordTimestamp` datetime default NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `lastLogon` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

# Administrator user; password: testing
INSERT INTO `users` ( `id` , `firstName` , `lastName` , `email` , `password` , `salt` , `role` , `status` , `forgotPasswordCode` , `forgotPasswordTimestamp` , `created` , `updated` , `lastLogon` )
VALUES (
NULL , 'Site', 'Administrator', 'admin@sierrabravo.net', '$2a$07$DO4cdidnH6f89fqL5f9pDexIFF.JeyDJJHljRjN7aqR7m0AZMI6vC' , '', 'admin', 'enabled', NULL , NULL , NOW( ) , NOW( ) , ''
);