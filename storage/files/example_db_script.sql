CREATE DATABASE IF NOT EXISTS example_db
	DEFAULT CHARACTER SET = utf8
	DEFAULT COLLATE = utf8_general_ci;

USE example_db;

CREATE TABLE IF NOT EXISTS example_table_01 (
	id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	title VARCHAR(32) NOT NULL DEFAULT 'example' 
);

CREATE TABLE IF NOT EXISTS example_table_02 (
	id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	title VARCHAR(32) NOT NULL DEFAULT 'example' 
);

CREATE TABLE IF NOT EXISTS example_table_03 (
	id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	title VARCHAR(32) NOT NULL DEFAULT 'example' 
);

