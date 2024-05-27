DELIMITER $
  CREATE TRIGGER IF NOT EXISTS update_product_price_on_update AFTER UPDATE ON product_variants
  FOR EACH ROW
  BEGIN
    DECLARE new_price INT;
    SELECT price INTO new_price FROM product_variants WHERE product_id = NEW.product_id AND variant_status = 1 LIMIT 1 OFFSET 0;
    UPDATE products SET product_price = new_price WHERE product_id = NEW.product_id;
  END$

  CREATE TRIGGER IF NOT EXISTS update_product_price_on_insert AFTER INSERT ON product_variants
  FOR EACH ROW
  BEGIN
    DECLARE new_price INT;
    SELECT price INTO new_price FROM product_variants WHERE product_id = NEW.product_id AND variant_status = 1 LIMIT 1 OFFSET 0;
    UPDATE products SET product_price = new_price WHERE product_id = NEW.product_id;
  END$
DELIMITER ;
