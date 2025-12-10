-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 08, 2025 at 04:52 AM
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
(1, '2025-12-03', '0', '0', '0', NULL, NULL);

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
(11, 'Sales', NULL, NULL),
(12, 'Digital Marketer', NULL, NULL),
(13, 'Web Designer', NULL, NULL),
(14, 'Web Develepor', NULL, NULL),
(15, 'Graphic Designer', NULL, NULL),
(16, 'HR', NULL, NULL),
(20, 'Others', NULL, NULL);

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

-- --------------------------------------------------------

--
-- Table structure for table `proforma_invoice_items`
--

CREATE TABLE `proforma_invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Proforma_id` varchar(255) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `warrenty` varchar(255) DEFAULT NULL,
  `unit_price` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `product_tax` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, NULL, 12, 'D001', 'AMAN', '9072518746', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'disabled', '2025-12-03 08:18:45', '2025-12-05 18:48:57');

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
(7, 'RAMIZ', 'ramiz@teamtechsoul.com', 'ramiz', NULL, '$2y$10$6bfgbSmhQZN82ZzcOQLsi.6/rJGmKd1lZ0uIiTJr3WTtN9h4oui6.', 'super-admin', 'active', '1762869459.20251019_124754.jpg', NULL, NULL, '2025-11-12 00:27:39'),
(21, 'developer', 'developer@teamtechsoul.com', 'developer', NULL, '$2y$10$SKaqh8Yhgv9JvFbHMEdGNubD37G2ekuD5riuaIZUzoogPinDZ48Ci', 'super-admin', 'active', '1764922638.1764840122.7309681.jpg', NULL, NULL, '2025-12-05 18:47:19');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daybooks`
--
ALTER TABLE `daybooks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daybook_balances`
--
ALTER TABLE `daybook_balances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `direct_sales`
--
ALTER TABLE `direct_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_categories`
--
ALTER TABLE `employee_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investors`
--
ALTER TABLE `investors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proforma_invoices`
--
ALTER TABLE `proforma_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proforma_invoice_items`
--
ALTER TABLE `proforma_invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_items`
--
ALTER TABLE `sales_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `utility_logs`
--
ALTER TABLE `utility_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
