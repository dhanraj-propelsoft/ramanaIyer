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