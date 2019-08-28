-- MySQL dump 10.13  Distrib 5.7.27, for Linux (x86_64)
--
-- Host: localhost    Database: pettycash
-- ------------------------------------------------------
-- Server version	5.7.27-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `mf_wht_type`
--

DROP TABLE IF EXISTS `mf_wht_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mf_wht_type` (
  `VCH_whtType` char(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `VCH_description` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`VCH_whtType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mf_wht_type`
--

LOCK TABLES `mf_wht_type` WRITE;
/*!40000 ALTER TABLE `mf_wht_type` DISABLE KEYS */;
INSERT INTO `mf_wht_type` VALUES ('C1','Customer Wht Type - Pasal 23',NULL,NULL),('V1','Vendor Wht Type - Pasal 4(2)',NULL,NULL),('V2','Vendor Wht Type - Pasal 21 Non Karyawan',NULL,NULL),('V3','Vendor Wht Type - Pasal 23',NULL,NULL),('V4','Vendor Wht Type - Pasal 26',NULL,NULL);
/*!40000 ALTER TABLE `mf_wht_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mf_wht_code`
--

DROP TABLE IF EXISTS `mf_wht_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mf_wht_code` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `VCH_WHTType` char(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VCH_WHTCode` char(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FLT_Rate` double(8,2) DEFAULT NULL,
  `VCH_Description` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mf_wht_code`
--

LOCK TABLES `mf_wht_code` WRITE;
/*!40000 ALTER TABLE `mf_wht_code` DISABLE KEYS */;
INSERT INTO `mf_wht_code` VALUES (1,'V1','1',20.00,'4(2)-20%-Deposito Berjangka(Rp)-DN',NULL,NULL),(2,'V1','2',20.00,'4(2)-20%-Deposito Berjangka(Rp)-LN',NULL,NULL),(3,'V1','3',20.00,'4(2)-20%-Deposito(Valas-PremiFwd)-DN',NULL,NULL),(4,'V1','4',20.00,'4(2)-20%-Deposito(Valas-PremiFwd)-LN',NULL,NULL),(5,'V1','5',20.00,'4(2)-20%-Deposito(Valas-non PremiFwd)-DN',NULL,NULL),(6,'V1','6',20.00,'4(2)-20%-Deposito(Valas-non PremiFwd)-LN',NULL,NULL),(7,'V1','7',20.00,'4(2)-20%-Sertifikat Deposito-DN',NULL,NULL),(8,'V1','8',20.00,'4(2)-20%-Sertifikat Deposito-LN',NULL,NULL),(9,'V1','9',20.00,'4(2)-20%-Tabungan-DN',NULL,NULL),(10,'V1','10',20.00,'4(2)-20%-Tabungan-LN',NULL,NULL),(11,'V1','11',20.00,'4(2)-20%-Diskonto Sertifikat BI',NULL,NULL),(12,'V1','12',20.00,'4(2)-20%-Jasa Giro',NULL,NULL),(13,'V1','13',0.00,'4(2)-0,5%-Jual Saham Pendiri',NULL,NULL),(14,'V1','14',0.00,'4(2)-0,1%-Jual Saham Bkn Pendiri',NULL,NULL),(15,'V1','15',15.00,'4(2)-15%-Bunga/disk obligasi BE DN',NULL,NULL),(16,'V1','16',20.00,'4(2)-20%-Bunga/disk obligasi BE LN',NULL,NULL),(17,'V1','17',25.00,'4(2)-25%-Hadiah Undian',NULL,NULL),(18,'V1','18',10.00,'4(2)-10%-Sewa tanah & bangunan',NULL,NULL),(19,'V1','19',4.00,'4(2)-4%-Js Rcn Konst kual',NULL,NULL),(20,'V1','20',6.00,'4(2)-6%-Js Rcn Konst non kual',NULL,NULL),(21,'V1','21',2.00,'4(2)-2%-Js Lks Konst Kual Kcl',NULL,NULL),(22,'V1','22',3.00,'4(2)-3%-Js Lks Konst Kual Tghbsr',NULL,NULL),(23,'V1','23',4.00,'4(2)-4%-Js Lks Konst non Kual',NULL,NULL),(24,'V1','24',2.00,'4(2)-2%-Js Pgws Konst Kual',NULL,NULL),(25,'V1','25',4.00,'4(2)-4%-Js Pgws Konst non Kual',NULL,NULL),(26,'V1','28',10.00,'4(2)-10%-Bunga simpanan koperasi',NULL,NULL),(27,'V1','29',2.00,'4(2)-2,5%-Trans. derivatif bursa',NULL,NULL),(28,'V1','30',10.00,'4(2)-10%-Dividen WP Pribadi DN',NULL,NULL),(29,'V2','1',0.00,'21-Pgw tdk tetap/tng krj lps-NPWP',NULL,NULL),(30,'V2','2',0.00,'21-Pgw tdk tetap/tng krj lps-non NPWP',NULL,NULL),(31,'V2','3',0.00,'21-Imbalan distributor MLM - NPWP',NULL,NULL),(32,'V2','4',0.00,'21-Imbalan distributor MLM - non NPWP',NULL,NULL),(33,'V2','5',0.00,'21-Imbalan Dns Luar Asuransi-NPWP',NULL,NULL),(34,'V2','6',0.00,'21-Imbalan Dns Luar Asuransi-non NPWP',NULL,NULL),(35,'V2','7',0.00,'21-Imbalan Penjaja Brg Dgang-NPWP',NULL,NULL),(36,'V2','8',0.00,'21-Imbalan Penjaja Brg Dgang-non NPWP',NULL,NULL),(37,'V2','9',0.00,'21-Imbalan Tenaga Ahli  - NPWP',NULL,NULL),(38,'V2','10',0.00,'21-Imbalan Tenaga Ahli  - non NPWP',NULL,NULL),(39,'V2','11',0.00,'21-Honor Dewan Koms/Pengws-NPWP',NULL,NULL),(40,'V2','12',0.00,'21-Honor Dewan Koms/Pengws-non NPWP',NULL,NULL),(41,'V2','13',0.00,'21-Js Prod,Bonus Mantan Pgw-NPWP',NULL,NULL),(42,'V2','14',0.00,'21-Js Prod,Bonus Mantan Pgw-non NPWP',NULL,NULL),(43,'V2','15',0.00,'21-Dana Pensiun Pegawai-NPWP',NULL,NULL),(44,'V2','16',0.00,'21-Dana Pensiun Pegawai-non NPWP',NULL,NULL),(45,'V2','17',0.00,'21-Imbalan Peserta Kegiatan-NPWP',NULL,NULL),(46,'V2','18',0.00,'21-Imbalan Peserta Kegiatan-non NPWP',NULL,NULL),(47,'V2','19',0.00,'21-Imbalan non Pgw lnjut-NPWP',NULL,NULL),(48,'V2','20',0.00,'21-Imbalan non Pgw lnjut-non NPWP',NULL,NULL),(49,'V2','21',0.00,'21-Imbalan non Pgw tdk lnjut-NPWP',NULL,NULL),(50,'V2','22',0.00,'21-Imbalan non Pgw tdk lnjut-non NPWP',NULL,NULL),(51,'V2','23',0.00,'21-Penghasilan Pgw WP LN -NPWP',NULL,NULL),(52,'V3','1',15.00,'23-15%-Dividen-NPWP',NULL,NULL),(53,'V3','2',30.00,'23-30%-Dividen-non NPWP',NULL,NULL),(54,'V3','3',15.00,'23-15%-Bunga-NPWP',NULL,NULL),(55,'V3','4',30.00,'23-30%-Bunga-non NPWP',NULL,NULL),(56,'V3','5',15.00,'23-15%-Royalti-NPWP',NULL,NULL),(57,'V3','6',30.00,'23-30%-Royalti-non NPWP',NULL,NULL),(58,'V3','7',15.00,'23-15%-Hadiah dan penghargaan-NPWP',NULL,NULL),(59,'V3','8',30.00,'23-30%-Hadiah dan penghargaan-non NPWP',NULL,NULL),(60,'V3','9',2.00,'23-2%-Sewa angkutan darat-NPWP',NULL,NULL),(61,'V3','10',4.00,'23-4%-Sewa angkutan darat-non NPWP',NULL,NULL),(62,'V3','11',2.00,'23-2%-Sewa non angkutan darat-NPWP',NULL,NULL),(63,'V3','12',4.00,'23-4%-Sewa non angkutan darat-non NPWP',NULL,NULL),(64,'V3','13',2.00,'23-2%-Js.Teknik-NPWP',NULL,NULL),(65,'V3','14',4.00,'23-4%-Js.Teknik-non NPWP',NULL,NULL),(66,'V3','15',2.00,'23-2%-Js.Manajemen-NPWP',NULL,NULL),(67,'V3','16',4.00,'23-4%-Js.Manajemen-non NPWP',NULL,NULL),(68,'V3','17',2.00,'23-2%-Js.Konsultan-NPWP',NULL,NULL),(69,'V3','18',4.00,'23-4%-Js.Konsultan-non NPWP',NULL,NULL),(70,'V3','19',2.00,'23-2%-Js.Penilai (appraisal)-NPWP',NULL,NULL),(71,'V3','20',4.00,'23-4%-Js.Penilai (appraisal)-non NPWP',NULL,NULL),(72,'V3','21',2.00,'23-2%-Js.Aktuaris-NPWP',NULL,NULL),(73,'V3','22',4.00,'23-4%-Js.Aktuaris-non NPWP',NULL,NULL),(74,'V3','23',2.00,'23-2%-Js.Akuntansi,atestasi-NPWP',NULL,NULL),(75,'V3','24',4.00,'23-4%-Js.Akuntansi,atestasi-non NPWP',NULL,NULL),(76,'V3','25',2.00,'23-2%-Js.Perancang (design)-NPWP',NULL,NULL),(77,'V3','26',4.00,'23-4%-Js.Perancang (design)-non NPWP',NULL,NULL),(78,'V3','27',2.00,'23-2%-Js.Pengeboran Migas-NPWP',NULL,NULL),(79,'V3','28',4.00,'23-4%-Js.Pengeboran Migas-non NPWP',NULL,NULL),(80,'V3','29',2.00,'23-2%-Js.Penunjang migas-NPWP',NULL,NULL),(81,'V3','30',4.00,'23-4%-Js.Penunjang migas-non NPWP',NULL,NULL),(82,'V3','31',2.00,'23-2%-Js.Tambang non migas-NPWP',NULL,NULL),(83,'V3','32',4.00,'23-4%-Js.Tambang non migas-non NPWP',NULL,NULL),(84,'V3','33',2.00,'23-2%-Js. Tunjang Penerbangan-NPWP',NULL,NULL),(85,'V3','34',4.00,'23-4%-Js. Tunjang Penerbangan-non NPWP',NULL,NULL),(86,'V3','35',2.00,'23-2%-Js.penebangan hutan-NPWP',NULL,NULL),(87,'V3','36',4.00,'23-4%-Js.penebangan hutan-non NPWP',NULL,NULL),(88,'V3','37',2.00,'23-2%-Js.pengolahan limbah-NPWP',NULL,NULL),(89,'V3','38',4.00,'23-4%-Js.pengolahan limbah-non NPWP',NULL,NULL),(90,'V3','39',2.00,'23-2%-Js.outsourcing-NPWP',NULL,NULL),(91,'V3','40',4.00,'23-4%-Js.outsourcing-non NPWP',NULL,NULL),(92,'V3','41',2.00,'23-2%-Js.perantara/keagenan-NPWP',NULL,NULL),(93,'V3','42',4.00,'23-4%-Js.perantara/keagenan-non NPWP',NULL,NULL),(94,'V3','43',2.00,'23-2%-Js.srt harga non BE,KSE/PI-NPWP',NULL,NULL),(95,'V3','44',4.00,'23-4%-Js.srt harga non BE,KSE/PI-nonNPWP',NULL,NULL),(96,'V3','45',2.00,'23-2%-Js. Custodian non KSEI-NPWP',NULL,NULL),(97,'V3','46',4.00,'23-4%-Js. Custodian non KSEI-non NPWP',NULL,NULL),(98,'V3','47',2.00,'23-2%-Js.dubbbing-NPWP',NULL,NULL),(99,'V3','48',4.00,'23-4%-Js.dubbbing-non NPWP',NULL,NULL),(100,'V3','49',2.00,'23-2%-Js.mixing film-NPWP',NULL,NULL),(101,'V3','50',4.00,'23-4%-Js.mixing film-non NPWP',NULL,NULL),(102,'V3','51',2.00,'23-2%-Js.software computer-NPWP',NULL,NULL),(103,'V3','52',4.00,'23-4%-Js.software computer-non NPWP',NULL,NULL),(104,'V3','53',2.00,'23-2%-Js.Instalasi mesin dll-NPWP',NULL,NULL),(105,'V3','54',4.00,'23-4%-Js. Instalasi mesin, dll-non NPWP',NULL,NULL),(106,'V3','55',2.00,'23-2%-Js. perawatan mesin, dll-NPWP',NULL,NULL),(107,'V3','56',4.00,'23-4%-Js. perawatan mesin, dll-non NPWP',NULL,NULL),(108,'V3','57',2.00,'23-2%-Js.maklon-NPWP',NULL,NULL),(109,'V3','58',4.00,'23-4%-Js.maklon-non NPWP',NULL,NULL),(110,'V3','59',2.00,'23-2%-Js.Penyelidik & Keamanan-NPWP',NULL,NULL),(111,'V3','60',4.00,'23-4%-Js.Penyelidik & Keamanan-non NPWP',NULL,NULL),(112,'V3','61',2.00,'23-2%-Js.Event Organizer-NPWP',NULL,NULL),(113,'V3','62',4.00,'23-4%-Js.Event Organizer-non NPWP',NULL,NULL),(114,'V3','63',2.00,'23-2%-Js. pengepakan-NPWP',NULL,NULL),(115,'V3','64',4.00,'23-4%-Js. pengepakan-non NPWP',NULL,NULL),(116,'V3','65',2.00,'23-2%-Js.Sedia Tpt&Waktu media-NPWP',NULL,NULL),(117,'V3','66',4.00,'23-4%-Js.Sedia Tpt&Waktu media-non NPWP',NULL,NULL),(118,'V3','67',2.00,'23-2%-Js.pembasmian hama-NPWP',NULL,NULL),(119,'V3','68',4.00,'23-4%-Js.pembasmian hama-non NPWP',NULL,NULL),(120,'V3','69',2.00,'23-2%-Js.kebersihan-NPWP',NULL,NULL),(121,'V3','70',4.00,'23-4%-Js.kebersihan-non NPWP',NULL,NULL),(122,'V3','71',2.00,'23-2%-Js.catering-NPWP',NULL,NULL),(123,'V3','72',4.00,'23-4%-Js.catering-non NPWP',NULL,NULL),(124,'V3','73',2.00,'23-2%-Js.Logistik-NPWP',NULL,NULL),(125,'V3','74',4.00,'23-4%-Js.Logistik-Non NPWP',NULL,NULL),(126,'V3','75',2.00,'23-2%-Js.Ekspedisi-NPWP',NULL,NULL),(127,'V3','76',4.00,'23-4%-Js.Ekspedisi-Non NPWP',NULL,NULL),(128,'V3','77',2.00,'23-2%-Js.Pelatihan/Kursus-NPWP',NULL,NULL),(129,'V3','78',4.00,'23-4%-Js.Pelatihan/Kursus-Non NPWP',NULL,NULL),(130,'V3','79',2.00,'23-2%-Js.Penyelenggara Kegiatan-NPWP',NULL,NULL),(131,'V3','80',4.00,'23-4%-Js.Penyelenggara Kegiatan-Non NPWP',NULL,NULL),(132,'V4','1',20.00,'26-20%-Dividen',NULL,NULL),(133,'V4','2',20.00,'26-20%-Bunga',NULL,NULL),(134,'V4','3',20.00,'26-20%-Royalti',NULL,NULL),(135,'V4','4',20.00,'26-20%-Sewa/penghasilan dr harta',NULL,NULL),(136,'V4','5',20.00,'26-20%-Imbalan jasa&pekerjaan',NULL,NULL),(137,'V4','6',20.00,'26-20%-hadiah dan penghargaan',NULL,NULL),(138,'V4','7',20.00,'26-20%-pensiun&pembyran berkala',NULL,NULL),(139,'V4','8',20.00,'26-20%-premi swap,lindung nilai',NULL,NULL),(140,'V4','9',20.00,'26-20%-laba pembebasan utang',NULL,NULL),(141,'V4','10',20.00,'26-20%-Jual harta di Indonesia',NULL,NULL),(142,'V4','11',20.00,'26-20%-premi asuransi/reasuransi',NULL,NULL),(143,'V4','12',20.00,'26-20%-Hasil Penjualan Saham',NULL,NULL),(144,'V4','13',20.00,'26-20%-PKP BUT Setelah Pajak',NULL,NULL),(145,'C1','1',2.00,'PPh 23 - 2%',NULL,NULL);
/*!40000 ALTER TABLE `mf_wht_code` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-08-28  6:09:45
