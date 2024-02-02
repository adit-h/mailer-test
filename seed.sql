CREATE TABLE IF NOT EXISTS subscriber (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL,
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    `status` TINYINT(2) NULL DEFAULT 0,
    PRIMARY KEY (id)
) ENGINE=INNODB;

INSERT INTO subscriber (email, firstname, lastname, `status`) VALUES
    ('maria@mail.com', 'Maria', 'Hristozova', 1),
    ('jane@mail.com', 'Jane', 'Smith', 1),
    ('john@mail.com', 'John', 'Smith', 1),
    ('richard@mail.com', 'Richard', 'Smith', 1),
    ('donna@mail.com', 'Donna', 'Smith', 1),
    ('josh@mail.com', 'Josh', 'Harrelson', 1);