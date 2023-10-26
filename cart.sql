CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `pId` int(11) DEFAULT NULL,
  `pQty` int(3) DEFAULT NULL,
  `pPrice` int(11) DEFAULT NULL
);

ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);