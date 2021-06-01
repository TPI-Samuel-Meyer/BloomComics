/* Create database if exists */
CREATE DATABASE IF NOT EXISTS `tpi_sma_main`

USE `tpi_sma_main`;
SET default_storage_engine=InnoDB;
ALTER DATABASE tpi_sma_main CHARACTER SET utf8 COLLATE utf8_unicode_ci;

/* Export articles table strucure */
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int unsigned AUTO_INCREMENT NOT NULL,
  `ui` varchar(32) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `releaseDate` date DEFAULT NULL,
  `artwork` int unsigned NOT NULL,
  `author` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`ui`)
);

/* Export artwork table strucure */
CREATE TABLE IF NOT EXISTS `artworks` (
  `id` int unsigned AUTO_INCREMENT NOT NULL,
  `ui` varchar(32) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `releaseDate` date DEFAULT NULL,
  `editor` varchar(256) DEFAULT NULL,
  `type` tinyint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`ui`)
);

/* Export category_as_artwork table strucure */
CREATE TABLE IF NOT EXISTS `category_as_artwork` (
  `id` int unsigned AUTO_INCREMENT NOT NULL,
  `artwork` int unsigned NOT NULL,
  `category` tinyint unsigned NOT NULL,
  PRIMARY KEY (`id`)
);

/* Export comment_as_category table strucure */
CREATE TABLE IF NOT EXISTS `comment_as_article` (
  `id` int unsigned AUTO_INCREMENT NOT NULL,
  `comment` varchar(2000) NOT NULL,
  `article` int unsigned NOT NULL,
  `author` int unsigned NOT NULL,
  `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

/* Export categories table strucure */
CREATE TABLE IF NOT EXISTS `categories` (
  `id` tinyint unsigned AUTO_INCREMENT NOT NULL,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`name`)
);

/* Export mark_as_category table strucure */
CREATE TABLE IF NOT EXISTS `mark_as_article` (
  `id` int unsigned AUTO_INCREMENT NOT NULL,
  `mark` tinyint unsigned NOT NULL,
  `article` int unsigned NOT NULL,
  `author` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
);

/* Export roles table strucure */
CREATE TABLE IF NOT EXISTS `roles` (
  `id` tinyint unsigned AUTO_INCREMENT NOT NULL,
  `user` int unsigned NOT NULL,
  `role` tinyint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`ui`)
);

/* Export types table strucure */
CREATE TABLE IF NOT EXISTS `types` (
  `id` tinyint unsigned AUTO_INCREMENT NOT NULL,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`name`)
);

/* Export users table strucure */
CREATE TABLE IF NOT EXISTS `users` (
  `id` int unsigned AUTO_INCREMENT NOT NULL,
  `username` varchar(32) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(8000) NOT NULL,
  `description` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`email`),
  UNIQUE (`username`)
);

/* Export user_as_user table strucure */
CREATE TABLE IF NOT EXISTS `user_as_user` (
  `id` int unsigned AUTO_INCREMENT NOT NULL,
  `user1` int unsigned NOT NULL,
  `user2` int unsigned NOT NULL,
  `status` tinyint unsigned NOT NULL,
  PRIMARY KEY (`id`)
);

ALTER TABLE `articles`
ADD FOREIGN KEY (`artwork`) REFERENCES `artworks`(`id`);
ALTER TABLE `articles`
ADD FOREIGN KEY (`author`) REFERENCES `users`(`id`);

ALTER TABLE `artworks`
ADD FOREIGN KEY (`type`) REFERENCES `types`(`id`);

ALTER TABLE `category_as_artwork`
ADD FOREIGN KEY (`artwork`) REFERENCES `artworks`(`id`);
ALTER TABLE `category_as_artwork`
ADD FOREIGN KEY (`category`) REFERENCES `categories`(`id`);

ALTER TABLE `comment_as_article`
ADD FOREIGN KEY (`article`) REFERENCES `articles`(`id`);
ALTER TABLE `comment_as_article`
ADD FOREIGN KEY (`author`) REFERENCES `users`(`id`);

ALTER TABLE `mark_as_article`
ADD FOREIGN KEY (`article`) REFERENCES `articles`(`id`);
ALTER TABLE `mark_as_article`
ADD FOREIGN KEY (`author`) REFERENCES `users`(`id`);

ALTER TABLE `roles`
ADD FOREIGN KEY (`user`) REFERENCES `users`(`id`);

ALTER TABLE `user_as_user`
ADD FOREIGN KEY (`user1`) REFERENCES `users`(`id`);
ALTER TABLE `user_as_user`
ADD FOREIGN KEY (`user2`) REFERENCES `users`(`id`);
