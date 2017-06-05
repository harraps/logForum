-- we don't need to define the id or the date because they are auto generated

INSERT INTO `Section`(`s_name`) VALUES ("Section1");
INSERT INTO `Section`(`s_name`) VALUES ("Section2");
INSERT INTO `Section`(`s_name`) VALUES ("Section3");

INSERT INTO `Thread`(`u_id`,`s_id`,`t_name`) VALUES (1,1,"Thread1.1");
INSERT INTO `Thread`(`u_id`,`s_id`,`t_name`) VALUES (1,1,"Thread1.2");
INSERT INTO `Thread`(`u_id`,`s_id`,`t_name`) VALUES (1,1,"Thread1.3");
INSERT INTO `Thread`(`u_id`,`s_id`,`t_name`) VALUES (1,2,"Thread2.1");
INSERT INTO `Thread`(`u_id`,`s_id`,`t_name`) VALUES (1,2,"Thread2.2");
INSERT INTO `Thread`(`u_id`,`s_id`,`t_name`) VALUES (1,3,"Thread3.1");

INSERT INTO `Post`(`u_id`,`t_id`,`p_text`) VALUES (1,1,"Hello");
INSERT INTO `Post`(`u_id`,`t_id`,`p_text`) VALUES (1,1,"Hola");
INSERT INTO `Post`(`u_id`,`t_id`,`p_text`) VALUES (1,1,"Halo");

INSERT INTO `Chat`(`u_id`,`c_text`) VALUES (1,"Hello");
INSERT INTO `Chat`(`u_id`,`c_text`) VALUES (1,"Hola");
INSERT INTO `Chat`(`u_id`,`c_text`) VALUES (1,"Halo");