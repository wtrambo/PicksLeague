--
-- Table structure for table `pl_teams`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pl_teams` (
  `short_name` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT '',
  `team_location` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT '',
  `team_name` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`short_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pl_users`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pl_users` (
  `user_name` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT '',
  `season` int(11) NOT NULL DEFAULT '0',
  `privilege` varchar(1) COLLATE utf8_bin NOT NULL DEFAULT 'U',
  `display_rank` int(11) DEFAULT NULL,
  `first_name` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `last_name` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `nick_name` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `favorite_team` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `location` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `timezone` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `profile` blob,
  PRIMARY KEY (`user_name`,`season`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pl_games`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pl_games` (
  `home_team` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT '',
  `away_team` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT '',
  `season` int(11) NOT NULL DEFAULT '0',
  `week` int(11) NOT NULL DEFAULT '0',
  `start_time` datetime DEFAULT NULL,
  `home_score` int(11) DEFAULT NULL,
  `away_score` int(11) DEFAULT NULL,
  `spread` double DEFAULT NULL,
  PRIMARY KEY (`home_team`,`away_team`,`season`,`week`),
  CONSTRAINT `pl_games_ibfk_1` FOREIGN KEY (`away_team`) REFERENCES `pl_teams` (`short_name`),
  CONSTRAINT `pl_games_ibfk_2` FOREIGN KEY (`home_team`) REFERENCES `pl_teams` (`short_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pl_messages`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pl_messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `season` int(11) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` blob,
  PRIMARY KEY (`message_id`),
  CONSTRAINT `pl_messages_ibfk_1` FOREIGN KEY (`user_name`) REFERENCES `pl_users` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=1782 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pl_picks`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pl_picks` (
  `user_name` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT '',
  `home_team` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT '',
  `away_team` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT '',
  `season` int(11) NOT NULL DEFAULT '0',
  `week` int(11) NOT NULL DEFAULT '0',
  `pick` varchar(3) COLLATE utf8_bin DEFAULT NULL,
  `push` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_name`,`home_team`,`away_team`,`season`,`week`),
  CONSTRAINT `pl_picks_ibfk_1` FOREIGN KEY (`home_team`) REFERENCES `pl_teams` (`short_name`),
  CONSTRAINT `pl_picks_ibfk_2` FOREIGN KEY (`away_team`) REFERENCES `pl_teams` (`short_name`),
  CONSTRAINT `pl_picks_ibfk_3` FOREIGN KEY (`pick`) REFERENCES `pl_teams` (`short_name`),
  CONSTRAINT `pl_picks_ibfk_4` FOREIGN KEY (`user_name`) REFERENCES `pl_users` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;
