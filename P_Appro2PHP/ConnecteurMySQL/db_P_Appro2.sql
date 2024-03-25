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

CREATE TABLE t_places (
    place_id INT NOT NULL AUTO_INCREMENT,
    plaType varchar(50) NOT NULL,
    plaPrice DECIMAL(15,2) NOT NULL,
    PRIMARY KEY (place_id)
);

CREATE TABLE t_reservation (
    reservation_id INT NOT NULL AUTO_INCREMENT,
    resDate DATE NOT NULL,
    resMatin BOOLEAN NOT NULL,
    resApresMidi BOOLEAN NOT NULL,
    resStatut varchar(50) NOT NULL,
    places_fk INT NOT NULL,
    user_fk INT NOT NULL,
    PRIMARY KEY (reservation_id),
    FOREIGN KEY (places_fk) REFERENCES t_places(place_id),
    FOREIGN KEY (user_fk) REFERENCES t_user(user_id)
);
