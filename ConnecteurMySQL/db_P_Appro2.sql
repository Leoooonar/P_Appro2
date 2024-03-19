USE db_P_Appro2;

CREATE TABLE t_user (
    user_id INT NOT NULL AUTO_INCREMENT,
    useUsername varchar(50) NOT NULL,
    usePassword varchar(255) NOT NULL,
    useFirstname varchar(250) DEFAULT NULL,
    useLastname varchar(250) DEFAULT NULL,
    useMail varchar(250) DEFAULT NULL,
    useGender char(1) DEFAULT NULL,
    useIsAdmin tinyint(1) DEFAULT 0,
    PRIMARY KEY (user_id)
);