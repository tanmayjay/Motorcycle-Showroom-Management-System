SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `showroom`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(7) NOT NULL,
  `booking_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `product_id` int(7) NOT NULL,
  `user_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `contains`
--

CREATE TABLE `contains` (
  `sr_id` int(7) NOT NULL,
  `product_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cust_id` int(7) NOT NULL,
  `user_id` int(7) NOT NULL,
  `fname` varchar(25) NOT NULL,
  `lname` varchar(25) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `address` varchar(40) NOT NULL,
  `dob` datetime DEFAULT NULL,
  `image` longblob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(7) NOT NULL,
  `product_name` varchar(60) NOT NULL,
  `product_type` varchar(25) NOT NULL,
  `brand` varchar(25) NOT NULL,
  `mileage` int(5) UNSIGNED NOT NULL,
  `storage` int(4) DEFAULT NULL,
  `sale_count` int(4) DEFAULT NULL,
  `book_count` int(4) UNSIGNED DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `image_file` varchar(30) NOT NULL,
  `date_arrived` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sale_id` int(7) NOT NULL,
  `sale_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `payment` decimal(12,2) NOT NULL,
  `product_id` int(7) NOT NULL,
  `cust_id` int(7) NOT NULL,
  `user_id` int(7) NOT NULL,
  `sr_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `showroom`
--

CREATE TABLE `showroom` (
  `sr_id` int(7) NOT NULL,
  `sr_name` varchar(25) NOT NULL,
  `address` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `contact_no` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(7) NOT NULL,
  `user_name` varchar(25) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(20) NOT NULL,
  `user_type` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `fname` varchar(25) DEFAULT NULL,
  `lname` varchar(25) DEFAULT NULL,
  `address` varchar(40) DEFAULT NULL,
  `dob` datetime DEFAULT NULL,
  `gender` varchar(7) DEFAULT NULL,
  `phone_no` varchar(15) DEFAULT NULL,
  `image` longblob,
  `user_id` int(7) NOT NULL,
  `sr_id` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `Booking_Customer_FK` (`user_id`),
  ADD KEY `Booking_Product_FK` (`product_id`);

--
-- Indexes for table `contains`
--
ALTER TABLE `contains`
  ADD PRIMARY KEY (`sr_id`,`product_id`),
  ADD KEY `FK_ASS_5` (`product_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `Sales_Customer_FK` (`cust_id`),
  ADD KEY `Sales_Product_FK` (`product_id`),
  ADD KEY `Sales_users_FK` (`user_id`),
  ADD KEY `Sales_Showroom_FK` (`sr_id`);

--
-- Indexes for table `showroom`
--
ALTER TABLE `showroom`
  ADD PRIMARY KEY (`sr_id`),
  ADD KEY `showroom_user_info_FK` (`sr_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD KEY `users_user_info_FK` (`user_id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD UNIQUE KEY `user_info__IDX` (`user_id`),
  ADD KEY `showroom_user_info_FK` (`sr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cust_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `showroom`
--
ALTER TABLE `showroom`
  MODIFY `sr_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `Booking_Product_FK` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contains`
--
ALTER TABLE `contains`
  ADD CONSTRAINT `FK_ASS_4` FOREIGN KEY (`sr_id`) REFERENCES `showroom` (`sr_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ASS_5` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `Sales_Customer_FK` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Sales_Product_FK` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Sales_Showroom_FK` FOREIGN KEY (`sr_id`) REFERENCES `showroom` (`sr_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Sales_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_info`
--
ALTER TABLE `user_info`
  ADD CONSTRAINT `showroom_user_info_FK` FOREIGN KEY (`sr_id`) REFERENCES `showroom` (`sr_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `users_user_info_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;



COMMIT;
