-- SQL SCRIPT TO GENERATE THE DATABASE --

CREATE DATABASE IF NOT EXISTS `miniForum`;
USE `miniForum`;

SET FOREIGN_KEY_CHECKS = 0;

-- Table for users
CREATE TABLE IF NOT EXISTS `User` (
    `u_id`   INT         AUTO_INCREMENT            COMMENT "the id of the user",
    `u_name` VARCHAR(20) NOT NULL                  COMMENT "the name of the user",
    `u_mail` VARCHAR(40) NOT NULL                  COMMENT "the mail of the user",
    `u_pass` CHAR(40)    NOT NULL                  COMMENT "the password of the user", -- crypted password are 40 characters long
    `u_date` TIMESTAMP   DEFAULT CURRENT_TIMESTAMP COMMENT "the sign in date of the user",
    `u_perm` INT         DEFAULT 0                 COMMENT "the permissions of the user", -- follow a mask to specify the rights of the user
    PRIMARY KEY (`u_id`  ), -- each user has an unique id to identify him
    UNIQUE      (`u_name`), -- each user has it's own unique name
    UNIQUE      (`u_mail`)  -- you can register a mail only once
)ENGINE=InnoDB CHARSET=utf8 COMMENT="contains the user of the forum";

-- Table for posts
CREATE TABLE IF NOT EXISTS `Post` (
    `p_id`   INT           AUTO_INCREMENT            COMMENT "the id of the post",
    `u_id`   INT           NOT NULL                  COMMENT "the id of the user who posted this message",
    `t_id`   INT           NOT NULL                  COMMENT "the id of the thread in which the message has been posted",
    `p_date` TIMESTAMP     DEFAULT CURRENT_TIMESTAMP COMMENT "the time at which the message has been posted",
    `p_text` VARCHAR(2048) NOT NULL                  COMMENT "the message that has been posted",
    PRIMARY KEY (`p_id`  ), -- each post has an unique id to identify it
    INDEX       (`p_date`), -- we want to order the posts by their date
    FOREIGN KEY (`u_id`  ) REFERENCES `User`  (`u_id`), -- each post is linked to one user
    FOREIGN KEY (`t_id`  ) REFERENCES `Thread`(`t_id`)  -- each post is linked to one thread
)ENGINE=InnoDB CHARSET=utf8 COMMENT="contains the posts made on the forum";

-- Table for threads
CREATE TABLE IF NOT EXISTS `Thread` (
    `t_id`   INT         AUTO_INCREMENT            COMMENT "the id of the thread",
    `u_id`   INT         NOT NULL                  COMMENT "the id of the creator of the thread",
    `s_id`   INT         NOT NULL                  COMMENT "the id of the section in which the thread is stored",
    `t_name` VARCHAR(40) NOT NULL                  COMMENT "the name of the thread",
    `t_date` TIMESTAMP   DEFAULT CURRENT_TIMESTAMP COMMENT "the date of last post made in this thread",
    `t_stat` INT         DEFAULT 0                 COMMENT "the state of the thread", -- follow a mask to specify its state (ex: pinned, closed, ...)
    PRIMARY KEY (`t_id`  ), -- each thread has an unique id to identify it
    UNIQUE      (`t_name`), -- each thread has a unique name
    FOREIGN KEY (`u_id`  ) REFERENCES `User`    (`u_id`), -- each thread has been created by one user
    FOREIGN KEY (`s_id`  ) REFERENCES `Section`(`s_id`)  -- each thread is inside one section
)ENGINE=InnoDB CHARSET=utf8 COMMENT="contains the threads made on the forum";

-- Table for sections
CREATE TABLE IF NOT EXISTS `Section` (
    `s_id`   INT         AUTO_INCREMENT  COMMENT "the id of the section",
    `u_id`   INT         NOT NULL        COMMENT "the id of the user who created this section",
    `s_supe` INT                         COMMENT "the id of the parent section", -- if null the parent is root
    `s_name` VARCHAR(40) NOT NULL        COMMENT "the name of the section",
    PRIMARY KEY (`s_id`  ), -- each section has an unique id to identify it
    UNIQUE      (`s_name`), -- each section has an unique name
    FOREIGN KEY (`u_id`  ) REFERENCES `User`   (`u_id`), -- each section has been made by one user
    FOREIGN KEY (`s_supe`) REFERENCES `Section`(`s_id`)  -- each section is the child of an other section, except for ROOT
)ENGINE=InnoDB CHARSET=utf8 COMMENT="contains the sections of the forum";

-- we create a base user ROOT to manage the forum
INSERT IGNORE INTO `User`(
    `u_id`,
    `u_name`,
    `u_mail`,
    `u_pass`,
    `u_perm`
) VALUES (
    1,
    "ROOT",
    "root@root",
    "dc76e9f0c0006e8f919e0c515c66dbba3982f785", -- ROOT's password : "root"
    -1 -- ALL permissions
);
-- we don't need to define the id or the date because they are auto generated
INSERT IGNORE INTO `Section`(
    `s_id`,
    `u_id`,
    `s_supe`,
    `s_name`
) VALUES (
    1,
    1,
    1,
    "ROOT" -- name of the ROOT section
);


SET FOREIGN_KEY_CHECKS = 1;
