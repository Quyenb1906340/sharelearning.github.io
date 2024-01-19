-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2023 at 07:25 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `luanvan`
--

-- --------------------------------------------------------

--
-- Table structure for table `bai_viet`
--

CREATE TABLE `bai_viet` (
  `bv_ma` int(11) NOT NULL,
  `dm_ma` int(11) NOT NULL,
  `nd_username` varchar(50) NOT NULL,
  `bv_tieude` varchar(100) NOT NULL,
  `bv_noidung` text NOT NULL,
  `bv_ngaydang` datetime NOT NULL DEFAULT current_timestamp(),
  `bv_luotxem` int(11) DEFAULT 0,
  `bv_diemtrungbinh` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `bai_viet`
--

INSERT INTO `bai_viet` (`bv_ma`, `dm_ma`, `nd_username`, `bv_tieude`, `bv_noidung`, `bv_ngaydang`, `bv_luotxem`, `bv_diemtrungbinh`) VALUES
(153, 45, 'admin', 'Những câu lệnh cơ bản trong MongoDB', '<p><strong>1.Tạo database trong MongoDB</strong></p><p>use DatabaseName\r\n</p><p>Trong đó DatabaseName là tên của database các bạn muốn tạo. vd: Tạo database có tên là projectdemo.</p><p>use projectdemo\r\n</p><p><strong>2.Xem database đang sử dụng</strong></p><p>Để xem database đang sử dụng(current database) thì chúng ta sử dụng lệnh:</p><p>db\r\n</p><p><strong>3.Xem tất cả các database trong hệ thống</strong></p><p>Để xe tất cả các database đã được tạo trên MongoDB thì mọi người sử dụng lệnh sau:</p><p>show dbs\r\n</p><p>Chú ý: Lệnh này sẽ chỉ hiện ra các database đã có ít nhất một collection(hiểu như table trong MySql), còn nếu chưa có thì nó sẽ không hiện ra.</p>', '2023-12-03 23:06:40', 1, 0),
(154, 45, 'admin', 'Truy vấn dữ liệu trong MongoDB', '<p><strong>1, Lấy tất cả dữ liệu trong Collection.</strong></p><p>-Để lấy tất cả dữ liệu ở trong collection chúng ta sử dụng phương thức find() với cú pháp:</p><p><strong>bash</strong></p><p><i>copy</i></p><p>db.collectionName.find()</p><p><strong>Trong đó</strong>: collectionName là tên của collection mà các bạn muốn truy vấn.</p><p>-Tuy nhiên, khi chỉ sử dụng mỗi phương thức find thì dữ liệu trả về sẽ dưới dạng object nhưng không theo một cấu trúc nào cả.</p><p><strong>VD</strong>: Lấy tất cả dữ liệu đang có trong Collection admin.</p>', '2023-12-03 23:10:06', 1, 0),
(155, 56, 'admin', 'Giá trị thời gian của tiền là gì?', '<p style=\"margin-left:0px;text-align:justify;\">Giá trị thời gian của tiền trong tiếng Anh được gọi là <span style=\"color:rgb(0,0,128);\"><i>Time value of Money</i></span>. Đây là thuật ngữ nói về khoản tiền đang có ở thời điểm hiện tại sẽ có giá trị cao hơn khoản tiền tương tự trong tương lai vì mức sinh lãi của nó. Giá trị thời gian của tiền đôi khi cũng được hiểu là giá trị chiết khấu của nó ở thời điểm hiện tại.&nbsp;&nbsp;</p><p style=\"margin-left:0px;text-align:justify;\">Giải thích dễ hiểu trên góc độ tài chính, tiền tệ liên tục vận động và sinh ra lợi nhuận. Nếu bạn có 1 triệu để đầu tư hoặc cho vay với lãi suất 9% ngày hôm nay, thì sau một năm bạn sẽ nhận được 1,09 triệu. Vậy nghĩa là 1 triệu đồng hôm nay có giá trị tương đương với 1,09 triệu sau một năm.</p><p style=\"margin-left:0px;text-align:justify;\">Mặt khác, tiền, thời gian và rủi ro có mối liên quan chặt chẽ với nhau. Mối quan hệ này được thể hiện thông qua lãi suất. Do đó, tiền tệ nhận được vào các thời điểm cũng khác nhau. Điều này cũng có nghĩa là chúng ta luôn cần phải xem xét đến giá trị thời gian của tiền để đánh giá các quyết định đầu tư và quyết định tài chính.</p>', '2023-12-03 23:17:23', 1, 0),
(156, 50, 'admin', 'Vai trò của hoạt động xét xử của tòa án trong quá trình phát triển hệ thống pháp luật Việt Nam', '<p><strong>1. Đặc điểm của hoạt động xét xử của Tòa án</strong></p><p>Hoạt động xét xử của Tòa án là hình thức áp dụng pháp luật quan trọng. Tính chất “áp dụng pháp luật” của hoạt động xét xử được biểu hiện ở những điểm sau đây:</p><p><i>a/ Hoạt động xét xử là hoạt động quyền lực</i></p><p>Xét xử là hoạt động phán quyết của cơ quan thay mặt Nhà nước nhằm khôi phục trật tự nếu nó bị xâm phạm, hoặc nhằm bảo vệ lợi ích hợp pháp và chính đáng của công dân, của tập thể, của quốc gia và xã hội. Vì vậy, đây là <i>một hoạt động quyền lực nhà nước</i> đặc thù, nó không đơn thuần chỉ là dàn xếp, hòa giải, mặc dù về thực chất, dàn xếp và hòa giải cũng có mục đích như vậy và do đó, có mối liên quan khăng khít với hoạt động xét xử.</p>', '2023-12-04 01:01:06', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `binh_luan`
--

CREATE TABLE `binh_luan` (
  `bl_ma` int(11) NOT NULL,
  `bv_ma` int(11) NOT NULL,
  `nd_username` varchar(50) NOT NULL,
  `bl_noidung` text NOT NULL,
  `trangthai` int(11) NOT NULL DEFAULT 1,
  `bl_thoigian` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `co_quyen`
--

CREATE TABLE `co_quyen` (
  `vt_ma` int(11) NOT NULL,
  `q_ma` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danhmuc_phancap`
--

CREATE TABLE `danhmuc_phancap` (
  `dm_cha` int(11) NOT NULL,
  `dm_con` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `danhmuc_phancap`
--

INSERT INTO `danhmuc_phancap` (`dm_cha`, `dm_con`) VALUES
(59, 60),
(59, 61);

-- --------------------------------------------------------

--
-- Table structure for table `danh_gia`
--

CREATE TABLE `danh_gia` (
  `dg_ma` int(11) NOT NULL,
  `bv_ma` int(11) NOT NULL,
  `nd_username` varchar(50) NOT NULL,
  `dg_diem` int(11) NOT NULL,
  `dg_thoigian` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danh_muc`
--

CREATE TABLE `danh_muc` (
  `dm_ma` int(11) NOT NULL,
  `mh_ma` int(11) NOT NULL,
  `dm_ten` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `danh_muc`
--

INSERT INTO `danh_muc` (`dm_ma`, `mh_ma`, `dm_ten`) VALUES
(45, 4, 'CSDL tài liệu MongoDB'),
(46, 4, 'CSDL đồ thị Neo4j'),
(47, 30, 'Giải quyết tranh chấp về môi trường'),
(48, 30, 'Xử lý vi phạm pháp luật về môi trường'),
(49, 29, 'Truy cứu trách nhiệm hành chính'),
(50, 29, 'Hoạt động xét xử của tòa án'),
(51, 33, 'Sinh lý bệnh quá trình viêm'),
(52, 31, 'Các loại thức ăn gia súc'),
(53, 31, 'Dự trữ và chế biến thức ăn gia súc'),
(54, 35, 'Chiến lược quản trị quan hệ khách hàng'),
(55, 35, 'Các cấp độ quản trị quan hệ khách hàng'),
(56, 34, 'Giá trị thời gian của tiền tệ'),
(57, 34, 'Định giá chứng khoán '),
(58, 20, 'Quy trình quản lý sản xuất'),
(59, 20, 'Quy trình giám sát nguồn gốc sản phẩm'),
(60, 20, 'Module quản lý sản phẩm'),
(61, 20, ' Module quản lý tiến độ sản xuất'),
(62, 23, 'Kích thích sinh sản cá bố mẹ '),
(63, 23, 'Quản lý phát triển phôi'),
(64, 24, 'Tập tính lãnh thổ'),
(65, 24, 'Tập tính di cư'),
(66, 27, 'Sự vận chuyển xa ở mạch gỗ và mạch libe'),
(67, 27, 'Dưỡng chất khoáng vi lượng');

-- --------------------------------------------------------

--
-- Table structure for table `khoi_lop`
--

CREATE TABLE `khoi_lop` (
  `kl_ma` int(11) NOT NULL,
  `kl_ten` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `khoi_lop`
--

INSERT INTO `khoi_lop` (`kl_ma`, `kl_ten`) VALUES
(1, 'Công nghệ thông tin'),
(2, 'Hệ thống thông tin'),
(3, 'Kỹ thuật phần mềm'),
(4, 'Kinh tế'),
(5, 'Quản trị kinh doanh'),
(6, 'Luật kinh tế'),
(7, 'Thú y'),
(8, 'Bảo vệ thực vật'),
(9, 'Quản lý đất đai'),
(10, 'Nuôi trồng thủy sản');

-- --------------------------------------------------------

--
-- Table structure for table `kiem_duyet`
--

CREATE TABLE `kiem_duyet` (
  `bv_ma` int(11) NOT NULL,
  `nd_username` varchar(50) NOT NULL,
  `tt_ma` int(11) NOT NULL,
  `thoigian` datetime NOT NULL DEFAULT current_timestamp(),
  `ghi_chu` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `kiem_duyet`
--

INSERT INTO `kiem_duyet` (`bv_ma`, `nd_username`, `tt_ma`, `thoigian`, `ghi_chu`) VALUES
(153, 'admin', 1, '2023-12-03 23:07:01', NULL),
(154, 'admin', 1, '2023-12-03 23:10:24', NULL),
(155, 'admin', 1, '2023-12-03 23:17:39', NULL),
(156, 'admin', 1, '2023-12-04 01:01:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lich_su_xem`
--

CREATE TABLE `lich_su_xem` (
  `nd_username` varchar(50) NOT NULL,
  `bv_ma` int(11) DEFAULT NULL,
  `bl_ma` int(11) DEFAULT NULL,
  `ls_thoigian` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `lich_su_xem`
--

INSERT INTO `lich_su_xem` (`nd_username`, `bv_ma`, `bl_ma`, `ls_thoigian`) VALUES
('admin', 153, NULL, '2023-12-03 23:07:10'),
('admin', 154, NULL, '2023-12-03 23:11:20'),
('admin', 155, NULL, '2023-12-03 23:17:56');

-- --------------------------------------------------------

--
-- Table structure for table `mon_hoc`
--

CREATE TABLE `mon_hoc` (
  `mh_ma` int(11) NOT NULL,
  `mh_ten` varchar(50) NOT NULL,
  `kl_ma` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `mon_hoc`
--

INSERT INTO `mon_hoc` (`mh_ma`, `mh_ten`, `kl_ma`) VALUES
(3, 'Xử lý ngôn ngữ tự nhiên', 1),
(4, 'Cơ sở dữ liệu NoSQL', 2),
(19, 'Kho dữ liệu và OLAP', 2),
(20, 'Hệ thống quản lý sản xuất', 2),
(21, 'Kiến trúc và Thiết kế phần mềm', 3),
(22, 'Bảo trì phần mềm', 3),
(23, 'Kỹ thuật sản xuất giống cá nước ngọt', 10),
(24, 'Tập tính động vật thủy sản', 10),
(25, 'Đo đạc địa chính', 9),
(26, 'Quy hoạch tổng thể kinh tế - xã hội', 9),
(27, 'Dinh dưỡng cây trồng', 8),
(28, 'Bệnh cây đại cương', 8),
(29, 'Luật hành chính', 6),
(30, 'Luật môi trường', 6),
(31, 'Thức ăn gia súc', 7),
(33, 'Sinh lý bệnh Thú y', 7),
(34, 'Quản trị tài chính', 5),
(35, 'Quản trị quan hệ khách hàng', 5),
(36, 'Kinh tế tài nguyên', 4),
(37, 'Kinh tế sản xuất', 4);

-- --------------------------------------------------------

--
-- Table structure for table `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `nd_username` varchar(50) NOT NULL,
  `vt_ma` int(11) NOT NULL,
  `nd_hoten` varchar(50) NOT NULL,
  `nd_gioitinh` tinyint(1) NOT NULL,
  `nd_email` varchar(100) NOT NULL,
  `nd_sdt` varchar(10) NOT NULL,
  `nd_matkhau` varchar(200) NOT NULL,
  `nd_diachi` varchar(100) NOT NULL,
  `nd_ngaysinh` date NOT NULL,
  `nd_hinh` text NOT NULL,
  `nd_ngaytao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`nd_username`, `vt_ma`, `nd_hoten`, `nd_gioitinh`, `nd_email`, `nd_sdt`, `nd_matkhau`, `nd_diachi`, `nd_ngaysinh`, `nd_hinh`, `nd_ngaytao`) VALUES
('AD01', 2, 'Lê Xuân', 0, '', '', '$2y$10$96U2ohw38iz1FdtBgTNgSOiHNKHvLaD7.UKO5cwUGVT2Y4fUiS6CG', '', '0000-00-00', 'unnamed.png', '2023-09-20 18:01:41'),
('AD02', 2, 'Trần Thị Trúc Quyên', 0, '', '', '$2y$10$07i2kBTwKCFtUC9xnxRsrefx937Ww3f/cve9U8f.wB2y6rBWdq7Ze', '', '0000-00-00', 'unnamed.png', '2023-11-08 01:37:35'),
('AD03', 2, 'Hoàng', 0, '', '', '$2y$10$v15ap2IS0cXht5YMjbHiVOT9Rvsi6JyNi8OwUCys0EPmvPxVvXbZG', '', '0000-00-00', 'unnamed.png', '2023-11-10 13:54:58'),
('AD04', 2, 'Tú', 0, '', '', '$2y$10$8eQNfBF4EYLBESGODJeBru9AA5rCZ5sr7U9f5XOyUi7y.b/YK1Bk.', '', '0000-00-00', 'unnamed.png', '2023-11-10 13:55:14'),
('AD05', 2, 'Liên', 0, '', '', '$2y$10$PQpmDi77SZ16BkdEd9p1meqc0O8wFovVGNgjpmp3.84jcLJ94LWqm', '', '0000-00-00', 'unnamed.png', '2023-11-10 13:55:32'),
('AD06', 2, 'Dung', 0, '', '', '$2y$10$qFTBf0kfVoRPoREtnUxBKucIudPrrHHlrjFoMry5cs93wfPAYaPx6', '', '0000-00-00', 'unnamed.png', '2023-11-10 13:55:49'),
('admin', 1, 'Quyên Trần', 0, '', '', '$2y$10$Al9koUhyGEIJFPguCHkB8.CZ7aiOnkzyzJGjCiaONAYBYWOpGAFoO', '', '0000-00-00', 'unnamed.png', '2023-09-20 19:25:55'),
('GV01', 3, 'Trần Văn Lành', 0, '', '', '$2y$10$dDNMpLBltb20e/pterv0R./vezIIDnz7Xli5lR1hZbJKVqzIWgE8O', '', '0000-00-00', 'unnamed.png', '2023-09-20 18:00:52'),
('gv010', 3, 'Khối lớp  3', 0, '', '', '$2y$10$3Gc2kIcP6Sa7u4oFNndXsezYjnqY0T9TDZpzqP8CWTZ3lFxDQ.CeW', '', '0000-00-00', 'unnamed.png', '2023-10-17 17:56:41'),
('HS01', 4, 'Nguyễn Văn Tùng', 0, '', '', '$2y$10$l6IMWGnovMlr4H4VRZOwM.HyBtwV.9tsNgfYxGYGFRymG5TXcAVVC', '', '0000-00-00', 'unnamed.png', '2023-09-20 18:01:20'),
('HS0100', 4, 'Ba Phi', 0, '', '', '$2y$10$atc/yWqGuKOb7NguBhg9DeHhqPkjZeujOZJ53GaQXkBbVXm9sCPhq', '', '0000-00-00', 'unnamed.png', '2023-10-13 17:02:55'),
('nga', 3, 'Nguyễn Thị Huỳnh Nga', 1, 'nga@gmail.com', '0123456789', '$2y$10$JihqG98MFby.KGVYajZKN.FPIAEtBajKJb10k32BMF1l.daSS9Vke', 'cần thơ', '2023-08-10', 'avt.png', '2022-12-19 23:52:06'),
('quyen', 4, 'Trần Thị Trúc Quyên', 1, 'quyen@gmail.com', '0123456987', '$2y$10$G.hPL8hFxjPudPgfz54AwOxCuD8Vd.Xf7ONEkrb/gHGZ6AlxLS2ZW', 'cần thơ', '2023-08-11', 'avt2.jpg', '2022-10-18 23:51:44');

-- --------------------------------------------------------

--
-- Table structure for table `quan_ly`
--

CREATE TABLE `quan_ly` (
  `dm_ma` int(11) NOT NULL,
  `nd_username` varchar(50) NOT NULL,
  `tg_phancong` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `quan_ly`
--

INSERT INTO `quan_ly` (`dm_ma`, `nd_username`, `tg_phancong`) VALUES
(1, 'AD01', '2023-11-10 14:22:54'),
(1, 'AD02', '2023-11-10 14:22:54'),
(14, 'AD01', '2023-11-10 14:22:54'),
(19, 'AD01', '2023-11-10 14:22:54'),
(19, 'AD02', '2023-11-10 14:22:54'),
(20, 'AD01', '2023-11-10 14:22:54'),
(20, 'AD02', '2023-11-10 14:22:54'),
(21, 'AD02', '2023-11-10 14:22:54');

-- --------------------------------------------------------

--
-- Table structure for table `quyen`
--

CREATE TABLE `quyen` (
  `q_ma` int(11) NOT NULL,
  `q_ten` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rep_bl`
--

CREATE TABLE `rep_bl` (
  `bl_cha` int(11) NOT NULL,
  `bl_con` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tai_lieu`
--

CREATE TABLE `tai_lieu` (
  `tl_ma` int(11) NOT NULL,
  `bv_ma` int(11) NOT NULL,
  `tl_tentaptin` varchar(100) NOT NULL,
  `tl_kichthuoc` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `tai_lieu`
--

INSERT INTO `tai_lieu` (`tl_ma`, `bv_ma`, `tl_tentaptin`, `tl_kichthuoc`) VALUES
(41, 154, 'MongoDB-query.pdf', 30);

-- --------------------------------------------------------

--
-- Table structure for table `trang_thai`
--

CREATE TABLE `trang_thai` (
  `tt_ma` int(11) NOT NULL,
  `tt_ten` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `trang_thai`
--

INSERT INTO `trang_thai` (`tt_ma`, `tt_ten`) VALUES
(1, 'Đã duyệt'),
(2, 'Đã bị hủy'),
(3, 'Chờ duyệt'),
(4, 'Đã bị xóa');

-- --------------------------------------------------------

--
-- Table structure for table `vai_tro`
--

CREATE TABLE `vai_tro` (
  `vt_ma` int(11) NOT NULL,
  `vt_ten` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `vai_tro`
--

INSERT INTO `vai_tro` (`vt_ma`, `vt_ten`) VALUES
(1, 'Super Admin'),
(2, 'Admin'),
(3, 'Giáo Viên'),
(4, 'Học Sinh');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bai_viet`
--
ALTER TABLE `bai_viet`
  ADD PRIMARY KEY (`bv_ma`),
  ADD KEY `dm_ma` (`dm_ma`),
  ADD KEY `nd_username` (`nd_username`);

--
-- Indexes for table `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD PRIMARY KEY (`bl_ma`),
  ADD KEY `nd_username` (`nd_username`),
  ADD KEY `bv_ma` (`bv_ma`),
  ADD KEY `trangthai` (`trangthai`);

--
-- Indexes for table `co_quyen`
--
ALTER TABLE `co_quyen`
  ADD PRIMARY KEY (`vt_ma`,`q_ma`),
  ADD KEY `q_ma` (`q_ma`);

--
-- Indexes for table `danhmuc_phancap`
--
ALTER TABLE `danhmuc_phancap`
  ADD PRIMARY KEY (`dm_cha`,`dm_con`),
  ADD KEY `dm_con` (`dm_con`);

--
-- Indexes for table `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD PRIMARY KEY (`dg_ma`),
  ADD KEY `bv_ma` (`bv_ma`),
  ADD KEY `nd_username` (`nd_username`);

--
-- Indexes for table `danh_muc`
--
ALTER TABLE `danh_muc`
  ADD PRIMARY KEY (`dm_ma`),
  ADD KEY `mh_ma` (`mh_ma`);

--
-- Indexes for table `khoi_lop`
--
ALTER TABLE `khoi_lop`
  ADD PRIMARY KEY (`kl_ma`);

--
-- Indexes for table `kiem_duyet`
--
ALTER TABLE `kiem_duyet`
  ADD PRIMARY KEY (`bv_ma`,`nd_username`,`tt_ma`),
  ADD KEY `nd_username` (`nd_username`),
  ADD KEY `tt_ma` (`tt_ma`);

--
-- Indexes for table `lich_su_xem`
--
ALTER TABLE `lich_su_xem`
  ADD KEY `bl_ma` (`bl_ma`),
  ADD KEY `bv_ma` (`bv_ma`),
  ADD KEY `nd_username` (`nd_username`);

--
-- Indexes for table `mon_hoc`
--
ALTER TABLE `mon_hoc`
  ADD PRIMARY KEY (`mh_ma`),
  ADD KEY `kl_ma` (`kl_ma`);

--
-- Indexes for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`nd_username`),
  ADD KEY `vt_ma` (`vt_ma`);

--
-- Indexes for table `quan_ly`
--
ALTER TABLE `quan_ly`
  ADD PRIMARY KEY (`dm_ma`,`nd_username`),
  ADD KEY `nd_username` (`nd_username`);

--
-- Indexes for table `quyen`
--
ALTER TABLE `quyen`
  ADD PRIMARY KEY (`q_ma`);

--
-- Indexes for table `rep_bl`
--
ALTER TABLE `rep_bl`
  ADD PRIMARY KEY (`bl_cha`,`bl_con`),
  ADD KEY `bl_con` (`bl_con`);

--
-- Indexes for table `tai_lieu`
--
ALTER TABLE `tai_lieu`
  ADD PRIMARY KEY (`tl_ma`),
  ADD KEY `bv_ma` (`bv_ma`);

--
-- Indexes for table `trang_thai`
--
ALTER TABLE `trang_thai`
  ADD PRIMARY KEY (`tt_ma`);

--
-- Indexes for table `vai_tro`
--
ALTER TABLE `vai_tro`
  ADD PRIMARY KEY (`vt_ma`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bai_viet`
--
ALTER TABLE `bai_viet`
  MODIFY `bv_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `binh_luan`
--
ALTER TABLE `binh_luan`
  MODIFY `bl_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `danh_gia`
--
ALTER TABLE `danh_gia`
  MODIFY `dg_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `danh_muc`
--
ALTER TABLE `danh_muc`
  MODIFY `dm_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `khoi_lop`
--
ALTER TABLE `khoi_lop`
  MODIFY `kl_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `mon_hoc`
--
ALTER TABLE `mon_hoc`
  MODIFY `mh_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `quyen`
--
ALTER TABLE `quyen`
  MODIFY `q_ma` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tai_lieu`
--
ALTER TABLE `tai_lieu`
  MODIFY `tl_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `trang_thai`
--
ALTER TABLE `trang_thai`
  MODIFY `tt_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vai_tro`
--
ALTER TABLE `vai_tro`
  MODIFY `vt_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bai_viet`
--
ALTER TABLE `bai_viet`
  ADD CONSTRAINT `bai_viet_ibfk_1` FOREIGN KEY (`dm_ma`) REFERENCES `danh_muc` (`dm_ma`),
  ADD CONSTRAINT `bai_viet_ibfk_2` FOREIGN KEY (`nd_username`) REFERENCES `nguoi_dung` (`nd_username`);

--
-- Constraints for table `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD CONSTRAINT `binh_luan_ibfk_1` FOREIGN KEY (`bv_ma`) REFERENCES `bai_viet` (`bv_ma`),
  ADD CONSTRAINT `binh_luan_ibfk_2` FOREIGN KEY (`nd_username`) REFERENCES `nguoi_dung` (`nd_username`),
  ADD CONSTRAINT `binh_luan_ibfk_3` FOREIGN KEY (`trangthai`) REFERENCES `trang_thai` (`tt_ma`);

--
-- Constraints for table `co_quyen`
--
ALTER TABLE `co_quyen`
  ADD CONSTRAINT `co_quyen_ibfk_1` FOREIGN KEY (`q_ma`) REFERENCES `quyen` (`q_ma`),
  ADD CONSTRAINT `co_quyen_ibfk_2` FOREIGN KEY (`vt_ma`) REFERENCES `vai_tro` (`vt_ma`);

--
-- Constraints for table `danhmuc_phancap`
--
ALTER TABLE `danhmuc_phancap`
  ADD CONSTRAINT `danhmuc_phancap_ibfk_1` FOREIGN KEY (`dm_cha`) REFERENCES `danh_muc` (`dm_ma`),
  ADD CONSTRAINT `danhmuc_phancap_ibfk_2` FOREIGN KEY (`dm_con`) REFERENCES `danh_muc` (`dm_ma`),
  ADD CONSTRAINT `danhmuc_phancap_ibfk_3` FOREIGN KEY (`dm_cha`) REFERENCES `danh_muc` (`dm_ma`);

--
-- Constraints for table `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD CONSTRAINT `danh_gia_ibfk_1` FOREIGN KEY (`bv_ma`) REFERENCES `bai_viet` (`bv_ma`),
  ADD CONSTRAINT `danh_gia_ibfk_2` FOREIGN KEY (`nd_username`) REFERENCES `nguoi_dung` (`nd_username`);

--
-- Constraints for table `danh_muc`
--
ALTER TABLE `danh_muc`
  ADD CONSTRAINT `danh_muc_ibfk_1` FOREIGN KEY (`mh_ma`) REFERENCES `mon_hoc` (`mh_ma`);

--
-- Constraints for table `kiem_duyet`
--
ALTER TABLE `kiem_duyet`
  ADD CONSTRAINT `kiem_duyet_ibfk_1` FOREIGN KEY (`nd_username`) REFERENCES `nguoi_dung` (`nd_username`),
  ADD CONSTRAINT `kiem_duyet_ibfk_2` FOREIGN KEY (`bv_ma`) REFERENCES `bai_viet` (`bv_ma`),
  ADD CONSTRAINT `kiem_duyet_ibfk_3` FOREIGN KEY (`tt_ma`) REFERENCES `trang_thai` (`tt_ma`);

--
-- Constraints for table `lich_su_xem`
--
ALTER TABLE `lich_su_xem`
  ADD CONSTRAINT `lich_su_xem_ibfk_1` FOREIGN KEY (`bl_ma`) REFERENCES `binh_luan` (`bl_ma`),
  ADD CONSTRAINT `lich_su_xem_ibfk_2` FOREIGN KEY (`bv_ma`) REFERENCES `bai_viet` (`bv_ma`),
  ADD CONSTRAINT `lich_su_xem_ibfk_3` FOREIGN KEY (`nd_username`) REFERENCES `nguoi_dung` (`nd_username`);

--
-- Constraints for table `mon_hoc`
--
ALTER TABLE `mon_hoc`
  ADD CONSTRAINT `mon_hoc_ibfk_1` FOREIGN KEY (`kl_ma`) REFERENCES `khoi_lop` (`kl_ma`);

--
-- Constraints for table `rep_bl`
--
ALTER TABLE `rep_bl`
  ADD CONSTRAINT `rep_bl_ibfk_1` FOREIGN KEY (`bl_cha`) REFERENCES `binh_luan` (`bl_ma`),
  ADD CONSTRAINT `rep_bl_ibfk_2` FOREIGN KEY (`bl_con`) REFERENCES `binh_luan` (`bl_ma`);

--
-- Constraints for table `tai_lieu`
--
ALTER TABLE `tai_lieu`
  ADD CONSTRAINT `tai_lieu_ibfk_1` FOREIGN KEY (`bv_ma`) REFERENCES `bai_viet` (`bv_ma`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
