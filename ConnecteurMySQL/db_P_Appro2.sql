USE db_P_Appro2;

CREATE TABLE t_user (
    user_id INT NOT NULL AUTO_INCREMENT,
    useUsername varchar(50) NOT NULL,
    usePassword varchar(255) NOT NULL,
    useIsAdmin tinyint(1) DEFAULT 0,
    PRIMARY KEY (user_id)
);