INSERT INTO users (user_id, user_name, user_password,email, notfy, last_login) VALUES (1, "SamuelPatrickMeneses","$2y$10$mtHqN3n1UupJaXdjj2xo3uq3OPGSGJAz8Sue1.s/KeTU7.WZknr5y","Samuel@email.com", 1, '2023-11-12 22:51:19');
INSERT INTO carts (user_id) VALUES (1);
INSERT INTO admins (admin_id, admin_name, admin_password) VALUES(1, "admin800","$2a$12$ADYVd9sQs.AG4nqzCv7sFuqpd7LcSmCnLEwtwYBmqp6droP/Xd4w6");
INSERT INTO grids (grid_id, grid_size, grid_color, grid_gender, grid_label) VALUES 
 (1, 'PPP', 'BLACK', 'M', 'PPP/BLACK/M'),
 (2, 'PP' , 'BLACK', 'M', 'PP/BLACK/M'),
 (3, 'P'  , 'BLACK', 'M', 'P/BLACK/M'),
 (4, 'M'  , 'BLACK', 'M', 'M/BLACK/M'),
 (5, 'G'  , 'BLACK', 'M', 'G/BLACK/M'),
 (6, '2G' , 'BLACK', 'M', '2G/BLACK/M'),
 (7, '3G' , 'BLACK', 'M', '3G/BLACK/M'),
 (8, '4G' , 'BLACK', 'M', '4G/BLACK/M'),
 (9, 'PPP', 'BLACK', 'F', 'PPP/BLACK/F'),
 (10, 'PP' , 'BLACK', 'F', 'PP/BLACK/F'),
 (11, 'P'  , 'BLACK', 'F', 'P/BLACK/F'),
 (12, 'M'  , 'BLACK', 'F', 'M/BLACK/F'),
 (13, 'G'  , 'BLACK', 'F', 'G/BLACK/F'),
 (14, '2G' , 'BLACK', 'F', '2G/BLACK/F'),
 (15, '3G' , 'BLACK', 'F', '3G/BLACK/F'),
 (16, '4G' , 'BLACK', 'F', '4G/BLACK/F');
INSERT INTO products (product_id, product_title, product_description, product_price, product_status) VALUES (1, 'camisa', 'camisa basica', 5000, 1);
INSERT INTO products (product_id, product_title, product_description, product_price, product_status) VALUES (2, 'poncho', 'bluzão', 1700, 1);
INSERT INTO product_variants (variant_id, grid_id, product_id, price, stock_quantity, variant_status) VALUES (1, 16, 1, 8000, 14, 1);
INSERT INTO product_variants (variant_id, grid_id, product_id, price, stock_quantity, variant_status) VALUES (2, 5, 2, 17000, 20, 1);
INSERT INTO images (image_id, variant_id, product_id, image_name, image_file) VALUES (1, 2, 2, '316430554_2224461077736438_7585446523594892452_n.jpg', '/uploads/3a09e036978df2ed8d0dbe34a42f69cdf80c382b8a96b39702ac6107c2cdf485.jpg');
INSERT INTO images (image_id, variant_id, product_id, image_name, image_file) VALUES (2, 2, 2, '9006113008620.jpeg', '/uploads/f99cfd44de7b289e8159ca59cee553443c427533e8edf524519eb5c2ef7aa255.jpeg');
INSERT INTO images (image_id, variant_id, product_id, image_name, image_file) VALUES (3, 1, 1, 'Captura de tela_2022-08-30_20-39-57.png', '/uploads/e9c4193bbad3dba4f2a8f3177a29067c895d2855e42165d8b8aaf8296ca0640d.png');
INSERT INTO cart_items (item_id, user_id, product_id, variant_id, cart_item_quantity, cart_item_price) VALUES (1, 1, 2, 2, 1, 17000);
INSERT INTO addresses(addr_id, user_id, addr_street, addr_number, addr_complement, addr_locality, addr_city, addr_region, addr_postal_code, addr_country) VALUES (1, 1, 'visente machado', '255', 'Fasenda Santa Elena', 'interior', 'palmitaltinho', 'Para', '85270000', 'BR')
