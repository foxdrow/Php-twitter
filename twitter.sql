-- Base de données : `twitter`
DROP DATABASE IF EXISTS twitter;
CREATE DATABASE twitter;

USE twitter;

-- Structure de la table `hashtags`

DROP TABLE IF EXISTS `hashtags`;
CREATE TABLE IF NOT EXISTS `hashtags` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Structure de la table `link_user_follower_user_following`

DROP TABLE IF EXISTS `link_user_follower_user_following`;
CREATE TABLE IF NOT EXISTS `link_user_follower_user_following` (
  `id_follower` int NOT NULL,
  `id_following` int NOT NULL,
  KEY `id_follower` (`id_follower`),
  KEY `id_following` (`id_following`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Structure de la table `link_user_tweet`

DROP TABLE IF EXISTS `link_user_tweet`;
CREATE TABLE IF NOT EXISTS `link_user_tweet` (
  `id_user` int NOT NULL,
  `id_tweet` int NOT NULL,
  KEY `id_tweet` (`id_tweet`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Structure de la table `link_tweet_hashtag`

DROP TABLE IF EXISTS `link_tweet_hashtag`;
CREATE TABLE IF NOT EXISTS `link_tweet_hashtag`(
  `id_hashtag` int NOT NULL,
  `id_tweet` int NOT NULL,
  FOREIGN KEY (`id_hashtag`) REFERENCES hashtag(`id`),
  FOREIGN KEY (`id_tweet`) REFERENCES tweet(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Structure de la table `media`

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` int NOT NULL AUTO_INCREMENT,
  `link` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Structure de la table `message`

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_from` int NOT NULL,
  `id_to` int NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `id_media` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_from` (`id_from`),
  KEY `id_to` (`id_to`),
  KEY `id_media` (`id_media`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Structure de la table `tweet`

DROP TABLE IF EXISTS `tweet`;
CREATE TABLE IF NOT EXISTS `tweet` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `content` text NOT NULL,
  `id_hashtag` int DEFAULT NULL,
  `id_user_mention` int DEFAULT NULL,
  `id_media` int DEFAULT NULL,
  `date` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_hashtag` (`id_hashtag`),
  KEY `id_user_mention` (`id_user_mention`),
  KEY `id_media` (`id_media`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Structure de la table `users`

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registration_date` DATETIME NOT NULL,
  `bio` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `nickname` (`nickname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Structure de la table `comments`

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
    `id` int NOT NULL AUTO_INCREMENT,
    `id_tweet` int NOT NULL,
    `id_user` int NOT NULL,
    `content` TEXT NOT NULL,
    `date` DATETIME NOT NULL,
    PRIMARY KEY(`id`),
    FOREIGN KEY (`id_tweet`) REFERENCES tweet(`id`),
    FOREIGN KEY (`id_user`) REFERENCES users(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Structure de la table `likes`

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
    `id` int NOT NULL AUTO_INCREMENT,
    `id_tweet` int NOT NULL,
    `id_user` int NOT NULL,
    PRIMARY KEY(`id`),
    FOREIGN KEY (`id_tweet`) REFERENCES tweet(`id`),
    FOREIGN KEY (`id_user`) REFERENCES users(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Structure de la table `notifications`

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `notification_id` int NOT NULL AUTO_INCREMENT,
  `notification_receiver_id` int NOT NULL,
  `notification_text` text NOT NULL,
  `read_notification` enum('no','yes') NOT NULL,
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=latin1;
