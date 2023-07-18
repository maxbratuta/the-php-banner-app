-- CREATE DATABASE main_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE main_db;

DROP TABLE IF EXISTS `visitors`;

CREATE TABLE `visitors`
(
    `id`          INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `ip_address`  VARCHAR(40)  NOT NULL,
    `user_agent`  VARCHAR(255) NOT NULL,
    `page_url`    VARCHAR(255) NOT NULL,
    `view_date`   DATETIME     NOT NULL,
    `views_count` INT UNSIGNED NOT NULL
);

CREATE UNIQUE INDEX visitors_visitor_uniq ON visitors (ip_address, user_agent, page_url);