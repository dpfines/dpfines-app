-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2025 at 07:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dpfines`
--

-- --------------------------------------------------------

--
-- Table structure for table `global_fines`
--

CREATE TABLE `global_fines` (
  `id` int(11) NOT NULL,
  `organisation` varchar(255) NOT NULL,
  `regulator` enum('ICO (UK)','CNIL (France)','BfDI (Germany)','DPC (Ireland)','AEPD (Spain)','FTC (USA)','OAIC (Australia)','OPC (Canada)','CNPD (Luxembourg)') NOT NULL,
  `sector` enum('Finance & Banking','Healthcare','Technology','Retail & E-commerce','Telecommunications','Public Sector','Education','Aviation / Transportation','Social Media') NOT NULL,
  `region` enum('EU / EEA','USA','Australia','Canada','Global') DEFAULT NULL,
  `fine_amount` decimal(20,2) DEFAULT NULL,
  `currency` enum('EUR','GBP','USD','AUD','CAD') NOT NULL,
  `fine_date` date DEFAULT NULL,
  `law` enum('GDPR','UK GDPR','DPA 2018','CCPA','Other') DEFAULT NULL,
  `articles_breached` varchar(255) DEFAULT NULL,
  `violation_type` enum('Security Breach','Inadequate Security','Consent Issues','Transparency','Data Transfer','Unlawful Processing','Children''s Privacy') DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `badges` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `link_to_case` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `global_fines`
--

INSERT INTO `global_fines` (`id`, `organisation`, `regulator`, `sector`, `region`, `fine_amount`, `currency`, `fine_date`, `law`, `articles_breached`, `violation_type`, `summary`, `badges`, `created_at`, `updated_at`, `link_to_case`) VALUES
(1, 'British Airways', 'ICO (UK)', 'Aviation / Transportation', 'EU / EEA', 20000000.00, 'GBP', '2020-10-01', 'GDPR', 'Art. 5, Art. 32', 'Security Breach', 'ICO fined British Airways £20M for a major security breach affecting 400,000+ customers.', 'major-breach,high-impact', '2025-11-21 11:30:04', '2025-11-21 11:30:04', 'https://www.bbc.com/news/technology-54568749'),
(2, 'Marriott International', 'ICO (UK)', 'Technology', 'EU / EEA', 18400000.00, 'GBP', '2020-11-01', 'GDPR', 'Art. 5, Art. 6, Art. 32', 'Inadequate Security', 'ICO fined Marriott £18.4M for failing to secure Starwood guest database.', 'security-failure', '2025-11-21 11:30:04', '2025-11-21 11:30:04', 'https://www.bbc.com/news/technology-54748843'),
(3, 'Clearview AI', 'ICO (UK)', 'Technology', 'Global', 7500000.00, 'GBP', '2022-05-23', 'UK GDPR', 'Art. 5, Art. 6', 'Unlawful Processing', 'ICO fined Clearview AI for unlawful collection of facial images scraped from the internet.', 'ai,biometrics', '2025-11-21 11:30:04', '2025-11-21 11:30:04', 'https://ico.org.uk/about-the-ico/media-centre/news-and-blogs/2022/05/ico-fines-clearview-ai-inc/'),
(4, 'TikTok', 'ICO (UK)', 'Social Media', 'EU / EEA', 12700000.00, 'GBP', '2023-04-04', 'UK GDPR', 'Art. 8', 'Children\'s Privacy', 'TikTok fined for allowing under-13s on the platform without parental consent.', 'children-privacy', '2025-11-21 11:30:04', '2025-11-21 11:30:04', 'https://ico.org.uk/about-the-ico/media-centre/news-and-blogs/2023/04/ico-fines-tiktok-127-million/'),
(5, 'Meta Platforms (Facebook)', 'DPC (Ireland)', 'Social Media', 'EU / EEA', 390000000.00, 'EUR', '2023-01-04', 'GDPR', 'Art. 6', 'Consent Issues', 'Ireland\'s DPC fined Meta €390M for unlawful personalised advertising practices.', 'adtech,consent', '2025-11-21 11:30:04', '2025-11-21 11:30:04', 'https://www.dataprotection.ie/en/news-media/press-releases/dpc-announces-decisions-and-fines-totaling-390-million-meta'),
(6, 'Amazon Europe Core', 'CNPD (Luxembourg)', 'Retail & E-commerce', 'EU / EEA', 746000000.00, 'EUR', '2021-07-16', 'GDPR', 'Art. 6', 'Unlawful Processing', 'Record-breaking €746M GDPR fine for unlawful processing of personal data for advertising.', 'record-fine', '2025-11-21 11:30:04', '2025-11-21 11:30:04', 'https://www.reuters.com/world/europe/amazon-fined-746-mln-euros-luxembourg-privacy-case-2021-07-30/'),
(7, 'WhatsApp Ireland', 'DPC (Ireland)', 'Technology', 'EU / EEA', 225000000.00, 'EUR', '2021-09-02', 'GDPR', 'Art. 12–14', 'Transparency', 'WhatsApp fined €225M for failing to properly disclose how data is shared with Facebook.', 'transparency', '2025-11-21 11:30:04', '2025-11-21 11:30:04', 'https://www.bbc.com/news/world-europe-58421352'),
(8, 'British Broadcasting Corporation (BBC)', 'ICO (UK)', 'Public Sector', '', 180000.00, 'GBP', '2021-05-01', 'UK GDPR', 'Art. 5', 'Security Breach', 'BBC fined for exposing personal data of pension scheme members.', 'public-sector,security', '2025-11-21 11:30:04', '2025-11-21 11:30:04', 'https://www.theregister.com/2021/02/09/bbc_ico_fine/'),
(9, 'H&M (Germany)', 'BfDI (Germany)', 'Retail & E-commerce', 'EU / EEA', 35000000.00, 'EUR', '2020-10-01', 'GDPR', 'Art. 5, Art. 6', 'Unlawful Processing', 'H&M fined €35M for excessive employee monitoring practices.', 'employee-data', '2025-11-21 11:30:04', '2025-11-21 11:30:04', 'https://www.bbc.com/news/technology-54423988'),
(10, 'Google LLC', 'CNIL (France)', 'Technology', 'EU / EEA', 100000000.00, 'EUR', '2020-12-07', 'GDPR', 'Art. 82 (cookies)', 'Consent Issues', 'CNIL fined Google €100M for dropping advertising cookies without valid consent.', 'cookies,adtech', '2025-11-21 11:30:04', '2025-11-21 11:30:04', 'https://www.reuters.com/article/us-france-google-privacy-idUSKBN28H1P8');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `global_fines`
--
ALTER TABLE `global_fines`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `global_fines`
--
ALTER TABLE `global_fines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
