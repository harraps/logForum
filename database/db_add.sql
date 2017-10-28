/*
    queries to add elements
*/

INSERT INTO `User`(`u_ip`,`u_name`,`u_desc`) VALUES (
    :ip,
    :name,
    :desc
);

INSERT INTO `Post`(`u_ip`,`t_id`,`p_text`) VALUES (
    :ip,
    :thread,
    :text
);

INSERT INTO `Thread`(`u_ip`,`s_id`,`t_name`) VALUES (
    :ip,
    :section,
    :name
);

INSERT INTO `Section`(`s_name`,`s_desc`) VALUES (
    :name,
    :desc
);