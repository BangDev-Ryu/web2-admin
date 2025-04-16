-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 16, 2025 lúc 05:00 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `web2_sql`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietphanquyen`
--

CREATE TABLE `chitietphanquyen` (
  `chucvu_id` int(11) NOT NULL,
  `quyen_id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietphieuban`
--

CREATE TABLE `chitietphieuban` (
  `phieuban_id` int(11) NOT NULL,
  `sanpham_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `chitietphieuban`
--

INSERT INTO `chitietphieuban` (`phieuban_id`, `sanpham_id`, `quantity`, `price`) VALUES
(1, 1, 6, 33000.00),
(1, 2, 1, 27500.00),
(1, 3, 1, 32450.00),
(2, 6, 5, 32890.00),
(2, 7, 4, 34100.00),
(2, 8, 5, 23100.00),
(3, 1, 2, 33000.00),
(3, 2, 2, 27500.00),
(3, 3, 2, 32450.00),
(3, 4, 1, 25850.00),
(3, 5, 1, 28050.00),
(3, 6, 1, 32890.00),
(3, 7, 1, 34100.00),
(3, 8, 1, 23100.00),
(4, 1, 11, 33000.00),
(5, 2, 3, 27500.00),
(5, 3, 3, 32450.00),
(5, 4, 3, 25850.00),
(6, 1, 3, 33000.00),
(6, 7, 3, 34100.00),
(6, 49, 1, 25300.00),
(6, 50, 1, 25300.00),
(7, 1, 1, 33000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietphieubaohanh`
--

CREATE TABLE `chitietphieubaohanh` (
  `phieubaohanh_id` int(11) NOT NULL,
  `sanpham_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietphieunhap`
--

CREATE TABLE `chitietphieunhap` (
  `phieunhap_id` int(11) NOT NULL,
  `sanpham_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `profit` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chucvu`
--

CREATE TABLE `chucvu` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `role_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `chucvu`
--

INSERT INTO `chucvu` (`id`, `role_name`, `role_description`) VALUES
(1, 'Khách hàng', 'Khách hàng'),
(2, 'Quản trị viên', 'Người quản lý hệ thống'),
(3, 'Nhân viên kho', 'Nhân viên quản kho');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chude`
--

CREATE TABLE `chude` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `theloai_id` int(11) DEFAULT NULL,
  `trangthai_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `chude`
--

INSERT INTO `chude` (`id`, `name`, `theloai_id`, `trangthai_id`) VALUES
(1, 'Naruto', 1, 1),
(2, 'One Piece', 1, 1),
(3, 'Ô tô', 2, 1),
(4, 'Mô tô', 2, 1),
(5, 'Quân sự', 5, 1),
(6, 'Dragon Ball', 1, 1),
(7, 'Marvel', 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diachi`
--

CREATE TABLE `diachi` (
  `id` int(11) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `ward` varchar(100) DEFAULT NULL,
  `nguoidung_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `diachi`
--

INSERT INTO `diachi` (`id`, `address`, `city`, `district`, `ward`, `nguoidung_id`) VALUES
(1, '123 Đường Ba Đình', 'Hà Nội', 'Quận Thanh Xuân', 'Khương Đình', 2),
(2, '123 Đường Nguyễn Trãi', 'Hồ Chí Minh', 'Quận 5', 'Phường 7', 2),
(3, '123 Phạm Thế Hiển', 'Hồ Chí Minh', 'Quận 8', 'Phường 6', 4),
(4, '123 Lê Hồng Phong', 'Hồ Chí Minh', 'Quận 5', 'Phường 3', 5),
(5, '123 An Dương Vương', 'Hồ Chí Minh', 'Quận 5', 'Phường 2', 6),
(6, '123 Nguyễn Tri Phương', 'Hồ Chí Minh', 'Quận 5', 'Phường 3', 7),
(7, '123 Tạ Quang Bửu', 'Hồ Chí Minh', 'Quận 8', 'Phường 4', 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `nguoidung_id` int(11) NOT NULL,
  `sanpham_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khuyenmai`
--

CREATE TABLE `khuyenmai` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(100) NOT NULL,
  `profit` decimal(10,2) NOT NULL,
  `type` varchar(10) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `khuyenmai`
--

INSERT INTO `khuyenmai` (`id`, `name`, `code`, `profit`, `type`, `startDate`, `endDate`) VALUES
(1, 'Khuyến mãi mùa hè', 'MUAHE1', 10.00, '1', '2025-06-01 00:00:00', '2025-06-30 23:59:59'),
(2, 'Khuyến mãi Black Friday', 'BLACKFRIDAY1', 20.00, '1', '2025-11-20 00:00:00', '2025-11-30 23:59:59'),
(3, 'Khuyến mãi Giáng sinh', 'GIANGSINH1', 50000.00, '2', '2025-12-01 00:00:00', '2025-12-25 23:59:59'),
(4, 'Khuyến mãi 8 tháng 3 ', '8THANG3', 25000.00, '2', '2025-02-08 00:00:00', '2025-05-25 23:59:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `taikhoan_id` int(11) DEFAULT NULL,
  `chucvu_id` int(11) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`id`, `fullname`, `email`, `phone`, `taikhoan_id`, `chucvu_id`, `picture`, `date_of_birth`) VALUES
(1, 'Đặng Huy', 'huyhoang119763@gmail.com', '0585822398', 1, 1, './assets/img/user-img/user_default.png', '2004-06-11'),
(2, 'Nguyễn Thanh Điền', 'nguyenthanhdien@gmail.com', '0585822396', 2, 1, './assets/img/user-img/user_default.png', '2004-09-11'),
(3, 'Đặng Huy', 'huyhoang119762@gmail.com', '0585822397', 3, 1, './assets/img/user-img/user_default.png', '2004-03-11'),
(4, 'Quách Gia Bảo', 'giabao@gmail.com', '', 4, 1, './assets/img/user-img/user_default.png', '0000-00-00'),
(5, 'Võ Kim Bằng', 'bangbang@gmail.com', '', 5, 1, './assets/img/user-img/user_default.png', '0000-00-00'),
(6, 'Hà Ngọc Thiên Bảo', 'miryl@gmail.com', '', 6, 1, './assets/img/user-img/user_default.png', '0000-00-00'),
(7, 'Đặng Huy', 'huyhoang119764@gmail.com', '', 7, 1, './assets/img/user-img/user_default.png', '0000-00-00'),
(8, 'Nguyễn Văn A', 'test@gmail.com', '', 8, 1, './assets/img/user-img/user_default.png', '0000-00-00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `contact_phone` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `trangthai_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `nhacungcap`
--

INSERT INTO `nhacungcap` (`id`, `name`, `contact_person`, `contact_email`, `contact_phone`, `address`, `trangthai_id`) VALUES
(1, 'Công ty A', 'Nguyen Van C', 'contact_a@example.com', '0123456789', '789 Đường A', 1),
(2, 'Công ty B', 'Tran Thi D', 'contact_b@example.com', '0987654321', '321 Đường B', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuban`
--

CREATE TABLE `phieuban` (
  `id` int(11) NOT NULL,
  `nguoidung_id` int(11) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `ward` varchar(100) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `trangthai_id` int(11) DEFAULT NULL,
  `payment` varchar(30) DEFAULT NULL,
  `khuyenmai_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `phieuban`
--

INSERT INTO `phieuban` (`id`, `nguoidung_id`, `address`, `city`, `district`, `ward`, `order_date`, `total_amount`, `trangthai_id`, `payment`, `khuyenmai_id`) VALUES
(1, 2, '123 Đường Ba Đình', 'Hà Nội', 'Quận Thanh Xuân', 'Khương Đình', '2025-04-16 10:52:42', 257950.00, 9, 'Thanh toán khi nhận hàng', NULL),
(2, 2, '123 Đường Nguyễn Trãi', 'Hồ Chí Minh', 'Quận 5', 'Phường 7', '2025-04-16 10:54:16', 416350.00, 9, 'Thanh toán khi nhận hàng', NULL),
(3, 4, '123 Phạm Thế Hiển', 'Hồ Chí Minh', 'Quận 8', 'Phường 6', '2025-04-16 11:06:52', 329890.00, 9, 'Thanh toán khi nhận hàng', NULL),
(4, 5, '123 Lê Hồng Phong', 'Hồ Chí Minh', 'Quận 5', 'Phường 3', '2025-04-16 11:18:13', 363000.00, 9, 'Thanh toán khi nhận hàng', NULL),
(5, 6, '123 An Dương Vương', 'Hồ Chí Minh', 'Quận 5', 'Phường 2', '2025-04-16 11:19:44', 257400.00, 9, 'Thanh toán khi nhận hàng', NULL),
(6, 7, '123 Nguyễn Tri Phương', 'Hồ Chí Minh', 'Quận 5', 'Phường 3', '2025-04-16 11:22:09', 251900.00, 9, 'Thanh toán khi nhận hàng', NULL),
(7, 8, '123 Tạ Quang Bửu', 'Hồ Chí Minh', 'Quận 8', 'Phường 4', '2025-04-16 11:23:28', 33000.00, 9, 'Thanh toán khi nhận hàng', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieubaohanh`
--

CREATE TABLE `phieubaohanh` (
  `id` int(11) NOT NULL,
  `phieuban_id` int(11) DEFAULT NULL,
  `nguoidung_id` int(11) DEFAULT NULL,
  `nguoixuly_id` int(11) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `trangthai_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieunhap`
--

CREATE TABLE `phieunhap` (
  `id` int(11) NOT NULL,
  `nhacungcap_id` int(11) DEFAULT NULL,
  `nguoidung_id` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `trangthai_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quyen`
--

CREATE TABLE `quyen` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `quyen`
--

INSERT INTO `quyen` (`id`, `name`) VALUES
(19, 'Sửa chủ đề'),
(27, 'Sửa chức vụ'),
(39, 'Sửa khuyến mãi'),
(35, 'Sửa nhà cung cấp'),
(31, 'Sửa phiếu nhập'),
(7, 'Sửa sản phẩm'),
(15, 'Sửa thể loại'),
(3, 'Sửa trang chủ'),
(23, 'Sửa tài khoản'),
(11, 'Sửa đơn hàng'),
(18, 'Thêm chủ đề'),
(26, 'Thêm chức vụ'),
(38, 'Thêm khuyến mãi'),
(34, 'Thêm nhà cung cấp'),
(30, 'Thêm phiếu nhập'),
(6, 'Thêm sản phẩm'),
(14, 'Thêm thể loại'),
(2, 'Thêm trang chủ'),
(22, 'Thêm tài khoản'),
(10, 'Thêm đơn hàng'),
(17, 'Xem chủ đề'),
(25, 'Xem chức vụ'),
(37, 'Xem khuyến mãi'),
(33, 'Xem nhà cung cấp'),
(29, 'Xem phiếu nhập'),
(5, 'Xem sản phẩm'),
(13, 'Xem thể loại'),
(1, 'Xem trang chủ'),
(21, 'Xem tài khoản'),
(9, 'Xem đơn hàng'),
(20, 'Xóa chủ đề'),
(28, 'Xóa chức vụ'),
(40, 'Xóa khuyến mãi'),
(36, 'Xóa nhà cung cấp'),
(32, 'Xóa phiếu nhập'),
(8, 'Xóa sản phẩm'),
(16, 'Xóa thể loại'),
(4, 'Xóa trang chủ'),
(24, 'Xóa tài khoản'),
(12, 'Xóa đơn hàng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `chude_id` int(11) DEFAULT NULL,
  `trangthai_id` int(11) DEFAULT NULL,
  `warranty_days` int(11) NOT NULL DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`id`, `name`, `description`, `selling_price`, `stock_quantity`, `chude_id`, `trangthai_id`, `warranty_days`, `image_url`, `updated_at`) VALUES
(1, 'Naruto - 01', 'Minifigure nhân vật Naruto.', 33000.00, 76, 1, 4, 0, './assets/img/lego-minifigure/mini-01.png', '2025-02-13 23:42:49'),
(2, 'Naruto - 02', 'Minifigure Naruto trong trạng thái chiến đấu.', 27500.00, 93, 1, 4, 0, './assets/img/lego-minifigure/mini-02.png', '2025-02-13 23:42:49'),
(3, 'Minato - 03', 'Minifigure Minato, cha của Naruto.', 32450.00, 93, 1, 4, 0, './assets/img/lego-minifigure/mini-03.png', '2025-02-13 23:42:49'),
(4, 'Sasuke - 04', 'Minifigure Sasuke, bạn thân của Naruto.', 25850.00, 96, 1, 4, 0, './assets/img/lego-minifigure/mini-04.png', '2025-02-13 23:42:49'),
(5, 'Boruto - 05', 'Minifigure Boruto, con trai của Naruto.', 28050.00, 99, 1, 4, 0, './assets/img/lego-minifigure/mini-05.png', '2025-02-13 23:42:49'),
(6, 'Itachi - 06', 'Minifigure Itachi, anh trai của Sasuke.', 32890.00, 94, 1, 4, 0, './assets/img/lego-minifigure/mini-06.png', '2025-02-13 23:42:49'),
(7, 'Obito - 07', 'Minifigure Obito, một nhân vật quan trọng.', 34100.00, 88, 1, 4, 0, './assets/img/lego-minifigure/mini-07.png', '2025-02-13 23:42:49'),
(8, 'Kakashi - 08', 'Minifigure Kakashi, thầy của Naruto.', 23100.00, 89, 1, 4, 0, './assets/img/lego-minifigure/mini-08.png', '2025-02-13 23:42:49'),
(9, 'Sasori - 09', 'Minifigure Sasori, một nhân vật phản diện.', 19800.00, 100, 1, 4, 0, './assets/img/lego-minifigure/mini-09.png', '2025-02-13 23:42:49'),
(10, 'Sasuke - 10', 'Minifigure Sasuke trong dạng mạnh mẽ.', 17600.00, 100, 1, 4, 0, './assets/img/lego-minifigure/mini-10.png', '2025-02-13 23:42:49'),
(11, 'Naruto - 11', 'Minifigure Naruto trong bộ đồ ninja.', 16500.00, 100, 1, 4, 0, './assets/img/lego-minifigure/mini-11.png', '2025-02-13 23:42:49'),
(12, 'Naruto - 12', 'Minifigure Naruto với biểu cảm quyết tâm.', 22000.00, 100, 1, 4, 0, './assets/img/lego-minifigure/mini-12.png', '2025-02-13 23:42:49'),
(13, 'Jiraiya - 13', 'Minifigure Jiraiya, thầy của Naruto.', 20900.00, 100, 1, 4, 0, './assets/img/lego-minifigure/mini-13.png', '2025-02-13 23:42:49'),
(14, 'Sarada - 14', 'Minifigure Sarada, con gái của Sasuke.', 33000.00, 100, 1, 4, 0, './assets/img/lego-minifigure/mini-14.png', '2025-02-13 23:42:49'),
(15, 'Naruto - 15', 'Minifigure Naruto trong trang phục chiến đấu.', 28600.00, 100, 1, 4, 0, './assets/img/lego-minifigure/mini-15.png', '2025-02-13 23:42:49'),
(16, 'Naruto - 16', 'Minifigure Naruto với phong cách độc đáo.', 25300.00, 100, 1, 4, 0, './assets/img/lego-minifigure/mini-16.png', '2025-02-13 23:42:49'),
(17, 'Awp Asiimov', 'Mô hình súng Awp Asiimov.', 2088900.00, 100, 5, 4, 7, './assets/img/lego-moc/moc-01.jpg', '2025-02-13 23:42:49'),
(18, 'HK G28', 'Mô hình súng HK G28.', 1868900.00, 100, 5, 4, 7, './assets/img/lego-moc/moc-02.png', '2025-02-13 23:42:49'),
(19, 'Scar-L Asiimov', 'Mô hình súng Scar-L Asiimov.', 1867800.00, 100, 5, 4, 7, './assets/img/lego-moc/moc-03.png', '2025-02-13 23:42:49'),
(20, 'Sniper XPR-50', 'Mô hình súng Sniper XPR-50.', 1857900.00, 100, 5, 4, 7, './assets/img/lego-moc/moc-04.png', '2025-02-13 23:42:49'),
(21, 'M4A1-S', 'Mô hình súng M4A1-S.', 1538900.00, 100, 5, 4, 7, './assets/img/lego-moc/moc-05.png', '2025-02-13 23:42:49'),
(22, 'AWM - 06', 'Mô hình súng AWM - 06.', 2198900.00, 100, 5, 4, 7, './assets/img/lego-moc/moc-06.png', '2025-02-13 23:42:49'),
(23, 'AWM - 07', 'Mô hình súng AWM - 07.', 2121900.00, 99, 5, 4, 7, './assets/img/lego-moc/moc-07.png', '2025-02-13 23:42:49'),
(24, 'AWM - 08', 'Mô hình súng AWM - 08.', 2066900.00, 99, 5, 4, 7, './assets/img/lego-moc/moc-08.png', '2025-02-13 23:42:49'),
(25, 'K-98', 'Mô hình súng K-98.', 1241900.00, 100, 5, 4, 7, './assets/img/lego-moc/moc-09.png', '2025-02-13 23:42:49'),
(26, 'AWm - 10', 'Mô hình súng AWm - 10.', 2181300.00, 100, 5, 4, 7, './assets/img/lego-moc/moc-10.png', '2025-02-13 23:42:49'),
(27, 'M24', 'Mô hình súng M24.', 1474000.00, 100, 5, 4, 7, './assets/img/lego-moc/moc-11.png', '2025-02-13 23:42:49'),
(28, 'AWM - 12', 'Mô hình súng AWM - 12.', 2083400.00, 100, 5, 4, 7, './assets/img/lego-moc/moc-12.png', '2025-02-13 23:42:49'),
(29, 'AWM - 13', 'Mô hình súng AWM - 13.', 1870000.00, 100, 5, 4, 7, './assets/img/lego-moc/moc-14.png', '2025-02-13 23:42:49'),
(30, 'Scar', 'Mô hình súng Scar.', 1650000.00, 100, 5, 4, 7, './assets/img/lego-moc/moc-15.png', '2025-02-13 23:42:49'),
(31, 'Siêu Xe Lamborghini Sian FKP 37', 'Mô hình siêu xe Lamborghini Sian.', 13464000.00, 100, 3, 4, 7, './assets/img/lego-technic/technic-01.png', '2025-02-13 23:42:49'),
(32, 'Siêu Xe Ferrari Daytona SP3', 'Mô hình siêu xe Ferrari Daytona SP3.', 15620000.00, 100, 3, 4, 7, './assets/img/lego-technic/technic-02.png', '2025-02-13 23:42:49'),
(33, 'Xe mô tô thể thao Kawasaki Ninja H2®R', 'Mô hình xe mô tô Kawasaki Ninja H2®R.', 2182400.00, 100, 4, 4, 7, './assets/img/lego-technic/technic-03.png', '2025-02-13 23:42:49'),
(34, 'Siêu Xe Lamborghini Huracán Tecnica', 'Mô hình siêu xe Lamborghini Huracán Tecnica.', 1532300.00, 100, 3, 4, 7, './assets/img/lego-technic/technic-04.png', '2025-02-13 23:42:49'),
(35, 'Siêu Xe Lamborghini', 'Mô hình siêu xe Lamborghini.', 2189000.00, 100, 3, 4, 7, './assets/img/lego-technic/technic-05.png', '2025-02-13 23:42:49'),
(36, 'Siêu Xe Juggernaut Koenigsegg', 'Mô hình siêu xe Juggernaut Koenigsegg.', 1958000.00, 100, 3, 4, 7, './assets/img/lego-technic/technic-06.png', '2025-02-13 23:42:49'),
(37, 'Siêu Xe Lamborghini Urus ST-X', 'Mô hình siêu xe Lamborghini Urus ST-X.', 1419000.00, 100, 3, 4, 7, './assets/img/lego-technic/technic-07.png', '2025-02-13 23:42:49'),
(38, 'Siêu Xe Thể thao', 'Mô hình siêu xe thể thao.', 1911800.00, 100, 3, 4, 7, './assets/img/lego-technic/technic-08.png', '2025-02-13 23:42:49'),
(39, 'Siêu Xe Pagani màu tím', 'Mô hình siêu xe Pagani màu tím.', 2090000.00, 100, 3, 4, 7, './assets/img/lego-technic/technic-09.png', '2025-02-13 23:42:49'),
(40, 'Siêu Xe Lamborghini Aventador', 'Mô hình siêu xe Lamborghini Aventador.', 2310000.00, 100, 3, 4, 7, './assets/img/lego-technic/technic-10.png', '2025-02-13 23:42:49'),
(41, 'Siêu Xe Lamborghini', 'Mô hình siêu xe Lamborghini.', 2200000.00, 100, 3, 4, 7, './assets/img/lego-technic/technic-11.png', '2025-02-13 23:42:49'),
(42, 'Motor H2R', 'Mô hình Motor H2R.', 1595000.00, 100, 4, 4, 7, './assets/img/lego-technic/technic-12.png', '2025-02-13 23:42:49'),
(43, 'Siêu xe vượt địa hình', 'Mô hình siêu xe vượt địa hình.', 990000.00, 100, 3, 4, 7, './assets/img/lego-technic/technic-13.png', '2025-02-13 23:42:49'),
(44, 'Siêu Xe Yamaha RIM', 'Mô hình siêu xe Yamaha RIM.', 1529000.00, 100, 4, 4, 7, './assets/img/lego-technic/technic-14.png', '2025-02-13 23:42:49'),
(45, 'Siêu Xe Ducati', 'Mô hình siêu xe Ducati.', 1650000.00, 100, 4, 4, 7, './assets/img/lego-technic/technic-15.png', '2025-02-13 23:42:49'),
(46, 'Broly - 19', 'Minifigure Broly với phong cách độc đáo.', 25300.00, 100, 6, 4, 0, './assets/img/lego-minifigure/mini-19.png', '2025-02-13 23:42:49'),
(47, 'Songoku - 20', 'Minifigure Songoku với phong cách độc đáo.', 25300.00, 100, 6, 4, 0, './assets/img/lego-minifigure/mini-20.png', '2025-02-13 23:42:49'),
(48, 'Thanos - 21', 'Minifigure Thanos trong phim Marvel.', 25300.00, 100, 7, 4, 0, './assets/img/lego-minifigure/mini-21.png', '2025-02-13 23:42:49'),
(49, 'Iron Man - 22', 'Minifigure Iron Man trong phim Marvel.', 25300.00, 99, 7, 4, 0, './assets/img/lego-minifigure/mini-22.png', '2025-02-13 23:42:49'),
(50, 'Zoro - 23', 'Minifigure Zoro trong phim One Piece.', 25300.00, 19, 2, 4, 0, './assets/img/lego-minifigure/mini-23.png', '2025-02-13 23:42:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan`
--

CREATE TABLE `taikhoan` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `trangthai_id` int(11) DEFAULT NULL,
  `type_account` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `taikhoan`
--

INSERT INTO `taikhoan` (`id`, `username`, `password`, `trangthai_id`, `type_account`, `created_at`) VALUES
(1, 'huyhoang119763', '$2y$10$PgvU1Fr9JYvfLUFM7MaGfe9MTmsfR6NO9iN0mt.IP6GJp38Wnmyeq', 1, 1, '2025-02-04 03:13:53'),
(2, 'thanhdien123', '$2y$10$Wrq27ZqBJgcI7c0402mrqOfaxPb0S4XH6q3rH.3z12lZYjqz7JzY6', 1, 1, '2025-02-04 03:13:53'),
(3, 'huyhoang119762', '$2y$10$b.nugxy1ewyn/Q3BSqnqiuOuQozMEsx4EcCYDLkei52QTAc17bdfe', 1, 1, '2025-02-15 06:27:53'),
(4, 'giabao2341', '$2y$10$8BLhA4ScyOi02DElrDTtDuBY6tVnwnihD2MXfNR6OhIm.5LVGw9CO', 1, 1, '2025-04-16 11:05:34'),
(5, 'banbanban', '$2y$10$lxEZkC6Ngb1a/cFRwa7IyeFc0N87ctVmav.FPDk404TXdrkolN/Ii', 1, 1, '2025-04-16 11:17:26'),
(6, 'thienbao123', '$2y$10$QemnXSfeY9kcpr83qh9pd.a7d8hWRIXvHt5mvpQY/EYj2A3kQa1pC', 1, 1, '2025-04-16 11:18:34'),
(7, 'danghuy123', '$2y$10$qDxr2s/tVJhua7XZiaWC3OlO3P1QIAU0scijH6D60JiU2DV/6rMbu', 1, 1, '2025-04-16 11:21:22'),
(8, 'test1234', '$2y$10$fC.rJIwgUjgYIi6jvd6LD.YbNp8DpCQzyoZ8xJG2dhfqmq3cZW9SK', 1, 1, '2025-04-16 11:22:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `theloai`
--

CREATE TABLE `theloai` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `trangthai_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `theloai`
--

INSERT INTO `theloai` (`id`, `name`, `description`, `trangthai_id`) VALUES
(1, 'Minifigure', 'Nhân vật Lego', 1),
(2, 'Technic', 'Lego Technic', 1),
(3, 'Architecture', 'Lego chủ đề kiến trúc', 1),
(4, 'Classic', 'Lego chủ đề cổ điển', 1),
(5, 'Moc', 'Lego được sáng tạo bởi những cá nhân riêng biệt', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trangthai`
--

CREATE TABLE `trangthai` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `trangthai`
--

INSERT INTO `trangthai` (`id`, `name`, `description`) VALUES
(1, 'Hoạt động', 'Trạng thái hoạt động'),
(2, 'Ngưng hoạt động', 'Trạng thái hoạt động'),
(3, 'Khóa', 'Tài khoản bị khóa'),
(4, 'Đang kinh doanh', 'Sản phẩm đang kinh doanh'),
(5, 'Ngừng kinh doanh', 'Sản phẩm ngừng kinh doanh'),
(6, 'Chưa xử lý', 'Đơn hàng chưa xử lý'),
(7, 'Đã xử lý', 'Đơn hàng đã xử lý'),
(8, 'Đang giao', 'Đơn hàng đang được giao'),
(9, 'Đã giao', 'Đơn hàng đã được giao'),
(10, 'Đã hủy', 'Đơn hàng đã được hủy'),
(11, 'Chưa xử lý bảo hành', 'Yêu cầu bảo hành chưa được xử lý'),
(12, 'Đã xử lý bảo hành', 'Yêu cầu bảo hành đã được xử lý');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitietphanquyen`
--
ALTER TABLE `chitietphanquyen`
  ADD PRIMARY KEY (`chucvu_id`,`quyen_id`),
  ADD KEY `quyen_id` (`quyen_id`);

--
-- Chỉ mục cho bảng `chitietphieuban`
--
ALTER TABLE `chitietphieuban`
  ADD PRIMARY KEY (`phieuban_id`,`sanpham_id`),
  ADD KEY `sanpham_id` (`sanpham_id`);

--
-- Chỉ mục cho bảng `chitietphieubaohanh`
--
ALTER TABLE `chitietphieubaohanh`
  ADD PRIMARY KEY (`phieubaohanh_id`,`sanpham_id`),
  ADD KEY `sanpham_id` (`sanpham_id`);

--
-- Chỉ mục cho bảng `chitietphieunhap`
--
ALTER TABLE `chitietphieunhap`
  ADD PRIMARY KEY (`phieunhap_id`,`sanpham_id`),
  ADD KEY `sanpham_id` (`sanpham_id`);

--
-- Chỉ mục cho bảng `chucvu`
--
ALTER TABLE `chucvu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Chỉ mục cho bảng `chude`
--
ALTER TABLE `chude`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `trangthai_id` (`trangthai_id`),
  ADD KEY `theloai_id` (`theloai_id`);

--
-- Chỉ mục cho bảng `diachi`
--
ALTER TABLE `diachi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoidung_id` (`nguoidung_id`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`nguoidung_id`,`sanpham_id`),
  ADD KEY `sanpham_id` (`sanpham_id`);

--
-- Chỉ mục cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `taikhoan_id` (`taikhoan_id`),
  ADD KEY `chucvu_id` (`chucvu_id`);

--
-- Chỉ mục cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `trangthai_id` (`trangthai_id`);

--
-- Chỉ mục cho bảng `phieuban`
--
ALTER TABLE `phieuban`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoidung_id` (`nguoidung_id`),
  ADD KEY `trangthai_id` (`trangthai_id`),
  ADD KEY `khuyenmai_id` (`khuyenmai_id`);

--
-- Chỉ mục cho bảng `phieubaohanh`
--
ALTER TABLE `phieubaohanh`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phieuban_id` (`phieuban_id`),
  ADD KEY `nguoidung_id` (`nguoidung_id`),
  ADD KEY `nguoixuly_id` (`nguoixuly_id`),
  ADD KEY `trangthai_id` (`trangthai_id`);

--
-- Chỉ mục cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nhacungcap_id` (`nhacungcap_id`),
  ADD KEY `nguoidung_id` (`nguoidung_id`),
  ADD KEY `trangthai_id` (`trangthai_id`);

--
-- Chỉ mục cho bảng `quyen`
--
ALTER TABLE `quyen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chude_id` (`chude_id`),
  ADD KEY `trangthai_id` (`trangthai_id`);

--
-- Chỉ mục cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `trangthai_id` (`trangthai_id`);

--
-- Chỉ mục cho bảng `theloai`
--
ALTER TABLE `theloai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `trangthai_id` (`trangthai_id`);

--
-- Chỉ mục cho bảng `trangthai`
--
ALTER TABLE `trangthai`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chucvu`
--
ALTER TABLE `chucvu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `chude`
--
ALTER TABLE `chude`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `diachi`
--
ALTER TABLE `diachi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `phieuban`
--
ALTER TABLE `phieuban`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `phieubaohanh`
--
ALTER TABLE `phieubaohanh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `quyen`
--
ALTER TABLE `quyen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `theloai`
--
ALTER TABLE `theloai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `trangthai`
--
ALTER TABLE `trangthai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitietphanquyen`
--
ALTER TABLE `chitietphanquyen`
  ADD CONSTRAINT `chitietphanquyen_ibfk_1` FOREIGN KEY (`chucvu_id`) REFERENCES `chucvu` (`id`),
  ADD CONSTRAINT `chitietphanquyen_ibfk_2` FOREIGN KEY (`quyen_id`) REFERENCES `quyen` (`id`);

--
-- Các ràng buộc cho bảng `chitietphieuban`
--
ALTER TABLE `chitietphieuban`
  ADD CONSTRAINT `chitietphieuban_ibfk_1` FOREIGN KEY (`phieuban_id`) REFERENCES `phieuban` (`id`),
  ADD CONSTRAINT `chitietphieuban_ibfk_2` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`);

--
-- Các ràng buộc cho bảng `chitietphieubaohanh`
--
ALTER TABLE `chitietphieubaohanh`
  ADD CONSTRAINT `chitietphieubaohanh_ibfk_1` FOREIGN KEY (`phieubaohanh_id`) REFERENCES `phieubaohanh` (`id`),
  ADD CONSTRAINT `chitietphieubaohanh_ibfk_2` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`);

--
-- Các ràng buộc cho bảng `chitietphieunhap`
--
ALTER TABLE `chitietphieunhap`
  ADD CONSTRAINT `chitietphieunhap_ibfk_1` FOREIGN KEY (`phieunhap_id`) REFERENCES `phieunhap` (`id`),
  ADD CONSTRAINT `chitietphieunhap_ibfk_2` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`);

--
-- Các ràng buộc cho bảng `chude`
--
ALTER TABLE `chude`
  ADD CONSTRAINT `chude_ibfk_1` FOREIGN KEY (`trangthai_id`) REFERENCES `trangthai` (`id`),
  ADD CONSTRAINT `chude_ibfk_2` FOREIGN KEY (`theloai_id`) REFERENCES `theloai` (`id`);

--
-- Các ràng buộc cho bảng `diachi`
--
ALTER TABLE `diachi`
  ADD CONSTRAINT `diachi_ibfk_1` FOREIGN KEY (`nguoidung_id`) REFERENCES `nguoidung` (`id`);

--
-- Các ràng buộc cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`nguoidung_id`) REFERENCES `nguoidung` (`id`),
  ADD CONSTRAINT `giohang_ibfk_2` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`);

--
-- Các ràng buộc cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD CONSTRAINT `nguoidung_ibfk_1` FOREIGN KEY (`taikhoan_id`) REFERENCES `taikhoan` (`id`),
  ADD CONSTRAINT `nguoidung_ibfk_2` FOREIGN KEY (`chucvu_id`) REFERENCES `chucvu` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD CONSTRAINT `nhacungcap_ibfk_1` FOREIGN KEY (`trangthai_id`) REFERENCES `trangthai` (`id`);

--
-- Các ràng buộc cho bảng `phieuban`
--
ALTER TABLE `phieuban`
  ADD CONSTRAINT `phieuban_ibfk_1` FOREIGN KEY (`nguoidung_id`) REFERENCES `nguoidung` (`id`),
  ADD CONSTRAINT `phieuban_ibfk_2` FOREIGN KEY (`trangthai_id`) REFERENCES `trangthai` (`id`),
  ADD CONSTRAINT `phieuban_ibfk_3` FOREIGN KEY (`khuyenmai_id`) REFERENCES `khuyenmai` (`id`);

--
-- Các ràng buộc cho bảng `phieubaohanh`
--
ALTER TABLE `phieubaohanh`
  ADD CONSTRAINT `phieubaohanh_ibfk_1` FOREIGN KEY (`nguoidung_id`) REFERENCES `nguoidung` (`id`),
  ADD CONSTRAINT `phieubaohanh_ibfk_2` FOREIGN KEY (`nguoixuly_id`) REFERENCES `nguoidung` (`id`),
  ADD CONSTRAINT `phieubaohanh_ibfk_3` FOREIGN KEY (`phieuban_id`) REFERENCES `phieuban` (`id`),
  ADD CONSTRAINT `phieubaohanh_ibfk_4` FOREIGN KEY (`trangthai_id`) REFERENCES `trangthai` (`id`);

--
-- Các ràng buộc cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD CONSTRAINT `phieunhap_ibfk_1` FOREIGN KEY (`nhacungcap_id`) REFERENCES `nhacungcap` (`id`),
  ADD CONSTRAINT `phieunhap_ibfk_2` FOREIGN KEY (`nguoidung_id`) REFERENCES `nguoidung` (`id`),
  ADD CONSTRAINT `phieunhap_ibfk_3` FOREIGN KEY (`trangthai_id`) REFERENCES `trangthai` (`id`);

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`chude_id`) REFERENCES `chude` (`id`),
  ADD CONSTRAINT `sanpham_ibfk_2` FOREIGN KEY (`trangthai_id`) REFERENCES `trangthai` (`id`);

--
-- Các ràng buộc cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD CONSTRAINT `taikhoan_ibfk_1` FOREIGN KEY (`trangthai_id`) REFERENCES `trangthai` (`id`);

--
-- Các ràng buộc cho bảng `theloai`
--
ALTER TABLE `theloai`
  ADD CONSTRAINT `theloai_ibfk_1` FOREIGN KEY (`trangthai_id`) REFERENCES `trangthai` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
