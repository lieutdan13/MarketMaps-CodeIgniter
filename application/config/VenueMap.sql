/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Event` (
  `EventId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `VenueId` int(11) DEFAULT NULL,
  `MapId` int(11) DEFAULT NULL,
  `Name` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`EventId`),
  UNIQUE KEY `EventId` (`EventId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Keyword` (
  `KeywordId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Keyword` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`KeywordId`),
  UNIQUE KEY `KeywordId` (`KeywordId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Map` (
  `MapId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Image` varchar(255) DEFAULT NULL,
  `Name` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`MapId`),
  UNIQUE KEY `MapId` (`MapId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MapSpace` (
  `MapSpaceId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `MapId` int(11) DEFAULT NULL,
  `Section` varchar(40) DEFAULT NULL,
  `Row` varchar(4) DEFAULT NULL,
  `Space` varchar(4) DEFAULT NULL,
  `Longitude` float DEFAULT NULL,
  `Latitude` float DEFAULT NULL,
  `MapImageX` int(11) DEFAULT NULL,
  `MapImageY` int(11) DEFAULT NULL,
  PRIMARY KEY (`MapSpaceId`),
  UNIQUE KEY `MapSpaceId` (`MapSpaceId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Product` (
  `ProductId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`ProductId`),
  UNIQUE KEY `ProductId` (`ProductId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Rel_Keyword_Vendor` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `KeywordId` int(11) DEFAULT NULL,
  `VendorId` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Rel_MapSpace_Vendor` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `MapSpaceId` int(11) DEFAULT NULL,
  `VendorId` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Rel_Product_Vendor` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ProductId` int(11) DEFAULT NULL,
  `VendorId` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ScheduledEvent` (
  `ScheduledEventId` int(11) NOT NULL DEFAULT '0',
  `EventId` int(11) DEFAULT NULL,
  `Name` varchar(40) DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `MapId` int(11) DEFAULT NULL,
  PRIMARY KEY (`ScheduledEventId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Vendor` (
  `VendorId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(40) DEFAULT NULL,
  `PhoneNumber` int(11) DEFAULT NULL,
  `VendorType` enum('individual','retail') DEFAULT NULL,
  PRIMARY KEY (`VendorId`),
  UNIQUE KEY `VendorId` (`VendorId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Venue` (
  `VenueId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(40) DEFAULT NULL,
  `Address` varchar(40) DEFAULT NULL,
  `City` varchar(40) DEFAULT NULL,
  `State` text,
  `PostalCode` text,
  `MapId` int(11) DEFAULT NULL,
  `VenueType` enum('flea_market','retail_store') DEFAULT NULL,
  PRIMARY KEY (`VenueId`),
  UNIQUE KEY `VenueId` (`VenueId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
