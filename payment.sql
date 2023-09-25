ALTER TABLE orders ADD COLUMN paymentId int(11) DEFAULT NULL;

CREATE TABLE `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `total_amt` int(11) DEFAULT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `pg_payment_id` varchar(255) DEFAULT NULL,
  `pg_order_id` varchar(255) DEFAULT NULL,
  `pg_signature` varchar(255) DEFAULT NULL,
  `pg_error_code` varchar(255) DEFAULT NULL,
  `pg_error_desc` varchar(255) DEFAULT NULL,
  `pg_error_source` varchar(255) DEFAULT NULL,
  `pg_error_step` varchar(255) DEFAULT NULL,
  `pg_error_reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
);