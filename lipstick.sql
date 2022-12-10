-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 29, 2022 lúc 01:18 PM
-- Phiên bản máy phục vụ: 10.4.22-MariaDB
-- Phiên bản PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `lipstick`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblcart`
--

CREATE TABLE `tblcart` (
  `id` bigint(20) NOT NULL,
  `memberId` bigint(20) NOT NULL,
  `createAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblcartdetail`
--

CREATE TABLE `tblcartdetail` (
  `cartId` bigint(20) NOT NULL,
  `productId` bigint(20) NOT NULL,
  `quantity` bigint(20) NOT NULL,
  `createAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblcategory`
--

CREATE TABLE `tblcategory` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tblcategory`
--

INSERT INTO `tblcategory` (`id`, `name`) VALUES
(8, 'Son lì'),
(9, 'Son dưỡng'),
(10, 'Son bóng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblcategoryproduct`
--

CREATE TABLE `tblcategoryproduct` (
  `sub_category_id` bigint(20) NOT NULL,
  `productId` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tblcategoryproduct`
--

INSERT INTO `tblcategoryproduct` (`sub_category_id`, `productId`) VALUES
(11, 63),
(12, 64);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblcontact`
--

CREATE TABLE `tblcontact` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phoneNumber` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `createAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblimage`
--

CREATE TABLE `tblimage` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `productId` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tblimage`
--

INSERT INTO `tblimage` (`id`, `name`, `productId`) VALUES
(158, '59246f45-efb6-412a-bc57-35ca295c4092.webp', 218),
(159, 'c2d6a415-0d9c-4306-b700-8309eef031d1.webp', 219),
(160, '19c4c0a0-7533-4936-91c4-0994f789f247.webp', 220),
(161, 'b216444d-7757-4081-986f-9b44cd295e96.webp', 221);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblmember`
--

CREATE TABLE `tblmember` (
  `id` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phoneNumber` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL,
  `isAdmin` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tblmember`
--

INSERT INTO `tblmember` (`id`, `email`, `name`, `address`, `phoneNumber`, `password`, `isAdmin`) VALUES
(2, 'luonghaui221@gmail.com', 'Nguyễn Văn Lương', 'Số 3 Ngõ Cổng Xây - Thôn Địch Trung', '0975658029', '$2y$10$VSNU6nT0ZM7oHbXNBoT5d.cfrusbkSTrVwOWtj9D6Mo9dGdHbQnM.', b'1'),
(3, 'luong221@gmail.com', 'Lương', 'Số 3 Ngõ Cổng Xây - Thôn Địch Trung', '0975658029', '$2y$10$NjF7JqY9ghysmwKWCf64Du8qqIfxPTcNPRx7d64H5OH2Lc9OQU0ZC', b'0');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblorder`
--

CREATE TABLE `tblorder` (
  `id` varchar(15) NOT NULL,
  `memberId` bigint(20) NOT NULL,
  `status` enum('PROCESSING','PENDING','SHIPED','DELIVERED','CANCELLED') DEFAULT 'PENDING',
  `totalAmount` float NOT NULL,
  `discount` float DEFAULT 0,
  `shipCost` float NOT NULL,
  `createAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblorderitem`
--

CREATE TABLE `tblorderitem` (
  `id` bigint(20) NOT NULL,
  `productId` bigint(20) NOT NULL,
  `orderId` varchar(15) NOT NULL,
  `price` float NOT NULL,
  `quantity` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblproduct`
--

CREATE TABLE `tblproduct` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tblproduct`
--

INSERT INTO `tblproduct` (`id`, `name`, `description`, `price`) VALUES
(63, 'Son 3CE Red Recipe a8352d', '{\"ops\":[{\"attributes\":{\"color\":\"#3c3c3c\",\"bold\":true},\"insert\":\"Bộ sưu tập lần này của 3CE sẽ đưa các nàng quay trở lại với tình yêu bất diệt với son đỏ trong dịp Valentine đầy ý nghĩa này. Với tên gọi Red Recipe, dòng son mới toanh đầy cuốn hút của 3CE ra mắt với 5 tone son đỏ, mỗi màu một sắc thái và có nét quyến rũ rất riêng. Trong đó Son 3CE dòng Red Recipe màu 214 là màu đỏ tươi đầy sức sống và được yêu thích nhất của bộ sưu tập.\"},{\"insert\":\"\\n\"}]}', 450000),
(64, 'DIOR Addict Lip Glow e33638', '{\"ops\":[{\"insert\":\"Nhắc đến các loại son dưỡng High-end không thể bỏ qua nhà \"},{\"attributes\":{\"bold\":true},\"insert\":\"DIOR\"},{\"insert\":\" – thương hiệu đứng đầu trong thế giới dưỡng môi khi cho ra đời nhiều dòng son dưỡng môi từ dạng thỏi đến dạng kem với nhiều kiểu dáng khác nhau. Đến hẹn lại lên, cứ vào dịp cuối năm, \"},{\"attributes\":{\"bold\":true},\"insert\":\"DIOR\"},{\"insert\":\" lại khiến các tín đồ mê son “đứng ngồi không yên” chờ đợi sự ra đời phiên bản mới của dòng son này.\\nTrong Bộ sưu tập \"},{\"attributes\":{\"bold\":true},\"insert\":\"mùa xuân 2019\"},{\"insert\":\", \"},{\"attributes\":{\"bold\":true,\"color\":\"#f37165\",\"link\":\"https://www.vivalust.vn/thuong-hieu/dior\"},\"insert\":\"DIOR \"},{\"insert\":\"đã chính thức ra mắt dòng son dưỡng thần thánh mang tên \"},{\"attributes\":{\"bold\":true},\"insert\":\"Dior Lip Glow To The Max, \"},{\"insert\":\"với một diện mạo mới vô cùng xinh xắn chẳng khác gì viên kẹo ngọt Alpenliebe. Son có tất cả 3 màu : hồng dâu, cam đào và hồng tím cực kì ngọt ngào và dễ thương.\\n\"}]}', 750000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblproductdetail`
--

CREATE TABLE `tblproductdetail` (
  `id` bigint(20) NOT NULL,
  `productId` bigint(20) NOT NULL,
  `color` varchar(100) NOT NULL,
  `quantity` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tblproductdetail`
--

INSERT INTO `tblproductdetail` (`id`, `productId`, `color`, `quantity`) VALUES
(218, 63, '#a8352d', 100),
(219, 64, '#dd9478', 5),
(220, 64, '#b93e21', 5),
(221, 64, '#e33638', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblreview`
--

CREATE TABLE `tblreview` (
  `id` bigint(20) NOT NULL,
  `memberId` bigint(20) NOT NULL,
  `productId` bigint(20) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblsubcategory`
--

CREATE TABLE `tblsubcategory` (
  `id` bigint(20) NOT NULL,
  `categoryId` bigint(20) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tblsubcategory`
--

INSERT INTO `tblsubcategory` (`id`, `categoryId`, `name`) VALUES
(11, 10, 'son 3ce'),
(12, 9, 'son dior');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tblcart`
--
ALTER TABLE `tblcart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `memberId` (`memberId`);

--
-- Chỉ mục cho bảng `tblcartdetail`
--
ALTER TABLE `tblcartdetail`
  ADD PRIMARY KEY (`cartId`,`productId`),
  ADD KEY `productId` (`productId`);

--
-- Chỉ mục cho bảng `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tblcategoryproduct`
--
ALTER TABLE `tblcategoryproduct`
  ADD PRIMARY KEY (`sub_category_id`,`productId`),
  ADD KEY `productId` (`productId`);

--
-- Chỉ mục cho bảng `tblcontact`
--
ALTER TABLE `tblcontact`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tblimage`
--
ALTER TABLE `tblimage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productId` (`productId`);

--
-- Chỉ mục cho bảng `tblmember`
--
ALTER TABLE `tblmember`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tblorder`
--
ALTER TABLE `tblorder`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tblorderitem`
--
ALTER TABLE `tblorderitem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orderId` (`orderId`),
  ADD KEY `productId` (`productId`);

--
-- Chỉ mục cho bảng `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tblproductdetail`
--
ALTER TABLE `tblproductdetail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productId` (`productId`);

--
-- Chỉ mục cho bảng `tblreview`
--
ALTER TABLE `tblreview`
  ADD PRIMARY KEY (`id`),
  ADD KEY `memberId` (`memberId`),
  ADD KEY `productId` (`productId`);

--
-- Chỉ mục cho bảng `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoryId` (`categoryId`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tblcart`
--
ALTER TABLE `tblcart`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `tblcontact`
--
ALTER TABLE `tblcontact`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tblimage`
--
ALTER TABLE `tblimage`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT cho bảng `tblmember`
--
ALTER TABLE `tblmember`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `tblorderitem`
--
ALTER TABLE `tblorderitem`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tblproduct`
--
ALTER TABLE `tblproduct`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT cho bảng `tblproductdetail`
--
ALTER TABLE `tblproductdetail`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT cho bảng `tblreview`
--
ALTER TABLE `tblreview`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `tblcart`
--
ALTER TABLE `tblcart`
  ADD CONSTRAINT `tblcart_ibfk_1` FOREIGN KEY (`memberId`) REFERENCES `tblmember` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tblcartdetail`
--
ALTER TABLE `tblcartdetail`
  ADD CONSTRAINT `tblcartdetail_ibfk_1` FOREIGN KEY (`cartId`) REFERENCES `tblcart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblcartdetail_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `tblproduct` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tblcategoryproduct`
--
ALTER TABLE `tblcategoryproduct`
  ADD CONSTRAINT `tblcategoryproduct_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `tblproduct` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblcategoryproduct_ibfk_2` FOREIGN KEY (`sub_category_id`) REFERENCES `tblsubcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tblimage`
--
ALTER TABLE `tblimage`
  ADD CONSTRAINT `tblimage_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `tblproductdetail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tblorderitem`
--
ALTER TABLE `tblorderitem`
  ADD CONSTRAINT `tblorderitem_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `tblorder` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblorderitem_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `tblproduct` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tblproductdetail`
--
ALTER TABLE `tblproductdetail`
  ADD CONSTRAINT `tblproductdetail_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `tblproduct` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tblreview`
--
ALTER TABLE `tblreview`
  ADD CONSTRAINT `tblreview_ibfk_1` FOREIGN KEY (`memberId`) REFERENCES `tblmember` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblreview_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `tblproduct` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  ADD CONSTRAINT `tblsubcategory_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `tblcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
