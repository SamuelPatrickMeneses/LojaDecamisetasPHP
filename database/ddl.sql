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

CREATE TABLE IF NOT EXISTS products (
  product_id INT(11) NOT NULL AUTO_INCREMENT,
  product_title VARCHAR(500) NOT NULL,
  product_description VARCHAR(1000) NOT NULL,
  product_price INT(6) NOT NULL,
  product_status TINYINT NOT NULL,
  PRIMARY KEY (product_id),
  FULLTEXT (product_title)
) CHARACTER SET=utf8;

CREATE TABLE IF NOT EXISTS grids (
  grid_id INT(11) NOT NULL AUTO_INCREMENT,
  grid_size VARCHAR(3) NOT NULL,
  grid_color VARCHAR(20) NOT NULL,
  grid_label VARCHAR(26) NOT NULL,
  grid_gender VARCHAR(1) NOT NULL,
  PRIMARY KEY (grid_id)
) CHARACTER SET=utf8;

CREATE TABLE IF NOT EXISTS product_variants (
  variant_id INT(11) NOT NULL AUTO_INCREMENT,
  grid_id INT(11) NOT NULL,
  product_id INT(11) NOT NULL,
  price INT(6) NOT NULL,
  stock_quantity INT(8) NOT NULL DEFAULT 0,
  variant_status TINYINT NOT NULL,
  PRIMARY KEY (variant_id),
  FOREIGN KEY (product_id) REFERENCES products(product_id)
) CHARACTER SET=utf8;
