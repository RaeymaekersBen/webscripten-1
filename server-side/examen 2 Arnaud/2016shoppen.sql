-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: 
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `icon`) VALUES
(1, 'Babyspulletjes en kinderkleding', 'toys.png'),
(2, 'Culinaire zaken', 'winetasting.png'),
(3, 'Fotografie en toebehoren', 'photo.png');

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--
DROP TABLE IF EXISTS `shops`;
CREATE TABLE `shops` (
`id` int(11) NOT NULL,
`name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
`category_id` int(11) NOT NULL DEFAULT 0, 
`description` varchar(1000) COLLATE utf8mb4_unicode_ci,
`address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
`lat` decimal(9,6) NOT NULL,
`lon` decimal(9,6) NOT NULL,
`website` varchar(255) COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `name`, `category_id`, `description`, `address`, `lat`, `lon`, `website`) VALUES
(1, 'De Springboon', 1, 'Lore Smet zit tot over haar oren in de wonderlijke wereld van kinders en kleuren. Ze had al twee jonge ukkies en een webshop met toffe baby- en kinderspullen. Nu is daar ook nog een kleurrijke winkel bijgekomen, een echte, in de Baselstraat in Kruibeke. Het is hier leuk winkelen. Lore is haar vrolijke enthousiaste zelve, en van al dat moois begin je spontaan vertederd te kijken. Het speelgoed is sprookjesachtig, met poppen van Roodkapje en puzzels in de vorm van ridders en prinsessen. De kleertjes (van 0 tot 8 jaar) hebben dan weer felle kleuren en leuke prints. Er zijn babypakjes met tractors en met kersjes, grappige t-shirts met opgedrukte dassen, slaapzakjes met \'schaap zacht\' erop... Af en toe gaat het hier de nostalgische kant uit. Monchichi aapjes! Maar ook: blikken doosjes, tasjes met tekeningen van potjes confituur, zelfgemaakte vintage juwelen.', 'Bazelstraat 15 - 9150 Kruibeke', 51.169770, 4.311809, 'http://www.springboon.be'),
(2, 'Kinderkleding KIDS', 1, 'Ontdek onze collectie kinderkleding! Kleding van 0 tot 16 jaar. ONZE MERKEN: CKS, Garcia, Esprit, EDC, Rumbl, Blablabla, BFC, Cars, Ten Cate', 'Langestraat 88 - 9150 Kruibeke', 51.174939, 4.314975, 'http://kinderkledingkidskruibeke.be'),
(3, 'Kaas & Wijn Stefaan', 2, 'Stefaan is reeds van jongsaf gepassioneerd door wijnen. Na zijn studies aan de Hotelschool Koksijde heeft hij steeds gewerkt als sommelier in enkele klassezaken in België. In 2005 is hij verkozen tot "Eerste Sommelier van België" en in 2006 won hij de wedstrijd "Beste Sommelier van België". In 2010 nam Stefaan deel aan het Wereldkampioenschap voor Sommeliers van Zuid-Afrikaanse Wijnen. (WOSA Sommelier World Cup) Hij werd zeer verdienstelijk tweede. 

Hierna is de wijnimport gestart. Door veel te proeven en te vergelijken en door een juiste prijszetting te handhaven garanderen wij u het beste uit elke regio die we aanbieden. We hebben een uitgebreid assortiment uit Zuid-Afrika, Italië, Frankrijk en vele andere landen. Stefaan beslist niet alles alleen, als Sally het ook lekker vindt, dan pas stellen we de wijnen te koop aan.

Sally is de rechterhand van Stefaan (en ook wel de linkerhand). Zij helpt waar en wanneer nodig en zorgt voor de ondersteuning ivm leveringen en winkel.', 'Langestraat 103 - 9150 Kruibeke', 51.174740, 4.315128, 'http://kaasenwijnstefaan.be/'),
(4, 'Studio Deyaert', 3, 'Studio Deyaert is een betrouwbare fotostudio die met veel plezier uw speciale dag op de gevoelige plaat vastlegt. Deze fotostudio in Rupelmonde bestaat al 93 jaar. Dankzij die ruime ervaring mag u altijd zeker zijn van kwalitatieve resultaten. Studio Deyaert is een familiebedrijf dat al drie generaties instaat voor de beste foto\'s voor elke gelegenheid. Fotografie is voor ons meer dan een beroep: het is een roeping. Eén waar wij met veel plezier op inspelen.', 'Kloosterstraat 29 - 9150 Rupelmonde', 51.128098, 4.288900, 'http://studiodeyaert.be/')

;

-- --------------------------------------------------------




--
-- Table structure for table `actions`
--
DROP TABLE IF EXISTS `actions`;
CREATE TABLE `actions` (
`id` int(11) NOT NULL,
`title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
`shop_id` int(11) NOT NULL,
`weight` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `title`, `shop_id`, `weight`) VALUES
(1, '-15% schattige lampen Lapin & me', 1, -4),
(2, 'Gratis roggeverdommebrood bij kaasschotel', 3, -6),
(3, 'Wijndegustatie op 20 maart 2016', 3, 0);

-- --------------------------------------------------------




--
-- Table structure for table `users`
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
`id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$ERrAdBi/yPrdwAzgHOx1ROSZzt1U03wubDGBZu45oWpDRCnO0Frf2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
 ADD PRIMARY KEY (`id`);
 
 --
-- Indexes for table `actions`
--
ALTER TABLE `actions`
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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;