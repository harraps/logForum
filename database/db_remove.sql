/*
    queries to delete elements from the database
*/

-- remove post
DELETE FROM `Post` WHERE `p_id` = :id;

-- remove thread
DELETE FROM `Thread` WHERE `t_id` = :id;

-- remove section
DELETE FROM `Section` WHERE `s_id` = :id;

-- remove user with his messages and his threads by its IP
DELETE FROM `Post`   WHERE `u_ip` = :ip;
DELETE FROM `Thread` WHERE `u_ip` = :ip;
DELETE FROM `User`   WHERE `u_ip` = :ip;

-- remove user by its name
DELETE `Post`, `Thread`, `User` 
FROM ((`User` 
INNER JOIN `Thread` ON `User`.`u_ip` = `Thread`.`u_ip`) 
INNER JOIN `Post`   ON `User`.`u_ip` = `Post`  .`u_ip`)
WHERE `u_name` = :name;