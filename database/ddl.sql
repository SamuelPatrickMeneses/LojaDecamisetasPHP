CREATE TABLE IF NOT EXISTS  users (
    user_id INT(11) NOT NULL AUTO_INCREMENT,
    user_name VARCHAR(100) NOT NULL,
    user_password VARCHAR(33) NOT NULL, 
    email VARCHAR(50) NOT NULL,
    phone VARCHAR(32),
    notfy TINYINT(1) DEFAULT 0,
    last_login TIMESTAMP DEFAULT NOW(),
    PRIMARY KEY (user_id),
    UNIQUE INDEX users_email_index (email),
    INDEX user_name_index (user_name)
)CHARACTER SET=utf8;

INSERT INTO users (user_name, user_password,email, notfy) VALUES ("Samuel","senha1","Samuel@email.com", 1); 