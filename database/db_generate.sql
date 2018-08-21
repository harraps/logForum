-- SQL SCRIPT TO GENERATE THE DATABASE --

CREATE DATABASE IF NOT EXISTS `logForum`;
USE `logForum`;

SET FOREIGN_KEY_CHECKS = 0;

-- Table for posts
CREATE TABLE IF NOT EXISTS `Post` (
    `p_id`   INT           AUTO_INCREMENT            COMMENT "the id of the post",
    `u_ip`   VARCHAR(39)   NOT NULL                  COMMENT "the IP of the user who posted this message",
    `t_id`   INT           NOT NULL                  COMMENT "the id of the thread in which the message has been posted",
    `p_date` TIMESTAMP     DEFAULT CURRENT_TIMESTAMP COMMENT "the time at which the message has been posted",
    `p_text` VARCHAR(2048) NOT NULL                  COMMENT "the message that has been posted",
    PRIMARY KEY (`p_id`  ), -- each post has an unique id to identify it
    INDEX       (`p_date`), -- we want to order the posts by their date
    FOREIGN KEY (`t_id`  ) REFERENCES `Thread`(`t_id`) ON DELETE CASCADE -- each post is linked to one thread
)ENGINE=InnoDB CHARSET=utf8 COMMENT="contains the posts made on the forum";

-- Table for threads
CREATE TABLE IF NOT EXISTS `Thread` (
    `t_id`   INT         AUTO_INCREMENT            COMMENT "the id of the thread",
    `u_ip`   VARCHAR(39) NOT NULL                  COMMENT "the IP of the creator of the thread",
    `s_id`   INT         NOT NULL                  COMMENT "the id of the section in which the thread is stored",
    `t_date` TIMESTAMP   DEFAULT CURRENT_TIMESTAMP COMMENT "the date of last post made in this thread",
    `t_name` VARCHAR(40) NOT NULL                  COMMENT "the name of the thread",
    PRIMARY KEY (`t_id`  ), -- each thread has an unique id to identify it
    FOREIGN KEY (`s_id`  ) REFERENCES `Section`(`s_id`) ON DELETE CASCADE -- each thread is inside one section
)ENGINE=InnoDB CHARSET=utf8 COMMENT="contains the threads made on the forum";

-- Table for sections
CREATE TABLE IF NOT EXISTS `Section` (
    `s_id`   INT          AUTO_INCREMENT COMMENT "the id of the section",
    `u_ip`   VARCHAR(39)  NOT NULL       COMMENT "the IP of the creator of the section",
    `s_name` VARCHAR(40)  NOT NULL       COMMENT "the name of the section",
    `s_desc` VARCHAR(100) DEFAULT ""     COMMENT "the description of the section",
    PRIMARY KEY (`s_id`  ), -- each section has an unique id to identify it
    UNIQUE      (`s_name`)  -- each section has an unique name
)ENGINE=InnoDB CHARSET=utf8 COMMENT="contains the sections of the forum";

SET FOREIGN_KEY_CHECKS = 1;
