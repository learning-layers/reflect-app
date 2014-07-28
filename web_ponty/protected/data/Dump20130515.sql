CREATE DATABASE  IF NOT EXISTS `ponty` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ponty`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: ponty
-- ------------------------------------------------------
-- Server version	5.5.27

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
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text,
  `question_id` int(11) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_answers2question_id_idx` (`question_id`),
  CONSTRAINT `fk_answers2question_id` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` VALUES (4,'I was going to work at 10:00 o´clock',9,'2013-05-13 09:08:49'),(5,'200 Humans',10,'2013-05-13 09:09:24'),(6,'All are fine!',10,'2013-05-13 09:09:41'),(7,'All is important!',11,'2013-05-13 09:10:01'),(9,'Diese antwort wurde per REST eingepflegt!',12,'2013-05-14 17:41:34'),(10,'Diese antwort wurde per REST eingepflegt!',12,'2013-05-14 17:45:58');
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `visible` tinyint(1) DEFAULT '1',
  `description` text,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Medicine',1,NULL,'2013-05-06 18:58:31');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `public` tinyint(1) DEFAULT '0',
  `name` varchar(250) NOT NULL,
  `blocked` tinyint(1) DEFAULT '0',
  `stack_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT '0',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_questions2stack_id_idx` (`stack_id`),
  KEY `fk_questions2category_id_idx` (`category_id`),
  CONSTRAINT `fk_questions2category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `fk_questions2stack_id` FOREIGN KEY (`stack_id`) REFERENCES `stacks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (9,0,'What time did I go to work?',1,13,NULL,0,'2013-05-13 09:06:43'),(10,0,'How many people are sick?',1,13,1,0,'2013-05-13 09:07:30'),(11,1,'What was important?',1,13,1,0,'2013-05-13 09:08:06'),(12,1,'How was the weather?',1,14,NULL,0,'2013-05-13 09:11:44');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `rating_value` int(11) NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_ratings2user_id_idx` (`user_id`),
  KEY `fk_ratings2question_id_idx` (`question_id`),
  CONSTRAINT `fk_ratings2question_id` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ratings2user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ratings`
--

LOCK TABLES `ratings` WRITE;
/*!40000 ALTER TABLE `ratings` DISABLE KEYS */;
/*!40000 ALTER TABLE `ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stacks`
--

DROP TABLE IF EXISTS `stacks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `description` text,
  `user_id` int(11) NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_stacks2user_id_idx` (`user_id`),
  CONSTRAINT `fk_stacks2user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stacks`
--

LOCK TABLES `stacks` WRITE;
/*!40000 ALTER TABLE `stacks` DISABLE KEYS */;
INSERT INTO `stacks` VALUES (13,'My business day','All about my business',11,'2013-05-08 16:42:37'),(14,'My private things','',12,'2013-05-13 09:11:12');
/*!40000 ALTER TABLE `stacks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trash_mail_providers`
--

DROP TABLE IF EXISTS `trash_mail_providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trash_mail_providers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `trash_mail_providers_index02` (`address`)
) ENGINE=InnoDB AUTO_INCREMENT=862 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trash_mail_providers`
--

LOCK TABLES `trash_mail_providers` WRITE;
/*!40000 ALTER TABLE `trash_mail_providers` DISABLE KEYS */;
INSERT INTO `trash_mail_providers` VALUES (513,'0815.ru'),(514,'0clickemail.com'),(515,'10minutemail.com'),(516,'12houremail.com'),(517,'12minutemail.com'),(518,'1pad.de'),(519,'2prong.com'),(520,'3d-painting.com'),(521,'agedmail.com'),(522,'akapost.com'),(523,'ano-mail.net'),(524,'anon-mail.de'),(525,'anonbox.net'),(526,'anonmails.de'),(527,'anonymbox.com'),(528,'antichef.net'),(529,'antireg.ru'),(530,'antispam.de'),(531,'antispam24.de'),(532,'antispammail.de'),(533,'asdasd.ru'),(534,'b2cmail.de'),(535,'beefmilk.com'),(536,'binkmail.com'),(537,'bio-muesli.info'),(538,'bio-muesli.net'),(539,'blackmarket.to'),(540,'bobmail.info'),(541,'bofthew.com'),(542,'bootybay.de'),(543,'breakthru.com'),(544,'brennendesreich.de'),(545,'bspamfree.org'),(546,'buffemail.com'),(547,'bugmenever.com'),(548,'bugmenot.com'),(549,'bumpymail.com'),(550,'bund.us'),(551,'cam4you.cc'),(552,'card.zp.ua'),(553,'centermail.com'),(554,'centermail.net'),(555,'cheatmail.de'),(556,'chogmail.com'),(557,'cool.fr.nf'),(558,'courriel.fr.nf'),(559,'cust.in'),(560,'dbunker.com'),(561,'deadaddress.com'),(562,'delikkt.de'),(563,'despam.it'),(564,'despammed.com'),(565,'devnullmail.com'),(566,'dingbone.com'),(567,'discardmail.com'),(568,'discardmail.de'),(569,'disposeamail.com'),(570,'dispostable.com'),(571,'dodgeit.com'),(572,'dodgit.com'),(573,'dontreg.com'),(574,'dontsendmespam.de'),(575,'dotman.de'),(576,'dudmail.com'),(577,'dump-email.info'),(578,'dumpmail.de'),(579,'duskmail.com'),(580,'e4ward.com'),(581,'edv.to'),(582,'einmalmail.de'),(583,'eintagsmail.de'),(584,'emailgo.de'),(585,'emailias.com'),(586,'emaillime.com'),(587,'emailsensei.com'),(588,'emailtemporanea.com'),(589,'emailtemporanea.net'),(590,'express.net.ua'),(591,'eyepaste.com'),(592,'fakedemail.com'),(593,'fakemail.fr'),(594,'filzmail.com'),(595,'fivemail.de'),(596,'flyspam.com'),(597,'fr33mail.info'),(598,'frapmail.com'),(599,'fudgerub.com'),(600,'garbagemail.org'),(601,'garliclife.com'),(602,'getmails.eu'),(603,'getonemail.com'),(604,'giantmail.de'),(605,'gishpuppy.com'),(606,'great-host.in'),(607,'guerrillamail.com'),(608,'guerrillamail.org'),(609,'guerrillamailblock.com'),(610,'haltospam.com'),(611,'hidemail.de'),(612,'hmamail.com'),(613,'hochsitze.com'),(614,'hulapla.de'),(615,'humaility.com'),(616,'hushmail.com'),(617,'ieh-mail.de'),(618,'ignoremail.com'),(619,'imails.info'),(620,'incognitomail.net'),(621,'incognitomail.org'),(622,'infocom.zp.ua'),(623,'instant-mail.de'),(624,'ip6.li'),(625,'irish2me.com'),(626,'is.af'),(627,'jetable.com'),(628,'jetable.fr.nf'),(629,'jetable.net'),(630,'jetable.org'),(631,'jnxjn.com'),(632,'junk.to'),(633,'kasmail.com'),(634,'keepmymail.com'),(635,'klzlk.com'),(636,'kulturbetrieb.info'),(637,'kurzepost.de'),(638,'lawlita.com'),(639,'lhsdv.com'),(640,'lifebyfood.com'),(641,'llogin.ru'),(642,'lolfreak.net'),(643,'lookugly.com'),(644,'losemymail.com'),(645,'lr78.com'),(646,'luckymail.org'),(647,'m21.cc'),(648,'m4ilweb.info'),(649,'mail.zp.ua'),(650,'mail21.cc'),(651,'mail4trash.com'),(652,'mailbiz.biz'),(653,'mailcatch.com'),(654,'mailde.de'),(655,'mailde.info'),(656,'maileater.com'),(657,'maileimer.de'),(658,'mailexpire.com'),(659,'mailforspam.com'),(660,'mailin8r.com'),(661,'mailinater.com'),(662,'mailinator.com'),(663,'mailinator.net'),(664,'mailinator2.com'),(665,'mailita.tk'),(666,'mailme24.com'),(667,'mailmetrash.com'),(668,'mailms.com'),(669,'mailnull.com'),(670,'mailorg.org'),(671,'mailscrap.com'),(672,'mailshell.com'),(673,'mailtrash.net'),(674,'mailtv.net'),(675,'mailtv.tv'),(676,'makemetheking.com'),(677,'mbx.cc'),(678,'mega.zik.dj'),(679,'meltmail.com'),(680,'messagebeamer.de'),(681,'ministry-of-silly-walks.de'),(682,'mintemail.com'),(683,'misterpinball.de'),(684,'moncourrier.fr.nf'),(685,'monemail.fr.nf'),(686,'monmail.fr.nf'),(687,'mt2009.com'),(688,'mycard.net.ua'),(689,'mypartyclip.de'),(690,'mysamp.de'),(691,'mytempmail.com'),(692,'mytrashmail.com'),(693,'nabuma.com'),(694,'nepwk.com'),(695,'nervmich.net'),(696,'nervtmich.net'),(697,'netzidiot.de'),(698,'nevermail.de'),(699,'no-spam.ws'),(700,'nobugmail.com'),(701,'nobuma.com'),(702,'noclickemail.com'),(703,'nomail.xl.cx'),(704,'nomail2me.com'),(705,'nospam.ze.tc'),(706,'nospam4.us'),(707,'nospamfor.us'),(708,'nospammail.net'),(709,'nospamthanks.info'),(710,'nowmymail.com'),(711,'nurfuerspam.de'),(712,'nwldx.com'),(713,'objectmail.com'),(714,'obobbo.com'),(715,'odnorazovoe.ru'),(716,'ohaaa.de'),(717,'omail.pro'),(718,'oneoffemail.com'),(719,'oneoffmail.com'),(720,'onlatedotcom.info'),(721,'otherinbox.com'),(722,'owlpic.com'),(723,'pjjkp.com'),(724,'plexolan.de'),(725,'politikerclub.de'),(726,'pookmail.com'),(727,'privacy.net'),(728,'privy-mail.de'),(729,'proxymail.eu'),(730,'prtnx.com'),(731,'punkass.com'),(732,'put2.net'),(733,'quickinbox.com'),(734,'rcpt.at'),(735,'realtyalerts.ca'),(736,'recode.me'),(737,'rppkn.com'),(738,'rtrtr.com'),(739,'s0ny.net'),(740,'safetymail.info'),(741,'safetypost.de'),(742,'sandelf.de'),(743,'schafmail.de'),(744,'schmeissweg.tk'),(745,'schrott-email.de'),(746,'secretemail.de'),(747,'secure-mail.biz'),(748,'secure-mail.cc'),(749,'SendSpamHere.com'),(750,'senseless-entertainment.com'),(751,'server.ms'),(752,'sharklasers.com'),(753,'shieldemail.com'),(754,'sinnlos-mail.de'),(755,'slopsbox.com'),(756,'smellfear.com'),(757,'sneakemail.com'),(758,'sofort-mail.de'),(759,'sogetthis.com'),(760,'soodonims.com'),(761,'spam.la'),(762,'spam.su'),(763,'spamavert.com'),(764,'spambob.com'),(765,'spambog.com'),(766,'spambog.de'),(767,'spambog.ru'),(768,'spambox.us'),(769,'spamcero.com'),(770,'spamcorptastic.com'),(771,'spamday.com'),(772,'spamex.com'),(773,'spamfree.eu'),(774,'spamfree24.com'),(775,'spamfree24.de'),(776,'spamfree24.info'),(777,'spamfree24.org'),(778,'spamgourmet.com'),(779,'spamherelots.com'),(780,'SpamHerePlease.com'),(781,'spamhole.com'),(782,'spaminator.de'),(783,'spamkill.info'),(784,'spaml.com'),(785,'spaml.de'),(786,'spammotel.com'),(787,'spamobox.com'),(788,'spamspot.com'),(789,'SpamThisPlease.com'),(790,'spamtrail.com'),(791,'speed.1s.fr'),(792,'spoofmail.de'),(793,'squizzy.de'),(794,'stinkefinger.net'),(795,'super-auswahl.de'),(796,'superstachel.de'),(797,'suremail.info'),(798,'teewars.org'),(799,'teleworm.com'),(800,'temp-mail.org'),(801,'temp-mail.ru'),(802,'tempail.com'),(803,'tempemail.net'),(804,'tempinbox.com'),(805,'tempmailer.com'),(806,'tempomail.fr'),(807,'temporarily.de'),(808,'temporaryemail.net'),(809,'temporaryinbox.com'),(810,'temporarymailaddress.com'),(811,'thanksnospam.info'),(812,'thankyou2010.com'),(813,'thc.st'),(814,'thisisnotmyrealemail.com'),(815,'thismail.net'),(816,'tilien.com'),(817,'topranklist.de'),(818,'tradermail.info'),(819,'trash-mail.at'),(820,'trash-mail.com'),(821,'trash-mail.de'),(822,'trash2009.com'),(823,'trashdevil.com'),(824,'trashdevil.de'),(825,'trashemail.de'),(826,'trashinbox.com'),(827,'trashmail.at'),(828,'trashmail.com'),(829,'trashmail.de'),(830,'trashmail.me'),(831,'trashmail.net'),(832,'trashymail.com'),(833,'trialmail.de'),(834,'twinmail.de'),(835,'tyldd.com'),(836,'uggsrock.com'),(837,'us.af'),(838,'veryrealemail.com'),(839,'vpn.st'),(840,'wasteland.rfc822.org'),(841,'webm4il.info'),(842,'wegwerf-email-adressen.de'),(843,'wegwerf-email.net'),(844,'wegwerf-emails.de'),(845,'wegwerfadresse.de'),(846,'wegwerfemail.com'),(847,'wegwerfemail.de'),(848,'wegwerfmail.de'),(849,'wegwerfmail.net'),(850,'wegwerfmail.org'),(851,'wh4f.org'),(852,'whyspam.me'),(853,'yopmail.com'),(854,'yopmail.fr'),(855,'yopmail.net'),(856,'youmailr.com'),(857,'yxzx.net'),(858,'z1p.biz'),(859,'zehnminuten.de'),(860,'zehnminutenmail.de'),(861,'zippymail.info');
/*!40000 ALTER TABLE `trash_mail_providers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(250) NOT NULL,
  `password` varchar(500) NOT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `blocked` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-15  0:07:46
