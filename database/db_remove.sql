/*
    queries to delete elements from the database
*/

-- remove post
DELETE FROM `Post` WHERE `p_id` = :id;

-- remove thread
DELETE FROM `Thread` WHERE `t_id` = :id;

-- remove section
DELETE FROM `Section` WHERE `s_id` = :id;