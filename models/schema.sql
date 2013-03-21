CREATE TABLE IF NOT EXISTS `forum` (
    `id`                 int(11) NOT NULL AUTO_INCREMENT,
    `forum_id`           int(11) NOT NULL DEFAULT '2',
    `type`               enum('post','reply','message','category','vote','user','watch') CHARACTER SET latin1 NOT NULL,
    `reply_to`           int(11) DEFAULT NULL,
    `author`             int(11) DEFAULT NULL,
    `author_email_hash`  varchar(32) CHARACTER SET latin1 NOT NULL,
    `author_name`        varchar(45) CHARACTER SET latin1 NOT NULL,
    `time_created`       timestamp   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `time_last_activity` timestamp      NULL DEFAULT NULL,
    `replies`            int(11) DEFAULT NULL,
    `title`              varchar(80)    CHARACTER SET latin1 DEFAULT NULL,
    `message`            varchar(10000) CHARACTER SET latin1 DEFAULT NULL,
    `views`              int(11) NOT NULL,
    `visibility`         enum('mod_hidden','hidden','normal','sticky') NOT NULL DEFAULT 'normal',
    `flags`              enum('daily','answered','closed','pending')   DEFAULT NULL,
    `stats`              varchar(300)  DEFAULT NULL,
    `ext`                varchar(8000) NOT NULL,
  PRIMARY KEY (`id`),
    KEY `reply_to` (`reply_to`),
    KEY `status_time` (`visibility`,`time_last_activity`),
    KEY `all_posts` (`type`,`forum_id`,`visibility`,`time_last_activity`),
    KEY `replies` (`forum_id`,`replies`),
    KEY `views` (`forum_id`,`views`),
    KEY `title` (`forum_id`,`title`),
    KEY `message` (`forum_id`,`message`(64)),
    KEY `forum_id_type` (`forum_id`,`type`,`time_last_activity`),
    KEY `author` (`author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `forum`
  ADD CONSTRAINT `forum_ibfk_1` FOREIGN KEY (`reply_to`)
  REFERENCES `forum` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
