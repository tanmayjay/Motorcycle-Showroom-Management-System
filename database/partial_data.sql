--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_type`, `brand`, `mileage`, `storage`, `sale_count`, `book_count`, `status`, `price`, `image_file`, `date_arrived`) VALUES
(1, 'Yamaha R15 V3', 'Motorcycle', 'Yamaha', 150, 5, 3, 2, 'In Stock', '500000.00', 'images/r15.png', '0000-00-00 00:00:00'),
(2, 'Suzuki Gixxer SF Single Disc', 'Motorcycle', 'Suzuki', 150, 3, 1, NULL, 'In Stock', '240000.00', 'images/gsf.jpg', '0000-00-00 00:00:00'),
(3, 'Honda CBR150R Repsol', 'Motorcycle', 'Honda', 150, 4, 1, NULL, 'In stock', '450000.00', 'images/repsol.jpg', '0000-00-00 00:00:00'),
(6, 'Suzuki Gixxer SF Double Disc MotoGP Edition', 'Motorcycle', 'Suzuki', 160, 4, 1, 2, 'In Stock', '300000.00', 'images/gsfm.jpg', '2019-03-10 00:00:00'),
(7, 'Honda CBR 150R Special Edition', 'Motorcycle', 'Honda', 150, 6, 0, NULL, 'In Stock', '450000.00', 'images/cbr.jpg', '0000-00-00 00:00:00'),
(8, 'Bajaj Pulsar NS160', 'Motorcycle', 'Bajaj', 160, 7, 1, NULL, 'In Stock', '190000.00', 'images/pulsar.jpg', '0000-00-00 00:00:00'),
(9, 'TVS Apache RTR160 4V', 'Motorcycle', 'TVS', 160, 3, 0, NULL, 'In Stock', '187000.00', 'images/rtr.jpg', '0000-00-00 00:00:00'),
(11, 'Hero XF3R', 'Motorcycle', 'Hero', 150, 6, 0, NULL, 'In Stock', '250000.00', 'images/heroxf3r.jpg', '0000-00-00 00:00:00'),
(12, 'Suzuki GSX-R150', 'Motorcycle', 'Suzuki', 150, 9, 0, NULL, 'In Stock', '400000.00', 'images/gsxr.jpg', '0000-00-00 00:00:00'),
(13, 'Suzuki GSX-S150', 'Motorcycle', 'Suzuki', 150, 0, 0, NULL, 'Stock Out', '325000.00', 'images/gsxs.jpg', '0000-00-00 00:00:00'),
(14, 'Kawasaki Ninja 125', 'Motorcycle', 'Kawasaki', 125, 5, NULL, NULL, 'In Stock', '350000.00', 'images/Ninja125.jpg', '0000-00-00 00:00:00'),
(15, 'Kawasaki Ninja H2', 'Motorcycle', 'Kawasaki', 180, NULL, NULL, NULL, 'Upcoming', '500000.00', 'images/ninjah2.jpg', '0000-00-00 00:00:00'),
(16, 'Yamaha Fazer V2', 'Motorcycle', 'Yamaha', 150, 4, 1, NULL, 'In Stock', '330000.00', 'images/fazer2.jpg', '2019-02-10 00:00:00'),
(17, 'Suzuki Intruder 150', 'Motorcycle', 'Suzuki', 150, 0, NULL, NULL, 'Upcoming', '270000.00', 'images/intruder.jpeg', '0000-00-00 00:00:00');

-- --------------------------------------------------------
--
-- Dumping data for table `showroom`
--

INSERT INTO `showroom` (`sr_id`, `sr_name`, `address`, `email`, `contact_no`) VALUES
(1, 'Banasree-1', 'Block-D, Banasree, Dhaka', 'care_b1@stallions.com', '542376891');

-- --------------------------------------------------------

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `email`, `password`, `user_type`) VALUES
(1, 'jay', 'jktanmay@gmail.com', 'Tanmay071', 'Admin');