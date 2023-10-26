ALTER TABLE orders ADD COLUMN receiptNo varchar(50) DEFAULT NULL;
ALTER TABLE orders ADD COLUMN paymentId varchar(50) DEFAULT NULL;

CREATE TABLE `payment` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `userId` INT(11) DEFAULT NULL,
  `total_amt` INT(11) DEFAULT NULL,
  `receipt_no` VARCHAR(50) DEFAULT NULL,
  `payment_status` VARCHAR(50) DEFAULT NULL,
  `pg_payment_id` VARCHAR(100) DEFAULT NULL,
  `pg_order_id` VARCHAR(100) DEFAULT NULL,
  `pg_signature` VARCHAR(100) DEFAULT NULL,
  `pg_error_code` VARCHAR(100) DEFAULT NULL,
  `pg_error_desc` MEDIUMTEXT,
  `pg_error_source` VARCHAR(100) DEFAULT NULL,
  `pg_error_step` VARCHAR(100) DEFAULT NULL,
  `pg_error_reason` VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE `payment`;
CREATE TABLE `payment` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `userId` INT(11) DEFAULT NULL,
  `receipt_no` VARCHAR(50) DEFAULT NULL,
  `total_amt` INT(11) DEFAULT NULL,
  `pg_buyer` VARCHAR(100) DEFAULT NULL,
  `pg_buyer_name` VARCHAR(100) DEFAULT NULL,
  `pg_buyer_phone` VARCHAR(100) DEFAULT NULL,
  `pg_currency` VARCHAR(100) DEFAULT NULL,
  `pg_fees` VARCHAR(100) DEFAULT NULL,
  `pg_longurl` MEDIUMTEXT,
  `pg_mac` VARCHAR(100) DEFAULT NULL,
  `pg_payment_id` VARCHAR(100) DEFAULT NULL,
  `pg_request_id` VARCHAR(100) DEFAULT NULL,
  `pg_purpose` VARCHAR(100) DEFAULT NULL,
  `pg_shorturl` VARCHAR(100) DEFAULT NULL,
  `payment_status` VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

ALTER TABLE users ADD COLUMN address_line1 longtext DEFAULT NULL;
ALTER TABLE users ADD COLUMN address_line2 longtext DEFAULT NULL;
ALTER TABLE orders ADD COLUMN price varchar(50) DEFAULT NULL;
ALTER TABLE orders ADD COLUMN dtSupply datetime DEFAULT NULL;
ALTER TABLE products ADD COLUMN prod_avail varchar(25) DEFAULT NULL;
ALTER TABLE products ADD COLUMN allow_ao smallint DEFAULT 0;
ALTER TABLE orders ADD COLUMN orderId varchar(50) DEFAULT NULL;
ALTER TABLE orders ADD COLUMN orderBy varchar(10) DEFAULT NULL;