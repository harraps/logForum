-- SQL SCRIPT TO GENERATE THE DATABASE --

CREATE DATABASE IF NOT EXISTS `logForum`;
USE `logForum`;

SET FOREIGN_KEY_CHECKS = 0;

/*
    user are identified with their IP
    this is not secure at all but the website is not intended to be put online
    nor it is intended to put compromising information on it
*/

-- Table for users
CREATE TABLE IF NOT EXISTS `User` (
    `u_ip`   INT         DEFAULT -1                COMMENT "the ip of the user",
    `u_date` TIMESTAMP   DEFAULT CURRENT_TIMESTAMP COMMENT "the first time that IP was registered",
    `u_name` VARCHAR(20) NOT NULL                  COMMENT "the name of the user",
    `u_desc` VARCHAR(40) DEFAULT ""                COMMENT "the description of the user",
    PRIMARY KEY (`u_ip`  ), -- we identify the users by their IP
    INDEX       (`u_date`)  -- we want to order the posts by their date
)ENGINE=InnoDB CHARSET=utf8 COMMENT="contains the user of the forum";

-- Table for posts
CREATE TABLE IF NOT EXISTS `Post` (
    `p_id`   INT           AUTO_INCREMENT            COMMENT "the id of the post",
    `u_ip`   INT                                     COMMENT "the IP of the user who posted this message",
    `t_id`   INT           NOT NULL                  COMMENT "the id of the thread in which the message has been posted",
    `p_date` TIMESTAMP     DEFAULT CURRENT_TIMESTAMP COMMENT "the time at which the message has been posted",
    `p_text` VARCHAR(2048) NOT NULL                  COMMENT "the message that has been posted",
    PRIMARY KEY (`p_id`  ), -- each post has an unique id to identify it
    INDEX       (`p_date`), -- we want to order the posts by their date
    FOREIGN KEY (`u_ip`  ) REFERENCES `User`  (`u_ip`) ON DELETE SET NULL, -- each post is linked to one user
    FOREIGN KEY (`t_id`  ) REFERENCES `Thread`(`t_id`) ON DELETE CASCADE   -- each post is linked to one thread
)ENGINE=InnoDB CHARSET=utf8 COMMENT="contains the posts made on the forum";

-- Table for threads
CREATE TABLE IF NOT EXISTS `Thread` (
    `t_id`   INT         AUTO_INCREMENT            COMMENT "the id of the thread",
    `u_ip`   INT                                   COMMENT "the IP of the creator of the thread",
    `s_id`   INT         NOT NULL                  COMMENT "the id of the section in which the thread is stored",
    `t_date` TIMESTAMP   DEFAULT CURRENT_TIMESTAMP COMMENT "the date of last post made in this thread",
    `t_name` VARCHAR(40) NOT NULL                  COMMENT "the name of the thread",
    PRIMARY KEY (`t_id`  ), -- each thread has an unique id to identify it
    FOREIGN KEY (`u_ip`  ) REFERENCES `User`   (`u_ip`) ON DELETE SET NULL, -- each thread has been created by one user
    FOREIGN KEY (`s_id`  ) REFERENCES `Section`(`s_id`) ON DELETE CASCADE   -- each thread is inside one section
)ENGINE=InnoDB CHARSET=utf8 COMMENT="contains the threads made on the forum";

-- Table for sections
CREATE TABLE IF NOT EXISTS `Section` (
    `s_id`   INT           AUTO_INCREMENT COMMENT "the id of the section",
    `s_name` VARCHAR(40)   NOT NULL       COMMENT "the name of the section",
    `s_desc` VARCHAR(2048) DEFAULT ""     COMMENT "the description of the section",
    PRIMARY KEY (`s_id`  ), -- each section has an unique id to identify it
    UNIQUE      (`s_name`)  -- each section has an unique name
)ENGINE=InnoDB CHARSET=utf8 COMMENT="contains the sections of the forum";

-- mark the user as deleted
INSERT IGNORE INTO `User`(`u_ip`,`u_name`) VALUES (-1, "DELETED");

SET FOREIGN_KEY_CHECKS = 1;
