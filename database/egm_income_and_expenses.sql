-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2020 at 03:19 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `egm_income_and_expenses`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_company`
--

CREATE TABLE `tbl_company` (
  `company_id` int(11) NOT NULL,
  `company_created_by` int(11) NOT NULL,
  `company_last_update_by` int(11) DEFAULT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_website` varchar(100) DEFAULT NULL,
  `company_email` varchar(100) DEFAULT NULL,
  `company_address` varchar(100) DEFAULT NULL,
  `company_city` varchar(100) DEFAULT NULL,
  `company_country` varchar(100) DEFAULT NULL,
  `company_zip_code` varchar(100) DEFAULT NULL,
  `company_phone` varchar(100) DEFAULT NULL,
  `company_fax` varchar(100) DEFAULT NULL,
  `company_created_at` datetime NOT NULL,
  `company_updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_company`
--

INSERT INTO `tbl_company` (`company_id`, `company_created_by`, `company_last_update_by`, `company_name`, `company_website`, `company_email`, `company_address`, `company_city`, `company_country`, `company_zip_code`, `company_phone`, `company_fax`, `company_created_at`, `company_updated_at`) VALUES
(1, 2, 1, 'EGavilan Media', 'https://egavilanmedia.com', 'egavilanmedia@gmail.com', '43 Corny Court', 'BOOKABIE', 'South Australia', '5690', '(08) 8745 6746', '(02) 4630 8835', '2020-08-22 04:11:10', '2020-10-17 00:09:02');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customers`
--

CREATE TABLE `tbl_customers` (
  `customer_id` int(11) NOT NULL,
  `customer_created_by` int(11) NOT NULL,
  `customer_last_update_by` int(11) DEFAULT NULL,
  `customer_full_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `customer_officer_name` varchar(100) NOT NULL,
  `customer_telephone` varchar(100) DEFAULT NULL,
  `customer_cellphone` varchar(100) DEFAULT NULL,
  `customer_address` varchar(500) DEFAULT NULL,
  `customer_bank_name` varchar(200) NOT NULL,
  `customer_bank_account_number` varchar(50) NOT NULL,
  `customer_bank_account_type` varchar(50) NOT NULL,
  `customer_website` varchar(200) NOT NULL,
  `customer_username` varchar(50) NOT NULL,
  `customer_password` varchar(50) NOT NULL,
  `customer_status` enum('Active','Inactive') NOT NULL,
  `customer_note` text DEFAULT NULL,
  `customer_created_at` datetime NOT NULL,
  `customer_updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_customers`
--

INSERT INTO `tbl_customers` (`customer_id`, `customer_created_by`, `customer_last_update_by`, `customer_full_name`, `customer_email`, `customer_officer_name`, `customer_telephone`, `customer_cellphone`, `customer_address`, `customer_bank_name`, `customer_bank_account_number`, `customer_bank_account_type`, `customer_website`, `customer_username`, `customer_password`, `customer_status`, `customer_note`, `customer_created_at`, `customer_updated_at`) VALUES
(1, 1, NULL, 'Dillon Pace', 'quam@ametultricies.net', 'Cody Bauer', '1-895-521-0973', '1-777-189-3960', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Inactive', '', '2020-10-10 23:40:06', NULL),
(2, 1, NULL, 'Kieran James', 'Cras.convallis@egetvolutpat.net', 'Kieran James', '1-436-496-3521', '1-633-327-1215', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Active', '', '2020-10-10 23:40:49', NULL),
(3, 1, NULL, 'Caldwell Jarvis', 'sagittis@Pellentesquetincidunt.edu', '', '1-498-736-4069', '1-161-144-7985', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Active', '', '2020-10-10 23:41:41', NULL),
(4, 1, NULL, 'Jameson Boyle', 'facilisi@diam.org', 'Quinn Castaneda', '1-983-643-5121', '1-770-708-7636', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Inactive', '', '2020-10-10 23:42:29', NULL),
(5, 1, NULL, 'Hu Gross', 'Aliquam.ornare.libero@Crasdolor.org', 'Wang Oneil', '1-347-447-1374', '1-381-396-5525', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Active', '', '2020-10-10 23:43:14', NULL),
(6, 1, NULL, 'Axel Weeks', 'pellentesque.eget@ultricesVivamusrhoncus.org', 'Ivan Crawford', '1-269-604-0991', '1-649-395-6414', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Inactive', '', '2020-10-10 23:52:01', NULL),
(7, 1, NULL, 'Edward Sanchez', 'diam@consectetuer.com', 'Neil Colon', '1-244-724-1790', '1-808-290-9609', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Inactive', '', '2020-10-10 23:52:51', NULL),
(8, 1, NULL, 'Magee Morton', 'venenatis.a@Aeneaneget.ca', '', '', '', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Inactive', '', '2020-10-10 23:53:22', NULL),
(9, 1, NULL, 'Arthur Cook', '', '', '', '', '', '', '', '', '', '', '', 'Inactive', '', '2020-10-10 23:53:36', NULL),
(10, 1, NULL, 'Troy Decker', 'Integer@Mauris.net', 'Lance Mckee', '1-189-139-0545', '1-531-483-5748', '', '', '', '', '', '', '', 'Inactive', '', '2020-10-10 23:54:10', NULL),
(11, 1, NULL, 'Wesley Cote', 'quam@ipsumsodales.ca', '', '', '', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Inactive', '', '2020-10-10 23:54:44', NULL),
(12, 1, NULL, 'Ulysses Carlson', 'scelerisque@pede.ca', 'Forrest Blanchard', '1-840-828-1220', '1-815-776-6696', '', '', '', '', '', '', '', 'Active', '', '2020-10-10 23:55:28', NULL),
(13, 1, 1, 'Nissim Wooten', 'arcu.ac@Suspendisse.net', 'Mohammad Alexander', '1-240-219-6276', '1-906-458-8175', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Active', '', '2020-10-10 23:56:08', '2020-10-10 23:56:22'),
(14, 1, NULL, 'Dieter Hyde', 'risus@Maurisblandit.org', '1-376-990-8628', '1-546-349-2064', '1-546-349-2064', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Inactive', '', '2020-10-10 23:57:33', NULL),
(15, 1, NULL, 'Hu Stephenson', '', '', '', '', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Active', '', '2020-10-10 23:58:00', NULL),
(16, 1, NULL, 'Chancellor Abbott', 'at.egestas@nonjustoProin.net', 'Chancellor Abbott', '1-156-621-9956', '1-545-617-7267', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Active', '', '2020-10-10 23:58:43', NULL),
(17, 1, NULL, 'Arsenio Bird', 'ipsum@Sedauctor.net', 'Barclay Russell', '1-894-312-8440', '1-720-773-7922', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Active', '', '2020-10-10 23:59:30', NULL),
(18, 1, NULL, 'Macon Luna', 'ipsum.Phasellus.vitae@utipsum.net', 'Jelani Carrillo', '1-257-480-4306', '1-469-613-9678', '', '', '', '', '', '', '', 'Inactive', '', '2020-10-11 00:00:26', NULL),
(19, 1, NULL, 'Alden Colon', 'auctor@malesuadafringillaest.edu', 'Uriah Howard', '1-162-854-3844', '', '', '', '', '', '', '', '', 'Inactive', '', '2020-10-11 00:01:03', NULL),
(20, 1, NULL, 'Len Mccarty', 'sed@Nullatincidunt.com', '', '', '', '', '', '', '', '', '', '', 'Inactive', '', '2020-10-11 00:01:30', NULL),
(21, 1, 1, 'Michael Carismilth', 'michaelc@hotmail.com', '', '(958) 203-5829', '', '123 Fledeo Drive, 213 Mark Street, Great City, United States', '', '', '', '', '', '', 'Active', '', '2020-10-17 00:15:22', '2020-10-17 00:17:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expenses`
--

CREATE TABLE `tbl_expenses` (
  `expense_id` int(11) NOT NULL,
  `expense_category_id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `expense_created_by` int(11) NOT NULL,
  `expense_last_update_by` int(11) DEFAULT NULL,
  `expense_date` date DEFAULT NULL,
  `expense_description` varchar(250) NOT NULL,
  `expense_amount` decimal(10,2) NOT NULL,
  `expense_note` text DEFAULT NULL,
  `expense_created_at` datetime NOT NULL,
  `expense_updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_expenses`
--

INSERT INTO `tbl_expenses` (`expense_id`, `expense_category_id`, `provider_id`, `payment_id`, `file_id`, `expense_created_by`, `expense_last_update_by`, `expense_date`, `expense_description`, `expense_amount`, `expense_note`, `expense_created_at`, `expense_updated_at`) VALUES
(1, 1, 7, 6, 0, 1, NULL, '2020-01-01', 'Seed', '1200.00', '', '2020-10-16 23:04:14', NULL),
(2, 5, 11, 3, 0, 1, NULL, '2020-02-12', 'Fertilizer.', '900.00', '', '2020-10-16 23:04:57', NULL),
(3, 11, 7, 2, 0, 1, NULL, '2020-03-04', 'Feed', '2100.00', '', '2020-10-16 23:05:31', NULL),
(4, 10, 11, 7, 0, 1, NULL, '2020-04-21', 'Processing', '1300.00', '', '2020-10-16 23:06:18', NULL),
(5, 11, 7, 4, 0, 1, NULL, '2020-05-13', 'Marketing', '755.00', '', '2020-10-16 23:07:06', NULL),
(6, 4, 12, 6, 0, 1, NULL, '2020-06-25', 'Interest', '1025.00', '', '2020-10-16 23:08:14', NULL),
(7, 5, 7, 5, 0, 1, NULL, '2020-07-16', 'Depreciation', '2000.00', '', '2020-10-16 23:10:47', NULL),
(8, 7, 7, 1, 0, 1, NULL, '2020-08-19', 'Rent', '1750.00', '', '2020-10-16 23:11:33', NULL),
(9, 11, 1, 6, 0, 1, NULL, '2020-09-08', 'Telephone & Internet expenses', '1600.00', '', '2020-10-16 23:12:51', NULL),
(11, 7, 17, 1, 3, 1, 1, '2020-10-17', 'Walmart purchase', '46.30', 'For the office...', '2020-10-17 00:29:26', '2020-10-17 00:30:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expense_categories`
--

CREATE TABLE `tbl_expense_categories` (
  `expense_category_id` int(11) NOT NULL,
  `expense_category_created_by` int(11) NOT NULL,
  `expense_category_last_update_by` int(11) DEFAULT NULL,
  `expense_category_name` varchar(100) NOT NULL,
  `expense_category_status` enum('Active','Inactive') NOT NULL,
  `expense_category_created_at` datetime NOT NULL,
  `expense_category_updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_expense_categories`
--

INSERT INTO `tbl_expense_categories` (`expense_category_id`, `expense_category_created_by`, `expense_category_last_update_by`, `expense_category_name`, `expense_category_status`, `expense_category_created_at`, `expense_category_updated_at`) VALUES
(1, 9, 9, 'Entertaiment', 'Active', '2020-10-06 09:38:44', '2020-10-07 11:55:25'),
(2, 9, 9, 'Logding', 'Inactive', '2020-10-06 09:38:49', '2020-10-07 11:55:43'),
(3, 9, 9, 'Meals', 'Active', '2020-10-06 09:39:00', '2020-10-07 11:56:01'),
(4, 9, 9, 'Transportation', 'Active', '2020-10-06 09:39:08', '2020-10-07 11:56:19'),
(5, 9, 9, 'Utilities', 'Active', '2020-10-06 09:40:35', '2020-10-07 11:57:08'),
(6, 9, 9, 'Supplies', 'Inactive', '2020-10-06 09:40:40', '2020-10-07 11:57:22'),
(7, 9, 9, 'Cleaning and maint', 'Active', '2020-10-06 09:40:47', '2020-10-07 11:57:39'),
(8, 9, 9, 'Repairs', 'Active', '2020-10-06 09:40:52', '2020-10-07 11:57:51'),
(9, 9, 9, 'Insurance', 'Active', '2020-10-06 09:40:56', '2020-10-07 11:58:10'),
(10, 9, 9, 'Auto and Travel', 'Active', '2020-10-06 09:41:01', '2020-10-07 11:58:27'),
(11, 9, 9, 'Bills & Utilities', 'Active', '2020-10-06 09:41:09', '2020-10-07 12:01:05'),
(12, 1, 1, 'Advertising', 'Inactive', '2020-10-17 00:25:21', '2020-10-17 00:25:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_files`
--

CREATE TABLE `tbl_files` (
  `file_id` int(11) NOT NULL,
  `file_name` varchar(100) DEFAULT NULL,
  `file_storage_path` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_files`
--

INSERT INTO `tbl_files` (`file_id`, `file_name`, `file_storage_path`) VALUES
(1, 'receipt_5f8a6591db13f5.88234157.pdf', 'files/receipt_5f8a6591db13f5.88234157.pdf'),
(2, 'receipt_5f8a686aaa3df5.99332457.pdf', 'files/receipt_5f8a686aaa3df5.99332457.pdf'),
(3, 'receipt_5f8a73457b44d7.08867340.pdf', 'files/receipt_5f8a73457b44d7.08867340.pdf'),
(4, 'receipt_5f8a741635d805.93461730.pdf', 'files/receipt_5f8a741635d805.93461730.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_income`
--

CREATE TABLE `tbl_income` (
  `income_id` int(11) NOT NULL,
  `income_category_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `income_created_by` int(11) NOT NULL,
  `income_last_update_by` int(11) DEFAULT NULL,
  `income_date` date DEFAULT NULL,
  `income_description` varchar(250) NOT NULL,
  `income_amount` decimal(10,2) NOT NULL,
  `income_note` text DEFAULT NULL,
  `income_created_at` datetime NOT NULL,
  `income_updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_income`
--

INSERT INTO `tbl_income` (`income_id`, `income_category_id`, `customer_id`, `payment_id`, `file_id`, `income_created_by`, `income_last_update_by`, `income_date`, `income_description`, `income_amount`, `income_note`, `income_created_at`, `income_updated_at`) VALUES
(1, 4, 3, 1, 4, 1, 1, '2020-01-08', 'Government Payments.', '2000.00', '', '2020-10-16 22:58:34', '2020-10-17 00:33:26'),
(3, 1, 3, 1, 0, 1, 1, '2020-03-18', 'Sales of crop products', '5000.00', '', '2020-10-16 23:02:22', '2020-10-16 23:08:46'),
(4, 1, 12, 1, 1, 1, 1, '2020-04-15', 'Merchandise Sales', '5500.00', '', '2020-10-16 23:15:34', '2020-10-16 23:31:29'),
(5, 2, 16, 2, 0, 1, NULL, '2020-05-21', 'Music Lesson Income', '3000.00', '', '2020-10-16 23:16:12', NULL),
(6, 1, 12, 3, 0, 1, NULL, '2020-06-10', 'Sales Revenue', '3000.00', '', '2020-10-16 23:17:10', NULL),
(7, 2, 2, 4, 0, 1, NULL, '2020-07-22', 'Software sale', '3950.00', '', '2020-10-16 23:17:45', NULL),
(8, 9, 16, 6, 0, 1, NULL, '2020-08-05', 'Advertising.', '3500.00', '', '2020-10-16 23:18:23', NULL),
(9, 2, 15, 4, 0, 1, 1, '2020-09-16', 'Web Hosting', '2500.00', '', '2020-10-16 23:19:39', '2020-10-16 23:19:56'),
(10, 2, 3, 4, 0, 1, 1, '2020-10-14', 'Sales Revenue', '3500.00', '', '2020-10-16 23:20:41', '2020-10-16 23:21:00'),
(11, 1, 21, 3, 0, 1, NULL, '2020-04-13', 'Service Receipt', '470.00', '', '2020-10-17 00:32:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_income_categories`
--

CREATE TABLE `tbl_income_categories` (
  `income_category_id` int(11) NOT NULL,
  `income_category_created_by` int(11) NOT NULL,
  `income_category_last_update_by` int(11) DEFAULT NULL,
  `income_category_name` varchar(100) NOT NULL,
  `income_category_status` enum('Active','Inactive') NOT NULL,
  `income_category_created_at` datetime NOT NULL,
  `income_category_updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_income_categories`
--

INSERT INTO `tbl_income_categories` (`income_category_id`, `income_category_created_by`, `income_category_last_update_by`, `income_category_name`, `income_category_status`, `income_category_created_at`, `income_category_updated_at`) VALUES
(1, 9, 9, 'Product Sales', 'Active', '2020-10-06 10:29:53', '2020-10-07 12:19:39'),
(2, 9, 9, 'Service Sales', 'Active', '2020-10-06 10:36:00', '2020-10-07 12:19:44'),
(3, 9, 9, 'Interest Income', 'Active', '2020-10-06 10:36:11', '2020-10-07 12:08:25'),
(4, 9, 9, 'Capital Gain', 'Active', '2020-10-06 10:46:46', '2020-10-07 12:19:50'),
(5, 9, 9, 'Rental and Royalty', 'Inactive', '2020-10-06 10:46:52', '2020-10-07 12:11:44'),
(6, 9, 9, 'Utility Refund', 'Active', '2020-10-06 10:46:56', '2020-10-07 12:17:49'),
(7, 9, 9, 'Application Fee', 'Inactive', '2020-10-06 10:47:04', '2020-10-07 12:18:11'),
(8, 9, 9, 'Investment', 'Active', '2020-10-06 10:47:09', '2020-10-07 12:18:46'),
(9, 9, 9, 'Government Programs', 'Active', '2020-10-06 10:47:13', '2020-10-07 12:19:13'),
(10, 9, 9, 'Rental Properties', 'Inactive', '2020-10-06 10:48:04', '2020-10-07 12:14:16'),
(11, 9, 9, 'Capital', 'Inactive', '2020-10-06 10:48:14', '2020-10-07 12:13:18'),
(12, 9, 9, 'Earned', 'Inactive', '2020-10-06 10:57:28', '2020-10-07 12:13:04'),
(13, 1, 1, 'Mechanics and repaires', 'Active', '2020-10-17 00:24:09', '2020-10-17 00:24:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payments`
--

CREATE TABLE `tbl_payments` (
  `payment_id` int(11) NOT NULL,
  `payment_created_by` int(11) NOT NULL,
  `payment_last_update_by` int(11) DEFAULT NULL,
  `payment_name` varchar(100) NOT NULL,
  `payment_status` enum('Active','Inactive') NOT NULL,
  `payment_created_at` datetime NOT NULL,
  `payment_updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_payments`
--

INSERT INTO `tbl_payments` (`payment_id`, `payment_created_by`, `payment_last_update_by`, `payment_name`, `payment_status`, `payment_created_at`, `payment_updated_at`) VALUES
(1, 1, NULL, 'Cash', 'Active', '2020-10-09 12:36:37', NULL),
(2, 1, NULL, 'Checks', 'Active', '2020-10-09 12:36:44', NULL),
(3, 1, NULL, 'Debit cards', 'Active', '2020-10-09 12:36:52', NULL),
(4, 1, NULL, 'Credit cards', 'Active', '2020-10-09 12:36:59', NULL),
(5, 1, NULL, 'Mobile payments', 'Active', '2020-10-09 12:37:05', NULL),
(6, 1, NULL, 'Electronic bank transfers', 'Active', '2020-10-09 12:37:13', NULL),
(7, 1, NULL, 'Bitcoin', 'Active', '2020-10-09 12:38:00', NULL),
(8, 1, 1, 'Prepaid Card', 'Active', '2020-10-17 00:20:18', '2020-10-17 00:20:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_providers`
--

CREATE TABLE `tbl_providers` (
  `provider_id` int(11) NOT NULL,
  `provider_created_by` int(11) NOT NULL,
  `provider_last_update_by` int(11) DEFAULT NULL,
  `provider_full_name` varchar(100) NOT NULL,
  `provider_email` varchar(100) DEFAULT NULL,
  `provider_officer_name` varchar(100) NOT NULL,
  `provider_telephone` varchar(100) DEFAULT NULL,
  `provider_cellphone` varchar(100) DEFAULT NULL,
  `provider_address` varchar(500) DEFAULT NULL,
  `provider_bank_name` varchar(200) NOT NULL,
  `provider_bank_account_number` varchar(50) NOT NULL,
  `provider_bank_account_type` varchar(50) NOT NULL,
  `provider_website` varchar(200) NOT NULL,
  `provider_username` varchar(50) NOT NULL,
  `provider_password` varchar(50) NOT NULL,
  `provider_status` enum('Active','Inactive') NOT NULL,
  `provider_note` text DEFAULT NULL,
  `provider_created_at` datetime NOT NULL,
  `provider_updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_providers`
--

INSERT INTO `tbl_providers` (`provider_id`, `provider_created_by`, `provider_last_update_by`, `provider_full_name`, `provider_email`, `provider_officer_name`, `provider_telephone`, `provider_cellphone`, `provider_address`, `provider_bank_name`, `provider_bank_account_number`, `provider_bank_account_type`, `provider_website`, `provider_username`, `provider_password`, `provider_status`, `provider_note`, `provider_created_at`, `provider_updated_at`) VALUES
(1, 1, 1, 'Salvador Reese', 'Curabitur.sed@lectus.com', 'Thaddeus Short', '1-422-805-9061', '1-769-405-2870', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Active', '', '2020-10-10 23:16:29', '2020-10-10 23:29:43'),
(2, 1, 1, 'Reed Stevenson', 'viverra@duiFuscediam.org', 'Myles Pruitt', '1-851-396-9127', '1-517-677-4226', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Active', '', '2020-10-10 23:16:52', '2020-10-10 23:30:13'),
(3, 1, 1, 'Hall Mathews', 'eu@metusAeneansed.org', 'Lyle Clay', '1-850-208-4958', '1-499-648-1924', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Inactive', '', '2020-10-10 23:17:18', '2020-10-10 23:30:39'),
(4, 1, 1, 'Flynn Mclean', 'risus@Inmi.org', 'Melvin Payne', '1-490-320-6601', '1-153-956-3111', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Active', '', '2020-10-10 23:17:34', '2020-10-10 23:31:17'),
(5, 1, 1, 'Keaton Meadows', 'id.enim@Pellentesqueultriciesdignissim.com', 'Hiram Hoover', '1-479-938-1190', '1-566-465-9886', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Active', '', '2020-10-10 23:17:53', '2020-10-10 23:31:49'),
(6, 1, 1, 'Bradley Joseph', 'eget.ipsum.Suspendisse@nonfeugiat.edu', 'Macon Buck', '1-389-744-5735', '1-695-581-6189', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Inactive', '', '2020-10-10 23:18:13', '2020-10-10 23:32:14'),
(7, 1, NULL, 'Denton Harrington', 'Duis.ac@auctor.co.uk', 'Devin Brooks', '1-153-561-4032', '1-880-739-8160', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Active', '', '2020-10-10 23:22:49', NULL),
(8, 1, NULL, 'Armand Valencia', 'eu.enim@sapienCrasdolor.edu', 'Wang Rocha', '1-408-882-0505', '1-181-683-9218', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Active', '', '2020-10-10 23:26:16', NULL),
(9, 1, 1, 'Neil Blevins', 'eu.arcu@pharetraNam.org', 'Aaron Austin', '1-352-144-8881', '1-437-680-6848', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Active', '', '2020-10-10 23:27:15', '2020-10-10 23:32:48'),
(10, 1, 1, 'Elvis Berry', 'nulla.Integer.vulputate@mollis.ca', 'Derek Warren', '1-995-436-3153', '1-841-904-9551', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Active', '', '2020-10-10 23:28:15', '2020-10-10 23:32:39'),
(11, 1, NULL, 'Christopher Oneill', 'consectetuer.adipiscing.elit@sagittis.org', 'Mohammad Stephenson', '1-480-939-4340', '1-590-168-3689', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Active', '', '2020-10-10 23:29:08', NULL),
(12, 1, NULL, 'Lucas Patrick', 'parturient.montes@nonummyFuscefermentum.co.uk', 'Camden Wagner', '1-152-141-5623', '1-227-243-0619', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Active', '', '2020-10-10 23:34:23', NULL),
(13, 1, 1, 'Paul Justice', 'sollicitudin.adipiscing.ligula@ipsumnuncid.org', 'Carlos Good', '1-951-564-9971', '1-474-291-2834', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Inactive', '', '2020-10-10 23:35:25', '2020-10-10 23:37:56'),
(14, 1, NULL, 'Boris Pitts', 'eu.odio.tristique@Donec.co.uk', 'Chadwick Hardin', '1-583-689-2656', '1-611-117-8293', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Active', '', '2020-10-10 23:36:10', NULL),
(15, 1, NULL, 'Abdul Simmons', 'sed.hendrerit@arcu.net', 'Allistair Davidson', '1-384-287-0266', '1-674-334-6744', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Active', '', '2020-10-10 23:36:57', NULL),
(16, 1, NULL, 'Benjamin Valencia', 'vehicula@Sedeget.net', 'Nissim Robertson', '1-291-686-4603', '1-593-931-1493', '', '', '', '', 'http://egavilanmedia.com', '', '', 'Inactive', '', '2020-10-10 23:37:48', NULL),
(17, 1, 1, 'Walmart', '', '', '', '', '', '', '', '', '', '', '', 'Active', '', '2020-10-17 00:13:15', '2020-10-17 00:13:56');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `user_created_by` int(11) NOT NULL,
  `user_last_update_by` int(11) DEFAULT NULL,
  `user_full_name` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_gender` enum('Male','Female') NOT NULL,
  `user_status` enum('Active','Inactive') NOT NULL,
  `user_role` enum('Admin','User') NOT NULL,
  `user_password` varchar(150) NOT NULL,
  `user_created_at` datetime NOT NULL,
  `user_updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `user_created_by`, `user_last_update_by`, `user_full_name`, `user_email`, `user_gender`, `user_status`, `user_role`, `user_password`, `user_created_at`, `user_updated_at`) VALUES
(1, 1, 1, 'EGavilan Media', 'egavilanmedia@gmail.com', 'Male', 'Active', 'Admin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2020-08-24 06:10:10', '2020-10-16 22:38:40'),
(2, 1, NULL, 'user', 'user@gmail.com', 'Male', 'Active', 'User', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2020-10-11 20:23:17', NULL),
(3, 1, 1, 'E Gavilan', 'egavilan@gmail.com', 'Male', 'Inactive', 'User', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2020-10-17 00:11:24', '2020-10-17 00:12:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_company`
--
ALTER TABLE `tbl_company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `tbl_expenses`
--
ALTER TABLE `tbl_expenses`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `tbl_expense_categories`
--
ALTER TABLE `tbl_expense_categories`
  ADD PRIMARY KEY (`expense_category_id`);

--
-- Indexes for table `tbl_files`
--
ALTER TABLE `tbl_files`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `tbl_income`
--
ALTER TABLE `tbl_income`
  ADD PRIMARY KEY (`income_id`);

--
-- Indexes for table `tbl_income_categories`
--
ALTER TABLE `tbl_income_categories`
  ADD PRIMARY KEY (`income_category_id`);

--
-- Indexes for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `tbl_providers`
--
ALTER TABLE `tbl_providers`
  ADD PRIMARY KEY (`provider_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_company`
--
ALTER TABLE `tbl_company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_expenses`
--
ALTER TABLE `tbl_expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_expense_categories`
--
ALTER TABLE `tbl_expense_categories`
  MODIFY `expense_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_files`
--
ALTER TABLE `tbl_files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_income`
--
ALTER TABLE `tbl_income`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_income_categories`
--
ALTER TABLE `tbl_income_categories`
  MODIFY `income_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_providers`
--
ALTER TABLE `tbl_providers`
  MODIFY `provider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
