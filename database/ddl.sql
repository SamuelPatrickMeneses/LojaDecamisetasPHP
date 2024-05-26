CREATE TABLE IF NOT EXISTS  users (
    user_id INT(11) NOT NULL AUTO_INCREMENT,
    user_name VARCHAR(100) NOT NULL,
    user_password VARCHAR(255) NOT NULL, 
    email VARCHAR(50) NOT NULL COLLATE utf8_bin,
    phone VARCHAR(32),
    notfy TINYINT(1) DEFAULT 0,
    last_login DATETIME,
    gmt_ofset TINYINT(2) DEFAULT 0,
    tax_id VARCHAR(11) DEFAULT '',
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
  FOREIGN KEY (product_id) REFERENCES products(product_id),
  FOREIGN KEY (grid_id) REFERENCES grids(grid_id)
) CHARACTER SET=utf8;

CREATE TABLE IF NOT EXISTS images (
  image_id INT(11) NOT NULL AUTO_INCREMENT,
  variant_id int NOT NULL,
  product_id int NOT NULL,
  image_name varchar(255) NOT NULL,
  image_file varchar(255) NOT NULL,
  PRIMARY KEY (image_id),
  CONSTRAINT images_ibfk_1 FOREIGN KEY (variant_id) REFERENCES product_variants (variant_id),
  CONSTRAINT images_ibfk_2 FOREIGN KEY (product_id) REFERENCES products (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS orders (
  order_id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NOT NULL,
  order_total INT NOT NULL,
  order_status TINYINT DEFAULT 0,
  pagback_id VARCHAR(41),
  order_time DATETIME NOT NULL,
  gmt_ofset TINYINT(2) DEFAULT 0,
  installments TINYINT(2) DEFAULT 1,
  PRIMARY KEY (order_id),
  FOREIGN KEY (user_id) REFERENCES users (user_id)
);

CREATE TABLE IF NOT EXISTS order_items (
  order_item_id INT(11) NOT NULL AUTO_INCREMENT,
  order_id INT(11) NOT NULL,
  product_id INT(11) NOT NULL,
  variant_id INT(11) NOT NULL,
  order_item_quantity INT NOT NULL,
  order_item_price INT(6) NOT NULL,
  PRIMARY KEY (order_item_id),
  FOREIGN KEY (order_id) REFERENCES orders (order_id),
  FOREIGN KEY (product_id) REFERENCES products (product_id),
  FOREIGN KEY (variant_id) REFERENCES product_variants (variant_id)
);
CREATE TABLE IF NOT EXISTS carts (
  user_id INT(11) NOT NULL,
  cart_total INT NOT NULL DEFAULT 0,
  cart_count INT NOT NULL DEFAULT 0,
  PRIMARY KEY (user_id),
  FOREIGN KEY (user_id) REFERENCES users (user_id)
);
CREATE TABLE IF NOT EXISTS cart_items (
  item_id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NOT NULL,
  product_id INT(11) NOT NULL,
  variant_id INT(11) NOT NULL,
  cart_item_quantity INT NOT NULL,
  cart_item_price INT(6) NOT NULL,
  PRIMARY KEY (item_id),
  FOREIGN KEY (user_id) REFERENCES users (user_id),
  FOREIGN KEY (product_id) REFERENCES products (product_id),
  FOREIGN KEY (variant_id) REFERENCES product_variants (variant_id)
);

CREATE TABLE IF NOT EXISTS addresses (
    addr_id INT(11) AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    addr_street VARCHAR(160),
    addr_number INT,
    addr_complement VARCHAR(40),
    addr_locality VARCHAR(60),
    addr_city VARCHAR(99),
    addr_region CHAR(50),
    addr_postal_code CHAR(8),
    addr_country varchar(5),
    PRIMARY KEY (addr_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE IF NOT EXISTS api_public_key (
    apk_id INT(11) AUTO_INCREMENT,
    apk_text VARCHAR(400),
    apk_time DATETIME NOT NULL,
    PRIMARY KEY (apk_id)
);
