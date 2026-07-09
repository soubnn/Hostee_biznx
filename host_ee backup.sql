-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 07, 2026 at 08:36 AM
-- Server version: 10.11.10-MariaDB-log
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `host_ee`
--

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `acc_no` varchar(255) DEFAULT NULL,
  `book_no` varchar(255) DEFAULT NULL,
  `biller_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `opening_balance` varchar(255) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chiplevels`
--

CREATE TABLE `chiplevels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jobcard_id` int(11) NOT NULL,
  `servicer_name` varchar(255) NOT NULL,
  `service_date` varchar(255) NOT NULL,
  `servicer_contact` varchar(255) DEFAULT NULL,
  `staff_name` varchar(255) DEFAULT NULL,
  `chiplevel_complaint` varchar(255) DEFAULT NULL,
  `courier_delivery` varchar(255) DEFAULT NULL,
  `courier_bill` varchar(255) DEFAULT NULL,
  `service_charge` varchar(255) DEFAULT NULL,
  `return_date` varchar(255) DEFAULT NULL,
  `handover_staff` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chiplevel_servicers`
--

CREATE TABLE `chiplevel_servicers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `servicer_name` varchar(255) NOT NULL,
  `servicer_contact` varchar(255) DEFAULT NULL,
  `servicer_place` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consignments`
--

CREATE TABLE `consignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jobcard_number` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `customer_place` varchar(255) DEFAULT NULL,
  `customer_type` varchar(255) NOT NULL,
  `work_location` varchar(255) DEFAULT NULL,
  `service_type` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `warranty_type` varchar(255) DEFAULT NULL,
  `accessories` text DEFAULT NULL,
  `physical_condition` text DEFAULT NULL,
  `estimate_delivery` date DEFAULT NULL,
  `complaints` text DEFAULT NULL,
  `components` text DEFAULT NULL,
  `work_desc` varchar(999) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `advance` varchar(255) DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `image4` varchar(255) DEFAULT NULL,
  `image5` varchar(255) DEFAULT NULL,
  `complaint_details` text DEFAULT NULL,
  `estimate` varchar(255) DEFAULT NULL,
  `customer_relation` varchar(255) DEFAULT NULL,
  `gst_no` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `add_by` varchar(255) DEFAULT NULL,
  `informed_staff` varchar(255) DEFAULT NULL,
  `informed_date` datetime DEFAULT NULL,
  `approved_staff` varchar(255) DEFAULT NULL,
  `approved_date` datetime DEFAULT NULL,
  `return_staff` varchar(255) DEFAULT NULL,
  `return_date` datetime DEFAULT NULL,
  `rejected_date` datetime DEFAULT NULL,
  `rejected_staff` varchar(255) DEFAULT NULL,
  `delivered_staff` varchar(255) DEFAULT NULL,
  `delivered_date` datetime DEFAULT NULL,
  `approve_status` varchar(255) DEFAULT 'pending',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consignment_assessments`
--

CREATE TABLE `consignment_assessments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `consignment_id` varchar(255) NOT NULL,
  `staff` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` datetime DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consoulidates`
--

CREATE TABLE `consoulidates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sales_id` varchar(255) NOT NULL,
  `gst` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `subject` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `date`, `name`, `company`, `contact`, `email`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, '2026-01-20', NULL, NULL, NULL, NULL, NULL, NULL, 'unread', '2026-01-20 07:46:11', NULL),
(2, '2026-01-20', NULL, NULL, NULL, NULL, NULL, NULL, 'unread', '2026-01-20 07:46:13', NULL),
(3, '2026-03-07', 'Andrewleaky', NULL, '83981338958', 'no.reply.MortenTaylor@gmail.com', NULL, 'Howdy-ho! hosteetheplanner.in \r\n \r\nDid you know that it is possible to send business offer completely legally? \r\nWhen such messages are sent, no personal data is used, and they are securely sent to forms that have been specifically designed to receive messages and appeals. You donâ€™t need to be concerned that Contact Form messages will end up in spam, since theyâ€™re seen as important. \r\nTry out our service â€“ no cost involved! \r\nWe are able to provide up to 50,000 messages for you. \r\n \r\nThe cost of sending one million messages is $59. \r\n \r\nThis letter is automatically generated. \r\n \r\nContact us. \r\nTelegram - https://t.me/FeedbackFormEU \r\nWhatsApp - +375259112693 \r\nWhatsApp  https://wa.me/+375259112693 \r\nWe only use chat for communication.', 'unread', '2026-03-07 13:12:24', NULL),
(4, '2026-03-18', 'Leeza Bindra', NULL, '7532833829', 'leeza.rocketdigitaltech@gmail.com', NULL, 'Hello http://hosteetheplanner.in,\r\n \r\nI hope youâ€™re doing well.\r\n\r\nWe help businesses improve their online presence with professional website design that is fast, mobile-friendly, and optimized for conversions.\r\n\r\nIf you are planning a website redesign or a new project, Iâ€™d be happy to share some ideas and our pricing.\r\n \r\nWarm regards,\r\nLeeza', 'unread', '2026-03-18 14:03:12', NULL),
(5, '2026-03-19', 'Sonam Prajapati', NULL, '7532833829', 'sonam.rocketdigitaltech@gmail.com', NULL, 'Hello http://hosteetheplanner.in,\r\n \r\nI hope youâ€™re doing well. I came across your business online and thought you might be interested in improving your visibility and traffic on search engines.\r\n \r\nWe specialize in helping businesses strengthen their online presence through effective SEO strategies.\r\n \r\nOnce you share your target keywords and target market, Iâ€™ll send a full proposal.\r\n \r\nWarm regards,\r\nSonam', 'unread', '2026-03-19 07:01:54', NULL),
(6, '2026-03-20', 'Anaya ', NULL, '9266141479', 'anaya.dgtlsolution@gmail.com', NULL, 'Hello http://hosteetheplanner.in,\r\n\r\nI wanted to reach out to see if youâ€™re open to exploring ways to grow your website traffic and boost online performance.\r\n\r\nWe offer customized SEO services that deliver measurable improvements.\r\n\r\nOnce you share your target keywords and target market, Iâ€™ll send a full proposal.\r\n\r\nBest Regards,\r\n\r\nAnaya', 'unread', '2026-03-20 05:36:36', NULL),
(7, '2026-03-30', 'Deepa ', NULL, '9266141479', 'deepa.dgtlsolution@gmail.com', NULL, 'Hello http://hosteetheplanner.in,\r\n \r\nIf youâ€™re looking to boost your websiteâ€™s visibility, I can help you achieve top Google rankings.\r\n \r\nIâ€™ll prepare a complete SEO plan with actionable steps and potential growth insights for your products or services.\r\n \r\nOnce you share your target keywords and target market, Iâ€™ll send a full proposal.\r\n \r\nBest Regards,\r\nDeepa\r\n', 'unread', '2026-03-30 09:14:24', NULL),
(8, '2026-04-02', 'Deepa ', NULL, '9266141479', 'preston.kraegen44@gmail.com', NULL, 'Hi http://hosteetheplanner.in,\r\n \r\nWe can place your website on Google 1st page.\r\n \r\nI can give you our Complete SEO Action Plan along with a customary reach and add great value to your product/ service.\r\n \r\nI may send you a SEO Packages & price list. If interested.\r\n \r\nBest Regards,\r\nDeepa\r\nOnline SEO Consultant', 'unread', '2026-04-02 06:56:38', NULL),
(9, '2026-04-03', 'DavidJak', NULL, '81184268624', 'no.reply.HansLeroy@gmail.com', NULL, 'Hey there! hosteetheplanner.in, \r\nWhile exploring the internet I came across hosteetheplanner.in. \r\nOur system automatically sends messages through website contact forms. \r\nOur system supports outreach to websites around the world. \r\n  \r\n  \r\nFeel free to contact us if you want more information. \r\n \r\nThanks for taking a moment to read this. \r\nContact us. \r\nTelegram - https://t.me/FeedbackFormEU \r\nWhatsApp - +375259112693 \r\nWhatsApp  https://wa.me/+375259112693', 'unread', '2026-04-03 09:40:36', NULL),
(10, '2026-04-28', 'isffpvrhvx', NULL, '+1-025-915-2345', 'stxjxmfu@immenseignite.info', NULL, 'qstpdntvwtwhqwqznrvfdnxndvdipd', 'unread', '2026-04-28 22:57:57', NULL),
(11, '2026-05-21', NULL, NULL, NULL, NULL, NULL, NULL, 'unread', '2026-05-21 04:33:10', NULL),
(12, '2026-05-22', 'Felix Lence', NULL, '84432286997', 'executive@sapmsllc.ae', NULL, 'Greetings, \r\n \r\nWe are pleased to offer funding solutions to support your business growth. Our Loan Department provides financing for Working Capital, Start?ups, and expansion projects across sectors including Renewable Energy, Real Estate, Telecommunications, Infrastructure, Agriculture, Healthcare, and Oil & Gas. \r\n \r\nWe offer competitive rates and a fast, reliable application process. \r\n \r\nKindly respond at your earliest convenience so we can proceed with next steps. \r\n \r\nRegards \r\n \r\nFelix Lence \r\n \r\nFinancial Broker Authority to Anwar \r\nDohat Al-Adab Street, Al-Khuwair, \r\nMuscat, Sultanate of Oman \r\nW: +968 7503 9067 \r\nfelix.lence@anwarllc.com \r\nLevel 43, Building 115, King Abdullah Financial \r\nDistrict - Building Riyadh, Saudi Arabia â€“ ETC', 'unread', '2026-05-22 08:05:06', NULL),
(13, '2026-06-06', NULL, NULL, NULL, NULL, NULL, NULL, 'unread', '2026-06-06 18:54:24', NULL),
(14, '2026-06-09', 'Youssef Abdullah', NULL, '87774469731', 'yabdullah.agency@gmail.com', NULL, 'Seasons Greetings, \r\n \r\nWe are a Dubai-based business consulting and sourcing company with an extensive network of buyers, importers, distributors, and investors across the UAE and the Middle East. \r\n \r\nBased on the growing demand from our clients, we are seeking to establish business relationships with reputable manufacturers, traders, and distributors interested in expanding their products into the UAE market. \r\n \r\nThrough our network, we can introduce qualified buyers and business opportunities in sectors such as agriculture, manufacturing, construction, mining, oil and gas, consumer goods, and other industries. We conduct our business professionally and in full compliance with UAE laws and regulations. \r\n \r\nIf your company is interested in exploring cooperation opportunities, please send us your company profile, product e-catalog, and pricing information. We would be pleased to review your offerings and discuss potential business opportunities. \r\n \r\nContact me on this email address: yabdullah-agency@finvlimited.com \r\n \r\nKind regards, \r\nMr. Youssef Abdullah \r\nDubai Business Consultants', 'unread', '2026-06-09 07:47:10', NULL),
(15, '2026-06-24', NULL, NULL, NULL, NULL, NULL, NULL, 'unread', '2026-06-24 20:41:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `place` varchar(255) DEFAULT NULL,
  `gst_no` varchar(255) DEFAULT NULL,
  `balance` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `generated_by` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `mobile`, `email`, `place`, `gst_no`, `balance`, `add_date`, `generated_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'MOHAMMED ISMAIL', '9048156633', NULL, 'NADAPURAM', NULL, NULL, '2025-12-23 19:08:55', 'ADIL', 'active', '2025-12-24 00:08:55', '2025-12-24 00:08:55'),
(2, 'MSM HIGHER SECONDARY SCHOOL', '9946985000', NULL, 'KALLINGAL PARAMBU', NULL, NULL, '2025-12-27 13:04:01', 'ADIL', 'active', '2025-12-27 18:04:01', '2025-12-27 18:04:29'),
(3, 'UNIVERSAL INSTITUTE', '9447177624', NULL, 'KOTTAKKAL', NULL, NULL, '2025-12-27 13:08:53', 'ADIL', 'active', '2025-12-27 18:08:53', '2025-12-27 18:08:53'),
(4, 'MUBARIS', '9544526675', NULL, 'CALICUT', NULL, NULL, '2025-12-31 12:18:29', 'ADIL', 'active', '2025-12-31 17:18:29', '2025-12-31 17:18:29'),
(5, 'MUBARIS', '9544526675', NULL, 'CALICUT', NULL, NULL, '2025-12-31 12:20:49', 'ADIL', 'active', '2025-12-31 17:20:49', '2025-12-31 17:20:49'),
(6, 'UDF THIRUVEGAPPURA', '9846666648', NULL, 'THIRUVEGAPPURA', NULL, NULL, '2025-12-31 19:33:58', 'ADIL', 'active', '2026-01-01 00:33:58', '2026-01-01 00:33:58'),
(7, 'SAMEER BINSI', '7025863004', NULL, 'MALAPPURAM', NULL, NULL, '2026-01-03 15:18:03', 'OFFICE ADMIN', 'active', '2026-01-03 20:18:03', '2026-01-03 20:18:03'),
(8, 'SAMEER BINSI', '7025863004', NULL, 'MALAPPURAM', NULL, NULL, '2026-01-03 15:19:00', 'OFFICE ADMIN', 'active', '2026-01-03 20:19:00', '2026-01-03 20:19:00'),
(9, 'STONE WALL PROJECTS LLP', '9562211110', NULL, 'PUTHANATHANI', NULL, '0', '2026-01-04 22:23:52', 'ADIL', 'active', '2026-01-05 03:23:52', '2026-01-05 03:23:52'),
(10, 'NATURALS BEAUTY SALOON', '9565100909', NULL, 'PUTHANATHANI', NULL, '0', '2026-01-04 22:24:25', 'ADIL', 'active', '2026-01-05 03:24:25', '2026-01-05 03:24:25'),
(11, 'DR SULAIMAN MELPATHUR', '9744312222', NULL, 'MELPATHUR', NULL, NULL, '2026-01-04 22:25:35', 'ADIL', 'active', '2026-01-05 03:25:35', '2026-01-05 03:25:35'),
(12, 'GREEN VILLAGE NUTRITION VILLAGE', '7994046834', NULL, 'PUTHANATHANI', NULL, '0', '2026-01-04 22:26:23', 'ADIL', 'active', '2026-01-05 03:26:23', '2026-01-05 03:26:23'),
(13, 'PATHMIA PRIVATE LIMITED', '8848337393', NULL, 'CALICUT', NULL, '0', '2026-01-04 22:27:16', 'ADIL', 'active', '2026-01-05 03:27:16', '2026-01-05 03:27:16'),
(14, 'PRATHYASHA DE-ADDICTION CENTRE', '7909100110', NULL, 'PUTHANATHANI', NULL, '37700', '2026-01-04 22:28:05', 'ADIL', 'active', '2026-01-05 03:28:05', '2026-01-05 03:28:05'),
(15, 'DR ROSE\'S HOMEO CLINIC', '8589862919', NULL, 'PUTHANATHANI', NULL, '0', '2026-01-04 22:29:24', 'ADIL', 'active', '2026-01-05 03:29:24', '2026-01-05 03:29:24'),
(16, 'CENTRAL CLINIC', '8089061916', NULL, 'KUTTIKALATHANI', NULL, '0', '2026-01-06 16:19:51', 'ADIL', 'active', '2026-01-06 21:19:51', '2026-01-06 21:19:51'),
(17, 'ANVAR HAIDARI - PATH', '8137801902', NULL, 'KANNUR', NULL, '0', '2026-01-06 20:23:38', 'ADIL', 'active', '2026-01-07 01:23:38', '2026-01-07 01:23:38'),
(18, 'DISTRICT MISSION COORDINATOR  KUDUMBASHREE DISTRICT MISSION, PALAKKAD  SECOND FLOOR, CIVIL STATION  PALAKKAD, 678001 KUDUMBASHREEPKD9@GMAIL.COM', '8921451054', NULL, 'PALAKKAD', NULL, NULL, '2026-01-08 12:31:24', 'ADIL', 'active', '2026-01-08 17:31:24', '2026-01-08 17:31:24'),
(19, 'ASKAR YELLOW RIVER', '7470732515', NULL, NULL, NULL, '0', '2026-01-13 14:00:24', 'ADIL', 'active', '2026-01-13 19:00:24', '2026-01-13 19:00:24'),
(20, 'IRSHAD K', '8606305528', NULL, 'THALAKKADATHUR', NULL, '500', '2026-01-13 14:00:57', 'ADIL', 'active', '2026-01-13 19:00:57', '2026-01-13 19:00:57'),
(21, 'FAVAS', '9947195204', NULL, 'CALICUT', NULL, NULL, '2026-01-15 10:48:24', 'OFFICE ADMIN', 'active', '2026-01-15 15:48:24', '2026-01-15 15:49:05'),
(22, 'ROSHAN', '9072930567', NULL, 'PERINTHALMANNA', NULL, NULL, '2026-01-16 10:13:25', 'OFFICE ADMIN', 'active', '2026-01-16 15:13:25', '2026-01-16 15:13:25'),
(23, 'RAMEES', '8156947066', NULL, 'MANNARKADU', NULL, NULL, '2026-01-19 13:30:01', 'OFFICE ADMIN', 'active', '2026-01-19 18:30:01', '2026-01-19 18:30:01'),
(24, 'ZIYAD', '9037587117', NULL, 'MUKKAM', NULL, NULL, '2026-01-19 13:45:09', 'OFFICE ADMIN', 'active', '2026-01-19 18:45:09', '2026-01-19 18:45:09'),
(25, 'NOUSHAD VALANCHERY', '9995984110', NULL, 'VALANCHERY', NULL, NULL, '2026-01-19 17:55:41', 'ADIL', 'active', '2026-01-19 22:55:41', '2026-01-19 22:55:41'),
(26, 'NAVAS PATTAMBI', '8714263757', NULL, 'PATTAMBI NATIONAL FEST 2026', NULL, NULL, '2026-01-20 11:22:39', 'OFFICE ADMIN', 'active', '2026-01-20 16:22:39', '2026-01-20 16:22:39'),
(27, 'PRINCIPAL PPTM COLLEGER CHERUR', '9061853090', NULL, 'CHERUR', NULL, NULL, '2026-02-07 12:11:53', 'ADIL', 'active', '2026-02-07 17:11:53', '2026-02-07 17:13:56'),
(28, 'RAC HSS KATAMERI', '9645212073', NULL, 'KATAMERI', NULL, NULL, '2026-02-07 12:12:21', 'ADIL', 'active', '2026-02-07 17:12:21', '2026-02-07 17:12:21'),
(29, 'AMUPS AREEKAD', '7907462845', NULL, 'AREEKAD', NULL, NULL, '2026-02-12 13:21:09', 'OFFICE ADMIN', 'active', '2026-02-12 18:21:09', '2026-02-12 18:21:09'),
(30, 'AMUPS AREEKAD', '7907462845', NULL, 'AREEKAD', NULL, NULL, '2026-02-12 14:23:32', 'OFFICE ADMIN', 'active', '2026-02-12 19:23:32', '2026-02-12 19:23:32'),
(31, 'JOYAL SHAJI', '7012572769', NULL, 'ALAPPUZHA', NULL, NULL, '2026-02-20 14:48:31', 'ADIL', 'active', '2026-02-20 19:48:31', '2026-02-20 19:48:31'),
(32, 'ROSHAN MEA COLLEGE', '9072930567', NULL, 'PERINTHALMANNA', NULL, NULL, '2026-02-25 13:47:53', 'ADIL', 'active', '2026-02-25 18:47:53', '2026-02-25 18:47:53'),
(33, 'DIRECTOR , HORIZON ENGLISH SCHOOL', '9207787266', NULL, 'PEACEVALLEY IRIKKUR', NULL, NULL, '2026-02-27 13:57:15', 'ADIL', 'active', '2026-02-27 18:57:15', '2026-02-27 18:57:15'),
(34, 'PRINCIPAL,  MM KNOWLEDGE ARTS AND SCIENCE COLLEGE,  KARAKKUNDU,  TALIPARAMBA.', '9947650767', NULL, 'THALIPPRAMB - KANNUR', NULL, NULL, '2026-02-27 16:32:21', 'ADIL', 'active', '2026-02-27 21:32:21', '2026-02-27 21:32:21'),
(35, 'COLLEGE UNION UNIVERSITY COLLEGE OF ENGINEERING KARYAVATTAM', '8289962616', NULL, 'TRIVANDRUM', NULL, NULL, '2026-02-28 14:30:54', 'ADIL', 'active', '2026-02-28 19:30:54', '2026-02-28 19:30:54'),
(36, 'SIMET COLLEGE OF NURSING', '9645137588', NULL, NULL, NULL, NULL, '2026-03-14 08:55:31', 'ADIL', 'active', '2026-03-14 12:55:31', '2026-03-14 12:55:31'),
(37, 'SIMET COLLEGE OF NURSING', '9645137588', NULL, 'KALOOR', NULL, NULL, '2026-03-14 08:57:06', 'ADIL', 'active', '2026-03-14 12:57:06', '2026-03-14 12:57:06'),
(38, 'NESTO HYPERMARKET', '8129461113', NULL, 'INKEL CITY', NULL, NULL, '2026-03-14 14:23:51', 'ADIL', 'active', '2026-03-14 18:23:51', '2026-03-14 18:23:51'),
(39, 'KEF LABAN', '7902606066', NULL, 'PUTHANATHANI', NULL, NULL, '2026-03-16 13:43:03', 'ADIL', 'active', '2026-03-16 17:43:03', '2026-03-16 17:43:03'),
(40, 'WATERMELON KIDS', '9746578705', NULL, 'PUTHANATHANI', NULL, '17000', '2026-03-16 15:36:36', 'ADIL', 'active', '2026-03-16 19:36:36', '2026-03-16 19:36:36'),
(41, 'MINHAJ CH & MOHAMMED SALMANUL FARIS PV , KMCT ARTS & SCIENCE COLLEGE', '8157002064', NULL, 'KUTTIPPURAM', NULL, NULL, '2026-03-23 15:29:48', 'ADIL', 'active', '2026-03-23 19:29:48', '2026-03-23 19:29:48'),
(42, 'CMAMLP SCHOOL', '9446096666', NULL, 'CHENAKKAL', NULL, NULL, '2026-04-03 15:19:06', 'OFFICE ADMIN', 'active', '2026-04-03 19:19:06', '2026-04-03 19:19:06'),
(43, 'CMAMLP SCHOOL', '9446096666', NULL, 'CHENAKKAL', NULL, NULL, '2026-04-03 15:19:45', 'OFFICE ADMIN', 'active', '2026-04-03 19:19:45', '2026-04-03 19:19:45'),
(44, 'HAPI CLINIC', '9207552244', NULL, 'PUTHANATHANI', NULL, '0', '2026-04-08 11:04:25', 'ADIL', 'active', '2026-04-08 15:04:25', '2026-04-08 15:04:25'),
(45, 'RUBA\'S DIVERSZA', '8590911966', NULL, 'PUTHANATHANI', NULL, '0', '2026-04-08 11:07:12', 'ADIL', 'active', '2026-04-08 15:07:12', '2026-04-08 15:07:12'),
(46, 'DR BLOOM', '9037493737', NULL, 'KOTTAKKAL', NULL, '0', '2026-04-08 11:07:55', 'ADIL', 'active', '2026-04-08 15:07:55', '2026-04-08 15:07:55'),
(47, 'DR . NAMSHAD MALAPPURAM', '8089502467', NULL, 'MALAPPURAM', NULL, NULL, '2026-04-13 17:12:19', 'ADIL', 'active', '2026-04-13 21:12:19', '2026-04-13 21:12:19'),
(48, 'ASIF VILLAN VILECTRO', '9746447338', NULL, 'VATTAPPARAMB', NULL, NULL, '2026-04-18 12:10:15', 'OFFICE ADMIN', 'active', '2026-04-18 16:10:15', '2026-04-18 16:10:15'),
(49, 'PRINCIPAL, AL JAMIA ARTS AND SCIENCE COLLEGE', '8606155523', NULL, 'PERINTHALMANNA', NULL, NULL, '2026-05-01 17:52:20', 'ADIL', 'active', '2026-05-01 21:52:20', '2026-05-01 21:52:20'),
(50, 'PRINCIPAL, AL JAMIA ARTS AND SCIENCE COLLEGE, PERINTHALMANNA', '8606155523', NULL, 'PERINTHALMANNA', NULL, NULL, '2026-05-01 17:53:44', 'ADIL', 'active', '2026-05-01 21:53:44', '2026-05-01 21:53:44'),
(51, 'GTEC', '8547867379', NULL, 'PUTHANATHANI', NULL, NULL, '2026-05-02 16:16:51', 'OFFICE ADMIN', 'active', '2026-05-02 20:16:51', '2026-05-02 20:16:51'),
(52, 'GTEC PUTHANATHANI INVOICE', '8547867379', NULL, 'PUTHANATHANI', NULL, NULL, '2026-05-02 16:28:46', 'OFFICE ADMIN', 'active', '2026-05-02 20:28:46', '2026-05-02 20:28:46'),
(53, 'EDUCLUES', '7306314104', NULL, 'KOTTAKKAL', NULL, NULL, '2026-05-08 16:29:08', 'OFFICE ADMIN', 'active', '2026-05-08 20:29:08', '2026-05-08 20:29:08'),
(54, 'DR ASHIF K.P', '8907333777', NULL, 'PATTAMBI', NULL, NULL, '2026-05-08 16:39:44', 'OFFICE ADMIN', 'active', '2026-05-08 20:39:44', '2026-05-08 20:39:44'),
(55, 'RECTIFI', '7025366178', NULL, 'CALICUT', NULL, NULL, '2026-05-31 16:11:17', 'ADIL', 'active', '2026-05-31 20:11:17', '2026-05-31 20:11:17'),
(56, 'ACCOUNTAMY', '7994833515', NULL, 'KOTTAKKAL', NULL, NULL, '2026-06-01 18:19:07', 'ADIL', 'active', '2026-06-01 22:19:07', '2026-06-01 22:19:07'),
(57, 'SOL EDUCATION', '9846147310', NULL, 'KOTTAKKAL', NULL, NULL, '2026-06-01 18:20:56', 'ADIL', 'active', '2026-06-01 22:20:56', '2026-06-01 22:20:56'),
(58, 'KEF DAY', '9846223757', NULL, 'CALICUT', NULL, NULL, '2026-06-02 10:51:14', 'ADIL', 'active', '2026-06-02 14:51:14', '2026-06-02 14:51:14'),
(59, 'PLAN AT PROJECTS', '9746910694', NULL, 'CHANGARAMKULAM', NULL, NULL, '2026-06-02 10:51:57', 'ADIL', 'active', '2026-06-02 14:51:57', '2026-06-02 14:51:57'),
(60, 'ELANJI MAKEOVER STUDIO', '7306908633', NULL, 'EDARIKODE', NULL, NULL, '2026-06-02 10:52:25', 'ADIL', 'active', '2026-06-02 14:52:25', '2026-06-02 14:52:25'),
(61, 'FETERNITY MOVEMENT', '8943881344', NULL, 'MALAPPURAM', NULL, NULL, '2026-06-02 10:55:53', 'ADIL', 'active', '2026-06-02 14:55:53', '2026-06-02 14:55:53'),
(62, 'FRETERNITY MOVEMENT', '8943881344', NULL, 'MALAPPURAM', NULL, NULL, '2026-06-02 10:56:34', 'ADIL', 'active', '2026-06-02 14:56:34', '2026-06-02 14:56:34'),
(63, 'LUXON TATA', '7025580007', NULL, 'MALAPPURAM', NULL, NULL, '2026-06-02 12:42:47', 'ADIL', 'active', '2026-06-02 16:42:47', '2026-06-02 16:42:47'),
(64, 'ENGLISH SPARK', '7511170787', NULL, 'TIRUR', NULL, NULL, '2026-06-13 11:27:21', 'ADIL', 'active', '2026-06-13 15:27:21', '2026-06-13 15:27:21'),
(65, 'VAIGA CONSULTANCY', '9995415419', NULL, 'PUTHANATHANI', NULL, NULL, '2026-06-15 13:21:54', 'ADIL', 'active', '2026-06-15 17:21:54', '2026-06-15 17:21:54'),
(66, 'TECHSOUL KOTTAKKAL', '9526989842', NULL, 'KOTTAKKAL', NULL, NULL, '2026-06-17 17:28:59', 'ADIL', 'active', '2026-06-17 21:28:59', '2026-06-17 21:28:59'),
(67, 'AIMS ACADEMY', '9526989842', NULL, 'KOTTAKKAL', NULL, NULL, '2026-06-17 17:34:32', 'ADIL', 'active', '2026-06-17 21:34:32', '2026-06-17 21:34:32'),
(68, 'NOOWO ONLINE MADRASSA', '7592041963', NULL, NULL, NULL, NULL, '2026-07-02 15:40:13', 'ADIL', 'active', '2026-07-02 19:40:13', '2026-07-02 19:40:13'),
(69, 'KIMT TECHNOLOGY INNOVATION', '8606302302', NULL, 'KOTTAKKAL', NULL, NULL, '2026-07-03 12:13:38', 'ADIL', 'active', '2026-07-03 16:13:38', '2026-07-03 16:13:38');

-- --------------------------------------------------------

--
-- Table structure for table `daybooks`
--

CREATE TABLE `daybooks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `expense_id` varchar(255) DEFAULT NULL,
  `income_id` varchar(255) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `job` varchar(255) DEFAULT NULL,
  `staff` varchar(255) DEFAULT NULL,
  `amount` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `accounts` varchar(255) DEFAULT NULL,
  `add_by` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daybooks`
--

INSERT INTO `daybooks` (`id`, `date`, `expense_id`, `income_id`, `description`, `job`, `staff`, `amount`, `type`, `accounts`, `add_by`, `add_date`, `status`, `created_at`, `updated_at`) VALUES
(1, '2025-12-28', 'staff_salary', NULL, 'Salary', NULL, '1', '11538.46', 'Expense', 'CASH', NULL, NULL, 'active', '2025-12-27 19:18:27', '2025-12-27 19:18:27'),
(2, '2025-12-28', NULL, '1', '245', NULL, NULL, '2000', 'Income', 'CASH', 'ADIL', '2025-12-27 14:26:43', 'active', NULL, NULL),
(4, '2026-01-06', NULL, 'FROM_INVOICE', NULL, 'B2C-00008-2526', NULL, '20000', 'Income', 'CASH', NULL, NULL, 'active', '2026-01-06 23:40:54', '2026-01-06 23:40:54'),
(5, '2026-01-06', NULL, 'FROM_INVOICE', NULL, 'B2C-00007-2526', NULL, '7000', 'Income', 'CASH', 'ADIL', '2026-01-12 14:10:49', 'active', '2026-01-12 19:10:49', '2026-01-12 19:10:49'),
(6, '2026-01-06', NULL, 'FROM_INVOICE', NULL, 'B2C-00005-2526', NULL, '7000', 'Income', 'CASH', 'ADIL', '2026-01-12 14:11:27', 'active', '2026-01-12 19:11:27', '2026-01-12 19:11:27'),
(7, '2026-01-07', '1', NULL, '2 BOTTLE', NULL, NULL, '120', 'Expense', 'CASH', 'ADIL', '2026-01-19 12:58:59', 'active', NULL, NULL),
(8, '2026-01-07', NULL, 'FROM_INVOICE', NULL, 'B2C-00003-2526', NULL, '10800', 'Income', 'CASH', 'ADIL', '2026-02-03 11:42:38', 'active', '2026-02-03 16:42:38', '2026-02-03 16:42:38'),
(9, '2026-01-07', NULL, 'FROM_INVOICE', NULL, 'B2C-00011-2526', NULL, '22500', 'Income', 'CASH', 'ADIL', '2026-02-03 11:42:52', 'active', '2026-02-03 16:42:52', '2026-02-03 16:42:52'),
(10, '2026-01-07', NULL, 'FROM_INVOICE', NULL, 'B2C-00001-2526', NULL, '13300', 'Income', 'CASH', 'ADIL', '2026-02-03 11:43:12', 'active', '2026-02-03 16:43:12', '2026-02-03 16:43:12'),
(11, '2026-01-07', '4', NULL, 'DECEMBER MONTH TOTAL', NULL, NULL, '35300', 'Expense', 'CASH', 'ADIL', '2026-02-03 11:45:51', 'active', NULL, NULL),
(12, '2026-01-07', '5', NULL, 'DECEMBER MONTH', NULL, NULL, '10000', 'Expense', 'CASH', 'ADIL', '2026-02-03 11:47:04', 'active', NULL, NULL),
(13, '2026-01-07', '6', NULL, 'HIBA - VIDEO', NULL, NULL, '3800', 'Expense', 'CASH', 'ADIL', '2026-02-03 11:47:59', 'active', NULL, NULL),
(14, '2026-01-07', '7', NULL, 'DECEMBER BILL', NULL, NULL, '3073', 'Expense', 'CASH', 'ADIL', '2026-02-03 11:50:00', 'active', NULL, NULL),
(15, '2026-01-07', '8', NULL, 'TOTAL ALL EXPENCE', NULL, NULL, '28307', 'Expense', 'CASH', 'ADIL', '2026-02-03 11:51:58', 'active', NULL, NULL),
(16, '2026-03-07', NULL, 'FROM_INVOICE', NULL, 'B2C-00021-2526', NULL, '27505.84', 'Income', 'CASH', 'ADIL', '2026-03-11 21:15:03', 'active', '2026-03-12 01:15:03', '2026-03-12 01:15:03'),
(17, '2026-03-07', NULL, 'FROM_INVOICE', NULL, 'B2C-00016-2526', NULL, '45000', 'Income', 'CASH', 'ADIL', '2026-03-11 21:16:32', 'active', '2026-03-12 01:16:32', '2026-03-12 01:16:32'),
(18, '2026-03-10', NULL, 'FROM_INVOICE', NULL, 'B2C-00023-2526', NULL, '5000', 'Income', 'ACCOUNT', NULL, NULL, 'active', '2026-03-23 19:31:18', '2026-03-23 19:31:18'),
(19, '2026-04-08', NULL, 'FROM_INVOICE', NULL, 'B2C-00009-2526', NULL, '4250', 'Income', 'CASH', 'ADIL', '2026-04-13 17:12:44', 'active', '2026-04-13 21:12:44', '2026-04-13 21:12:44'),
(20, '2026-04-08', NULL, 'FROM_INVOICE', NULL, 'B2C-00012-2526', NULL, '660', 'Income', 'ACCOUNT', 'ADIL', '2026-04-13 17:13:09', 'active', '2026-04-13 21:13:09', '2026-04-13 21:13:09'),
(21, '2026-04-08', NULL, 'FROM_INVOICE', NULL, 'B2C-00003-2627', NULL, '10000', 'Income', 'ACCOUNT', 'ADIL', '2026-04-13 17:13:30', 'active', '2026-04-13 21:13:30', '2026-04-13 21:13:30'),
(22, '2026-04-08', NULL, 'FROM_INVOICE', NULL, 'B2C-00005-2627', NULL, '7600', 'Income', 'CASH', 'ADIL', '2026-04-13 17:13:46', 'active', '2026-04-13 21:13:46', '2026-04-13 21:13:46'),
(23, '2026-04-08', NULL, 'FROM_INVOICE', NULL, 'B2C-00022-2526', NULL, '11800', 'Income', 'CASH', 'ADIL', '2026-04-13 17:14:49', 'active', '2026-04-13 21:14:49', '2026-04-13 21:14:49'),
(24, '2026-04-08', NULL, 'FROM_INVOICE', NULL, 'B2C-00017-2526', NULL, '10000', 'Income', 'CASH', 'ADIL', '2026-04-13 17:14:55', 'active', '2026-04-13 21:14:55', '2026-04-13 21:14:55'),
(25, '2026-04-08', NULL, 'FROM_INVOICE', NULL, 'B2C-00002-2627', NULL, '7000', 'Income', 'CASH', 'ADIL', '2026-04-13 17:15:13', 'active', '2026-04-13 21:15:13', '2026-04-13 21:15:13'),
(26, '2026-04-08', NULL, 'FROM_INVOICE', NULL, 'B2C-00018-2526', NULL, '5900', 'Income', 'CASH', 'ADIL', '2026-04-13 17:16:09', 'active', '2026-04-13 21:16:09', '2026-04-13 21:16:09'),
(27, '2026-04-08', NULL, 'FROM_INVOICE', NULL, 'B2C-00015-2526', NULL, '22770', 'Income', 'CASH', 'ADIL', '2026-04-13 17:16:26', 'active', '2026-04-13 21:16:26', '2026-04-13 21:16:26'),
(28, '2026-04-08', NULL, 'FROM_INVOICE', NULL, 'B2C-00020-2526', NULL, '7600', 'Income', 'ACCOUNT', 'ADIL', '2026-04-13 17:16:40', 'active', '2026-04-13 21:16:40', '2026-04-13 21:16:40'),
(29, '2026-04-08', NULL, 'FROM_INVOICE', NULL, 'B2C-00019-2526', NULL, '7800', 'Income', 'CASH', 'ADIL', '2026-04-13 17:16:57', 'active', '2026-04-13 21:16:57', '2026-04-13 21:16:57'),
(30, '2026-04-08', NULL, 'FROM_INVOICE', NULL, 'B2C-00001-2627', NULL, '9600', 'Income', 'ACCOUNT', 'ADIL', '2026-04-13 17:17:12', 'active', '2026-04-13 21:17:12', '2026-04-13 21:17:12'),
(31, '2026-04-08', NULL, 'FROM_INVOICE', NULL, 'B2C-00004-2526', NULL, '1300', 'Income', 'CASH', 'ADIL', '2026-04-13 17:17:34', 'active', '2026-04-13 21:17:34', '2026-04-13 21:17:34'),
(32, '2026-04-11', '9', NULL, 'FEBURAY', NULL, NULL, '108400', 'Expense', 'CASH', 'ADIL', '2026-04-13 17:21:21', 'active', NULL, NULL),
(33, '2026-04-11', NULL, '1', 'HIBA - VIDEO', NULL, NULL, '1000', 'Income', 'CASH', 'ADIL', '2026-07-02 15:50:17', 'active', NULL, NULL),
(34, '2026-06-02', '10', NULL, 'PMA BOOK', NULL, NULL, '400', 'Expense', 'ACCOUNT', 'ADIL', '2026-07-03 12:27:44', 'active', NULL, NULL),
(35, '2026-06-02', NULL, 'FROM_INVOICE', NULL, 'B2C-00006-2627', NULL, '7000', 'Income', 'ACCOUNT', NULL, NULL, 'active', '2026-07-03 16:28:56', '2026-07-03 16:28:56');

-- --------------------------------------------------------

--
-- Table structure for table `daybook_balances`
--

CREATE TABLE `daybook_balances` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `ledger_balance` varchar(255) DEFAULT NULL,
  `account_balance` varchar(255) DEFAULT NULL,
  `cash_balance` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daybook_balances`
--

INSERT INTO `daybook_balances` (`id`, `date`, `ledger_balance`, `account_balance`, `cash_balance`, `updated_at`, `created_at`) VALUES
(1, '2026-01-05', '0', '0', '0', NULL, NULL),
(2, '2026-01-06', '0', '0', '34000', NULL, NULL),
(4, '2026-01-07', '0', '0', '0', NULL, NULL),
(5, '2026-01-08', '0', '0', '0', NULL, NULL),
(6, '2026-01-09', '0', '0', '0', NULL, NULL),
(7, '2026-01-10', '0', '0', '0', NULL, NULL),
(8, '2026-01-11', '0', '0', '0', NULL, NULL),
(9, '2026-01-12', '0', '0', '0', NULL, NULL),
(10, '2026-01-13', '0', '0', '0', NULL, NULL),
(11, '2026-01-14', '0', '0', '0', NULL, NULL),
(12, '2026-01-15', '0', '0', '0', NULL, NULL),
(13, '2026-01-16', '0', '0', '0', NULL, NULL),
(14, '2026-01-17', '0', '0', '0', NULL, NULL),
(15, '2026-01-18', '0', '0', '0', NULL, NULL),
(16, '2026-01-19', '0', '0', '0', NULL, NULL),
(17, '2026-01-20', '0', '0', '0', NULL, NULL),
(18, '2026-01-21', '0', '0', '0', NULL, NULL),
(19, '2026-01-22', '0', '0', '0', NULL, NULL),
(20, '2026-01-23', '0', '0', '0', NULL, NULL),
(21, '2026-01-24', '0', '0', '0', NULL, NULL),
(22, '2026-01-25', '0', '0', '0', NULL, NULL),
(23, '2026-01-26', '0', '0', '0', NULL, NULL),
(24, '2026-01-27', '0', '0', '0', NULL, NULL),
(25, '2026-01-28', '0', '0', '0', NULL, NULL),
(26, '2026-01-29', '0', '0', '0', NULL, NULL),
(27, '2026-01-30', '0', '0', '0', NULL, NULL),
(28, '2026-01-31', '0', '0', '0', NULL, NULL),
(29, '2026-02-01', '0', '0', '0', NULL, NULL),
(30, '2026-02-02', '0', '0', '0', NULL, NULL),
(31, '2026-02-03', '0', '0', '0', NULL, NULL),
(32, '2026-02-04', '0', '0', '0', NULL, NULL),
(33, '2026-02-05', '0', '0', '0', NULL, NULL),
(34, '2026-02-06', '0', '0', '0', NULL, NULL),
(35, '2026-02-07', '0', '0', '0', NULL, NULL),
(36, '2026-02-08', '0', '0', '0', NULL, NULL),
(37, '2026-02-09', '0', '0', '0', NULL, NULL),
(38, '2026-02-10', '0', '0', '0', NULL, NULL),
(39, '2026-02-11', '0', '0', '0', NULL, NULL),
(40, '2026-02-12', '0', '0', '0', NULL, NULL),
(41, '2026-02-13', '0', '0', '0', NULL, NULL),
(42, '2026-02-14', '0', '0', '0', NULL, NULL),
(43, '2026-02-15', '0', '0', '0', NULL, NULL),
(44, '2026-02-16', '0', '0', '0', NULL, NULL),
(45, '2026-02-17', '0', '0', '0', NULL, NULL),
(46, '2026-02-18', '0', '0', '0', NULL, NULL),
(47, '2026-02-19', '0', '0', '0', NULL, NULL),
(48, '2026-02-20', '0', '0', '0', NULL, NULL),
(49, '2026-02-21', '0', '0', '0', NULL, NULL),
(50, '2026-02-22', '0', '0', '0', NULL, NULL),
(51, '2026-02-23', '0', '0', '0', NULL, NULL),
(52, '2026-02-24', '0', '0', '0', NULL, NULL),
(53, '2026-02-25', '0', '0', '0', NULL, NULL),
(54, '2026-02-26', '0', '0', '0', NULL, NULL),
(55, '2026-02-27', '0', '0', '0', NULL, NULL),
(56, '2026-02-28', '0', '0', '0', NULL, NULL),
(57, '2026-03-01', '0', '0', '0', NULL, NULL),
(58, '2026-03-02', '0', '0', '0', NULL, NULL),
(59, '2026-03-03', '0', '0', '0', NULL, NULL),
(60, '2026-03-04', '0', '0', '0', NULL, NULL),
(61, '2026-03-05', '0', '0', '0', NULL, NULL),
(62, '2026-03-06', '0', '0', '0', NULL, NULL),
(63, '2026-03-07', '0', '0', '72505.84', NULL, NULL),
(64, '2026-03-08', '0', '0', '72505.84', NULL, NULL),
(65, '2026-03-09', '0', '0', '72505.84', NULL, NULL),
(66, '2026-03-10', '0', '5000', '72505.84', NULL, NULL),
(67, '2026-03-11', '0', '5000', '72505.84', NULL, NULL),
(68, '2026-03-12', '0', '5000', '72505.84', NULL, NULL),
(69, '2026-03-13', '0', '5000', '72505.84', NULL, NULL),
(70, '2026-03-14', '0', '5000', '72505.84', NULL, NULL),
(71, '2026-03-15', '0', '5000', '72505.84', NULL, NULL),
(72, '2026-03-16', '0', '5000', '72505.84', NULL, NULL),
(73, '2026-03-17', '0', '5000', '72505.84', NULL, NULL),
(74, '2026-03-18', '0', '5000', '72505.84', NULL, NULL),
(75, '2026-03-19', '0', '5000', '72505.84', NULL, NULL),
(76, '2026-03-20', '0', '5000', '72505.84', NULL, NULL),
(77, '2026-03-21', '0', '5000', '72505.84', NULL, NULL),
(78, '2026-03-22', '0', '5000', '72505.84', NULL, NULL),
(79, '2026-03-23', '0', '5000', '72505.84', NULL, NULL),
(80, '2026-03-24', '0', '5000', '72505.84', NULL, NULL),
(81, '2026-03-25', '0', '5000', '72505.84', NULL, NULL),
(82, '2026-03-26', '0', '5000', '72505.84', NULL, NULL),
(83, '2026-03-27', '0', '5000', '72505.84', NULL, NULL),
(84, '2026-03-28', '0', '5000', '72505.84', NULL, NULL),
(85, '2026-03-29', '0', '5000', '72505.84', NULL, NULL),
(86, '2026-03-30', '0', '5000', '72505.84', NULL, NULL),
(87, '2026-03-31', '0', '5000', '72505.84', NULL, NULL),
(88, '2026-04-01', '0', '5000', '72505.84', NULL, NULL),
(89, '2026-04-02', '0', '5000', '72505.84', NULL, NULL),
(90, '2026-04-03', '0', '5000', '72505.84', NULL, NULL),
(91, '2026-04-04', '0', '5000', '72505.84', NULL, NULL),
(92, '2026-04-05', '0', '5000', '72505.84', NULL, NULL),
(93, '2026-04-06', '0', '5000', '72505.84', NULL, NULL),
(94, '2026-04-07', '0', '5000', '72505.84', NULL, NULL),
(95, '2026-04-08', '0', '32860', '150925.84', NULL, NULL),
(96, '2026-04-09', '0', '32860', '150925.84', NULL, NULL),
(97, '2026-04-10', '0', '32860', '150925.84', NULL, NULL),
(98, '2026-04-11', NULL, '32860.00', '43525.84', NULL, NULL),
(99, '2026-05-31', NULL, '500', '0', NULL, NULL),
(100, '2026-06-01', '0', '500', '0', NULL, NULL),
(101, '2026-06-02', NULL, '7100', '0.00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `daybook_prevs`
--

CREATE TABLE `daybook_prevs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `expense` varchar(255) DEFAULT NULL,
  `income` varchar(255) DEFAULT NULL,
  `amount` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `accounts` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daybook_prev_balances`
--

CREATE TABLE `daybook_prev_balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `ledger_balance` varchar(255) NOT NULL DEFAULT '0',
  `account_balance` varchar(255) NOT NULL DEFAULT '0',
  `cash_balance` varchar(255) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daybook_services`
--

CREATE TABLE `daybook_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) NOT NULL,
  `daybook_service` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daybook_summaries`
--

CREATE TABLE `daybook_summaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) NOT NULL,
  `opening_cash` varchar(255) DEFAULT NULL,
  `opening_account` varchar(255) DEFAULT NULL,
  `opening_ledger` varchar(255) DEFAULT NULL,
  `closing_cash` varchar(255) DEFAULT NULL,
  `closing_account` varchar(255) DEFAULT NULL,
  `closing_ledger` varchar(255) DEFAULT NULL,
  `added_by` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daybook_summaries`
--

INSERT INTO `daybook_summaries` (`id`, `date`, `opening_cash`, `opening_account`, `opening_ledger`, `closing_cash`, `closing_account`, `closing_ledger`, `added_by`, `status`, `created_at`, `updated_at`) VALUES
(1, '2026-01-05', '0', '10800', '0', '0', '10800', '0', 'ADIL', 'active', '2026-01-05 23:43:51', '2026-01-05 23:43:51'),
(2, '2026-01-06', '0', '0', '0', '34000', '0', '0', 'ADIL', 'active', '2026-01-19 17:58:22', '2026-01-19 17:58:22'),
(3, '2026-01-07', '34000', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:05:00', '2026-02-03 17:05:00'),
(4, '2026-01-08', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:07:03', '2026-02-03 17:07:03'),
(5, '2026-01-09', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:07:18', '2026-02-03 17:07:18'),
(6, '2026-01-10', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:08:10', '2026-02-03 17:08:10'),
(7, '2026-01-11', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:08:15', '2026-02-03 17:08:15'),
(8, '2026-01-12', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:08:19', '2026-02-03 17:08:19'),
(9, '2026-01-13', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:08:28', '2026-02-03 17:08:28'),
(10, '2026-01-14', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:08:33', '2026-02-03 17:08:33'),
(11, '2026-01-15', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:08:38', '2026-02-03 17:08:38'),
(12, '2026-01-16', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:08:43', '2026-02-03 17:08:43'),
(13, '2026-01-17', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:08:47', '2026-02-03 17:08:47'),
(14, '2026-01-18', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:08:53', '2026-02-03 17:08:53'),
(15, '2026-01-19', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:09:00', '2026-02-03 17:09:00'),
(16, '2026-01-20', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:09:05', '2026-02-03 17:09:05'),
(17, '2026-01-21', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:09:09', '2026-02-03 17:09:09'),
(18, '2026-01-22', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:09:14', '2026-02-03 17:09:14'),
(19, '2026-01-23', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:09:18', '2026-02-03 17:09:18'),
(20, '2026-01-24', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:09:23', '2026-02-03 17:09:23'),
(21, '2026-01-25', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:09:27', '2026-02-03 17:09:27'),
(22, '2026-01-26', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:09:32', '2026-02-03 17:09:32'),
(23, '2026-01-27', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:09:36', '2026-02-03 17:09:36'),
(24, '2026-01-28', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:09:41', '2026-02-03 17:09:41'),
(25, '2026-01-29', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:09:47', '2026-02-03 17:09:47'),
(26, '2026-01-30', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:10:14', '2026-02-03 17:10:14'),
(27, '2026-01-31', '0', '0', '0', '0', '0', '0', 'DEVELOPER', 'active', '2026-02-03 17:10:57', '2026-02-03 17:10:57'),
(28, '2026-02-01', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-07 17:56:39', '2026-02-07 17:56:39'),
(29, '2026-02-01', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-07 17:56:43', '2026-02-07 17:56:43'),
(30, '2026-02-02', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-07 17:56:49', '2026-02-07 17:56:49'),
(31, '2026-02-03', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-07 17:56:59', '2026-02-07 17:56:59'),
(32, '2026-02-04', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-07 17:57:07', '2026-02-07 17:57:07'),
(33, '2026-02-05', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-07 17:57:24', '2026-02-07 17:57:24'),
(34, '2026-02-06', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-20 20:28:31', '2026-02-20 20:28:31'),
(35, '2026-02-07', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-20 20:28:42', '2026-02-20 20:28:42'),
(36, '2026-02-08', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-20 20:28:46', '2026-02-20 20:28:46'),
(37, '2026-02-09', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-20 20:28:50', '2026-02-20 20:28:50'),
(38, '2026-02-10', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-20 20:28:54', '2026-02-20 20:28:54'),
(39, '2026-02-11', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-20 20:29:04', '2026-02-20 20:29:04'),
(40, '2026-02-12', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-20 20:29:08', '2026-02-20 20:29:08'),
(41, '2026-02-13', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-20 20:29:15', '2026-02-20 20:29:15'),
(42, '2026-02-14', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-20 20:29:18', '2026-02-20 20:29:18'),
(43, '2026-02-15', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-20 20:29:22', '2026-02-20 20:29:22'),
(44, '2026-02-16', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-20 20:29:26', '2026-02-20 20:29:26'),
(45, '2026-02-17', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-20 20:29:31', '2026-02-20 20:29:31'),
(46, '2026-02-18', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-20 20:30:00', '2026-02-20 20:30:00'),
(47, '2026-02-19', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-02-20 20:30:06', '2026-02-20 20:30:06'),
(48, '2026-02-20', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-03-08 19:42:30', '2026-03-08 19:42:30'),
(49, '2026-02-21', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-03-08 19:42:35', '2026-03-08 19:42:35'),
(50, '2026-02-22', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-03-08 19:42:39', '2026-03-08 19:42:39'),
(51, '2026-02-23', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-03-08 19:42:44', '2026-03-08 19:42:44'),
(52, '2026-02-24', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-03-08 19:42:48', '2026-03-08 19:42:48'),
(53, '2026-02-25', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-03-08 19:42:54', '2026-03-08 19:42:54'),
(54, '2026-02-26', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-03-08 19:42:57', '2026-03-08 19:42:57'),
(55, '2026-02-27', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-03-08 19:43:01', '2026-03-08 19:43:01'),
(56, '2026-02-28', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-03-08 19:43:04', '2026-03-08 19:43:04'),
(57, '2026-03-01', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-03-08 19:43:08', '2026-03-08 19:43:08'),
(58, '2026-03-02', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-03-08 19:43:11', '2026-03-08 19:43:11'),
(59, '2026-03-03', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-03-08 19:43:15', '2026-03-08 19:43:15'),
(60, '2026-03-04', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-03-08 19:43:18', '2026-03-08 19:43:18'),
(61, '2026-03-05', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-03-08 19:43:22', '2026-03-08 19:43:22'),
(62, '2026-03-06', '0', '0', '0', '0', '0', '0', 'ADIL', 'active', '2026-03-08 19:43:26', '2026-03-08 19:43:26'),
(63, '2026-03-07', '0', '0', '0', '72505.84', '0', '0', 'ADIL', 'active', '2026-03-23 19:28:23', '2026-03-23 19:28:23'),
(64, '2026-03-08', '72505.84', '0', '0', '72505.84', '0', '0', 'ADIL', 'active', '2026-03-23 19:28:31', '2026-03-23 19:28:31'),
(65, '2026-03-09', '72505.84', '0', '0', '72505.84', '0', '0', 'ADIL', 'active', '2026-03-23 19:28:36', '2026-03-23 19:28:36'),
(66, '2026-03-10', '72505.84', '0', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:28:02', '2026-04-04 18:28:02'),
(67, '2026-03-11', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:28:10', '2026-04-04 18:28:10'),
(68, '2026-03-12', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:28:14', '2026-04-04 18:28:14'),
(69, '2026-03-13', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:28:29', '2026-04-04 18:28:29'),
(70, '2026-03-14', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:28:42', '2026-04-04 18:28:42'),
(71, '2026-03-15', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:28:49', '2026-04-04 18:28:49'),
(72, '2026-03-16', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:28:52', '2026-04-04 18:28:52'),
(73, '2026-03-17', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:28:56', '2026-04-04 18:28:56'),
(74, '2026-03-18', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:29:00', '2026-04-04 18:29:00'),
(75, '2026-03-19', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:29:03', '2026-04-04 18:29:03'),
(76, '2026-03-20', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:29:06', '2026-04-04 18:29:06'),
(77, '2026-03-21', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:29:09', '2026-04-04 18:29:09'),
(78, '2026-03-22', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:29:16', '2026-04-04 18:29:16'),
(79, '2026-03-23', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:29:19', '2026-04-04 18:29:19'),
(80, '2026-03-24', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:29:22', '2026-04-04 18:29:22'),
(81, '2026-03-25', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:29:26', '2026-04-04 18:29:26'),
(82, '2026-03-26', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:29:33', '2026-04-04 18:29:33'),
(83, '2026-03-27', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:29:36', '2026-04-04 18:29:36'),
(84, '2026-03-28', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:29:40', '2026-04-04 18:29:40'),
(85, '2026-03-29', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:29:48', '2026-04-04 18:29:48'),
(86, '2026-03-30', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:29:52', '2026-04-04 18:29:52'),
(87, '2026-03-31', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:29:56', '2026-04-04 18:29:56'),
(88, '2026-04-01', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:29:59', '2026-04-04 18:29:59'),
(89, '2026-04-02', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:30:05', '2026-04-04 18:30:05'),
(90, '2026-04-03', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-04 18:30:09', '2026-04-04 18:30:09'),
(91, '2026-04-04', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-08 15:02:12', '2026-04-08 15:02:12'),
(92, '2026-04-05', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-08 15:02:16', '2026-04-08 15:02:16'),
(93, '2026-04-06', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-08 15:03:00', '2026-04-08 15:03:00'),
(94, '2026-04-07', '72505.84', '5000', '0', '72505.84', '5000', '0', 'ADIL', 'active', '2026-04-13 21:12:31', '2026-04-13 21:12:31'),
(95, '2026-04-08', '72505.84', '5000', '0', '150925.84', '32860', '0', 'ADIL', 'active', '2026-04-13 21:17:58', '2026-04-13 21:17:58'),
(96, '2026-04-09', '150925.84', '32860', '0', '150925.84', '32860', '0', 'ADIL', 'active', '2026-04-13 21:18:06', '2026-04-13 21:18:06'),
(97, '2026-04-10', '150925.84', '32860', '0', '150925.84', '32860', '0', 'ADIL', 'active', '2026-04-13 21:18:35', '2026-04-13 21:18:35'),
(98, '2026-05-31', '0', '500', '0', '0', '500', '0', 'ADIL', 'active', '2026-05-31 21:18:35', '2026-05-31 21:18:35'),
(99, '2026-06-01', '0', '500', '0', '0', '500', '0', 'DEVELOPER', 'active', '2026-07-03 15:49:33', '2026-07-03 15:49:33');

-- --------------------------------------------------------

--
-- Table structure for table `direct_sales`
--

CREATE TABLE `direct_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sales_date` varchar(255) DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_place` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `pay_method` varchar(255) DEFAULT NULL,
  `sales_staff` int(11) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `grand_total` varchar(255) DEFAULT NULL,
  `is_gst` varchar(255) DEFAULT NULL,
  `gst_number` varchar(255) DEFAULT NULL,
  `print_status` varchar(255) NOT NULL DEFAULT 'not_printed',
  `payment_status` varchar(255) NOT NULL DEFAULT 'not_paid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `direct_sales`
--

INSERT INTO `direct_sales` (`id`, `sales_date`, `invoice_number`, `customer_id`, `customer_name`, `customer_place`, `customer_phone`, `pay_method`, `sales_staff`, `discount`, `grand_total`, `is_gst`, `gst_number`, `print_status`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, '2026-01-05', 'B2C-00001-2526', 9, 'STONE WALL PROJECTS LLP', NULL, '9562211110', 'CASH', 1, NULL, '13300', 'No', NULL, 'not_printed', 'paid', '2026-01-05 23:14:52', '2026-01-05 23:42:37'),
(2, '2026-01-05', 'B2C-00002-2526', 10, 'NATURALS BEAUTY SALOON', NULL, '9565100909', 'ACCOUNT', 1, '0', '0', 'No', NULL, 'cancelled', 'cancelled', '2026-01-05 23:32:07', '2026-01-05 23:43:05'),
(3, '2026-01-06', 'B2C-00003-2526', 10, 'NATURALS BEAUTY SALOON', NULL, '9565100909', 'CASH', 1, NULL, '10800', 'No', NULL, 'not_printed', 'paid', '2026-01-05 23:46:17', '2026-01-05 23:50:32'),
(4, '2026-01-06', 'B2C-00004-2526', 16, 'CENTRAL CLINIC', NULL, '8089061916', 'CASH', 1, '0', '1300.00', 'No', NULL, 'not_printed', 'paid', '2026-01-06 21:28:11', '2026-01-06 21:28:11'),
(5, '2026-01-06', 'B2C-00005-2526', 15, 'DR ROSE\'S HOMEO CLINIC', NULL, '8589862919', 'CASH', 1, NULL, '7000.00', 'No', NULL, 'not_printed', 'paid', '2026-01-06 23:26:27', '2026-01-06 23:26:27'),
(6, '2026-01-06', 'B2C-00006-2526', 14, 'PRATHYASHA DE-ADDICTION CENTRE', NULL, '7909100110', 'CREDIT', 1, NULL, '34700.00', 'No', NULL, 'not_printed', 'not_paid', '2026-01-06 23:33:19', '2026-01-06 23:33:19'),
(7, '2026-01-06', 'B2C-00007-2526', 12, 'GREEN VILLAGE NUTRITION VILLAGE', NULL, '7994046834', 'CASH', 1, NULL, '7000.00', 'No', NULL, 'not_printed', 'paid', '2026-01-06 23:34:50', '2026-01-06 23:34:50'),
(8, '2026-01-06', 'B2C-00008-2526', 7, 'SAMEER BINSI', NULL, '7025863004', 'CASH', 1, NULL, '20000.00', 'No', NULL, 'not_printed', 'paid', '2026-01-06 23:40:54', '2026-01-06 23:40:54'),
(9, '2026-01-06', 'B2C-00009-2526', 17, 'ANVAR HAIDARI - PATH', NULL, '8137801902', 'CASH', 1, NULL, '4250.00', 'No', NULL, 'not_printed', 'paid', '2026-01-07 01:29:06', '2026-01-07 01:29:06'),
(10, '2026-01-06', 'B2C-00010-2526', 17, 'ANVAR HAIDARI - PATH', NULL, '8137801902', 'CREDIT', 1, '0', '0', 'No', NULL, 'cancelled', 'cancelled', '2026-01-07 01:29:14', '2026-01-07 01:31:50'),
(11, '2026-01-06', 'B2C-00011-2526', 13, 'PATHMIA PRIVATE LIMITED', NULL, '8848337393', 'CASH', 1, NULL, '22500.00', 'No', NULL, 'not_printed', 'paid', '2026-01-07 01:35:47', '2026-01-07 01:35:47'),
(12, '2026-01-06', 'B2C-00012-2526', 19, 'ASKAR YELLOW RIVER', NULL, '7470732515', 'ACCOUNT', 1, NULL, '660.00', 'No', NULL, 'not_printed', 'paid', '2026-01-13 19:04:09', '2026-01-13 19:04:09'),
(13, '2026-01-06', 'B2C-00013-2526', 20, 'IRSHAD K', NULL, '8606305528', 'CREDIT', 1, '0', '500.00', 'No', NULL, 'not_printed', 'not_paid', '2026-01-13 19:07:49', '2026-01-13 19:07:49'),
(14, '2026-01-07', 'B2C-00014-2526', 14, 'PRATHYASHA DE-ADDICTION CENTRE', NULL, '7909100110', 'CREDIT', 1, NULL, '3000.00', 'No', NULL, 'not_printed', 'not_paid', '2026-01-22 18:56:45', '2026-01-22 18:56:45'),
(15, '2026-02-01', 'B2C-00015-2526', 13, 'PATHMIA PRIVATE LIMITED', NULL, '8848337393', 'CASH', 7, NULL, '22770.00', 'No', NULL, 'not_printed', 'paid', '2026-02-04 22:52:20', '2026-02-04 22:52:20'),
(16, '2026-02-01', 'B2C-00016-2526', 13, 'PATHMIA PRIVATE LIMITED', NULL, '8848337393', 'CASH', 7, NULL, '45000.00', 'No', NULL, 'not_printed', 'paid', '2026-02-04 22:55:16', '2026-02-04 22:55:16'),
(17, '2026-02-06', 'B2C-00017-2526', 9, 'STONE WALL PROJECTS LLP', NULL, '9562211110', 'CASH', 7, NULL, '10000.00', 'No', NULL, 'not_printed', 'paid', '2026-02-07 17:58:16', '2026-02-07 17:58:16'),
(18, '2026-02-06', 'B2C-00018-2526', 10, 'NATURALS BEAUTY SALOON', NULL, '9565100909', 'CASH', 7, '0', '5900.00', 'No', NULL, 'not_printed', 'paid', '2026-02-07 18:04:05', '2026-02-07 18:04:05'),
(19, '2026-02-06', 'B2C-00019-2526', 15, 'DR ROSE\'S HOMEO CLINIC', NULL, '8589862919', 'CASH', 7, NULL, '7800.00', 'No', NULL, 'not_printed', 'paid', '2026-02-07 18:15:49', '2026-02-07 18:15:49'),
(20, '2026-02-06', 'B2C-00020-2526', 12, 'GREEN VILLAGE NUTRITION VILLAGE', NULL, '7994046834', 'ACCOUNT', 7, NULL, '7600.00', 'No', NULL, 'not_printed', 'paid', '2026-02-07 18:24:26', '2026-02-07 18:24:26'),
(21, '2026-02-20', 'B2C-00021-2526', 13, 'PATHMIA PRIVATE LIMITED', NULL, '8848337393', 'CASH', 7, '0', '27505.84', 'No', NULL, 'not_printed', 'paid', '2026-02-20 20:47:45', '2026-02-20 20:47:45'),
(22, '2026-03-07', 'B2C-00022-2526', 9, 'STONE WALL PROJECTS LLP', NULL, '9562211110', 'CASH', 7, NULL, '11800.00', 'No', NULL, 'not_printed', 'paid', '2026-03-08 19:48:21', '2026-03-08 19:48:21'),
(23, '2026-03-10', 'B2C-00023-2526', 41, 'MINHAJ CH & MOHAMMED SALMANUL FARIS PV , KMCT ARTS & SCIENCE COLLEGE', NULL, '8157002064', 'ACCOUNT', 7, NULL, '5000.00', 'No', NULL, 'not_printed', 'paid', '2026-03-23 19:31:18', '2026-03-23 19:31:18'),
(24, '2026-04-07', 'B2C-00001-2627', 44, 'HAPI CLINIC', NULL, '9207552244', 'ACCOUNT', 7, NULL, '9600.00', 'No', NULL, 'not_printed', 'paid', '2026-04-08 15:05:19', '2026-04-08 15:05:19'),
(25, '2026-04-07', 'B2C-00002-2627', 45, 'RUBA\'S DIVERSZA', NULL, '8590911966', 'CASH', 7, NULL, '7000.00', 'No', NULL, 'not_printed', 'paid', '2026-04-08 15:08:17', '2026-04-08 15:08:17'),
(26, '2026-04-07', 'B2C-00003-2627', 46, 'DR BLOOM', NULL, '9037493737', 'ACCOUNT', 7, '0', '10000.00', 'No', NULL, 'not_printed', 'paid', '2026-04-08 15:10:02', '2026-04-08 15:10:02'),
(27, '2026-04-07', 'B2C-00004-2627', 40, 'WATERMELON KIDS', NULL, '9746578705', 'CREDIT', 7, NULL, '17000.00', 'No', NULL, 'not_printed', 'not_paid', '2026-04-08 15:11:50', '2026-04-08 15:11:50'),
(28, '2026-04-07', 'B2C-00005-2627', 15, 'DR ROSE\'S HOMEO CLINIC', NULL, '8589862919', 'CASH', 7, NULL, '7600.00', 'No', NULL, 'not_printed', 'paid', '2026-04-08 15:14:00', '2026-04-08 15:14:00'),
(29, '2026-06-02', 'B2C-00006-2627', 45, 'RUBA\'S DIVERSZA', NULL, '8590911966', 'ACCOUNT', 7, NULL, '7000.00', 'No', NULL, 'not_printed', 'paid', '2026-07-03 16:28:56', '2026-07-03 16:28:56');

-- --------------------------------------------------------

--
-- Table structure for table `employee_categories`
--

CREATE TABLE `employee_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_categories`
--

INSERT INTO `employee_categories` (`id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'Office Admin', '2025-12-29 06:17:51', '2025-12-29 06:17:51'),
(2, 'Accountant', '2025-12-29 06:17:51', '2025-12-29 06:17:51'),
(3, 'Digital Marketer', '2025-12-29 06:17:51', '2025-12-29 06:17:51'),
(4, 'Graphic Designer', '2025-12-29 06:17:51', '2025-12-29 06:17:51'),
(5, 'Video Grapher', '2025-12-29 06:17:51', '2025-12-29 06:17:51'),
(6, 'Video Editor', '2025-12-29 06:17:51', '2025-12-29 06:17:51'),
(7, 'Tele Caller', '2025-12-29 06:17:51', '2025-12-29 06:17:51'),
(8, 'General Manager', '2025-12-29 06:17:51', '2025-12-29 06:17:51');

-- --------------------------------------------------------

--
-- Table structure for table `estimates`
--

CREATE TABLE `estimates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `estimate_type` varchar(255) NOT NULL,
  `estimate_date` varchar(255) NOT NULL,
  `valid_upto` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `grand_total` varchar(255) DEFAULT NULL,
  `generated_by` varchar(500) DEFAULT NULL,
  `add_date` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimate_items`
--

CREATE TABLE `estimate_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `estimate_id` varchar(255) NOT NULL,
  `product_category` varchar(255) DEFAULT NULL,
  `product_name` text DEFAULT NULL,
  `warrenty` varchar(255) DEFAULT NULL,
  `unit_price` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `product_tax` varchar(255) NOT NULL DEFAULT '0',
  `total` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimate_request`
--

CREATE TABLE `estimate_request` (
  `id` int(8) NOT NULL,
  `need` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_contact` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `reference` varchar(500) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_bookings`
--

CREATE TABLE `event_bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `place` varchar(255) DEFAULT NULL,
  `whatsapp_no` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expense_name` varchar(255) NOT NULL,
  `expense_category` varchar(255) DEFAULT 'Expense',
  `add_by` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `expense_name`, `expense_category`, `add_by`, `date`, `created_at`, `updated_at`) VALUES
(1, 'WATER', 'Expense', 'ADIL', '2026-01-19 12:58:46', '2026-01-19 17:58:46', '2026-01-19 17:58:46'),
(2, 'PATHMIA RECHARGE', 'Expense', 'OFFICE ADMIN', '2026-01-20 11:01:52', '2026-01-20 16:01:52', '2026-01-20 16:01:52'),
(3, 'FREELANCE POSTER DESIGN ( MUBARAK)', 'Expense', 'OFFICE ADMIN', '2026-01-20 11:04:22', '2026-01-20 16:04:22', '2026-01-20 16:04:22'),
(4, 'STAFF SALARY DECEMBER', 'Expense', 'ADIL', '2026-02-03 11:44:55', '2026-02-03 16:44:55', '2026-02-03 16:44:55'),
(5, 'RENT', 'Expense', 'ADIL', '2026-02-03 11:46:46', '2026-02-03 16:46:46', '2026-02-03 16:46:46'),
(6, 'EXTRA WORK', 'Expense', 'ADIL', '2026-02-03 11:47:37', '2026-02-03 16:47:37', '2026-02-03 16:47:37'),
(7, 'VI PREPAID', 'Expense', 'ADIL', '2026-02-03 11:49:13', '2026-02-03 16:49:13', '2026-02-03 16:49:13'),
(8, 'OTHER EXPENSES', 'Expense', 'ADIL', '2026-02-03 11:51:17', '2026-02-03 16:51:17', '2026-02-03 16:51:17'),
(9, 'STAFF SALARY', 'Expense', 'ADIL', '2026-04-13 17:20:44', '2026-04-13 21:20:44', '2026-04-13 21:20:44'),
(10, 'COURIER CHARGE', 'Expense', 'ADIL', '2026-07-03 12:27:08', '2026-07-03 16:27:08', '2026-07-03 16:27:08');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE `fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) NOT NULL,
  `customer` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `work` text NOT NULL,
  `estimate` varchar(255) DEFAULT NULL,
  `invoice` varchar(255) DEFAULT NULL,
  `add_by` varchar(255) DEFAULT NULL,
  `invoice_add_by` varchar(255) DEFAULT NULL,
  `invoice_date` datetime DEFAULT NULL,
  `delivered_date` varchar(255) DEFAULT NULL,
  `delivered_staff` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `field_purchases`
--

CREATE TABLE `field_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `field_id` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `product` text DEFAULT NULL,
  `seller` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `bill` varchar(255) DEFAULT NULL,
  `add_by` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(500) NOT NULL,
  `group_subgroup` varchar(500) NOT NULL DEFAULT 'Parent',
  `group_status` varchar(500) NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incomes`
--

CREATE TABLE `incomes` (
  `id` int(11) NOT NULL,
  `income_name` varchar(255) NOT NULL,
  `add_by` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `incomes`
--

INSERT INTO `incomes` (`id`, `income_name`, `add_by`, `date`, `created_at`, `updated_at`) VALUES
(1, 'MEDIA', 'ADIL', '2025-12-27 14:26:04', '2025-12-27 19:26:04', '2025-12-27 19:26:04'),
(2, 'VIDEO GRAPHY', 'OFFICE ADMIN', '2026-01-03 15:27:21', '2026-01-03 20:27:21', '2026-01-03 20:27:21');

-- --------------------------------------------------------

--
-- Table structure for table `investors`
--

CREATE TABLE `investors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `balance` varchar(255) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jobcard_id` varchar(255) DEFAULT NULL,
  `sales_id` varchar(255) DEFAULT NULL,
  `is_gst` varchar(255) DEFAULT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `bill_generated` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `jobcard_id`, `sales_id`, `is_gst`, `invoice_no`, `bill_generated`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, '1', 'No', 'B2C-00001-2526', 'ADIL', 'active', '2026-01-05 23:14:52', '2026-01-05 23:14:52'),
(2, NULL, '2', 'No', 'B2C-00002-2526', 'ADIL', 'active', '2026-01-05 23:32:07', '2026-01-05 23:32:07'),
(3, NULL, '3', 'No', 'B2C-00003-2526', 'ADIL', 'active', '2026-01-05 23:46:17', '2026-01-05 23:46:17'),
(4, NULL, '4', 'No', 'B2C-00004-2526', 'ADIL', 'active', '2026-01-06 21:28:11', '2026-01-06 21:28:11'),
(5, NULL, '5', 'No', 'B2C-00005-2526', 'ADIL', 'active', '2026-01-06 23:26:27', '2026-01-06 23:26:27'),
(6, NULL, '6', 'No', 'B2C-00006-2526', 'ADIL', 'active', '2026-01-06 23:33:19', '2026-01-06 23:33:19'),
(7, NULL, '7', 'No', 'B2C-00007-2526', 'ADIL', 'active', '2026-01-06 23:34:50', '2026-01-06 23:34:50'),
(8, NULL, '8', 'No', 'B2C-00008-2526', 'ADIL', 'active', '2026-01-06 23:40:54', '2026-01-06 23:40:54'),
(9, NULL, '9', 'No', 'B2C-00009-2526', 'ADIL', 'active', '2026-01-07 01:29:06', '2026-01-07 01:29:06'),
(10, NULL, '10', 'No', 'B2C-00010-2526', 'ADIL', 'active', '2026-01-07 01:29:14', '2026-01-07 01:29:14'),
(11, NULL, '11', 'No', 'B2C-00011-2526', 'ADIL', 'active', '2026-01-07 01:35:47', '2026-01-07 01:35:47'),
(12, NULL, '12', 'No', 'B2C-00012-2526', 'ADIL', 'active', '2026-01-13 19:04:09', '2026-01-13 19:04:09'),
(13, NULL, '13', 'No', 'B2C-00013-2526', 'ADIL', 'active', '2026-01-13 19:07:49', '2026-01-13 19:07:49'),
(14, NULL, '14', 'No', 'B2C-00014-2526', 'OFFICE ADMIN', 'active', '2026-01-22 18:56:45', '2026-01-22 18:56:45'),
(15, NULL, '15', 'No', 'B2C-00015-2526', 'ADIL', 'active', '2026-02-04 22:52:20', '2026-02-04 22:52:20'),
(16, NULL, '16', 'No', 'B2C-00016-2526', 'ADIL', 'active', '2026-02-04 22:55:16', '2026-02-04 22:55:16'),
(17, NULL, '17', 'No', 'B2C-00017-2526', 'ADIL', 'active', '2026-02-07 17:58:16', '2026-02-07 17:58:16'),
(18, NULL, '18', 'No', 'B2C-00018-2526', 'ADIL', 'active', '2026-02-07 18:04:05', '2026-02-07 18:04:05'),
(19, NULL, '19', 'No', 'B2C-00019-2526', 'ADIL', 'active', '2026-02-07 18:15:49', '2026-02-07 18:15:49'),
(20, NULL, '20', 'No', 'B2C-00020-2526', 'ADIL', 'active', '2026-02-07 18:24:26', '2026-02-07 18:24:26'),
(21, NULL, '21', 'No', 'B2C-00021-2526', 'ADIL', 'active', '2026-02-20 20:47:45', '2026-02-20 20:47:45'),
(22, NULL, '22', 'No', 'B2C-00022-2526', 'ADIL', 'active', '2026-03-08 19:48:21', '2026-03-08 19:48:21'),
(23, NULL, '23', 'No', 'B2C-00023-2526', 'ADIL', 'active', '2026-03-23 19:31:18', '2026-03-23 19:31:18'),
(24, NULL, '24', 'No', 'B2C-00001-2627', 'ADIL', 'active', '2026-04-08 15:05:19', '2026-04-08 15:05:19'),
(25, NULL, '25', 'No', 'B2C-00002-2627', 'ADIL', 'active', '2026-04-08 15:08:17', '2026-04-08 15:08:17'),
(26, NULL, '26', 'No', 'B2C-00003-2627', 'ADIL', 'active', '2026-04-08 15:10:02', '2026-04-08 15:10:02'),
(27, NULL, '27', 'No', 'B2C-00004-2627', 'ADIL', 'active', '2026-04-08 15:11:50', '2026-04-08 15:11:50'),
(28, NULL, '28', 'No', 'B2C-00005-2627', 'ADIL', 'active', '2026-04-08 15:14:00', '2026-04-08 15:14:00'),
(29, NULL, '29', 'No', 'B2C-00006-2627', 'ADIL', 'active', '2026-07-03 16:28:56', '2026-07-03 16:28:56');

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int(8) NOT NULL,
  `job_title` varchar(500) NOT NULL,
  `application_date` varchar(255) NOT NULL,
  `applicant_name` varchar(500) NOT NULL,
  `applicant_gender` varchar(10) NOT NULL,
  `applicant_dob` date NOT NULL,
  `applicant_qualification` varchar(500) NOT NULL,
  `applicant_email` varchar(500) NOT NULL,
  `applicant_mobile` bigint(40) NOT NULL,
  `applicant_state` varchar(500) NOT NULL,
  `applicant_district` varchar(500) NOT NULL,
  `applicant_hometown` varchar(500) NOT NULL,
  `experience` varchar(500) DEFAULT NULL,
  `salary_expectation` varchar(500) DEFAULT NULL,
  `relocate` varchar(500) NOT NULL,
  `remarks` text DEFAULT NULL,
  `linkedin` varchar(500) DEFAULT NULL,
  `applicant_resume` varchar(500) NOT NULL,
  `status` varchar(255) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journals`
--

CREATE TABLE `journals` (
  `id` int(11) NOT NULL,
  `journal_code` varchar(500) DEFAULT NULL,
  `journal_name` varchar(500) NOT NULL,
  `journal_group` varchar(500) NOT NULL,
  `opening_balance` varchar(500) DEFAULT NULL,
  `balance` varchar(500) DEFAULT NULL,
  `contact_info` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marketings`
--

CREATE TABLE `marketings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(10) NOT NULL,
  `date` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `contact_no` varchar(255) NOT NULL,
  `job_role` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_category` varchar(255) DEFAULT NULL,
  `company_place` varchar(255) DEFAULT NULL,
  `km_to_location` int(11) DEFAULT NULL,
  `petrol_amount` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `visit` int(11) NOT NULL,
  `reply` text DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marketing_summaries`
--

CREATE TABLE `marketing_summaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `no_of_customers` int(11) NOT NULL,
  `total_fuel_amount` varchar(255) NOT NULL DEFAULT '0',
  `total_km` varchar(255) NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meta_data`
--

CREATE TABLE `meta_data` (
  `id` int(11) NOT NULL,
  `meta_key` varchar(500) NOT NULL,
  `meta_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(13, '2014_10_12_000000_create_users_table', 1),
(28, '2021_10_02_073459_create_staffs_table', 2),
(29, '2021_10_02_074840_create_employee_categories_table', 2),
(30, '2021_10_08_073622_create_product_categories_table', 2),
(31, '2021_10_29_055725_create_consignments_table', 2),
(33, '2022_02_02_062219_create_expenses_table', 2),
(36, '2022_03_03_063401_create_worktypes_table', 2),
(39, '2022_03_10_120857_create_sellers_table', 2),
(40, '2022_03_10_123255_create_purchases_table', 2),
(41, '2022_03_11_055050_create_purchase_items_table', 2),
(42, '2022_03_12_091428_create_stocks_table', 2),
(43, '2022_03_15_152634_create_sales_table', 3),
(44, '2022_03_15_085046_create_vehicles_table', 4),
(45, '2022_02_01_071926_create_daybooks_table', 5),
(49, '2022_03_10_114738_create_products_table', 6),
(51, '2022_03_29_100446_create_direct_sales_table', 7),
(53, '2022_04_01_071850_create_sales_items_table', 8),
(54, '2022_04_01_063832_create_chiplevels_table', 9),
(55, '2022_04_05_063850_create_estimates_table', 9),
(56, '2022_05_03_154447_create_warrenties_table', 10),
(58, '2022_05_23_054631_create_marketings_table', 11),
(59, '2022_04_18_072126_create_estimate_items_table', 12),
(60, '2022_05_01_194911_create_incomes_table', 13),
(61, '2022_05_03_150527_create_chiplevel_servicers_table', 14),
(62, '2022_05_27_101151_create_marketing_summaries_table', 15),
(63, '2022_06_06_100718_create_customers_table', 16),
(64, '2022_06_07_101357_create_invoices_table', 17),
(65, '2022_06_22_073339_create_daybook_summaries_table', 18),
(66, '2022_06_22_073645_create_daybook_services_table', 19),
(67, '2022_07_19_085128_create_contacts_table', 20),
(68, '2022_09_14_121639_create_meta_data_table', 21),
(69, '2022_09_27_082948_create_fields_table', 22),
(70, '2022_09_28_075835_create_field_purchases_table', 23),
(71, '2022_11_16_110010_create_salary_payments_table', 24),
(72, '2023_02_16_111250_create_journals_table', 25),
(73, '2023_02_17_095816_create_groups_table', 26),
(74, '2023_05_03_100158_create_daybook_prevs_table', 27),
(75, '2023_05_03_121622_create_daybook_prev_balances_table', 27),
(76, '2023_08_05_151451_create_purchase_orders_table', 28),
(77, '2023_08_05_151633_create_purchase_order_items_table', 29),
(78, '2023_08_17_163657_create_proforma_invoice_items_table', 29),
(79, '2023_08_17_163823_create_proforma_invoices_table', 29),
(100, '2023_12_05_124618_create_sales_return_items_table', 30),
(101, '2023_12_05_125702_create_sales_returns_table', 30),
(102, '2023_12_05_170653_create_purchase_return_items_table', 30),
(103, '2023_12_05_171351_create_purchase_returns_table', 30),
(104, '2024_03_07_153814_add_basic_salary_to_salary_payments_table', 31),
(105, '2024_03_07_154738_add_employee_code_to_staffs_table', 31),
(106, '2024_06_15_151832_add_join_date_to_staffs_table', 32),
(107, '2024_08_27_105431_add_courier_address_to_sellers_table', 33),
(108, '2024_08_27_181313_add_invoice_to_fields', 34),
(109, '2024_08_28_170657_add_courier_delivery_and_courier_bill_to_chiplevels_table', 35),
(110, '2024_08_28_171041_add_courier_delivery_and_courier_bill_to_warrenties_table', 35),
(111, '2024_09_02_163121_create_consoulidates_table', 36),
(112, '2024_09_10_095705_add_add_by_to_fields', 37),
(113, '2024_09_17_155006_add_add_by_to_consignments_table', 38),
(114, '2024_09_18_131431_create_consignment_assessments_table', 39),
(115, '2024_09_19_161545_add_informed_and_approved_columns_to_consignments_table', 39),
(116, '2024_09_24_115343_add_date_and_time_to_consignment_assessments_table', 40),
(117, '2024_10_01_121548_add_return_fields_to_consignments_table', 41),
(118, '2024_10_04_121159_add_delivered_staff_and_delivered_date_to_consignments_table', 42),
(119, '2024_10_04_150138_add_add_by_and_add_date_to_field_purchases_table', 43),
(120, '2024_10_04_160730_add_invoice_add_by_and_invoice_date_to_fields_table', 44),
(121, '2024_10_10_112822_add_add_by_and_date_to_sales_table', 45),
(122, '2024_10_10_122820_add_add_by_and_date_to_products_table', 46),
(123, '2024_10_10_134307_add_add_by_and_date_to_purchases_table', 47),
(124, '2024_10_10_160429_add_add_by_and_date_to_purchase_returns_table', 48),
(125, '2024_10_10_162259_add_add_by_and_date_to_sales_returns_table', 49),
(126, '2024_10_10_165623_add_add_by_and_date_to_incomes_table', 50),
(127, '2024_10_10_174323_add_add_by_and_date_to_expenses_table', 51),
(128, '2024_10_11_103744_add_add_by_and_add_date_to_daybooks_table', 52),
(129, '2024_10_11_153041_add_add_by_and_add_date_to_vehicles_table', 53),
(130, '2024_10_11_154718_add_add_date_to_estimates_table', 54),
(131, '2024_10_11_160815_add_add_date_to_purchase_orders_table', 55),
(132, '2024_10_11_162809_add_add_date_and_generated_by_to_proforma_invoices_table', 56),
(133, '2024_10_11_164553_add_add_date_and_generated_by_to_customers_table', 57),
(134, '2024_10_14_110909_create_utility_logs_table', 58),
(135, '2024_10_14_124932_add_rejected_columns_to_consignments_table', 59),
(136, '2025_03_15_115041_create_investors_table', 60),
(137, '2025_04_30_133920_create_banks_table', 61),
(138, '2025_12_02_163945_create_projects_table', 62),
(139, '2025_12_02_172544_create_news_events_table', 63);

-- --------------------------------------------------------

--
-- Table structure for table `news_events`
--

CREATE TABLE `news_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `hsn_code` varchar(255) DEFAULT NULL,
  `product_price` varchar(255) DEFAULT NULL,
  `product_selling_price` varchar(255) DEFAULT NULL,
  `product_mrp` varchar(255) DEFAULT NULL,
  `product_description` varchar(255) DEFAULT NULL,
  `product_unit_details` varchar(255) DEFAULT NULL,
  `product_schedule` varchar(255) DEFAULT NULL,
  `product_tax_percent` varchar(255) DEFAULT NULL,
  `product_cgst` varchar(255) DEFAULT NULL,
  `product_sgst` varchar(255) DEFAULT NULL,
  `product_igst` varchar(255) DEFAULT NULL,
  `product_warrenty` varchar(255) DEFAULT NULL,
  `product_max_stock` int(11) NOT NULL DEFAULT 0,
  `product_batch` varchar(255) DEFAULT NULL,
  `product_expiry_date` varchar(255) DEFAULT NULL,
  `product_supplier` varchar(255) DEFAULT NULL,
  `product_company` varchar(255) DEFAULT NULL,
  `product_brand` varchar(255) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `add_by` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `product_status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `product_code`, `product_name`, `hsn_code`, `product_price`, `product_selling_price`, `product_mrp`, `product_description`, `product_unit_details`, `product_schedule`, `product_tax_percent`, `product_cgst`, `product_sgst`, `product_igst`, `product_warrenty`, `product_max_stock`, `product_batch`, `product_expiry_date`, `product_supplier`, `product_company`, `product_brand`, `product_image`, `add_by`, `date`, `product_status`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'POSTER DESIGN', '49111010', '350', NULL, NULL, NULL, NULL, 'SCHEDULE 5', NULL, '9', '9', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'developer', '2025-12-31 13:17:25', 'active', '2025-12-31 18:17:25', '2025-12-31 18:17:25'),
(2, 3, NULL, 'BINSI & IMAM LIVE CONCERT ADVANCE', '999621', '10000', NULL, NULL, NULL, NULL, 'SCHEDULE 5', NULL, '9', '9', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'ADIL', '2026-01-04 22:31:10', 'active', '2026-01-05 03:31:10', '2026-01-05 03:31:10'),
(3, 4, NULL, 'DIGITAL MARKETTING', '998361', '7000', NULL, NULL, NULL, NULL, 'SCHEDULE 5', NULL, '9', '9', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'ADIL', '2026-01-04 22:32:08', 'active', '2026-01-05 03:32:08', '2026-01-05 03:32:08'),
(4, 2, NULL, 'VIDEO PRODUCTION', '999612', '2000', NULL, NULL, NULL, NULL, 'SCHEDULE 5', NULL, '9', '9', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'ADIL', '2026-01-04 22:33:03', 'active', '2026-01-05 03:33:03', '2026-01-05 03:33:03'),
(5, 4, NULL, 'PERSONAL BRANDING', '998398', '20000', NULL, NULL, NULL, NULL, 'SCHEDULE 5', NULL, '9', '9', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'ADIL', '2026-01-04 22:34:12', 'active', '2026-01-05 03:34:12', '2026-01-05 03:34:12'),
(6, 4, NULL, 'AD SPEND', '998361', '1000', NULL, NULL, NULL, NULL, 'SCHEDULE 5', NULL, '9', '9', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'OFFICE ADMIN', '2026-01-05 17:02:33', 'active', '2026-01-05 22:02:33', '2026-01-05 22:02:33'),
(7, 2, NULL, 'MOTION GRAPHICS', '999613', '2000', NULL, NULL, NULL, NULL, 'SCHEDULE 5', NULL, '9', '9', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'ADIL', '2026-01-06 16:24:55', 'active', '2026-01-06 21:24:55', '2026-01-06 21:24:55'),
(8, 4, NULL, 'DIGITAL MARKETTING PACKAGE', '998361', '10000', NULL, NULL, NULL, NULL, 'SCHEDULE 5', NULL, '9', '9', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'ADIL', '2026-01-06 18:30:49', 'active', '2026-01-06 23:30:49', '2026-01-06 23:30:49'),
(9, 4, NULL, 'DIGITAL MARKETTING PLAN', '998361', '10000', NULL, NULL, NULL, NULL, 'SCHEDULE 5', NULL, '9', '9', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'ADIL', '2026-01-06 18:31:25', 'active', '2026-01-06 23:31:25', '2026-01-06 23:31:25'),
(10, 2, NULL, 'LOGO DESIGN', '998392', '500', NULL, NULL, NULL, NULL, 'SCHEDULE 5', NULL, '9', '9', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'ADIL', '2026-01-13 14:01:50', 'active', '2026-01-13 19:01:50', '2026-01-13 19:01:50'),
(11, 4, NULL, 'AD SPEND - DECEMBER', '99836', '1000', NULL, NULL, NULL, NULL, 'SCHEDULE 5', NULL, '9', '9', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'ADIL', '2026-02-04 17:43:28', 'active', '2026-02-04 22:43:28', '2026-02-04 22:43:28'),
(12, 4, NULL, 'AD SPEND - JANUARY', '99836', '1000', NULL, NULL, NULL, NULL, 'SCHEDULE 5', NULL, '9', '9', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'ADIL', '2026-02-04 17:43:52', 'active', '2026-02-04 22:43:52', '2026-02-04 22:43:52'),
(13, 3, NULL, 'LIVE STREAMING', '998433', '10000', NULL, NULL, NULL, NULL, 'SCHEDULE 5', NULL, '9', '9', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'ADIL', '2026-02-12 16:03:45', 'active', '2026-02-12 21:03:45', '2026-02-12 21:03:45'),
(14, 2, NULL, 'GIMBAL RENT', '997319', '1000', NULL, NULL, NULL, NULL, 'SCHEDULE 5', NULL, '9', '9', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'ADIL', '2026-02-20 15:39:53', 'active', '2026-02-20 20:39:53', '2026-02-20 20:39:53'),
(15, 3, NULL, 'BINSI IMAM LIVE CONCERT', '999621', '75000', NULL, NULL, NULL, NULL, 'SCHEDULE 5', NULL, '9', '9', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'ADIL', '2026-02-25 13:46:16', 'active', '2026-02-25 18:46:16', '2026-02-25 18:46:16'),
(16, 5, NULL, 'PMA GAFOOR SESSION ADVANCE', '999293', '10000', NULL, NULL, NULL, NULL, 'SCHEDULE 5', NULL, '9', '9', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'ADIL', '2026-02-27 13:58:33', 'active', '2026-02-27 18:58:33', '2026-02-27 18:58:33'),
(17, 2, NULL, 'SOCIAL MEDIA HANDLING', '998361', '3500', NULL, NULL, NULL, NULL, 'SCHEDULE 5', NULL, '9', '9', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'ADIL', '2026-03-08 15:44:51', 'active', '2026-03-08 19:44:51', '2026-03-08 19:44:51');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'MEDIOA PRODUCTION.', '2025-12-27 19:20:13', '2025-12-27 19:20:13'),
(2, 'MEDIA PRODUCTION', '2025-12-31 18:11:07', '2025-12-31 18:11:07'),
(3, 'EVENT', '2025-12-31 18:33:51', '2025-12-31 18:33:51'),
(4, 'BRANDING', '2026-01-03 20:16:20', '2026-01-03 20:16:20'),
(5, 'SESSION', '2026-02-27 18:58:27', '2026-02-27 18:58:27');

-- --------------------------------------------------------

--
-- Table structure for table `proforma_invoices`
--

CREATE TABLE `proforma_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `invoice_date` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `gst_available` varchar(255) DEFAULT NULL,
  `gst_number` varchar(255) DEFAULT NULL,
  `grand_total` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `generated_by` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `proforma_invoices`
--

INSERT INTO `proforma_invoices` (`id`, `invoice_number`, `invoice_date`, `customer_name`, `customer_phone`, `gst_available`, `gst_number`, `grand_total`, `add_date`, `generated_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'H0065', '2025-12-23', '1', '9048156633', 'No', NULL, '75000.00', '2025-12-23 19:11:46', 'ADIL', 'active', NULL, NULL),
(2, 'H066', '2025-12-27', '2', NULL, 'No', NULL, '5800.00', '2025-12-27 13:05:39', 'ADIL', 'active', NULL, NULL),
(3, 'H065', '2025-12-27', '3', NULL, 'No', NULL, '6800.00', '2025-12-27 13:10:18', 'ADIL', 'active', NULL, NULL),
(4, 'H0067', '2025-12-31', '1', NULL, 'No', NULL, '10000.00', '2025-12-31 12:20:12', 'ADIL', 'active', NULL, NULL),
(5, 'H0067', '2025-12-31', '4', '9544526675', 'No', NULL, '10000.00', '2025-12-31 12:24:47', 'ADIL', 'active', NULL, NULL),
(6, 'H0067', '2025-12-31', '4', '9544526675', 'No', NULL, '10000.00', '2025-12-31 13:10:15', 'ADIL', 'active', NULL, NULL),
(7, 'H0067', '2025-12-31', '4', '9544526675', 'No', NULL, '10000.00', '2025-12-31 13:37:45', 'ADIL', 'active', NULL, NULL),
(8, 'H0067', '2025-12-31', '4', '9544526675', 'No', NULL, '10000.00', '2025-12-31 13:39:18', 'ADIL', 'active', NULL, NULL),
(9, 'H0068', '2025-12-31', '6', '9846666648', 'No', NULL, '10000.00', '2025-12-31 19:36:54', 'ADIL', 'active', NULL, NULL),
(10, 'H0068', '2025-12-31', '6', '9846666648', 'No', NULL, '10000.00', '2025-12-31 19:41:44', 'ADIL', 'active', NULL, NULL),
(11, 'H0661', '2026-01-03', '7', '7025863004', 'No', NULL, '20000.00', '2026-01-03 15:25:11', 'OFFICE ADMIN', 'active', NULL, NULL),
(12, 'H0068', '2026-01-08', '18', '8921451054', 'No', NULL, '33000.00', '2026-01-08 12:33:25', 'ADIL', 'active', NULL, NULL),
(13, 'H0068', '2026-01-08', '18', NULL, 'No', NULL, '33000.00', '2026-01-08 12:35:16', 'ADIL', 'active', NULL, NULL),
(14, 'H068', '2026-01-08', '18', NULL, 'No', NULL, '33000.00', '2026-01-08 12:37:28', 'ADIL', 'active', NULL, NULL),
(15, 'H069', '2026-01-08', '18', NULL, 'No', NULL, '77000.00', '2026-01-08 12:39:54', 'ADIL', 'active', NULL, NULL),
(16, 'H066', '2026-01-12', '2', NULL, 'No', NULL, '5800.00', '2026-01-12 12:52:58', 'ADIL', 'active', NULL, NULL),
(17, 'H065', '2026-01-12', '3', NULL, 'No', NULL, '6800.00', '2026-01-12 12:54:16', 'ADIL', 'active', NULL, NULL),
(18, 'H0070', '2026-01-12', '13', NULL, 'No', NULL, '84190.00', '2026-01-12 14:40:48', 'ADIL', 'active', NULL, NULL),
(19, 'H0070', '2026-01-12', '13', '8848337393', 'No', NULL, '84190.00', '2026-01-12 14:52:53', 'ADIL', 'active', NULL, NULL),
(20, 'H071', '2026-01-12', '13', '88448337393', 'No', NULL, '22000.00', '2026-01-12 15:31:58', 'ADIL', 'active', NULL, NULL),
(21, 'H0073', '2026-01-14', '13', '8848337393', 'No', NULL, '160643.00', '2026-01-14 17:10:25', 'ADIL', 'active', NULL, NULL),
(22, 'H0073', '2026-01-15', '21', '919947195204', 'No', NULL, '15000.00', '2026-01-15 10:56:59', 'OFFICE ADMIN', 'active', NULL, NULL),
(23, 'H0074', '2026-01-16', '22', '9072930567', 'No', NULL, '10000.00', '2026-01-16 10:25:49', 'OFFICE ADMIN', 'active', NULL, NULL),
(24, 'HOO75', '2026-01-19', '23', '8156947066', 'No', NULL, '10000.00', '2026-01-19 13:35:50', 'OFFICE ADMIN', 'active', NULL, NULL),
(25, 'HOO76', '2026-01-19', '24', '9037587117', 'No', NULL, '8000.00', '2026-01-19 13:50:04', 'OFFICE ADMIN', 'active', NULL, NULL),
(26, 'H0077', '2026-01-19', '23', '8156947066', 'No', NULL, '10000.00', '2026-01-19 14:01:13', 'OFFICE ADMIN', 'active', NULL, NULL),
(27, 'H0078', '2026-01-20', '26', '8714263757', 'No', NULL, '15000.00', '2026-01-20 11:35:49', 'OFFICE ADMIN', 'active', NULL, NULL),
(28, 'HOO79', '2026-01-20', '25', NULL, 'No', NULL, '3000.00', '2026-01-20 11:39:58', 'OFFICE ADMIN', 'active', NULL, NULL),
(29, 'H0080', '2026-02-07', '27', '9061853090', 'No', NULL, '10000.00', '2026-02-07 12:15:12', 'ADIL', 'active', NULL, NULL),
(30, 'H081', '2026-02-07', '28', '9645212073', 'No', NULL, '10000.00', '2026-02-07 12:16:48', 'ADIL', 'active', NULL, NULL),
(31, 'H0083', '2026-02-12', '29', '7907462845', 'No', NULL, '10000.00', '2026-02-12 16:05:10', 'ADIL', 'active', NULL, NULL),
(32, 'H0084', '2026-02-20', '31', '7012572769', 'No', NULL, '15000.00', '2026-02-20 14:50:07', 'ADIL', 'active', NULL, NULL),
(33, 'H0085', '2026-02-22', '14', '7909100110', 'No', NULL, '41200.00', '2026-02-22 16:13:25', 'ADIL', 'active', NULL, NULL),
(34, 'H0086', '2026-02-25', '32', '9072930567', 'No', NULL, '85000.00', '2026-02-25 13:54:38', 'ADIL', 'active', NULL, NULL),
(35, 'H00086', '2026-02-27', '33', '9207787266', 'No', NULL, '10000.00', '2026-02-27 14:00:39', 'ADIL', 'active', NULL, NULL),
(36, 'H0087', '2026-02-27', '34', '9947650767', 'No', NULL, '10000.00', '2026-02-27 16:34:16', 'ADIL', 'active', NULL, NULL),
(37, 'H0087', '2026-02-28', '35', '8289962616', 'No', NULL, '5000.00', '2026-02-28 14:32:01', 'ADIL', 'active', NULL, NULL),
(38, 'H0085', '2026-03-03', '16', NULL, 'No', NULL, '12000.00', '2026-03-03 14:24:44', 'ADIL', 'active', NULL, NULL),
(39, 'H0090', '2026-03-14', '36', '9645137588', 'No', NULL, '15000.00', '2026-03-14 08:58:37', 'ADIL', 'active', NULL, NULL),
(40, 'H0090', '2026-03-14', '38', '8129461113', 'No', NULL, '20000.00', '2026-03-14 14:25:02', 'ADIL', 'active', NULL, NULL),
(41, 'H0093', '2026-03-16', '39', '7902606066', 'No', NULL, '3450.00', '2026-03-16 14:12:41', 'ADIL', 'active', NULL, NULL),
(42, 'H0096', '2026-03-16', '15', NULL, 'No', NULL, '7000.00', '2026-03-16 15:33:40', 'ADIL', 'active', NULL, NULL),
(43, 'H0096', '2026-03-16', '40', NULL, 'No', NULL, '5000.00', '2026-03-16 15:37:35', 'ADIL', 'active', NULL, NULL),
(44, 'H0095', '2026-03-27', '35', '918289962616', 'No', NULL, '85000.00', '2026-03-27 19:55:32', 'ADIL', 'active', NULL, NULL),
(45, 'H0097', '2026-04-03', '42', '9446096666', 'No', NULL, '340250.00', '2026-04-03 16:24:04', 'OFFICE ADMIN', 'active', NULL, NULL),
(46, 'HOO97', '2026-04-03', '42', '9446096666', 'No', NULL, '340250.00', '2026-04-03 17:05:47', 'OFFICE ADMIN', 'active', NULL, NULL),
(47, 'H0100', '2026-04-04', '9', NULL, 'No', NULL, '5250.00', '2026-04-04 14:15:34', 'ADIL', 'active', NULL, NULL),
(48, 'H0101', '2026-04-13', '47', '8089502467', 'No', NULL, '15000.00', '2026-04-13 17:26:10', 'ADIL', 'active', NULL, NULL),
(49, 'H0102', '2026-04-18', '48', '9746447338', 'No', NULL, '1300.00', '2026-04-18 12:13:27', 'OFFICE ADMIN', 'active', NULL, NULL),
(50, 'H0100', '2026-04-24', '16', NULL, 'No', NULL, '18700.00', '2026-04-24 18:44:51', 'ADIL', 'active', NULL, NULL),
(51, 'H0106', '2026-05-01', '9', NULL, 'No', NULL, '9800.00', '2026-05-01 23:24:47', 'ADIL', 'active', NULL, NULL),
(52, 'H0107', '2026-05-02', '51', '8547867379', 'No', NULL, '1750.00', '2026-05-02 16:21:44', 'OFFICE ADMIN', 'active', NULL, NULL),
(53, 'H0107', '2026-05-02', '52', '8547867379', 'No', NULL, '1750.00', '2026-05-02 16:29:30', 'OFFICE ADMIN', 'active', NULL, NULL),
(54, 'H0108', '2026-05-08', '44', NULL, 'No', NULL, '11200.00', '2026-05-08 16:14:10', 'OFFICE ADMIN', 'active', NULL, NULL),
(55, 'H0109', '2026-05-08', '45', NULL, 'No', NULL, '8000.00', '2026-05-08 16:16:32', 'OFFICE ADMIN', 'active', NULL, NULL),
(56, 'H0109', '2026-05-08', '45', NULL, 'No', NULL, '8000.00', '2026-05-08 16:19:32', 'OFFICE ADMIN', 'active', NULL, NULL),
(57, 'HO1O8', '2026-05-08', '44', NULL, 'No', NULL, '11200.00', '2026-05-08 16:21:37', 'OFFICE ADMIN', 'active', NULL, NULL),
(58, 'H0110', '2026-05-08', '46', NULL, 'No', NULL, '11200.00', '2026-05-08 16:23:55', 'OFFICE ADMIN', 'active', NULL, NULL),
(59, 'H0111', '2026-05-08', '15', NULL, 'No', NULL, '500.00', '2026-05-08 16:27:06', 'OFFICE ADMIN', 'active', NULL, NULL),
(60, 'H0112', '2026-05-08', '53', NULL, 'No', NULL, '14000.00', '2026-05-08 16:31:01', 'OFFICE ADMIN', 'active', NULL, NULL),
(61, 'HO113', '2026-05-08', '54', NULL, 'No', NULL, '15000.00', '2026-05-08 16:40:32', 'OFFICE ADMIN', 'active', NULL, NULL),
(62, 'HO114', '2026-05-08', '16', NULL, 'No', NULL, '36700.00', '2026-05-08 16:54:00', 'OFFICE ADMIN', 'active', NULL, NULL),
(63, 'H00105', '2026-05-31', '55', '7025361678', 'No', NULL, '159020.00', '2026-05-31 16:28:47', 'ADIL', 'active', NULL, NULL),
(64, 'H0116', '2026-06-01', '46', NULL, 'No', NULL, '10800.00', '2026-06-01 18:12:30', 'ADIL', 'active', NULL, NULL),
(65, 'H0117', '2026-06-01', '15', NULL, 'No', NULL, '600.00', '2026-06-01 18:13:38', 'ADIL', 'active', NULL, NULL),
(66, 'H0118', '2026-06-01', '44', NULL, 'No', NULL, '12800.00', '2026-06-01 18:15:14', 'ADIL', 'active', NULL, NULL),
(67, 'H0119', '2026-06-01', '45', NULL, 'No', NULL, '7000.00', '2026-06-01 18:16:11', 'ADIL', 'active', NULL, NULL),
(68, 'H0120', '2026-06-01', '53', NULL, 'No', NULL, '14000.00', '2026-06-01 18:17:29', 'ADIL', 'active', NULL, NULL),
(69, 'H0121', '2026-06-01', '56', NULL, 'No', NULL, '14000.00', '2026-06-01 18:19:53', 'ADIL', 'active', NULL, NULL),
(70, 'H0122', '2026-06-01', '57', NULL, 'No', NULL, '10000.00', '2026-06-01 18:21:20', 'ADIL', 'active', NULL, NULL),
(71, 'H0123', '2026-06-02', '59', '9746910694', 'No', NULL, '900.00', '2026-06-02 10:54:06', 'ADIL', 'active', NULL, NULL),
(72, 'H0124', '2026-06-02', '60', '7306908633', 'No', NULL, '300.00', '2026-06-02 10:55:04', 'ADIL', 'active', NULL, NULL),
(73, 'H0124', '2026-06-02', '62', NULL, 'No', NULL, '300.00', '2026-06-02 10:56:58', 'ADIL', 'active', NULL, NULL),
(74, 'H0125', '2026-06-02', '58', '9846223757', 'No', NULL, '3600.00', '2026-06-02 10:58:20', 'ADIL', 'active', NULL, NULL),
(75, 'H0126', '2026-06-02', '9', NULL, 'No', NULL, '7700.00', '2026-06-02 10:59:17', 'ADIL', 'active', NULL, NULL),
(76, 'H0127', '2026-06-02', '51', NULL, 'No', NULL, '700.00', '2026-06-02 11:00:00', 'ADIL', 'active', NULL, NULL),
(77, 'H0128', '2026-06-02', '63', '7025580007', 'No', NULL, '10000.00', '2026-06-02 12:44:17', 'ADIL', 'active', NULL, NULL),
(78, 'H0129', '2026-06-03', '63', '7025580007', 'No', NULL, '10000.00', '2026-06-03 13:57:17', 'ADIL', 'active', NULL, NULL),
(79, 'H0130', '2026-06-13', '58', NULL, 'No', NULL, '4800.00', '2026-06-13 11:24:56', 'ADIL', 'active', NULL, NULL),
(80, 'H0131', '2026-06-13', '64', NULL, 'No', NULL, '1500.00', '2026-06-13 11:28:21', 'ADIL', 'active', NULL, NULL),
(81, 'H0132', '2026-06-15', '65', '9995415419', 'No', NULL, '6900.00', '2026-06-15 13:53:02', 'ADIL', 'active', NULL, NULL),
(82, 'H0133', '2026-06-17', '65', NULL, 'No', NULL, '3600.00', '2026-06-17 10:45:11', 'ADIL', 'active', NULL, NULL),
(83, 'H0134', '2026-06-17', '66', '9526989842', 'No', NULL, '5860.00', '2026-06-17 17:31:48', 'ADIL', 'active', NULL, NULL),
(84, 'H0135', '2026-06-23', '65', '9995415419', 'No', NULL, '13700.00', '2026-06-23 15:30:53', 'ADIL', 'active', NULL, NULL),
(85, 'H0136', '2026-06-30', '16', '9846124030', 'No', NULL, '13600.00', '2026-06-30 13:28:27', 'ADIL', 'active', NULL, NULL),
(86, 'H0137', '2026-07-02', '56', NULL, 'No', NULL, '14000.00', '2026-07-02 15:43:39', 'ADIL', 'active', NULL, NULL),
(87, 'H0138', '2026-07-02', '53', NULL, 'No', NULL, '14000.00', '2026-07-02 15:45:06', 'ADIL', 'active', NULL, NULL),
(88, 'H0139', '2026-07-02', '68', NULL, 'No', NULL, '5000.00', '2026-07-02 15:46:08', 'ADIL', 'active', NULL, NULL),
(89, 'H0140', '2026-07-03', '69', '8606302302', 'No', NULL, '16550.00', '2026-07-03 12:15:59', 'ADIL', 'active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `proforma_invoice_items`
--

CREATE TABLE `proforma_invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Proforma_id` varchar(255) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `warrenty` varchar(255) DEFAULT NULL,
  `unit_price` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `product_tax` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `proforma_invoice_items`
--

INSERT INTO `proforma_invoice_items` (`id`, `Proforma_id`, `product_name`, `description`, `warrenty`, `unit_price`, `qty`, `product_tax`, `total`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', 'SAMEER BINSI CONCERT ADVANCE PAYMENT ( 15-12-2025 )', NULL, NULL, '25000', '1', '0', '25000.00', 'active', NULL, NULL),
(2, '1', 'SAMEER BINSI CONCERT BALANCE  PAYMENT ( 15-12-2025 )', NULL, NULL, '50000', '1', '0', '50000.00', 'active', NULL, NULL),
(3, '2', 'THUSHARA GIFT COUPEN ( 15000 NOS )', NULL, NULL, '5800', '1', '0', '5800.00', 'active', NULL, NULL),
(4, '3', 'THUSHARA NOTICE PRINTING ( 4500 COPY )', NULL, NULL, '6800', '1', '0', '6800.00', 'active', NULL, NULL),
(5, '4', 'SAMEER BINSI LIVE CONCERT - JAN 25 ( ADVANCE AMOUNT)', 'BALANCE 70000 ( INCLUDING TA )', NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(6, '5', 'SAMEER BINSI LIVE CONCERT - JAN 25 @ CALICUT ADVANCE AMOUNT', NULL, NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(7, '6', 'BINSI & IMAM LIVE CONCERT - ADVANCE', 'DATE - JAN 25 , PLACE - ASPINCOURTYARD, BALANCE AMOUNT 70000 ( INCLUDE TA )', NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(8, '7', 'BINSI & IMAM LIVE CONCERT ADVANCE', 'BALANCE 70000 ( INCLUDE TA ), EVENT DATE - 26-01-2026, LOCATION - ASPIN COURTYARD CALICUT', NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(9, '8', 'BINSI & IMAM LIVE CONCERT ADVANCE', 'BALANCE 70000 ( INCLUDE TA ), EVENT DATE - 25-01-2026, LOCATION - ASPIN COURTYARD CALICUT', NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(10, '9', 'BINSI & IMAM CONCERT ADVANCE', 'BALANCE 7000 ( INCLUDE TA ), EVENT DATE 01-01-2026, PLACE - THIRUVEGAPPURA', NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(11, '10', 'BINSI & IMAM CONCERT ADVANCE', 'BALANCE 70000 ( INCLUDE TA ), EVENT DATE 01-01-2026, PLACE - THIRUVEGAPPURA', NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(12, '11', 'BINSI & IMAM CONCERT ADVANCE', 'BALANCE 50000 ( INCLUDE TA ) , DATE JAN 26 , PLACE KOZHIKKOD', NULL, '20000', '1', '0', '20000.00', 'active', NULL, NULL),
(13, '12', '2', 'BALANCE 77000/- , EVENT DATE - 2026 JANUARY 08 , PLACE - THRITHALA', NULL, '33000', '1', '0', '33000.00', 'active', NULL, NULL),
(14, '13', '2', 'ADVANCE PAID ON 20-12-2025 , BALANCE 77000/- , EVENT DATE - 2026 JANUARY 08 , PLACE - THRITHALA', NULL, '33000', '1', '0', '33000.00', 'active', NULL, NULL),
(15, '14', 'BINSI & IMAM LIVE CONCERT ADVANCE', 'ADVANCE PAID ON 20-12-2025 , BALANCE 77000/- , EVENT DATE - 2026 JANUARY 08 , PLACE - THRITHALA', NULL, '33000', '1', '0', '33000.00', 'active', NULL, NULL),
(16, '15', 'BINSI & IMAM JAN 08 CONCERT BALANCE', 'TOTAL - 110000/- , ADVANCE 33000 PAID ON 20-12-2025', NULL, '77000', '1', '0', '77000.00', 'active', NULL, NULL),
(17, '16', 'THUSHARA GIFT COUPEN ( 1500 NOS )', NULL, NULL, '5800', '1', '0', '5800.00', 'active', NULL, NULL),
(18, '17', 'THUSHARA NOTICE PRINTING', '4500 COPY', NULL, '6800', '1', '0', '6800.00', 'active', NULL, NULL),
(19, '18', 'FRAME WITH PRINT', '51 + 14 + 13', NULL, '105', '78', '0', '8190.00', 'active', NULL, NULL),
(20, '18', 'FRAME ONLY', '51 + 16 + 2', NULL, '90', '69', '0', '6210.00', 'active', NULL, NULL),
(21, '18', 'LED WALL ( 120 SQFT)', 'CABLLING CHAREGE - 2000', NULL, '16000', '1', '0', '16000.00', 'active', NULL, NULL),
(22, '18', 'new product', NULL, NULL, '0', '1', '0', '0', 'active', NULL, NULL),
(23, '18', 'VIDEO RECORDING', '3 HD VIDEO CAMERA + SPOT MIXING', NULL, '5500', '3', '0', '16500.00', 'active', NULL, NULL),
(24, '18', 'HIGHLIGHT VIDEO', '3 REELS + FULL DAY HIGH LIGHT', NULL, '13500', '1', '0', '13500.00', 'active', NULL, NULL),
(25, '18', 'STILL PHOTO', 'SPOT EDITING AND TAGING', NULL, '6000', '1', '0', '6000.00', 'active', NULL, NULL),
(26, '18', 'HYPNOTIST TAG PRINT', '14 NOS', NULL, '110', '14', '0', '1540.00', 'active', NULL, NULL),
(27, '18', 'MOMENTO', 'GUEST AND PATRON', NULL, '210', '12', '0', '2520.00', 'active', NULL, NULL),
(28, '18', 'POSTER DESIGNING', '33 NOS', NULL, '7830', '1', '0', '7830.00', 'active', NULL, NULL),
(29, '18', '6*3 BANNER', 'CERTIFIED HYPNOTIST', NULL, '450', '1', '0', '450.00', 'active', NULL, NULL),
(30, '18', '8*4 BANNER', 'WW BR MEMBERS', NULL, '800', '1', '0', '800.00', 'active', NULL, NULL),
(31, '18', 'TAG PRINTING', 'PARTICIPATES AND GUEST TAG ( 13 SHEET)', NULL, '50', '13', '0', '650.00', 'active', NULL, NULL),
(32, '18', 'EVENT HOSTING', '4 VOLUNTEERS', NULL, '1000', '4', '0', '4000.00', 'active', NULL, NULL),
(33, '19', 'FRAME WITH PRINT', '51 + 14 + 13', NULL, '105', '78', '0', '8190.00', 'active', NULL, NULL),
(34, '19', 'FRAME ONLY', '51 + 16 + 2', NULL, '90', '69', '0', '6210.00', 'active', NULL, NULL),
(35, '19', 'LED WALL ( 120 SQFT)', 'CABLLING CHAREGE - 2000', NULL, '16000', '1', '0', '16000.00', 'active', NULL, NULL),
(36, '19', 'VIDEO RECORDING', '3 HD VIDEO CAMERA + SPOT MIXING', NULL, '5500', '3', '0', '16500.00', 'active', NULL, NULL),
(37, '19', 'HIGHLIGHT VIDEO', '3 REELS + FULL DAY HIGH LIGHT', NULL, '13500', '1', '0', '13500.00', 'active', NULL, NULL),
(38, '19', 'STILL PHOTO', 'SPOT EDITING AND TAGING', NULL, '6000', '1', '0', '6000.00', 'active', NULL, NULL),
(39, '19', 'HYPNOTIST TAG PRINT', '14 NOS', NULL, '110', '14', '0', '1540.00', 'active', NULL, NULL),
(40, '19', 'MOMENTO', 'GUEST AND PATRON', NULL, '210', '12', '0', '2520.00', 'active', NULL, NULL),
(41, '19', 'POSTER DESIGNING', '33 NOS', NULL, '7830', '1', '0', '7830.00', 'active', NULL, NULL),
(42, '19', '6*3 BANNER', 'CERTIFIED HYPNOTIST', NULL, '450', '1', '0', '450.00', 'active', NULL, NULL),
(43, '19', '8*4 BANNER', 'WWBR MEMBERS', NULL, '800', '1', '0', '800.00', 'active', NULL, NULL),
(44, '19', 'TAG PRINTING', 'PARTICIPATES AND GUEST TAG ( 13 SHEET)', NULL, '50', '13', '0', '650.00', 'active', NULL, NULL),
(45, '19', 'EVENT HOSTING', '4 PERSON', NULL, '1000', '4', '0', '4000.00', 'active', NULL, NULL),
(46, '20', 'VIDEO PRODUCTION', 'WORLDWIDE BOOK OF RECORD', NULL, '500', '28', '0', '14000.00', 'active', NULL, NULL),
(47, '20', '4', 'CERTIFIED HYPNOTIST', NULL, '500', '11', '0', '5500.00', 'active', NULL, NULL),
(48, '20', 'VIDEO PRODUCTION', 'MENTALISM SHOW', NULL, '500', '5', '0', '2500.00', 'active', NULL, NULL),
(49, '21', 'FRAMES', '147 FRAMES', NULL, '14400', '1', '0', '14400.00', 'active', NULL, NULL),
(50, '21', 'LED WALL ( 120 SQFT )', NULL, NULL, '16000', '1', '0', '16000.00', 'active', NULL, NULL),
(51, '21', 'CAMERA RECORDING & STILL', NULL, NULL, '36000', '1', '0', '36000.00', 'active', NULL, NULL),
(52, '21', 'TAG PRITNING & MOMENTO', NULL, NULL, '4710', '1', '0', '4710.00', 'active', NULL, NULL),
(53, '21', 'DESIGNING & PRINTINMG', NULL, NULL, '9080', '1', '0', '9080.00', 'active', NULL, NULL),
(54, '21', 'GUEST AMOUNT', '10k ,6k ,3k', NULL, '19000', '1', '0', '19000.00', 'active', NULL, NULL),
(55, '21', 'FOOD', 'LUNCH & DINNER', NULL, '4953', '1', '0', '4953.00', 'active', NULL, NULL),
(56, '21', 'CASH PRICE', '1000+ 500', NULL, '1500', '1', '0', '1500.00', 'active', NULL, NULL),
(57, '21', 'KING FORT', 'HALL RENT', NULL, '55000', '1', '0', '55000.00', 'active', NULL, NULL),
(58, '22', '2', 'BALANCE AMOUNT 60000/-, DATE : 16/01/26, PLACE : NADAPURAM', NULL, '15000', '1', '0', '15000.00', 'active', NULL, NULL),
(59, '23', '2', '[ BALANCE AMOUNT 63000/-, DATE : 11/02/26, PLACE : PERINTHALMANNA ]', NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(60, '24', '2', 'BALANCE AMOUNT  70000/-, DATE: 08/01/2026 ,PLACE-MANNARKADU', NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(61, '25', '2', 'BALANCE- 62000, DATE :22/01/26, PLACE: MUKKAM', NULL, '8000', '1', '0', '8000.00', 'active', NULL, NULL),
(62, '26', '2', 'BALANCE AMOUNT 70000/-, DATE: 08/02/26 , PLACE-MANNARKADU', NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(63, '27', '2', 'BALANCE AMOUNT 60000/-, DATE: 28/03/26 , TIME: 7 PM TO 10 PM, PLACE: PATTAMBI ( NHANGATTIRI SCHOOL GROUND)', NULL, '15000', '1', '0', '15000.00', 'active', NULL, NULL),
(64, '28', '2', 'BALANCE AMOUNT 57000/-, DATE: 01/02/26 , PLACE- VALANCHERY', NULL, '3000', '1', '0', '3000.00', 'active', NULL, NULL),
(65, '29', '2', 'BALANCE 60000, EVENT DATE FEBRUARY 10', NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(66, '30', '2', 'BALANCE 90000 , EVENT DATE ; MARCH 31', NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(67, '31', '13', '11-02-2026 ( 10AM TO 10 PM )', NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(68, '32', '2', 'EVENT DATE ; 2026 MARCH 26 - 6PM, BALANCE 70000/- ( PAID BEFORE EVENT START )', NULL, '15000', '1', '0', '15000.00', 'active', NULL, NULL),
(69, '33', '8', 'OCTOBER PENDING', NULL, '12400', '1', '0', '12400.00', 'active', NULL, NULL),
(70, '33', '8', 'NOVEMBER PENDING', NULL, '11300', '1', '0', '11300.00', 'active', NULL, NULL),
(71, '33', '8', 'DECEMBER PENDING', NULL, '11000', '1', '0', '11000.00', 'active', NULL, NULL),
(72, '33', '4', 'REEL JAN 8 EVENT', NULL, '2500', '1', '0', '2500.00', 'active', NULL, NULL),
(73, '33', '1', 'SLIDE POSTER', NULL, '500', '1', '0', '500.00', 'active', NULL, NULL),
(74, '33', '4', 'PANAKKAD VIDEO', NULL, '2000', '1', '0', '2000.00', 'active', NULL, NULL),
(75, '33', '4', 'VD SATHEESHAN', NULL, '1500', '1', '0', '1500.00', 'active', NULL, NULL),
(76, '34', '15', 'EVENT DATE ; 11-02-2026', NULL, '85000', '1', '0', '85000.00', 'active', NULL, NULL),
(77, '35', '16', 'SESSION DATE ; 31-03-2026 , SESSION DURATION 1.30 HR - 2 HR , BALANCE AMOUNT 30000', NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(78, '36', '2', 'EVENT DATE : 01-04-2026 , BALANCE 80000 ( PAID BEFORE EVENT START )', NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(79, '37', '2', 'BALANCE 70000, EVENT DATE ; 25-03-2026', NULL, '5000', '1', '0', '5000.00', 'active', NULL, NULL),
(80, '38', '1', 'ENT CAMP , ORTHO ,PULMO, ENT', NULL, '300', '4', '0', '1200.00', 'active', NULL, NULL),
(81, '38', 'NOTICE PRINTING', '2500 COPY', NULL, '7500', '1', '0', '7500.00', 'active', NULL, NULL),
(82, '38', 'NOTICE DISTRIBUTION', '9 MASJID', NULL, '250', '8', '0', '2000.00', 'active', NULL, NULL),
(83, '38', 'OLD BALANCE', 'POSTER DESIGN - [ELECTION DAY POSTER] ,AD SPEND - [DOCTOR\'S VIDEO]', NULL, '1300', '1', '0', '1300.00', 'active', NULL, NULL),
(84, '39', 'IMAM MAJBOOR REMUNERATION', 'EVENT DATE : 13-03-2025', NULL, '15000', '1', '0', '15000.00', 'active', NULL, NULL),
(85, '40', 'PMA GAFOOR REMUNERATION', 'IFTAR MEET 13-03-2026', NULL, '20000', '1', '0', '20000.00', 'active', NULL, NULL),
(86, '41', '10', 'RE DESIGN', NULL, '1000', '1', '0', '1000.00', 'active', NULL, NULL),
(87, '41', '1', NULL, NULL, '350', '7', '0', '2450.00', 'active', NULL, NULL),
(88, '42', '3', 'FEBRUARY', NULL, '7000', '1', '0', '7000.00', 'active', NULL, NULL),
(89, '43', '3', 'FEBRUARY MONTH. TOTAL PACKAGE 15000, ADVANCE 10000', NULL, '5000', '1', '0', '5000.00', 'active', NULL, NULL),
(90, '44', '15', 'EVENT DATE : 25-03-2026', NULL, '85000', '1', '0', '85000.00', 'active', NULL, NULL),
(91, '45', 'MOMENTOS', 'TOTAL MOMENTOS', NULL, '50450', '1', '0', '50450.00', 'active', NULL, NULL),
(92, '45', 'BEFORE VIDEOS', 'WHISHES, ANIMATIONS, STUDENT REEL, PROMO', NULL, '8000', '1', '0', '8000.00', 'active', NULL, NULL),
(93, '45', 'POSTERS', 'TOTAL PROGRAM POSTER, LED WALL POSTER', NULL, '18650', '1', '0', '18650.00', 'active', NULL, NULL),
(94, '45', 'SCHOOL PROFILES', 'VIDEO COVERAGE AND EDITING', NULL, '8000', '1', '0', '8000.00', 'active', NULL, NULL),
(95, '45', 'WALKIE TALKIES', 'TWO DAYS 10 PIECE RENT', NULL, '4000', '1', '0', '4000.00', 'active', NULL, NULL),
(96, '45', 'LED SCREEN', 'TWO DAYS RENT', NULL, '32000', '1', '0', '32000.00', 'active', NULL, NULL),
(97, '45', 'DRONE SHOOT', 'GHOSHAYATHRA ONE AND HALF HOUR', NULL, '5000', '1', '0', '5000.00', 'active', NULL, NULL),
(98, '45', 'LIV EPHOTOGRAPHY', 'TWO DAYS LIVE STREEMING', NULL, '20000', '1', '0', '20000.00', 'active', NULL, NULL),
(99, '45', 'PHOTOGRAPHY', 'TWO DAYS FULL PHOTO COVERAGE AND EDIT', NULL, '22000', '1', '0', '22000.00', 'active', NULL, NULL),
(100, '45', 'GUEST TA', 'PMA GAFOOR', NULL, '22500', '1', '0', '22500.00', 'active', NULL, NULL),
(101, '45', 'GUEST TA', 'ELOSHA SANEESH', NULL, '8500', '1', '0', '8500.00', 'active', NULL, NULL),
(102, '45', 'GUEST TA', 'NASIC DOLL', NULL, '27500', '1', '0', '27500.00', 'active', NULL, NULL),
(103, '45', 'MUSIC NIGHT', 'NAMSHAD, NOUFILA, FAYIS', NULL, '12000', '1', '0', '12000.00', 'active', NULL, NULL),
(104, '45', 'ANCHOR', 'SUHAD KUNNATH', NULL, '12000', '1', '0', '12000.00', 'active', NULL, NULL),
(105, '45', 'ANGANWADI FRAME', '10 PIECE FRAME', NULL, '2000', '1', '0', '2000.00', 'active', NULL, NULL),
(106, '45', 'FLAG', 'DISIGNING AND PRINTING', NULL, '2800', '1', '0', '2800.00', 'active', NULL, NULL),
(107, '45', 'BADGE', 'GUEST-60, VOLOUNTERE-48, OFFICIAL-48', NULL, '1870', '1', '0', '1870.00', 'active', NULL, NULL),
(108, '45', 'BANNER', 'GHOSHAYATRA BANNER PRINTING', NULL, '600', '1', '0', '600.00', 'active', NULL, NULL),
(109, '45', 'UMBRELLA', 'RENT ( 5 PIECE)', NULL, '1500', '1', '0', '1500.00', 'active', NULL, NULL),
(110, '45', 'MICKY MOUSE', 'RENT ( 4 PIECE)', NULL, '6000', '1', '0', '6000.00', 'active', NULL, NULL),
(111, '45', 'NOTIECE', 'A4 DOUBLE SIDE ( 1000 PIECE)', NULL, '4900', '1', '0', '4900.00', 'active', NULL, NULL),
(112, '45', 'FLEX', 'PRINTING AND BOARD ( 5 PIECE)', NULL, '6000', '1', '0', '6000.00', 'active', NULL, NULL),
(113, '45', 'DUMMY POSTER', 'POSTER PRINTING ( 1000 PIECE)', NULL, '7500', '1', '0', '7500.00', 'active', NULL, NULL),
(114, '45', 'ANNOUNCMENT', 'PROGRAME ANNOUNCMENT ( APRL 1)', NULL, '2500', '1', '0', '2500.00', 'active', NULL, NULL),
(115, '45', 'POSTER PASTING', 'DUMMY POSTERPASTING', NULL, '6250', '1', '0', '6250.00', 'active', NULL, NULL),
(116, '45', 'COUPEN', 'GIFT VOUCHER 100 ( 25 PIECE)', NULL, '1880', '1', '0', '1880.00', 'active', NULL, NULL),
(117, '45', 'COUPEN', 'GIFT VOUCHER 500 ( 10 PIECE)', NULL, '3100', '1', '0', '3100.00', 'active', NULL, NULL),
(118, '45', 'RECIEPT BOOK', 'SCHOOL NAME RCIEPT ( 2 PIECE)', NULL, '200', '1', '0', '200.00', 'active', NULL, NULL),
(119, '45', 'GATE', 'LIGHT BOARD GATE', NULL, '8500', '1', '0', '8500.00', 'active', NULL, NULL),
(120, '45', 'POSTER PRINTING', 'SUVANEER POSTER PRINTING', NULL, '450', '1', '0', '450.00', 'active', NULL, NULL),
(121, '45', 'POSTER PASTING', 'CLUB MEMBER EXPENSE', NULL, '2700', '1', '0', '2700.00', 'active', NULL, NULL),
(122, '45', 'MOMENTO FUEL', 'BOOKING AND PURCHASING @ KUNNUMKULAM', NULL, '3200', '1', '0', '3200.00', 'active', NULL, NULL),
(123, '45', 'FUEL', 'OTHER FUEL EXPENSE', NULL, '3000', '1', '0', '3000.00', 'active', NULL, NULL),
(124, '45', 'VEHICLE CHARGE', 'BOARD AND DUMMY POSTER PICK UP', NULL, '1000', '1', '0', '1000.00', 'active', NULL, NULL),
(125, '45', 'FOOD', 'GUEST, ANCHOR, LED, LIVE', NULL, '3700', '1', '0', '3700.00', 'active', NULL, NULL),
(126, '45', 'PROGRAM DAY SHOOT', 'VIDEO COVERAGE ( DAY 1 @ DAY 2)', NULL, '7000', '1', '0', '7000.00', 'active', NULL, NULL),
(127, '45', 'CO-ORDINATION CHARGE', 'TWO DAY PROGRAM CO-ORDINATION', NULL, '8000', '1', '0', '8000.00', 'active', NULL, NULL),
(128, '45', 'VIDEO OUT', 'BALANCE VEDIO OUT', NULL, '5000', '1', '0', '5000.00', 'active', NULL, NULL),
(129, '46', 'MOMENTOS', 'TOTAL MOMENTOS', NULL, '50450', '1', '0', '50450.00', 'active', NULL, NULL),
(130, '46', 'BEFORE VIDEOS', 'WHISHES, ANIMATIONS, STUDENT REEL, PROMO', NULL, '8000', '1', '0', '8000.00', 'active', NULL, NULL),
(131, '46', 'POSTERS', 'TOTAL PROGRAM POSTER, LED WALL POSTER', NULL, '18650', '1', '0', '18650.00', 'active', NULL, NULL),
(132, '46', 'SCHOOL PROFILES', 'VIDEO COVERAGE AND EDITING', NULL, '8000', '1', '0', '8000.00', 'active', NULL, NULL),
(133, '46', 'WALKIE TALKIES', 'TWO DAYS 10 PIECE RENT', NULL, '4000', '1', '0', '4000.00', 'active', NULL, NULL),
(134, '46', 'LED SCREEN', 'TWO DAYS RENT', NULL, '32000', '1', '0', '32000.00', 'active', NULL, NULL),
(135, '46', 'DRONE SHOOT', 'GHOSHAYATHRA ONE AND HALF HOUR', NULL, '5000', '1', '0', '5000.00', 'active', NULL, NULL),
(136, '46', 'LIV EPHOTOGRAPHY', 'TWO DAYS LIVE STREAMING', NULL, '20000', '1', '0', '20000.00', 'active', NULL, NULL),
(137, '46', 'PHOTOGRAPHY', 'TWO DAYS FULL PHOTO COVERAGE AND EDIT', NULL, '22000', '1', '0', '22000.00', 'active', NULL, NULL),
(138, '46', 'GUEST TA', 'PMA GAFOOR', NULL, '22500', '1', '0', '22500.00', 'active', NULL, NULL),
(139, '46', 'GUEST TA', 'ELOSHA SANEESH', NULL, '8500', '1', '0', '8500.00', 'active', NULL, NULL),
(140, '46', 'GUEST TA', 'NASIC DOLL', NULL, '27500', '1', '0', '27500.00', 'active', NULL, NULL),
(141, '46', 'MUSIC NIGHT', 'NAMSHAD, NOUFILA, FAYIS', NULL, '12000', '1', '0', '12000.00', 'active', NULL, NULL),
(142, '46', 'ANCHOR', 'SUHAD KUNNATH', NULL, '12000', '1', '0', '12000.00', 'active', NULL, NULL),
(143, '46', 'ANGANWADI FRAME', '10 PIECE FRAME', NULL, '2000', '1', '0', '2000.00', 'active', NULL, NULL),
(144, '46', 'FLAG', 'DISIGNING AND PRINTING', NULL, '2800', '1', '0', '2800.00', 'active', NULL, NULL),
(145, '46', 'BADGE', 'GUEST-60, VOLOUNTERE-48, OFFICIAL-48', NULL, '1870', '1', '0', '1870.00', 'active', NULL, NULL),
(146, '46', 'BANNER', 'GHOSHAYATRA BANNER PRINTING', NULL, '600', '1', '0', '600.00', 'active', NULL, NULL),
(147, '46', 'UMBRELLA', 'RENT ( 5 PIECE)', NULL, '1500', '1', '0', '1500.00', 'active', NULL, NULL),
(148, '46', 'MICKY MOUSE', 'RENT ( 4 PIECE)', NULL, '6000', '1', '0', '6000.00', 'active', NULL, NULL),
(149, '46', 'NOTIECE', 'A4 DOUBLE SIDE ( 1000 PIECE)', NULL, '4900', '1', '0', '4900.00', 'active', NULL, NULL),
(150, '46', 'FLEX', 'PRINTING AND BOARD ( 5 PIECE)', NULL, '6000', '1', '0', '6000.00', 'active', NULL, NULL),
(151, '46', 'DUMMY POSTER', 'POSTER PRINTING ( 1000 PIECE)', NULL, '7500', '1', '0', '7500.00', 'active', NULL, NULL),
(152, '46', 'ANNOUNCMENT', 'PROGRAME ANNOUNCMENT ( APRL 1)', NULL, '2500', '1', '0', '2500.00', 'active', NULL, NULL),
(153, '46', 'POSTER PASTING', 'DUMMY POSTERPASTING', NULL, '6250', '1', '0', '6250.00', 'active', NULL, NULL),
(154, '46', 'COUPEN', 'GIFT VOUCHER 100 ( 25 PIECE)', NULL, '1880', '1', '0', '1880.00', 'active', NULL, NULL),
(155, '46', 'COUPEN', 'GIFT VOUCHER 500 ( 10 PIECE)', NULL, '3100', '1', '0', '3100.00', 'active', NULL, NULL),
(156, '46', 'RECIEPT BOOK', 'SCHOOL NAME RCIEPT ( 2 PIECE)', NULL, '200', '1', '0', '200.00', 'active', NULL, NULL),
(157, '46', 'GATE', 'LIGHT BOARD GATE', NULL, '8500', '1', '0', '8500.00', 'active', NULL, NULL),
(158, '46', 'POSTER PRINT', 'SUVANEER ADVERTISMENT POSTER PRINT', NULL, '450', '1', '0', '450.00', 'active', NULL, NULL),
(159, '46', 'POSTER PASTING', 'CLUB MEMBER PASTING EXPENSE', NULL, '2700', '1', '0', '2700.00', 'active', NULL, NULL),
(160, '46', 'FUEL', 'MOMENTO BOOKIN AND PURCHASING', NULL, '3200', '1', '0', '3200.00', 'active', NULL, NULL),
(161, '46', 'FUEL', 'OTHER FUEL EXPENSE', NULL, '3000', '1', '0', '3000.00', 'active', NULL, NULL),
(162, '46', 'VEHICLE CHARGE', 'FLEX BOARD AND DUMMY POSTER PICK UP', NULL, '1000', '1', '0', '1000.00', 'active', NULL, NULL),
(163, '46', 'FOOD', 'GUEST, ANCHOR, LED, LIVE', NULL, '3700', '1', '0', '3700.00', 'active', NULL, NULL),
(164, '46', 'VIDEO COVERAGE', 'DAY 1 AND DAY 2', NULL, '7000', '1', '0', '7000.00', 'active', NULL, NULL),
(165, '46', 'CO-ORDINATION CHARGE', 'TWO DAYS', NULL, '8000', '1', '0', '8000.00', 'active', NULL, NULL),
(166, '46', 'VIDEO OUT', 'BALANCE VIDEO EDITTING', NULL, '5000', '1', '0', '5000.00', 'active', NULL, NULL),
(167, '47', '1', NULL, NULL, '350', '15', '0', '5250.00', 'active', NULL, NULL),
(168, '48', '5', 'MARCH', NULL, '15000', '1', '0', '15000.00', 'active', NULL, NULL),
(169, '49', 'POSTERS', 'INSTAGRAM ACCOUNT CREATION', NULL, '1300', '1', '0', '1300.00', 'active', NULL, NULL),
(170, '50', '1', '3 POSTER', NULL, '300', '3', '0', '900.00', 'active', NULL, NULL),
(171, '50', 'NOTICE PRINTING', '3500 Nos - A5', NULL, '5800', '1', '0', '5800.00', 'active', NULL, NULL),
(172, '50', 'NOTICE DISTRIBUTION IN MASJID', '10 Masjid', NULL, '250', '10', '0', '2500.00', 'active', NULL, NULL),
(173, '50', '6', '5 Poster', NULL, '7500', '1', '0', '7500.00', 'active', NULL, NULL),
(174, '50', 'SOCIAL MEDIA HANDLING', 'Ad Setup & handling', NULL, '2000', '1', '0', '2000.00', 'active', NULL, NULL),
(175, '51', '1', NULL, NULL, '350', '28', '0', '9800.00', 'active', NULL, NULL),
(176, '52', '1', NULL, NULL, '350', '5', '0', '1750.00', 'active', NULL, NULL),
(177, '53', '1', NULL, NULL, '350', '5', '0', '1750.00', 'active', NULL, NULL),
(178, '54', '3', NULL, NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(179, '54', NULL, 'APRIL', NULL, '1200', '1', '0', '1200.00', 'active', NULL, NULL),
(180, '55', '3', NULL, NULL, '7000', '1', '0', '7000.00', 'active', NULL, NULL),
(181, '55', NULL, 'APRIL', NULL, '1000', '1', '0', '1000.00', 'active', NULL, NULL),
(182, '55', NULL, NULL, NULL, '0', '1', '0', '0', 'active', NULL, NULL),
(183, '56', '3', 'APRIL', NULL, '7000', '1', '0', '7000.00', 'active', NULL, NULL),
(184, '56', '6', 'APRIL', NULL, '1000', '1', '0', '1000.00', 'active', NULL, NULL),
(185, '57', '3', NULL, NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(186, '57', '6', 'APRIL', NULL, '1200', '1', '0', '1200.00', 'active', NULL, NULL),
(187, '58', '3', NULL, NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(188, '58', '6', 'APRIL', NULL, '1200', '1', '0', '1200.00', 'active', NULL, NULL),
(189, '59', '6', 'APRIL', NULL, '400', '1', '0', '400.00', 'active', NULL, NULL),
(190, '59', 'SERVICE CHARGE', 'APRIL', NULL, '100', '1', '0', '100.00', 'active', NULL, NULL),
(191, '60', '3', 'ACCOUNTAMY PAGE SETTING', NULL, '14000', '1', '0', '14000.00', 'active', NULL, NULL),
(192, '61', '5', 'ADVANCE', NULL, '15000', '1', '0', '15000.00', 'active', NULL, NULL),
(193, '62', '1', 'LAB, CAMP POSTER (3), BANNER DESIGNING', NULL, '300', '5', '0', '1500.00', 'active', NULL, NULL),
(194, '62', 'NOTICE PRINTING', '4500 Nos A5', NULL, '7200', '1', '0', '7200.00', 'active', NULL, NULL),
(195, '62', 'NOTICE DISTRIBUTION IN MASJID', '15 MASJID', NULL, '250', '15', '0', '3750.00', 'active', NULL, NULL),
(196, '62', 'BANNER', '6*4', NULL, '850', '1', '0', '850.00', 'active', NULL, NULL),
(197, '62', '6', 'MEDICAL CAMP', NULL, '2700', '1', '0', '2700.00', 'active', NULL, NULL),
(198, '62', '17', 'AD SETUP AND AD HANDLING', NULL, '2000', '1', '0', '2000.00', 'active', NULL, NULL),
(199, '62', 'OLD BALANCE', 'APRIL 24 BILL', NULL, '18700', '1', '0', '18700.00', 'active', NULL, NULL),
(200, '63', 'HALL & FOOD', 'PER HEAD 550', NULL, '550', '84', '0', '46200.00', 'active', NULL, NULL),
(201, '63', 'ROOM RENT', 'EXTRA ROOM', NULL, '1000', '1', '0', '1000.00', 'active', NULL, NULL),
(202, '63', 'TRAINER AMOUNT', 'PMA GAFOOR', NULL, '40000', '1', '0', '40000.00', 'active', NULL, NULL),
(203, '63', 'LED WALL', '150 SQUARE FEET', NULL, '120', '150', '0', '18000.00', 'active', NULL, NULL),
(204, '63', 'CABLING', 'LED WALL', NULL, '1500', '1', '0', '1500.00', 'active', NULL, NULL),
(205, '63', 'NOTE PAD', '100 Nos', NULL, '15', '100', '0', '1500.00', 'active', NULL, NULL),
(206, '63', 'PEN', '100 Nos', NULL, '10', '100', '0', '1000.00', 'active', NULL, NULL),
(207, '63', 'TAG', 'Print & Tag ( 36 Nos )', NULL, '20', '36', '0', '720.00', 'active', NULL, NULL),
(208, '63', 'POSTER MAKING', 'Social Media, Led Wall', NULL, '300', '17', '0', '5100.00', 'active', NULL, NULL),
(209, '63', 'AD CAMPAIGN', 'Total Ad spend', NULL, '9000', '1', '0', '9000.00', 'active', NULL, NULL),
(210, '63', 'PHOTO & VIDEO', 'Event Day pics, High Light Videos  ( 4 Videos )', NULL, '30000', '1', '0', '30000.00', 'active', NULL, NULL),
(211, '63', 'CO ORDINATION CHARGE', 'Total Event Hosting', NULL, '5000', '1', '0', '5000.00', 'active', NULL, NULL),
(212, '64', '8', NULL, NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(213, '64', '6', NULL, NULL, '800', '1', '0', '800.00', 'active', NULL, NULL),
(214, '65', '6', NULL, NULL, '600', '1', '0', '600.00', 'active', NULL, NULL),
(215, '66', '8', NULL, NULL, '12000', '1', '0', '12000.00', 'active', NULL, NULL),
(216, '66', '6', NULL, NULL, '800', '1', '0', '800.00', 'active', NULL, NULL),
(217, '67', '8', NULL, NULL, '7000', '1', '0', '7000.00', 'active', NULL, NULL),
(218, '68', '8', NULL, NULL, '14000', '1', '0', '14000.00', 'active', NULL, NULL),
(219, '69', '8', NULL, NULL, '14000', '1', '0', '14000.00', 'active', NULL, NULL),
(220, '70', '8', NULL, NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(221, '71', '1', NULL, NULL, '300', '3', '0', '900.00', 'active', NULL, NULL),
(222, '72', '1', NULL, NULL, '300', '1', '0', '300.00', 'active', NULL, NULL),
(223, '73', '1', NULL, NULL, '300', '1', '0', '300.00', 'active', NULL, NULL),
(224, '74', 'BROCHERE DESIGN', '12 PAGE', NULL, '300', '12', '0', '3600.00', 'active', NULL, NULL),
(225, '75', '1', NULL, NULL, '350', '22', '0', '7700.00', 'active', NULL, NULL),
(226, '76', '1', NULL, NULL, '350', '2', '0', '700.00', 'active', NULL, NULL),
(227, '77', 'CONTENT VIDEO', 'EID SPECIAL VIDEO', NULL, '10000', '1', '0', '10000.00', 'active', NULL, NULL),
(228, '78', 'CASTING & TALENT COORDINATION', NULL, NULL, '3500', '1', '0', '3500.00', 'active', NULL, NULL),
(229, '78', 'CAMERA , LIGHTING & VIDEOGRAPHY SERVICES', NULL, NULL, '3000', '1', '0', '3000.00', 'active', NULL, NULL),
(230, '78', 'VIDEO EDITING & POST-PRODUCTION', NULL, NULL, '3500', '1', '0', '3500.00', 'active', NULL, NULL),
(231, '79', 'BROCHERE DESIGN', '16 PAGE', NULL, '300', '16', '0', '4800.00', 'active', NULL, NULL),
(232, '80', '4', 'SHOOT & EDIT', NULL, '1500', '1', '0', '1500.00', 'active', NULL, NULL),
(233, '81', '1', 'A5 BROUCHUR DESIGN', NULL, '300', '20', '0', '6000.00', 'active', NULL, NULL),
(234, '81', 'PRINTING', 'A5 LAMINATION', NULL, '300', '3', '0', '900.00', 'active', NULL, NULL),
(235, '82', 'BROCHERE DESIGN', '12 PAGE', NULL, '300', '12', '0', '3600.00', 'active', NULL, NULL),
(236, '83', '1', 'CREATIVE DESIGN', NULL, '300', '13', '0', '3900.00', 'active', NULL, NULL),
(237, '83', '1', 'SPECIAL DAYS', NULL, '280', '5', '0', '1400.00', 'active', NULL, NULL),
(238, '83', '1', 'NAME BOARD', NULL, '280', '2', '0', '560.00', 'active', NULL, NULL),
(239, '84', 'BROUCHUR DESIGN', 'ENGLISH', NULL, '300', '12', '0', '3600.00', 'active', NULL, NULL),
(240, '84', 'BROUCHUR DESIGN', 'MALAYALAM', NULL, '300', '12', '0', '3600.00', 'active', NULL, NULL),
(241, '84', 'BROUCHUR PRINTING', 'MALAYALAM & ENGLISH', NULL, '300', '20', '0', '6000.00', 'active', NULL, NULL),
(242, '84', 'ENVELOPE PRINTING', '20 PIECE', NULL, '25', '20', '0', '500.00', 'active', NULL, NULL),
(243, '85', '1', 'CAMP & BORN POSTER', NULL, '350', '2', '0', '700.00', 'active', NULL, NULL),
(244, '85', 'PRINTING', 'CAMP POSTER 4800 PCS', NULL, '6800', '1', '0', '6800.00', 'active', NULL, NULL),
(245, '85', '6', '300 PER DAY  5 DAYS', NULL, '300', '5', '0', '1500.00', 'active', NULL, NULL),
(246, '85', 'SERVICE CHARGE', 'SOCIAL MEDIA HANDLING', NULL, '1000', '1', '0', '1000.00', 'active', NULL, NULL),
(247, '85', 'NEWS PAPER DISTRIBUTION', '4500 PCS', NULL, '0.80', '4500', '0', '3600.00', 'active', NULL, NULL),
(248, '86', '3', 'JUNE', NULL, '14000', '1', '0', '14000.00', 'active', NULL, NULL),
(249, '87', '3', 'JUNE', NULL, '14000', '1', '0', '14000.00', 'active', NULL, NULL),
(250, '88', '3', 'JUNE ADVANCE 7000, BALANCE 5000', NULL, '5000', '1', '0', '5000.00', 'active', NULL, NULL),
(251, '89', 'DIGITAL MARKETTING', 'JUNE MONTH', NULL, '15000', '1', '0', '15000.00', 'active', NULL, NULL),
(252, '89', 'BROUCHURE', '4 PAGE', NULL, '300', '4', '0', '1200.00', 'active', NULL, NULL),
(253, '89', 'BANNER DESIGN', NULL, NULL, '350', '1', '0', '350.00', 'active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `customer` varchar(255) DEFAULT NULL,
  `given_by` varchar(255) DEFAULT NULL,
  `project_description` text DEFAULT NULL,
  `start_date` varchar(255) DEFAULT NULL,
  `end_date` varchar(255) DEFAULT NULL,
  `budget` varchar(255) DEFAULT NULL,
  `team_leader` varchar(255) DEFAULT NULL,
  `team_members` varchar(255) DEFAULT NULL,
  `attachment1` varchar(255) DEFAULT NULL,
  `attachment2` varchar(255) DEFAULT NULL,
  `attachment3` varchar(255) DEFAULT NULL,
  `attachment4` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `project_name`, `customer`, `given_by`, `project_description`, `start_date`, `end_date`, `budget`, `team_leader`, `team_members`, `attachment1`, `attachment2`, `attachment3`, `attachment4`, `payment_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 'hala fest', '1', NULL, 'one month programme durimng the hala  fest', '2025-11-01', '2025-11-30', '150000', '1', '1', NULL, NULL, NULL, NULL, 'pending', 'active', '2025-12-27 19:21:32', '2025-12-27 19:21:32');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref_no` varchar(255) DEFAULT NULL,
  `transaction_type` varchar(255) DEFAULT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `invoice_date` varchar(255) DEFAULT NULL,
  `delivery_date` varchar(255) DEFAULT NULL,
  `seller_details` varchar(255) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `grand_total` varchar(255) DEFAULT NULL,
  `purchase_bill` varchar(255) DEFAULT NULL,
  `add_by` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `unit_price` varchar(255) DEFAULT NULL,
  `product_quantity` varchar(255) DEFAULT NULL,
  `gst_percent` varchar(255) DEFAULT NULL,
  `purchase_price` varchar(255) DEFAULT NULL,
  `purchase_date` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_number` varchar(255) DEFAULT NULL,
  `seller_name` varchar(255) DEFAULT NULL,
  `purchase_order_date` varchar(255) DEFAULT NULL,
  `seller_mobile` varchar(255) DEFAULT NULL,
  `grand_total` varchar(255) DEFAULT NULL,
  `generated_by` varchar(255) DEFAULT NULL,
  `add_date` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_items`
--

CREATE TABLE `purchase_order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_id` varchar(255) NOT NULL,
  `product_name` longtext DEFAULT NULL,
  `unit_price` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_returns`
--

CREATE TABLE `purchase_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `return_date` varchar(255) NOT NULL,
  `purchase_id` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `payement_method` varchar(255) NOT NULL,
  `add_by` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `payment_status` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_items`
--

CREATE TABLE `purchase_return_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_date` varchar(255) NOT NULL,
  `return_id` varchar(255) NOT NULL,
  `purchase_item_id` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `unit_price` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `tax` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_payments`
--

CREATE TABLE `salary_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` varchar(255) NOT NULL,
  `daybook_id` varchar(255) DEFAULT NULL,
  `basic_salary` varchar(255) DEFAULT NULL,
  `date` varchar(255) NOT NULL,
  `term` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `leaveDays` text DEFAULT NULL,
  `bankReference` text DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salary_payments`
--

INSERT INTO `salary_payments` (`id`, `staff_id`, `daybook_id`, `basic_salary`, `date`, `term`, `payment_type`, `amount`, `description`, `leaveDays`, `bankReference`, `payment_method`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', '1', '15000', '2025-12-28', '12-1-25', 'salary', '11538.46', NULL, '6', NULL, 'CASH', 'paid', '2025-12-27 19:18:27', '2025-12-27 19:18:27');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_card_id` int(11) NOT NULL,
  `add_by` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `serial` varchar(255) DEFAULT NULL,
  `product_id` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `qty` varchar(255) NOT NULL,
  `tax` varchar(255) DEFAULT NULL,
  `gst` varchar(255) DEFAULT NULL,
  `total` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_items`
--

CREATE TABLE `sales_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sales_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `product_name` longtext DEFAULT NULL,
  `unit_price` varchar(255) DEFAULT NULL,
  `product_quantity` varchar(255) DEFAULT NULL,
  `gst_percent` varchar(255) DEFAULT NULL,
  `sales_price` varchar(255) DEFAULT NULL,
  `sales_date` varchar(255) DEFAULT NULL,
  `serial_number` longtext DEFAULT NULL,
  `warranty` varchar(255) DEFAULT NULL,
  `gst_available` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_items`
--

INSERT INTO `sales_items` (`id`, `sales_id`, `product_id`, `product_name`, `unit_price`, `product_quantity`, `gst_percent`, `sales_price`, `sales_date`, `serial_number`, `warranty`, `gst_available`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', '3', NULL, '10000.00', '1', '0', '10000', '2026-01-05', 'MONTHLY CONTRACT', NULL, NULL, 'active', '2026-01-05 23:14:52', '2026-01-05 23:42:37'),
(2, '1', '6', NULL, '2700.00', '1', '0', '2700.00', '2026-01-05', NULL, NULL, NULL, 'active', '2026-01-05 23:14:52', '2026-01-05 23:14:52'),
(3, '1', '1', NULL, '300.00', '2', '0', '600.00', '2026-01-05', 'funscape', NULL, NULL, 'active', '2026-01-05 23:14:52', '2026-01-05 23:14:52'),
(4, '2', '3', NULL, '5000.00', '1', '0', '5000.00', '2026-01-05', 'MONTHLY CONTRACT', NULL, NULL, 'active', '2026-01-05 23:32:07', '2026-01-05 23:32:07'),
(5, '2', '6', NULL, '5200.00', '1', '0', '5200.00', '2026-01-05', NULL, NULL, NULL, 'active', '2026-01-05 23:32:07', '2026-01-05 23:32:07'),
(6, '2', '1', NULL, '300.00', '2', '0', '600.00', '2026-01-05', 'additional poster', NULL, NULL, 'active', '2026-01-05 23:32:07', '2026-01-05 23:32:07'),
(7, '3', '3', NULL, '5000.00', '1', '0', '5000', '2026-01-06', 'MONTHLY CONTRACT', NULL, NULL, 'active', '2026-01-05 23:46:17', '2026-01-05 23:50:32'),
(8, '3', '6', NULL, '5200.00', '1', '0', '5200.00', '2026-01-06', 'meta ads', NULL, NULL, 'active', '2026-01-05 23:46:17', '2026-01-05 23:46:17'),
(9, '3', '1', NULL, '300.00', '2', '0', '600.00', '2026-01-06', 'additional poster', NULL, NULL, 'active', '2026-01-05 23:46:17', '2026-01-05 23:46:17'),
(10, '4', '1', NULL, '300.00', '1', '0', '300.00', '2026-01-06', 'ELECTION DAY POSTER', NULL, NULL, 'active', '2026-01-06 21:28:11', '2026-01-06 21:28:11'),
(11, '4', '6', NULL, '1000.00', '1', '0', '1000.00', '2026-01-06', 'DOCTOR\'S VIDEO', NULL, NULL, 'active', '2026-01-06 21:28:11', '2026-01-06 21:28:11'),
(12, '5', '3', NULL, '7000.00', '1', '0', '7000.00', '2026-01-06', 'MONTHLY PLAN', NULL, NULL, 'active', '2026-01-06 23:26:27', '2026-01-06 23:26:27'),
(13, '6', '8', NULL, '12400.00', '1', '0', '12400.00', '2026-01-06', 'OCTOBER PENDING', NULL, NULL, 'active', '2026-01-06 23:33:19', '2026-01-06 23:33:19'),
(14, '6', '9', NULL, '11300.00', '1', '0', '11300.00', '2026-01-06', 'NOVEMBER PENDING', NULL, NULL, 'active', '2026-01-06 23:33:19', '2026-01-06 23:33:19'),
(15, '6', '3', NULL, '11000.00', '1', '0', '11000.00', '2026-01-06', 'DECEMBER', NULL, NULL, 'active', '2026-01-06 23:33:19', '2026-01-06 23:33:19'),
(16, '7', '3', NULL, '7000.00', '1', '0', '7000.00', '2026-01-06', NULL, NULL, NULL, 'active', '2026-01-06 23:34:50', '2026-01-06 23:34:50'),
(17, '8', '5', NULL, '20000.00', '1', '0', '20000.00', '2026-01-06', 'MONTHLY CONTRACT ( DECEMBER )', NULL, NULL, 'active', '2026-01-06 23:40:54', '2026-01-06 23:40:54'),
(18, '9', '6', NULL, '4250.00', '1', '0', '4250.00', '2026-01-06', 'HYPNOTISM & MENTALISM WORK SHOP', NULL, NULL, 'active', '2026-01-07 01:29:06', '2026-01-07 01:29:06'),
(20, '11', '3', NULL, '22500.00', '1', '0', '22500.00', '2026-01-06', 'MONTHLY CONTRACT ( 15 DAYS )', NULL, NULL, 'active', '2026-01-07 01:35:47', '2026-01-07 01:35:47'),
(21, '12', '1', NULL, '330.00', '2', '0', '660.00', '2026-01-06', 'CHRISTMAS OFFER & NATIONAL DAY DEAL', NULL, NULL, 'active', '2026-01-13 19:04:09', '2026-01-13 19:04:09'),
(22, '13', '10', NULL, '500.00', '1', '0', '500.00', '2026-01-06', NULL, NULL, NULL, 'active', '2026-01-13 19:07:49', '2026-01-13 19:07:49'),
(23, '14', '4', NULL, '2500.00', '1', '0', '2500.00', '2026-01-07', 'VIDEO REEL ( JAN 8 EVENT)', NULL, NULL, 'active', '2026-01-22 18:56:45', '2026-01-22 18:56:45'),
(24, '14', '1', NULL, '500.00', '1', '0', '500.00', '2026-01-07', 'slide poster', NULL, NULL, 'active', '2026-01-22 18:56:45', '2026-01-22 18:56:45'),
(25, '15', '11', NULL, '7670.00', '1', '0', '7670.00', '2026-02-01', 'CALICUT HYPNOSIS - 3427.66 , KANNUR HYPNOSIS - 2242.54 , KANNUR HYPNOSIS - 2000', NULL, NULL, 'active', '2026-02-04 22:52:20', '2026-02-04 22:52:20'),
(26, '15', '12', NULL, '15100.00', '1', '0', '15100.00', '2026-02-01', 'thrissure - 1420 , manjeri - 1969.72 , kottakkal - 1281.55 , calicut - 1470 , tirur - 553.72 , edaPPAL - 1840.12 , PALAKKAD - 2643.68 , KANNUR - 3921.34', NULL, NULL, 'active', '2026-02-04 22:52:20', '2026-02-04 22:52:20'),
(27, '16', '8', NULL, '45000.00', '1', '0', '45000.00', '2026-02-01', 'MONTHLY PACKAGE - JANUARY', NULL, NULL, 'active', '2026-02-04 22:55:16', '2026-02-04 22:55:16'),
(28, '17', '3', NULL, '10000.00', '1', '0', '10000.00', '2026-02-06', 'MONTHLY PLAN JANUARY', NULL, NULL, 'active', '2026-02-07 17:58:16', '2026-02-07 17:58:16'),
(29, '18', '8', NULL, '5000.00', '1', '0', '5000.00', '2026-02-06', 'JANUARY MONTH PLAN', NULL, NULL, 'active', '2026-02-07 18:04:05', '2026-02-07 18:04:05'),
(30, '18', '6', NULL, '900.00', '1', '0', '900.00', '2026-02-06', NULL, NULL, NULL, 'active', '2026-02-07 18:04:05', '2026-02-07 18:04:05'),
(31, '19', '8', NULL, '7000.00', '1', '0', '7000.00', '2026-02-06', 'JANUARY', NULL, NULL, 'active', '2026-02-07 18:15:49', '2026-02-07 18:15:49'),
(32, '19', '6', NULL, '800.00', '1', '0', '800.00', '2026-02-06', 'ALERGY POSTER', NULL, NULL, 'active', '2026-02-07 18:15:49', '2026-02-07 18:15:49'),
(33, '20', '3', NULL, '7000.00', '1', '0', '7000.00', '2026-02-06', 'JANUAR', NULL, NULL, 'active', '2026-02-07 18:24:26', '2026-02-07 18:24:26'),
(34, '20', '6', NULL, '600.00', '1', '0', '600.00', '2026-02-06', NULL, NULL, NULL, 'active', '2026-02-07 18:24:26', '2026-02-07 18:24:26'),
(35, '21', '3', NULL, '22500.00', '1', '0', '22500.00', '2026-02-20', 'FEBRUARY 15 DAYS', NULL, NULL, 'active', '2026-02-20 20:47:45', '2026-02-20 20:47:45'),
(36, '21', '6', NULL, '5005.84', '1', '0', '5005.84', '2026-02-20', 'palakkad - 620.73 , tirur - 1029.28 , thrissur - 1278.07 , manjeri - 1077.76 , thrissur - 1000', NULL, NULL, 'active', '2026-02-20 20:47:45', '2026-02-20 20:47:45'),
(37, '22', '17', NULL, '3500.00', '1', '0', '3500.00', '2026-03-07', '15 DAYS', NULL, NULL, 'active', '2026-03-08 19:48:21', '2026-03-08 19:48:21'),
(38, '22', '1', NULL, '350.00', '16', '0', '5600.00', '2026-03-07', NULL, NULL, NULL, 'active', '2026-03-08 19:48:21', '2026-03-08 19:48:21'),
(39, '22', '6', NULL, '2700.00', '1', '0', '2700.00', '2026-03-07', 'NATURALS', NULL, NULL, 'active', '2026-03-08 19:48:21', '2026-03-08 19:48:21'),
(40, '23', '2', NULL, '5000.00', '1', '0', '5000.00', '2026-03-10', 'EVENT DATE ; 24-03-2026 , BALANCE 73000/- ( PAID BEFORE THE EVENT START )', NULL, NULL, 'active', '2026-03-23 19:31:18', '2026-03-23 19:31:18'),
(41, '24', '3', NULL, '8800.00', '1', '0', '8800.00', '2026-04-07', 'START ON MARCH 7', NULL, NULL, 'active', '2026-04-08 15:05:19', '2026-04-08 15:05:19'),
(42, '24', '6', NULL, '800.00', '1', '0', '800.00', '2026-04-07', 'march', NULL, NULL, 'active', '2026-04-08 15:05:19', '2026-04-08 15:05:19'),
(43, '25', '3', NULL, '7000.00', '1', '0', '7000.00', '2026-04-07', 'MARCH', NULL, NULL, 'active', '2026-04-08 15:08:17', '2026-04-08 15:08:17'),
(44, '26', '3', NULL, '10000.00', '1', '0', '10000.00', '2026-04-07', 'MARCH', NULL, NULL, 'active', '2026-04-08 15:10:02', '2026-04-08 15:10:02'),
(45, '27', '3', NULL, '15000.00', '1', '0', '15000.00', '2026-04-07', 'MARCH', NULL, NULL, 'active', '2026-04-08 15:11:50', '2026-04-08 15:11:50'),
(46, '27', '6', NULL, '2000.00', '1', '0', '2000.00', '2026-04-07', 'march', NULL, NULL, 'active', '2026-04-08 15:11:50', '2026-04-08 15:11:50'),
(47, '28', '3', NULL, '7000.00', '1', '0', '7000.00', '2026-04-07', 'MARCH', NULL, NULL, 'active', '2026-04-08 15:14:00', '2026-04-08 15:14:00'),
(48, '28', '6', NULL, '600.00', '1', '0', '600.00', '2026-04-07', 'march', NULL, NULL, 'active', '2026-04-08 15:14:00', '2026-04-08 15:14:00'),
(49, '29', '8', NULL, '7000.00', '1', '0', '7000.00', '2026-06-02', 'DIVERZA MAY', NULL, NULL, 'active', '2026-07-03 16:28:56', '2026-07-03 16:28:56');

-- --------------------------------------------------------

--
-- Table structure for table `sales_returns`
--

CREATE TABLE `sales_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `return_date` varchar(255) NOT NULL,
  `sale_id` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `payement_method` varchar(255) NOT NULL,
  `add_by` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `payment_status` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_items`
--

CREATE TABLE `sales_return_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_date` varchar(255) NOT NULL,
  `return_id` varchar(255) NOT NULL,
  `sales_item_id` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `unit_price` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `tax` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_name` varchar(255) NOT NULL,
  `seller_city` varchar(255) DEFAULT NULL,
  `seller_area` varchar(255) DEFAULT NULL,
  `seller_district` varchar(255) DEFAULT NULL,
  `seller_state` varchar(255) DEFAULT NULL,
  `seller_pincode` varchar(255) DEFAULT NULL,
  `seller_phone` varchar(255) DEFAULT NULL,
  `seller_mobile` varchar(255) DEFAULT NULL,
  `seller_email` varchar(255) DEFAULT NULL,
  `seller_state_code` varchar(255) DEFAULT NULL,
  `seller_status` varchar(255) NOT NULL DEFAULT 'active',
  `seller_opening_balance` varchar(255) DEFAULT NULL,
  `seller_bank_name` varchar(255) DEFAULT NULL,
  `seller_bank_acc_no` varchar(255) DEFAULT NULL,
  `seller_bank_ifsc` varchar(255) DEFAULT NULL,
  `seller_bank_branch` varchar(255) DEFAULT NULL,
  `seller_gst` varchar(255) DEFAULT NULL,
  `seller_pan` varchar(255) DEFAULT NULL,
  `seller_tin` varchar(255) DEFAULT NULL,
  `courier_address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`id`, `seller_name`, `seller_city`, `seller_area`, `seller_district`, `seller_state`, `seller_pincode`, `seller_phone`, `seller_mobile`, `seller_email`, `seller_state_code`, `seller_status`, `seller_opening_balance`, `seller_bank_name`, `seller_bank_acc_no`, `seller_bank_ifsc`, `seller_bank_branch`, `seller_gst`, `seller_pan`, `seller_tin`, `courier_address`, `created_at`, `updated_at`) VALUES
(1, 'ABG', NULL, NULL, NULL, NULL, NULL, NULL, '644654165', NULL, NULL, 'active', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-27 19:23:44', '2025-12-27 19:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `employee_code` varchar(255) DEFAULT NULL,
  `staff_name` varchar(255) NOT NULL,
  `phone1` varchar(255) NOT NULL,
  `phone2` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `salary` varchar(255) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`id`, `user_id`, `category_id`, `employee_code`, `staff_name`, `phone1`, `phone2`, `dob`, `email`, `salary`, `join_date`, `address`, `remark`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 8, 'H0001', 'ADIL', '8089748698', '8089748698', '1999-12-01', 'adilbinazeeze@gmail.com', '15000', '2025-02-01', 'EDATHADATHIUL HOUSE VRANDATHANI PO', NULL, 'disabled', '2025-12-27 19:17:58', '2026-02-03 17:34:42'),
(2, NULL, 1, NULL, 'UMMU ATHEEQA', '8606265002', '8089886572', '19 Mar 1994', 'ATHUATHEEQA786@GMAIL.COM', '15000', '2026-01-02', 'CHATHANATHIL HOUSE\r\nKALPAKANCHERY PO\r\nATHIRUMADA\r\n676551', NULL, 'active', '2026-02-03 17:23:22', '2026-02-03 17:23:22'),
(3, NULL, 3, 'HTPK004', 'MOHAMMED FASIL K', '8606248526', '9744248526', '06 Jun 2002', 'FASILFK8@GMAIL.COM', '15000', '2025-10-14', 'KARAYIL HOUSE \r\nTHENNALA PO\r\nWEST BAZAR \r\n676508', NULL, 'active', '2026-02-03 17:26:28', '2026-02-03 17:26:28'),
(4, NULL, 4, 'HTPK006', 'MOHAMMED ADNAN', '9895083085', '9656690551', '07 Jun 2005', 'MOHAMEDADNANKALODI786@GMAIL.COM', '15000', '2025-11-15', 'KALODI HOUSE\r\nRASHEED NAGAR \r\nTIRURANGADI PO\r\n676306', NULL, 'active', '2026-02-03 17:29:57', '2026-02-03 17:29:57'),
(5, NULL, 3, NULL, 'SAJESH', '7994876800', '9496840710', NULL, 'SAJESHPARENGAL21@GMAIL.COM', '18000', '2025-12-01', 'PARENGAL HOUSE\r\nALINCHUVAD \r\nKOTAKKAL KUTTIPPURAM PO\r\nKOTTAKKAL\r\n676503', NULL, 'active', '2026-02-03 17:33:27', '2026-07-06 15:16:21'),
(6, NULL, 5, NULL, 'MOHAMMED SHAHZIN', '7994130725', NULL, '22 Dec 2003', 'shahzin44@gmail.com', '15000', '2025-12-24', 'CHUNGATH HOUSE \r\nALLUIR ROAD\r\nTHEKKAN KUTTUR PO\r\n676551', NULL, 'active', '2026-02-03 17:39:55', '2026-02-03 17:39:55'),
(7, NULL, 1, NULL, 'ADIL MOHAMED', '8089748698', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', '2026-02-04 22:40:26', '2026-02-04 22:40:26');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_unit_price` varchar(255) NOT NULL,
  `product_qty` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `upcoming_events`
--

CREATE TABLE `upcoming_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `image` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `email_verified_at`, `password`, `role`, `status`, `image`, `remember_token`, `created_at`, `updated_at`) VALUES
(21, 'RAMIZ', 'developer@hosteetheplanner.com', 'Ramiz', NULL, '$2y$10$6bfgbSmhQZN82ZzcOQLsi.6/rJGmKd1lZ0uIiTJr3WTtN9h4oui6.', 'super-admin', 'active', '1765171578.1764840122.7309681.jpg', NULL, NULL, '2025-12-08 15:56:18'),
(22, 'AJVAD', 'ajvad@hosteetheplanner.com', 'ajvad', '2025-12-09 18:47:41', '$2y$10$noAVuLxLJws/EAA5HCJ09umby2C92XHqhFQA17zObdjX4uJb4JAAi', 'super-admin', 'active', '1765607186.WhatsApp Image 2025-12-13 at 11.55.59 AM.jpeg', NULL, '2025-12-09 18:47:41', '2025-12-13 16:56:26'),
(23, 'ADIL', 'adil@hosteetheplanner.com', 'adil', '2025-12-09 18:47:41', '$2y$10$liIaqyzHb4JjbXfNAi9NPerY6IaRVLFEruXP5.E3SOXwBlN8/M4zW', 'super-admin', 'active', '1765607218.WhatsApp Image 2025-12-13 at 11.55.51 AM.jpeg', NULL, '2025-12-09 18:47:41', '2025-12-13 16:56:58'),
(24, 'OFFICE ADMIN', 'admin@hosteetheplanner.com', 'admin', '2025-12-29 18:47:41', '$2y$10$SqJIO5oQAeDwKzGERddzk.3GiHEuNw/KlfFqxAAAnkscFoWwDWbJG', 'admin', 'active', '1765171578.1764840122.7309681.jpg', NULL, '2025-12-09 18:47:41', '2025-12-29 21:23:12'),
(25, 'DEVELOPER', 'dev@gmail.com', 'developer', NULL, '$2y$10$SKaqh8Yhgv9JvFbHMEdGNubD37G2ekuD5riuaIZUzoogPinDZ48Ci', 'super-admin', 'active', '1764840122.7309681.jpg', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `utility_logs`
--

CREATE TABLE `utility_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `login_user` varchar(255) NOT NULL,
  `add_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `utility_logs`
--

INSERT INTO `utility_logs` (`id`, `login_user`, `add_date`, `created_at`, `updated_at`) VALUES
(1, 'ADIL', '2026-01-05 17:15:50', '2026-01-05 22:15:50', '2026-01-05 22:15:50'),
(2, 'ADIL', '2026-01-05 18:28:09', '2026-01-05 23:28:09', '2026-01-05 23:28:09'),
(3, 'ADIL', '2026-01-05 18:39:44', '2026-01-05 23:39:44', '2026-01-05 23:39:44'),
(4, 'ADIL', '2026-01-05 18:42:25', '2026-01-05 23:42:25', '2026-01-05 23:42:25'),
(5, 'ADIL', '2026-01-05 18:50:08', '2026-01-05 23:50:08', '2026-01-05 23:50:08'),
(6, 'ADIL', '2026-01-06 20:31:29', '2026-01-07 01:31:29', '2026-01-07 01:31:29'),
(7, 'developer', '2026-01-07 11:17:51', '2026-01-07 16:17:51', '2026-01-07 16:17:51');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_number` varchar(255) NOT NULL,
  `vehicle_name` varchar(255) DEFAULT NULL,
  `vehicle_model` varchar(255) DEFAULT NULL,
  `rc_owner` varchar(255) DEFAULT NULL,
  `engine_number` varchar(255) DEFAULT NULL,
  `chasis_number` varchar(255) DEFAULT NULL,
  `reg_validity` varchar(255) DEFAULT NULL,
  `insurance_number` varchar(255) DEFAULT NULL,
  `insurance_validity` varchar(255) DEFAULT NULL,
  `pollution_validity` varchar(255) DEFAULT NULL,
  `permit_validity` varchar(255) DEFAULT NULL,
  `rc_doc` varchar(255) DEFAULT NULL,
  `insurance_doc` varchar(255) DEFAULT NULL,
  `pollution_doc` varchar(255) DEFAULT NULL,
  `permit_doc` varchar(255) DEFAULT NULL,
  `add_by` varchar(255) DEFAULT NULL,
  `add_date` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warrenties`
--

CREATE TABLE `warrenties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jobcard_id` int(11) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `service_date` varchar(255) NOT NULL,
  `servicer_contact` varchar(255) DEFAULT NULL,
  `staff_name` varchar(255) DEFAULT NULL,
  `warrenty_complaint` varchar(255) DEFAULT NULL,
  `courier_delivery` varchar(255) DEFAULT NULL,
  `courier_bill` varchar(255) DEFAULT NULL,
  `service_charge` varchar(255) DEFAULT NULL,
  `return_date` varchar(255) DEFAULT NULL,
  `handover_staff` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `worktypes`
--

CREATE TABLE `worktypes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `work_type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chiplevels`
--
ALTER TABLE `chiplevels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chiplevel_servicers`
--
ALTER TABLE `chiplevel_servicers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consignments`
--
ALTER TABLE `consignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consignment_assessments`
--
ALTER TABLE `consignment_assessments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consoulidates`
--
ALTER TABLE `consoulidates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daybooks`
--
ALTER TABLE `daybooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daybook_balances`
--
ALTER TABLE `daybook_balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daybook_prevs`
--
ALTER TABLE `daybook_prevs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daybook_prev_balances`
--
ALTER TABLE `daybook_prev_balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daybook_services`
--
ALTER TABLE `daybook_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daybook_summaries`
--
ALTER TABLE `daybook_summaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `direct_sales`
--
ALTER TABLE `direct_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_categories`
--
ALTER TABLE `employee_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estimates`
--
ALTER TABLE `estimates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estimate_items`
--
ALTER TABLE `estimate_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estimate_request`
--
ALTER TABLE `estimate_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_bookings`
--
ALTER TABLE `event_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_bookings_event_id_foreign` (`event_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `field_purchases`
--
ALTER TABLE `field_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investors`
--
ALTER TABLE `investors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journals`
--
ALTER TABLE `journals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marketings`
--
ALTER TABLE `marketings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marketing_summaries`
--
ALTER TABLE `marketing_summaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meta_data`
--
ALTER TABLE `meta_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_events`
--
ALTER TABLE `news_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proforma_invoices`
--
ALTER TABLE `proforma_invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proforma_invoice_items`
--
ALTER TABLE `proforma_invoice_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchases_invoice_no_unique` (`invoice_no`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_return_items`
--
ALTER TABLE `purchase_return_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_payments`
--
ALTER TABLE `salary_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_items`
--
ALTER TABLE `sales_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_returns`
--
ALTER TABLE `sales_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_return_items`
--
ALTER TABLE `sales_return_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upcoming_events`
--
ALTER TABLE `upcoming_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `utility_logs`
--
ALTER TABLE `utility_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warrenties`
--
ALTER TABLE `warrenties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worktypes`
--
ALTER TABLE `worktypes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chiplevels`
--
ALTER TABLE `chiplevels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chiplevel_servicers`
--
ALTER TABLE `chiplevel_servicers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consignments`
--
ALTER TABLE `consignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consignment_assessments`
--
ALTER TABLE `consignment_assessments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consoulidates`
--
ALTER TABLE `consoulidates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `daybooks`
--
ALTER TABLE `daybooks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `daybook_balances`
--
ALTER TABLE `daybook_balances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `daybook_prevs`
--
ALTER TABLE `daybook_prevs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daybook_prev_balances`
--
ALTER TABLE `daybook_prev_balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daybook_services`
--
ALTER TABLE `daybook_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daybook_summaries`
--
ALTER TABLE `daybook_summaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `direct_sales`
--
ALTER TABLE `direct_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `employee_categories`
--
ALTER TABLE `employee_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `estimates`
--
ALTER TABLE `estimates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimate_items`
--
ALTER TABLE `estimate_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimate_request`
--
ALTER TABLE `estimate_request`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_bookings`
--
ALTER TABLE `event_bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `field_purchases`
--
ALTER TABLE `field_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `investors`
--
ALTER TABLE `investors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journals`
--
ALTER TABLE `journals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marketings`
--
ALTER TABLE `marketings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marketing_summaries`
--
ALTER TABLE `marketing_summaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meta_data`
--
ALTER TABLE `meta_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `news_events`
--
ALTER TABLE `news_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `proforma_invoices`
--
ALTER TABLE `proforma_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `proforma_invoice_items`
--
ALTER TABLE `proforma_invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_return_items`
--
ALTER TABLE `purchase_return_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_payments`
--
ALTER TABLE `salary_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_items`
--
ALTER TABLE `sales_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `sales_returns`
--
ALTER TABLE `sales_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_return_items`
--
ALTER TABLE `sales_return_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `upcoming_events`
--
ALTER TABLE `upcoming_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `utility_logs`
--
ALTER TABLE `utility_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warrenties`
--
ALTER TABLE `warrenties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `worktypes`
--
ALTER TABLE `worktypes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_bookings`
--
ALTER TABLE `event_bookings`
  ADD CONSTRAINT `event_bookings_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `upcoming_events` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
