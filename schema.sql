CREATE DATABASE work_okay
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE work_okay;

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    user_id INT NOT NULL
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status TINYINT(1) NOT NULL,
    name VARCHAR(150),
    date_completed DATE,
    user_id INT UNSIGNED NOT NULL,
    project_id INT UNSIGNED NOT NULL,
    file_path VARCHAR(255)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(45) NOT NULL UNIQUE,
    name VARCHAR(30),
    password CHAR (60) NOT NULL
);

CREATE FULLTEXT INDEX task_ft_search
    ON tasks(name);
