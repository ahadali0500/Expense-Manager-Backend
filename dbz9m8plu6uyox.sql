-- phpMyAdmin SQL Dump
-- version 5.1.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 21, 2024 at 10:10 AM
-- Server version: 8.0.36-28
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbz9m8plu6uyox`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_type`
--

CREATE TABLE `access_type` (
  `id` int NOT NULL,
  `access` varchar(250) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `access_type`
--

INSERT INTO `access_type` (`id`, `access`) VALUES
(1, 'Full'),
(2, 'Moderate'),
(3, 'Limited');

-- --------------------------------------------------------

--
-- Table structure for table `add-expense`
--

CREATE TABLE `add-expense` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `bank_id` int NOT NULL,
  `expense_type_id` int DEFAULT NULL,
  `general_expense_id` int DEFAULT NULL,
  `buisness_expense_id` int DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `departments_expense_id` int DEFAULT NULL,
  `departments_compensation_id` int DEFAULT NULL,
  `departments_employee_id` int DEFAULT NULL,
  `departments_purchase_id` int DEFAULT NULL,
  `payment_mode_id` int DEFAULT NULL,
  `everyday_expense_id` int DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_general_ci,
  `screenshot` varchar(1000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `transaction_by` int NOT NULL DEFAULT '0',
  `company_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add-expense`
--

INSERT INTO `add-expense` (`id`, `user_id`, `bank_id`, `expense_type_id`, `general_expense_id`, `buisness_expense_id`, `department_id`, `departments_expense_id`, `departments_compensation_id`, `departments_employee_id`, `departments_purchase_id`, `payment_mode_id`, `everyday_expense_id`, `amount`, `date`, `description`, `screenshot`, `transaction_by`, `company_id`) VALUES
(77, 40, 18, 2, 0, 35, 11, 1, 1, 21, 0, 4, 0, 200, '2024-07-12 00:00:00', 'qwsd', NULL, 40, 21),
(78, 40, 18, 2, 0, 35, 12, 2, 0, 0, 9, 15, 0, 2200, '2024-07-12 00:00:00', 'hyyy ', '1000140449_1720760193.jpg', 0, 21),
(79, 40, 18, 2, 0, 36, 0, 0, 0, 0, 0, 4, 13, 200, '2024-07-12 00:00:00', 'tyu', NULL, 36, 21),
(80, 36, 18, 1, 24, 0, 0, 0, 0, 0, 0, 12, 0, 3000, '2024-10-17 00:00:00', 'bill pay', NULL, 36, 21),
(81, 36, 20, 1, 26, 0, 0, 0, 0, 0, 0, 4, 0, 3000, '2024-10-17 00:00:00', 'b do fmdf', NULL, 36, 21);

-- --------------------------------------------------------

--
-- Table structure for table `add_income`
--

CREATE TABLE `add_income` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `bank_id` int NOT NULL,
  `amount` int NOT NULL,
  `datetime` datetime NOT NULL,
  `payment_mode` int NOT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `company_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_income`
--

INSERT INTO `add_income` (`id`, `user_id`, `bank_id`, `amount`, `datetime`, `payment_mode`, `details`, `image`, `company_id`) VALUES
(70, 40, 18, 4000, '2024-08-15 00:00:00', 4, 'abc', NULL, 21),
(71, 36, 18, 3000, '2024-10-17 00:00:00', 4, 'ggfdfdjjshbd', NULL, 21);

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` int NOT NULL,
  `company_id` int NOT NULL,
  `bank_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `current_amount` int NOT NULL,
  `actual_amount` int NOT NULL,
  `image` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `company_id`, `bank_name`, `current_amount`, `actual_amount`, `image`, `status`) VALUES
(18, 21, 'Meezan Bank', 41400, 40000, 'unnamed_1720693356.png', 0),
(19, 21, 'Alflah Bank', 1, 1, 'bafl-logo-home_1723705098.png', 0),
(20, 21, 'Bank Islami', 2000, 5000, 'BIPL-Logo_1723706411.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bank_transaction`
--

CREATE TABLE `bank_transaction` (
  `id` int NOT NULL,
  `income_id` int NOT NULL,
  `user_id` int NOT NULL,
  `bank_id` int NOT NULL,
  `amount_add` int NOT NULL,
  `amount_detect` int NOT NULL,
  `current_amount` int NOT NULL,
  `actual_amount` int NOT NULL,
  `payment_mode` int NOT NULL,
  `expense_id` int NOT NULL,
  `date` datetime NOT NULL,
  `company_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank_transaction`
--

INSERT INTO `bank_transaction` (`id`, `income_id`, `user_id`, `bank_id`, `amount_add`, `amount_detect`, `current_amount`, `actual_amount`, `payment_mode`, `expense_id`, `date`, `company_id`) VALUES
(91, 0, 0, 0, 40000, 0, 40000, 40000, 16, 0, '2024-07-11 00:00:00', 21),
(92, 0, 40, 18, 0, 200, 39800, 40000, 4, 77, '2024-07-12 00:00:00', 21),
(93, 0, 40, 18, 0, 2200, 37600, 39800, 15, 78, '2024-07-12 00:00:00', 21),
(94, 0, 40, 18, 0, 200, 37400, 37600, 4, 79, '2024-07-12 00:00:00', 21),
(95, 70, 40, 18, 4000, 0, 41400, 37400, 4, 0, '2024-08-15 00:00:00', 21),
(96, 71, 36, 18, 3000, 0, 44400, 41400, 4, 0, '2024-10-17 00:00:00', 21),
(97, 0, 36, 18, 0, 3000, 41400, 44400, 12, 80, '2024-10-17 00:00:00', 21),
(98, 0, 36, 20, 0, 3000, 2000, 5000, 4, 81, '2024-10-17 00:00:00', 21);

-- --------------------------------------------------------

--
-- Table structure for table `business_expense_list`
--

CREATE TABLE `business_expense_list` (
  `id` int NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '0=active 1=unactive',
  `company_id` int NOT NULL,
  `kuch` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business_expense_list`
--

INSERT INTO `business_expense_list` (`id`, `name`, `status`, `company_id`, `kuch`) VALUES
(33, 'Department Expense', 0, 20, 5),
(34, 'Everyday Expense', 0, 20, 6),
(35, 'Department Expense', 0, 21, 5),
(36, 'Everyday Expense', 0, 21, 6),
(37, 'Utilities', 0, 21, 0),
(38, 'Office Equipment', 0, 21, 0),
(39, 'Department Expense', 1, 22, 5),
(40, 'Everyday Expense', 1, 22, 6),
(41, 'Department Expense', 0, 23, 5),
(42, 'Everyday Expense', 0, 23, 6);

-- --------------------------------------------------------

--
-- Table structure for table `codeRecoverPassword`
--

CREATE TABLE `codeRecoverPassword` (
  `id` int NOT NULL,
  `email` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `code` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int NOT NULL,
  `name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `logo` varchar(250) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `email`, `password`, `logo`) VALUES
(20, 'Ahad Ali', 'ahadali0500@gmail.com', 'ahadali0500', 'jquery_1720612854.png'),
(21, 'Desired Technology', 'desiredtechnology@gmail.com', 'desiredtechnology', 'title_1720677786.png'),
(22, 'Darrel Gamble', 'zaveduxiq@mailinator.com', 'Pa$$w0rd!', 'html-5_1720760741.png'),
(23, 'Sigourney Hunter', 'fehozoq@mailinator.com', 'Pa$$w0rd!', 'github_1720764665.png');

-- --------------------------------------------------------

--
-- Table structure for table `company-expense-type`
--

CREATE TABLE `company-expense-type` (
  `id` int NOT NULL,
  `expense_type_id` int NOT NULL,
  `company_id` int NOT NULL,
  `expense_name` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  `department` int NOT NULL DEFAULT '1',
  `Compensations` int NOT NULL DEFAULT '1',
  `Employees` int NOT NULL DEFAULT '1',
  `Partnership` int NOT NULL DEFAULT '1',
  `Contractor` int NOT NULL DEFAULT '1',
  `PurchasingTools` int NOT NULL DEFAULT '1',
  `everyday` int NOT NULL DEFAULT '1',
  `status` int NOT NULL DEFAULT '1' COMMENT '0= active 1= disactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company-expense-type`
--

INSERT INTO `company-expense-type` (`id`, `expense_type_id`, `company_id`, `expense_name`, `department`, `Compensations`, `Employees`, `Partnership`, `Contractor`, `PurchasingTools`, `everyday`, `status`) VALUES
(17, 1, 20, 'General Expense', 0, 0, 1, 1, 1, 0, 0, 0),
(18, 2, 20, 'Office Expense', 0, 0, 0, 0, 0, 0, 0, 0),
(19, 1, 21, 'Home Expense', 0, 0, 1, 1, 1, 0, 0, 0),
(20, 2, 21, 'Office Expense', 0, 0, 0, 0, 0, 0, 0, 0),
(21, 1, 22, 'General Expense', 0, 0, 1, 1, 1, 0, 0, 0),
(22, 2, 22, 'Bussiness Expense', 1, 1, 1, 1, 1, 1, 1, 1),
(23, 1, 23, 'General Expense', 1, 1, 1, 1, 1, 1, 1, 0),
(24, 2, 23, 'Bussiness Expense', 0, 0, 0, 1, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `compensation_list`
--

CREATE TABLE `compensation_list` (
  `id` int NOT NULL,
  `type` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `company_id` int NOT NULL,
  `comp_id_type` int NOT NULL COMMENT '1= Employees 2= Invsertor/Partnership 3= Contractor',
  `status` int NOT NULL COMMENT '0= active 1= disactive	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compensation_list`
--

INSERT INTO `compensation_list` (`id`, `type`, `company_id`, `comp_id_type`, `status`) VALUES
(1, 'Employees', 21, 1, 0),
(2, 'Invsertor/Partnership', 21, 2, 0),
(3, 'Contractor', 21, 3, 0),
(4, 'Employees', 23, 1, 0),
(5, 'Invsertor/Partnership', 23, 2, 1),
(6, 'Contractor', 23, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int NOT NULL,
  `dept_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '0=active 1=unactive',
  `company_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `dept_name`, `status`, `company_id`) VALUES
(11, 'Development', 0, 21),
(12, 'SEO', 0, 21),
(13, 'Ahad Ali', 0, 23),
(14, 'bye', 0, 23);

-- --------------------------------------------------------

--
-- Table structure for table `department_expense`
--

CREATE TABLE `department_expense` (
  `id` int NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `dpt_expense_type` int NOT NULL,
  `company_id` int NOT NULL,
  `status` int NOT NULL COMMENT '0= active 1= disactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_expense`
--

INSERT INTO `department_expense` (`id`, `name`, `dpt_expense_type`, `company_id`, `status`) VALUES
(1, 'Compensations', 1, 21, 0),
(2, 'Purchasing Tools', 2, 21, 0),
(7, 'Compensation', 1, 22, 1),
(8, 'Purchasing Tools', 2, 22, 1),
(9, 'Compensation', 1, 23, 0),
(10, 'Purchasing Tools', 2, 23, 1);

-- --------------------------------------------------------

--
-- Table structure for table `department_purchasing_list`
--

CREATE TABLE `department_purchasing_list` (
  `id` int NOT NULL,
  `name` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `dpt_id` int NOT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '0=active 1=unactive',
  `company_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_purchasing_list`
--

INSERT INTO `department_purchasing_list` (`id`, `name`, `dpt_id`, `status`, `company_id`) VALUES
(9, 'Adsense ', 12, 0, 21),
(10, 'Subscriptions', 11, 0, 21),
(11, 'packages', 11, 1, 20),
(12, 'bbubfiu', 14, 0, 23);

-- --------------------------------------------------------

--
-- Table structure for table `employees_list`
--

CREATE TABLE `employees_list` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `employee_type` int NOT NULL COMMENT '1= Employees\r\n2= Invsertor/Partnership\r\n3= Contractor',
  `date_of_joining` date NOT NULL,
  `image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dept_id` int NOT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '0=active 1=unactive',
  `company_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees_list`
--

INSERT INTO `employees_list` (`id`, `name`, `employee_type`, `date_of_joining`, `image`, `dept_id`, `status`, `company_id`) VALUES
(21, 'ahmed', 1, '2024-07-11', 'attractive-dark-haired-man-is-working-table-office-he-wears-blue-shirt-with-black-jacket-he-is-taking-cup-coffee-smiling-camera_1720723492.jpg', 11, 0, 21),
(22, 'Nadeem', 2, '2024-07-11', 'artwork_1_1720723549.jpg', 12, 0, 21),
(23, 'Hira', 2, '2024-07-11', 'artwork_3_1720723588.jpg', 12, 0, 21);

-- --------------------------------------------------------

--
-- Table structure for table `everday_expenses_list`
--

CREATE TABLE `everday_expenses_list` (
  `id` int NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int DEFAULT '0',
  `company_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `everday_expenses_list`
--

INSERT INTO `everday_expenses_list` (`id`, `name`, `status`, `company_id`) VALUES
(12, 'Food', 0, 21),
(13, 'Travelling', 0, 21);

-- --------------------------------------------------------

--
-- Table structure for table `expense_type`
--

CREATE TABLE `expense_type` (
  `id` int NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `company_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense_type`
--

INSERT INTO `expense_type` (`id`, `name`, `company_id`) VALUES
(1, 'General Expense', 8),
(2, 'Bussiness Expense', 8);

-- --------------------------------------------------------

--
-- Table structure for table `general_expenses_list`
--

CREATE TABLE `general_expenses_list` (
  `id` int NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '0=active 1=unactive',
  `company_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `general_expenses_list`
--

INSERT INTO `general_expenses_list` (`id`, `name`, `status`, `company_id`) VALUES
(24, 'Internet, Cable, and Phone', 0, 21),
(25, 'Maintenance and Repairs', 1, 21),
(26, 'Electricity', 0, 21);

-- --------------------------------------------------------

--
-- Table structure for table `payment_mode`
--

CREATE TABLE `payment_mode` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_mode`
--

INSERT INTO `payment_mode` (`id`, `name`) VALUES
(4, 'Cash'),
(6, 'Credit Card'),
(10, 'Debit Card'),
(12, 'Net Banking'),
(14, 'Cheque'),
(15, 'JazzCash'),
(16, 'Manual');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `access` int NOT NULL DEFAULT '0' COMMENT '0 = pending\r\n1 = full     (All)\r\n2 = Moderate (Add-Expense, View-all-Expense)\r\n3 = Limited  (Add-Expense, View-his-Expense)\r\n4- denied',
  `image` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `company_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `access`, `image`, `company_id`) VALUES
(36, 'noor ', 'noorulan45@gmail.com', 'desirediez', 1, '', 21),
(37, 'ahmed', 'ahmed@gmail.com', '1234567', 2, '', 21),
(38, 'hassan ', 'hassan@gmail.com', '1234567', 3, '', 21),
(39, 'ali', 'ali123@gmail.com', '1234567', 0, '', 20),
(40, 'kashif', 'kashif@gmail.com', '12345678', 1, '1000140450_1720717582.jpg', 21),
(41, 'ahad ali', 'ahadali@gmail.com', '12345678', 0, '1000143378_1722077817.jpg', 8077);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_type`
--
ALTER TABLE `access_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `add-expense`
--
ALTER TABLE `add-expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `add_income`
--
ALTER TABLE `add_income`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_transaction`
--
ALTER TABLE `bank_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_expense_list`
--
ALTER TABLE `business_expense_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `codeRecoverPassword`
--
ALTER TABLE `codeRecoverPassword`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company-expense-type`
--
ALTER TABLE `company-expense-type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compensation_list`
--
ALTER TABLE `compensation_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department_expense`
--
ALTER TABLE `department_expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department_purchasing_list`
--
ALTER TABLE `department_purchasing_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees_list`
--
ALTER TABLE `employees_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_type` (`employee_type`);

--
-- Indexes for table `everday_expenses_list`
--
ALTER TABLE `everday_expenses_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_type`
--
ALTER TABLE `expense_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_expenses_list`
--
ALTER TABLE `general_expenses_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_mode`
--
ALTER TABLE `payment_mode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_type`
--
ALTER TABLE `access_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `add-expense`
--
ALTER TABLE `add-expense`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `add_income`
--
ALTER TABLE `add_income`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `bank_transaction`
--
ALTER TABLE `bank_transaction`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `business_expense_list`
--
ALTER TABLE `business_expense_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `codeRecoverPassword`
--
ALTER TABLE `codeRecoverPassword`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `company-expense-type`
--
ALTER TABLE `company-expense-type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `compensation_list`
--
ALTER TABLE `compensation_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `department_expense`
--
ALTER TABLE `department_expense`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `department_purchasing_list`
--
ALTER TABLE `department_purchasing_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `employees_list`
--
ALTER TABLE `employees_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `everday_expenses_list`
--
ALTER TABLE `everday_expenses_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `expense_type`
--
ALTER TABLE `expense_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `general_expenses_list`
--
ALTER TABLE `general_expenses_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `payment_mode`
--
ALTER TABLE `payment_mode`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
