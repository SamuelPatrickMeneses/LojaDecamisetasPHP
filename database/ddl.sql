CREATE TABLE IF NOT EXISTS  users (
    user_id INT(11) NOT NULL AUTO_INCREMENT,
    user_name VARCHAR(100) NOT NULL,
    user_password VARCHAR(255) NOT NULL, 
    email VARCHAR(50) NOT NULL COLLATE utf8_bin,
    phone VARCHAR(32),
    notfy TINYINT(1) DEFAULT 0,
    last_login DATETIME,
    gmt_ofset TINYINT(2) DEFAULT 0,
    PRIMARY KEY (user_id),
    UNIQUE INDEX users_email_index (email),
    INDEX user_name_index (user_name)
)CHARACTER SET=utf8;

CREATE TABLE IF NOT EXISTS admins(
  admin_id INT(11) NOT NULL AUTO_INCREMENT,
  admin_name VARCHAR(100) NOT NULL,
  admin_password VARCHAR(250) NOT NULL,
  PRIMARY KEY (admin_id)
) CHARACTER SET=utf8;

