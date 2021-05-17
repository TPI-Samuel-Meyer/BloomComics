/* Create database if exists */
CREATE DATABASE IF NOT EXISTS `bloomcomics`

USE `dishcc`;
SET default_storage_engine=InnoDB;
ALTER DATABASE bloomcomics CHARACTER SET utf8 COLLATE utf8_unicode_ci;

/* Export articles table strucure */
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int unsigned AUTO_INCREMENT NOT NULL,
  `ui` varchar(32) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `release` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`ui`)
);

/* Export categories table strucure */
CREATE TABLE IF NOT EXISTS `categories` (
  `id` tinyint unsigned AUTO_INCREMENT NOT NULL,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`name`)
);

/* Export roles table strucure */
CREATE TABLE IF NOT EXISTS `roles` (
  `id` tinyint unsigned AUTO_INCREMENT NOT NULL,
  `ui` varchar(32) NOT NULL,
  `user` int unsigned NOT NULL,
  `role` tinyint unisgned NOT NULL,
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
  `description` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`email`),
  UNIQUE (`username`)
);

ALTER TABLE `roles`
ADD FOREIGN KEY (`user`) REFERENCES `users`(`id`);
