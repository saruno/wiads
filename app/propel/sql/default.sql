
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- department
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `department`;

CREATE TABLE `department`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(1000),
    `code` VARCHAR(1000),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- employee
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `employee`;

CREATE TABLE `employee`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `department_id` INTEGER,
    `username` VARCHAR(1000),
    `password` VARCHAR(1000),
    `lastname` VARCHAR(1000),
    `firstname` VARCHAR(1000),
    `phone` VARCHAR(1000),
    `address` VARCHAR(1000),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `employee_fi_daecba` (`department_id`),
    CONSTRAINT `employee_fk_daecba`
        FOREIGN KEY (`department_id`)
        REFERENCES `department` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- warehouse
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `warehouse`;

CREATE TABLE `warehouse`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `employee_id` INTEGER,
    `name` VARCHAR(1000),
    `address` VARCHAR(1000),
    `phone` VARCHAR(1000),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `warehouse_fi_e9e6d3` (`employee_id`),
    CONSTRAINT `warehouse_fk_e9e6d3`
        FOREIGN KEY (`employee_id`)
        REFERENCES `employee` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- provider
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `provider`;

CREATE TABLE `provider`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(1000),
    `address` VARCHAR(1000),
    `phone` VARCHAR(1000),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- inventory_receiving_voucher
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `inventory_receiving_voucher`;

CREATE TABLE `inventory_receiving_voucher`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `provider_id` INTEGER,
    `warehouse_id` INTEGER,
    `created_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `inventory_receiving_voucher_fi_087e69` (`provider_id`),
    INDEX `inventory_receiving_voucher_fi_637c1d` (`warehouse_id`),
    CONSTRAINT `inventory_receiving_voucher_fk_087e69`
        FOREIGN KEY (`provider_id`)
        REFERENCES `provider` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `inventory_receiving_voucher_fk_637c1d`
        FOREIGN KEY (`warehouse_id`)
        REFERENCES `warehouse` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- category_product
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `category_product`;

CREATE TABLE `category_product`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(1000),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- product
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `category_id` INTEGER,
    `warehouse_id` INTEGER,
    `name` VARCHAR(1000),
    `slton` INTEGER,
    `donvi` VARCHAR(255),
    `description` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `product_fi_e28258` (`category_id`),
    INDEX `product_fi_637c1d` (`warehouse_id`),
    CONSTRAINT `product_fk_e28258`
        FOREIGN KEY (`category_id`)
        REFERENCES `category_product` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `product_fk_637c1d`
        FOREIGN KEY (`warehouse_id`)
        REFERENCES `warehouse` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- inventory_receiving_voucher_detail
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `inventory_receiving_voucher_detail`;

CREATE TABLE `inventory_receiving_voucher_detail`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `inventory_receiving_voucher_id` INTEGER,
    `product_id` INTEGER,
    `quantity` INTEGER,
    `price` DECIMAL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `inventory_receiving_voucher_detail_fi_34e9a3` (`inventory_receiving_voucher_id`),
    INDEX `inventory_receiving_voucher_detail_fi_0f5ed8` (`product_id`),
    CONSTRAINT `inventory_receiving_voucher_detail_fk_34e9a3`
        FOREIGN KEY (`inventory_receiving_voucher_id`)
        REFERENCES `inventory_receiving_voucher` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `inventory_receiving_voucher_detail_fk_0f5ed8`
        FOREIGN KEY (`product_id`)
        REFERENCES `product` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- customers
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(1000),
    `address` VARCHAR(1000),
    `phone` VARCHAR(1000),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- inventory_delivery_voucher
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `inventory_delivery_voucher`;

CREATE TABLE `inventory_delivery_voucher`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `warehouse_id` INTEGER,
    `employee_id` INTEGER,
    `customer_id` INTEGER,
    `created_at` DATETIME,
    `description` TEXT,
    PRIMARY KEY (`id`),
    INDEX `inventory_delivery_voucher_fi_637c1d` (`warehouse_id`),
    INDEX `inventory_delivery_voucher_fi_e9e6d3` (`employee_id`),
    INDEX `inventory_delivery_voucher_fi_b94313` (`customer_id`),
    CONSTRAINT `inventory_delivery_voucher_fk_637c1d`
        FOREIGN KEY (`warehouse_id`)
        REFERENCES `warehouse` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `inventory_delivery_voucher_fk_e9e6d3`
        FOREIGN KEY (`employee_id`)
        REFERENCES `employee` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `inventory_delivery_voucher_fk_b94313`
        FOREIGN KEY (`customer_id`)
        REFERENCES `customers` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- inventory_delivery_voucher_detail
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `inventory_delivery_voucher_detail`;

CREATE TABLE `inventory_delivery_voucher_detail`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `inventory_delivery_voucher_id` INTEGER,
    `product_id` INTEGER,
    `quantity` INTEGER,
    `price` DECIMAL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `inventory_delivery_voucher_detail_fi_469ae6` (`inventory_delivery_voucher_id`),
    INDEX `inventory_delivery_voucher_detail_fi_0f5ed8` (`product_id`),
    CONSTRAINT `inventory_delivery_voucher_detail_fk_469ae6`
        FOREIGN KEY (`inventory_delivery_voucher_id`)
        REFERENCES `inventory_delivery_voucher` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `inventory_delivery_voucher_detail_fk_0f5ed8`
        FOREIGN KEY (`product_id`)
        REFERENCES `product` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- news
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `news`;

CREATE TABLE `news`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `section_id` INTEGER,
    `subsection_ids` VARCHAR(1000),
    `orders` INTEGER,
    `suborder_ids` VARCHAR(1000),
    `front_page` TINYINT(1),
    `has_comment` TINYINT(1),
    `can_delete` TINYINT(1),
    `published_at` DATETIME,
    `imgs` VARCHAR(1000),
    `relative_news` VARCHAR(1000),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `news_fi_112411` (`section_id`),
    CONSTRAINT `news_fk_112411`
        FOREIGN KEY (`section_id`)
        REFERENCES `section` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- comment
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `comment`;

CREATE TABLE `comment`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `from` VARCHAR(500),
    `email` VARCHAR(255),
    `phone` VARCHAR(255),
    `published_at` DATETIME,
    `news_id` INTEGER,
    `section_id` INTEGER,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `comment_fi_d0fb2b` (`news_id`),
    INDEX `comment_fi_112411` (`section_id`),
    CONSTRAINT `comment_fk_d0fb2b`
        FOREIGN KEY (`news_id`)
        REFERENCES `news` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `comment_fk_112411`
        FOREIGN KEY (`section_id`)
        REFERENCES `section` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- section
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `section`;

CREATE TABLE `section`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `deep` INTEGER DEFAULT 0,
    `parent` INTEGER DEFAULT -1,
    `bundle_id` INTEGER DEFAULT -1,
    `orders` INTEGER,
    `can_delete` TINYINT(1) DEFAULT 0,
    `locked` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `section_fi_927735` (`bundle_id`),
    CONSTRAINT `section_fk_927735`
        FOREIGN KEY (`bundle_id`)
        REFERENCES `bundle` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- menu
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `deep` INTEGER,
    `parent` INTEGER,
    `section_id` INTEGER,
    `bundle_id` INTEGER,
    `orders` INTEGER,
    `can_delete` TINYINT(1) DEFAULT 1,
    `locked` TINYINT(1),
    `pos` VARCHAR(1000),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `menu_fi_112411` (`section_id`),
    INDEX `menu_fi_927735` (`bundle_id`),
    CONSTRAINT `menu_fk_112411`
        FOREIGN KEY (`section_id`)
        REFERENCES `section` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `menu_fk_927735`
        FOREIGN KEY (`bundle_id`)
        REFERENCES `bundle` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- bundle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `bundle`;

CREATE TABLE `bundle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `locked` TINYINT(1),
    `title` VARCHAR(1000),
    `bundle` VARCHAR(1000),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- language
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `language`;

CREATE TABLE `language`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `locked` TINYINT(1),
    `code` VARCHAR(100),
    `link` VARCHAR(1000),
    `img` VARCHAR(1000),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- useronline
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `useronline`;

CREATE TABLE `useronline`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `session` VARCHAR(1000) NOT NULL,
    `time` INTEGER,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- counter
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `counter`;

CREATE TABLE `counter`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `counter` INTEGER,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- app
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `app`;

CREATE TABLE `app`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(1000) NOT NULL,
    `bundle_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- advert
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `advert`;

CREATE TABLE `advert`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `section_id` INTEGER,
    `subsection_ids` VARCHAR(2000),
    `bundle_id` INTEGER,
    `section_link_id` INTEGER,
    `bundle_link_id` INTEGER,
    `view_at_homepage` TINYINT(1),
    `home_position` VARCHAR(30),
    `view_at_section` TINYINT(1),
    `section_position` VARCHAR(30),
    `location` VARCHAR(1024),
    `company` VARCHAR(1024),
    `platform` VARCHAR(500),
    `platform_version` VARCHAR(500),
    `can_delete` TINYINT(1),
    `published_at` DATETIME,
    `expired_at` DATETIME,
    `customer_id` INTEGER,
    `ratio` FLOAT DEFAULT 1,
    `daily_limit` INTEGER,
    `draft` TINYINT(1),
    `img` VARCHAR(1000),
    `imgs` VARCHAR(1000),
    `imgs_sizes` VARCHAR(500),
    `type` INTEGER,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `advert_fi_112411` (`section_id`),
    INDEX `advert_fi_7e8f3e` (`customer_id`),
    INDEX `advert_fi_927735` (`bundle_id`),
    CONSTRAINT `advert_fk_112411`
        FOREIGN KEY (`section_id`)
        REFERENCES `section` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `advert_fk_7e8f3e`
        FOREIGN KEY (`customer_id`)
        REFERENCES `customer` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `advert_fk_927735`
        FOREIGN KEY (`bundle_id`)
        REFERENCES `bundle` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- customer
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(1000),
    `username` VARCHAR(500),
    `owner` VARCHAR(500),
    `code` VARCHAR(50),
    `address` VARCHAR(1000),
    `phone` VARCHAR(1000),
    `email` VARCHAR(1000),
    `type` VARCHAR(500),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- place
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `place`;

CREATE TABLE `place`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `section_id` INTEGER,
    `orders_id` VARCHAR(1000),
    `locked` TINYINT(1) DEFAULT 0,
    `imgs` VARCHAR(1000),
    `address` VARCHAR(300),
    `email` VARCHAR(300),
    `phone` VARCHAR(300),
    `lat` VARCHAR(30),
    `lng` VARCHAR(30),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `place_fi_112411` (`section_id`),
    CONSTRAINT `place_fk_112411`
        FOREIGN KEY (`section_id`)
        REFERENCES `section` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- sectioncache
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sectioncache`;

CREATE TABLE `sectioncache`
(
    `section_id` INTEGER NOT NULL,
    `news_id` INTEGER NOT NULL,
    `locale` VARCHAR(30) NOT NULL,
    `link` VARCHAR(1000),
    `orders` INTEGER,
    `read` INTEGER,
    `published_at` DATETIME,
    `locked` TINYINT(1) DEFAULT 1,
    `front_page` TINYINT(1) DEFAULT 1,
    PRIMARY KEY (`section_id`,`news_id`,`locale`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- advertcache
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `advertcache`;

CREATE TABLE `advertcache`
(
    `section_id` INTEGER NOT NULL,
    `advert_id` INTEGER NOT NULL,
    `locale` VARCHAR(30) NOT NULL,
    `section_position` VARCHAR(30),
    `title` VARCHAR(1000),
    `brief` TEXT,
    `link` VARCHAR(1000),
    `link_to` VARCHAR(1000),
    `read` INTEGER DEFAULT 0,
    `imgs` VARCHAR(1000),
    `imgs_sizes` VARCHAR(500),
    `published_at` DATETIME,
    `expired_at` DATETIME,
    `locked` TINYINT(1) DEFAULT 1,
    PRIMARY KEY (`section_id`,`advert_id`,`locale`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- vote
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `vote`;

CREATE TABLE `vote`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `published_at` DATETIME,
    `locked` TINYINT(1) DEFAULT 1,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- vote_question
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `vote_question`;

CREATE TABLE `vote_question`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `vote_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `vote_question_fi_b2c012` (`vote_id`),
    CONSTRAINT `vote_question_fk_b2c012`
        FOREIGN KEY (`vote_id`)
        REFERENCES `vote` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- logs
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `logs`;

CREATE TABLE `logs`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `edit_by` VARCHAR(1000),
    `table` VARCHAR(1000),
    `item_id` INTEGER,
    `old` TEXT,
    `current` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- marker_category
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `marker_category`;

CREATE TABLE `marker_category`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `icon` VARCHAR(1000),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- marker
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `marker`;

CREATE TABLE `marker`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `image` VARCHAR(1000),
    `category_id` INTEGER,
    `longitude` VARCHAR(1000),
    `latitude` VARCHAR(1000),
    `detail_url_id` VARCHAR(50),
    `section_id` INTEGER,
    `subsection_ids` VARCHAR(1000),
    `orders` INTEGER,
    `suborder_ids` VARCHAR(1000),
    `front_page` TINYINT(1),
    `has_comment` TINYINT(1),
    `can_delete` TINYINT(1),
    `published_at` DATETIME,
    `imgs` VARCHAR(1000),
    `relative_news` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `marker_fi_112411` (`section_id`),
    INDEX `marker_fi_5c9777` (`category_id`),
    CONSTRAINT `marker_fk_112411`
        FOREIGN KEY (`section_id`)
        REFERENCES `section` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `marker_fk_5c9777`
        FOREIGN KEY (`category_id`)
        REFERENCES `marker_category` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(1000) NOT NULL,
    `password` VARCHAR(1000) NOT NULL,
    `salt` VARCHAR(1000) NOT NULL,
    `name` VARCHAR(1000) NOT NULL,
    `email` VARCHAR(500),
    `phone` VARCHAR(500),
    `company` VARCHAR(500),
    `is_active` TINYINT(1) DEFAULT 1 NOT NULL,
    `locked` TINYINT(1) DEFAULT 0 NOT NULL,
    `description` TEXT,
    `forgot` VARCHAR(500),
    `confirm` VARCHAR(2000),
    `type` SMALLINT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- role_group
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `role_group`;

CREATE TABLE `role_group`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(1000) NOT NULL,
    `role_id` VARCHAR(1000) NOT NULL,
    `description` TEXT,
    `type` SMALLINT DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- role
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(1000) NOT NULL,
    `description` TEXT,
    `type` SMALLINT DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- role_assign
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `role_assign`;

CREATE TABLE `role_assign`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_id` INTEGER NOT NULL,
    `role_id` VARCHAR(1000) NOT NULL,
    `role_group_id` VARCHAR(1000) NOT NULL,
    `description` TEXT,
    PRIMARY KEY (`id`),
    INDEX `role_assign_fi_29554a` (`user_id`),
    CONSTRAINT `role_assign_fk_29554a`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- promotion
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `promotion`;

CREATE TABLE `promotion`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(30),
    `customer` VARCHAR(30),
    `url` VARCHAR(300),
    `phone` VARCHAR(20),
    `fullname` VARCHAR(50),
    `address` VARCHAR(250),
    `type` VARCHAR(30),
    `status` INTEGER,
    `used_at` DATETIME,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- giftcode
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `giftcode`;

CREATE TABLE `giftcode`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50),
    `email` VARCHAR(50),
    `value` VARCHAR(500),
    `type` VARCHAR(50),
    `advert_id` INTEGER,
    `customer_id` INTEGER,
    `status` INTEGER DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `giftcode_fi_7e8f3e` (`customer_id`),
    CONSTRAINT `giftcode_fk_7e8f3e`
        FOREIGN KEY (`customer_id`)
        REFERENCES `customer` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- user_login
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_login`;

CREATE TABLE `user_login`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `uid` VARCHAR(250),
    `username` VARCHAR(250),
    `email` VARCHAR(250),
    `type` VARCHAR(250),
    `fullname` VARCHAR(250),
    `address` VARCHAR(250),
    `phone` VARCHAR(250),
    `location` VARCHAR(250),
    `ap_macaddr` VARCHAR(250),
    `advert_id` INTEGER,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- location
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `location`;

CREATE TABLE `location`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(250),
    `code` VARCHAR(250),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- accesspoint
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `accesspoint`;

CREATE TABLE `accesspoint`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `macaddr` VARCHAR(50),
    `ap_macaddr` VARCHAR(50),
    `fw_version` VARCHAR(50),
    `isp` VARCHAR(255),
    `ssid` VARCHAR(50),
    `key` VARCHAR(50),
    `province` VARCHAR(500),
    `ads_location` VARCHAR(500),
    `login_template` VARCHAR(500),
    `image` VARCHAR(1000),
    `category_id` INTEGER,
    `lng` VARCHAR(1000),
    `lat` VARCHAR(1000),
    `detail_url_id` VARCHAR(50),
    `section_id` INTEGER,
    `subsection_ids` VARCHAR(1000),
    `orders` INTEGER,
    `suborder_ids` VARCHAR(1000),
    `front_page` TINYINT(1),
    `has_comment` TINYINT(1),
    `can_delete` TINYINT(1),
    `published_at` DATETIME,
    `imgs` VARCHAR(1000),
    `relative_news` TEXT,
    `owner` VARCHAR(500),
    `customer_id` INTEGER,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `accesspoint_fi_7e8f3e` (`customer_id`),
    INDEX `accesspoint_fi_112411` (`section_id`),
    INDEX `accesspoint_fi_93f0f9` (`category_id`),
    CONSTRAINT `accesspoint_fk_7e8f3e`
        FOREIGN KEY (`customer_id`)
        REFERENCES `customer` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `accesspoint_fk_112411`
        FOREIGN KEY (`section_id`)
        REFERENCES `section` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `accesspoint_fk_93f0f9`
        FOREIGN KEY (`category_id`)
        REFERENCES `accesspoint_category` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- accesspoint_category
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `accesspoint_category`;

CREATE TABLE `accesspoint_category`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `icon` VARCHAR(1000),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- ads_log
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ads_log`;

CREATE TABLE `ads_log`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `ap_macaddr` VARCHAR(50),
    `device_macaddr` VARCHAR(50),
    `device` VARCHAR(1000),
    `wan_ip` VARCHAR(100),
    `device_ip` VARCHAR(100),
    `ap_sessionid` VARCHAR(200),
    `web_session` VARCHAR(200),
    `user_url` VARCHAR(1000),
    `is_mobile` INTEGER DEFAULT 0,
    `os` VARCHAR(200),
    `browser` VARCHAR(200),
    `user_agent` VARCHAR(1000),
    `phase` VARCHAR(50),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `ap_macaddr` (`ap_macaddr`, `device_macaddr`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- track_log
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `track_log`;

CREATE TABLE `track_log`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `ads_id` INTEGER DEFAULT 0,
    `ap_macaddr` VARCHAR(50),
    `device_macaddr` VARCHAR(50),
    `device` VARCHAR(1000),
    `wan_ip` VARCHAR(100),
    `device_ip` VARCHAR(100),
    `ap_sessionid` VARCHAR(200),
    `web_session` VARCHAR(200),
    `user_url` VARCHAR(1000),
    `is_mobile` INTEGER DEFAULT 0,
    `os` VARCHAR(200),
    `browser` VARCHAR(200),
    `user_agent` VARCHAR(1000),
    `phase` VARCHAR(50),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `ap_macaddr` (`ap_macaddr`, `device_macaddr`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- ap_log
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ap_log`;

CREATE TABLE `ap_log`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `ap_macaddr` VARCHAR(50),
    `fw_version` VARCHAR(50),
    `platform` VARCHAR(1000),
    `ip` VARCHAR(50),
    `ssid` VARCHAR(100),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- ap_config
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ap_config`;

CREATE TABLE `ap_config`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `ap_macaddr` VARCHAR(50),
    `fw_version` VARCHAR(50),
    `fw_version_next` VARCHAR(50),
    `platform` VARCHAR(1000),
    `ip` VARCHAR(50),
    `isp` VARCHAR(255),
    `ssid` VARCHAR(100),
    `need_update` INTEGER DEFAULT 1,
    `fw_upgrade` VARCHAR(50) DEFAULT 'option fw_upgrade 0',
    `fw_file` VARCHAR(100) DEFAULT '',
    `ssid_update` VARCHAR(50) DEFAULT 'option ssid_update 1',
    `ssid_next` VARCHAR(100) DEFAULT 'option ssid \"WiAds Free Wifi\"',
    `safe_sleep` VARCHAR(50) DEFAULT 'option safe_sleep 0',
    `reset_need` VARCHAR(50) DEFAULT 'option reset_to_default 0',
    `normal_mode` VARCHAR(50) DEFAULT 'option normal_mode 0',
    `update_uamdomains` VARCHAR(50) DEFAULT 'option update_uamdomains 0',
    `uamdomains` VARCHAR(500) DEFAULT '#HS_UAMDOMAINS',
    `uamdomains_next` VARCHAR(500) DEFAULT '#HS_UAMDOMAINS',
    `update_uamformat` VARCHAR(50) DEFAULT 'option update_uamformat 0',
    `uamformat` VARCHAR(100),
    `uamformat_next` VARCHAR(100),
    `update_uamhomepage` VARCHAR(50) DEFAULT 'option update_uamhomepage 0',
    `uamhomepage` VARCHAR(100),
    `uamhomepage_next` VARCHAR(100),
    `update_macauth` VARCHAR(50) DEFAULT 'option update_macauth 0',
    `macauth` VARCHAR(100),
    `macauth_next` VARCHAR(100),
    `update_channel` VARCHAR(50) DEFAULT 'option channel_update 0',
    `channel` VARCHAR(100),
    `channel_next` VARCHAR(100),
    `update_hwmode` VARCHAR(50) DEFAULT 'option hwmode_update 0',
    `hwmode` VARCHAR(100),
    `hwmode_next` VARCHAR(100),
    `update_htmode` VARCHAR(50) DEFAULT 'option htmode_update 0',
    `htmode` VARCHAR(100),
    `htmode_next` VARCHAR(100),
    `update_noscan` VARCHAR(50) DEFAULT 'option noscan_update 0',
    `noscan` VARCHAR(100),
    `noscan_next` VARCHAR(100),
    `update_encryption` VARCHAR(50) DEFAULT 'option encryption_update 0',
    `encryption` VARCHAR(100),
    `encryption_next` VARCHAR(100),
    `update_key` VARCHAR(50) DEFAULT 'option key_update 0',
    `key` VARCHAR(100),
    `key_next` VARCHAR(100),
    `update_lan_network` VARCHAR(100) DEFAULT 'option network_lan_update 1',
    `lan_network` VARCHAR(100) DEFAULT 'option network_lan \'172.16.16.1\'',
    `update_hosts` VARCHAR(50) DEFAULT 'option hosts_update 0',
    `hosts` VARCHAR(100),
    `iwinfo` VARCHAR(3000),
    `need_reboot` VARCHAR(50) DEFAULT 'option need_reboot 0',
    `wifi_enable` VARCHAR(50) DEFAULT 'active wifi 1',
    `bw_profile_id` INTEGER DEFAULT 1,
    `exclude` INTEGER DEFAULT 0,
    `activated` INTEGER DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `ap_macaddr` (`ap_macaddr`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- firmware
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `firmware`;

CREATE TABLE `firmware`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `type` VARCHAR(255),
    `name` VARCHAR(255),
    `fw_version` VARCHAR(500),
    `file` VARCHAR(500),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- user_data_collection
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_data_collection`;

CREATE TABLE `user_data_collection`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `advert_id` INTEGER,
    `data` VARCHAR(500),
    `device_mac` VARCHAR(50),
    `status` INTEGER DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- ads_daily_counting
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ads_daily_counting`;

CREATE TABLE `ads_daily_counting`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `advert_id` INTEGER,
    `ap_macaddr` VARCHAR(50),
    `view_count` INTEGER,
    `click_count` INTEGER,
    `date` VARCHAR(50),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- ads_distribution
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ads_distribution`;

CREATE TABLE `ads_distribution`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `advert_id` INTEGER,
    `current` INTEGER DEFAULT 0,
    `ratio` FLOAT DEFAULT 1,
    `location` VARCHAR(1024),
    `platform` VARCHAR(500),
    `platform_version` VARCHAR(500),
    `is_showing` INTEGER DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- bw_profile
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `bw_profile`;

CREATE TABLE `bw_profile`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(50),
    `username` VARCHAR(50),
    `password` VARCHAR(50),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- ap_report
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ap_report`;

CREATE TABLE `ap_report`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `ap_macaddr` VARCHAR(50),
    `year` INTEGER DEFAULT 0,
    `month` INTEGER DEFAULT 0,
    `01` VARCHAR(50) DEFAULT '0',
    `02` VARCHAR(50) DEFAULT '0',
    `03` VARCHAR(50) DEFAULT '0',
    `04` VARCHAR(50) DEFAULT '0',
    `05` VARCHAR(50) DEFAULT '0',
    `06` VARCHAR(50) DEFAULT '0',
    `07` VARCHAR(50) DEFAULT '0',
    `08` VARCHAR(50) DEFAULT '0',
    `09` VARCHAR(50) DEFAULT '0',
    `10` VARCHAR(50) DEFAULT '0',
    `11` VARCHAR(50) DEFAULT '0',
    `12` VARCHAR(50) DEFAULT '0',
    `13` VARCHAR(50) DEFAULT '0',
    `14` VARCHAR(50) DEFAULT '0',
    `15` VARCHAR(50) DEFAULT '0',
    `16` VARCHAR(50) DEFAULT '0',
    `17` VARCHAR(50) DEFAULT '0',
    `18` VARCHAR(50) DEFAULT '0',
    `19` VARCHAR(50) DEFAULT '0',
    `20` VARCHAR(50) DEFAULT '0',
    `21` VARCHAR(50) DEFAULT '0',
    `22` VARCHAR(50) DEFAULT '0',
    `23` VARCHAR(50) DEFAULT '0',
    `24` VARCHAR(50) DEFAULT '0',
    `25` VARCHAR(50) DEFAULT '0',
    `26` VARCHAR(50) DEFAULT '0',
    `27` VARCHAR(50) DEFAULT '0',
    `28` VARCHAR(50) DEFAULT '0',
    `29` VARCHAR(50) DEFAULT '0',
    `30` VARCHAR(50) DEFAULT '0',
    `31` VARCHAR(50) DEFAULT '0',
    `01_click` VARCHAR(50) DEFAULT '0',
    `02_click` VARCHAR(50) DEFAULT '0',
    `03_click` VARCHAR(50) DEFAULT '0',
    `04_click` VARCHAR(50) DEFAULT '0',
    `05_click` VARCHAR(50) DEFAULT '0',
    `06_click` VARCHAR(50) DEFAULT '0',
    `07_click` VARCHAR(50) DEFAULT '0',
    `08_click` VARCHAR(50) DEFAULT '0',
    `09_click` VARCHAR(50) DEFAULT '0',
    `10_click` VARCHAR(50) DEFAULT '0',
    `11_click` VARCHAR(50) DEFAULT '0',
    `12_click` VARCHAR(50) DEFAULT '0',
    `13_click` VARCHAR(50) DEFAULT '0',
    `14_click` VARCHAR(50) DEFAULT '0',
    `15_click` VARCHAR(50) DEFAULT '0',
    `16_click` VARCHAR(50) DEFAULT '0',
    `17_click` VARCHAR(50) DEFAULT '0',
    `18_click` VARCHAR(50) DEFAULT '0',
    `19_click` VARCHAR(50) DEFAULT '0',
    `20_click` VARCHAR(50) DEFAULT '0',
    `21_click` VARCHAR(50) DEFAULT '0',
    `22_click` VARCHAR(50) DEFAULT '0',
    `23_click` VARCHAR(50) DEFAULT '0',
    `24_click` VARCHAR(50) DEFAULT '0',
    `25_click` VARCHAR(50) DEFAULT '0',
    `26_click` VARCHAR(50) DEFAULT '0',
    `27_click` VARCHAR(50) DEFAULT '0',
    `28_click` VARCHAR(50) DEFAULT '0',
    `29_click` VARCHAR(50) DEFAULT '0',
    `30_click` VARCHAR(50) DEFAULT '0',
    `31_click` VARCHAR(50) DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- news_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `news_i18n`;

CREATE TABLE `news_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `title` VARCHAR(1000),
    `strip_title` VARCHAR(1000),
    `brief` TEXT,
    `content` LONGTEXT,
    `tag` VARCHAR(1000),
    `keyword` VARCHAR(1000),
    `post_by` VARCHAR(1000),
    `edit_by` VARCHAR(1000),
    `short_link` VARCHAR(1000),
    `link` VARCHAR(1000),
    `locked` TINYINT(1),
    `trash` TINYINT(1),
    `status` VARCHAR(255),
    `pre_status` VARCHAR(255),
    `status_note` VARCHAR(1000),
    `draft` TINYINT(1),
    `read` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `news_i18n_fk_35e9f9`
        FOREIGN KEY (`id`)
        REFERENCES `news` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- comment_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `comment_i18n`;

CREATE TABLE `comment_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `title` VARCHAR(1000),
    `strip_title` VARCHAR(1000),
    `content` TEXT,
    `news_link` VARCHAR(1000),
    `news_title` VARCHAR(1000),
    `section_title` VARCHAR(1000),
    `edit_by` VARCHAR(1000),
    `locked` TINYINT(1) DEFAULT 1,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `comment_i18n_fk_141bd2`
        FOREIGN KEY (`id`)
        REFERENCES `comment` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- section_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `section_i18n`;

CREATE TABLE `section_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'vi' NOT NULL,
    `title` VARCHAR(1000),
    `strip_title` VARCHAR(1000),
    `brief` TEXT,
    `content` TEXT,
    `link` VARCHAR(3000),
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `section_i18n_fk_da15bf`
        FOREIGN KEY (`id`)
        REFERENCES `section` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- menu_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `menu_i18n`;

CREATE TABLE `menu_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'vi' NOT NULL,
    `title` VARCHAR(1000),
    `strip_title` VARCHAR(1000),
    `brief` TEXT,
    `content` TEXT,
    `link_to` VARCHAR(1000),
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `menu_i18n_fk_14b1c0`
        FOREIGN KEY (`id`)
        REFERENCES `menu` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- language_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `language_i18n`;

CREATE TABLE `language_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'vi' NOT NULL,
    `title` VARCHAR(1000),
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `language_i18n_fk_5b9bd4`
        FOREIGN KEY (`id`)
        REFERENCES `language` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- advert_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `advert_i18n`;

CREATE TABLE `advert_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'vi' NOT NULL,
    `title` VARCHAR(1000),
    `description` VARCHAR(1000),
    `campagin` VARCHAR(1000),
    `strip_title` VARCHAR(1000),
    `brief` TEXT,
    `tag` VARCHAR(1000),
    `keyword` VARCHAR(1000),
    `post_by` VARCHAR(1000),
    `edit_by` VARCHAR(1000),
    `link` VARCHAR(1000),
    `link_to` VARCHAR(1000),
    `view` INTEGER DEFAULT 0,
    `locked` TINYINT(1) DEFAULT 0,
    `trash` TINYINT(1),
    `read` INTEGER,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `advert_i18n_fk_529269`
        FOREIGN KEY (`id`)
        REFERENCES `advert` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- place_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `place_i18n`;

CREATE TABLE `place_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'vi' NOT NULL,
    `title` VARCHAR(1000),
    `strip_title` VARCHAR(1000),
    `brief` TEXT,
    `tag` VARCHAR(1000),
    `keyword` VARCHAR(1000),
    `post_by` VARCHAR(1000),
    `edit_by` VARCHAR(1000),
    `link` VARCHAR(1000),
    `link_to` VARCHAR(1000),
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `place_i18n_fk_1e9e34`
        FOREIGN KEY (`id`)
        REFERENCES `place` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- vote_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `vote_i18n`;

CREATE TABLE `vote_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'vi' NOT NULL,
    `title` VARCHAR(1000),
    `content` TEXT,
    `post_by` VARCHAR(1000),
    `edit_by` VARCHAR(1000),
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `vote_i18n_fk_3ff174`
        FOREIGN KEY (`id`)
        REFERENCES `vote` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- vote_question_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `vote_question_i18n`;

CREATE TABLE `vote_question_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'vi' NOT NULL,
    `content` TEXT,
    `count` INTEGER DEFAULT 0,
    `total` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `vote_question_i18n_fk_42c247`
        FOREIGN KEY (`id`)
        REFERENCES `vote_question` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- marker_category_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `marker_category_i18n`;

CREATE TABLE `marker_category_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'vi' NOT NULL,
    `name` VARCHAR(1000),
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `marker_category_i18n_fk_0766b8`
        FOREIGN KEY (`id`)
        REFERENCES `marker_category` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- marker_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `marker_i18n`;

CREATE TABLE `marker_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'vi' NOT NULL,
    `name` VARCHAR(1000),
    `address` VARCHAR(1000),
    `pcontact` VARCHAR(1000),
    `detail_url` VARCHAR(1000),
    `title` VARCHAR(1000),
    `strip_title` VARCHAR(1000),
    `brief` TEXT,
    `content` TEXT,
    `tag` TEXT,
    `keyword` TEXT,
    `post_by` VARCHAR(1000),
    `edit_by` VARCHAR(1000),
    `short_link` TEXT,
    `link` TEXT,
    `locked` TINYINT(1),
    `trash` TINYINT(1),
    `status` VARCHAR(255),
    `pre_status` VARCHAR(255),
    `status_note` VARCHAR(1000),
    `draft` TINYINT(1),
    `read` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `marker_i18n_fk_d021b1`
        FOREIGN KEY (`id`)
        REFERENCES `marker` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- accesspoint_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `accesspoint_i18n`;

CREATE TABLE `accesspoint_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'vi' NOT NULL,
    `name` VARCHAR(1000),
    `address` VARCHAR(1000),
    `pcontact` VARCHAR(1000),
    `detail_url` VARCHAR(1000),
    `title` VARCHAR(1000),
    `strip_title` VARCHAR(1000),
    `brief` TEXT,
    `content` TEXT,
    `tag` TEXT,
    `keyword` TEXT,
    `post_by` VARCHAR(1000),
    `edit_by` VARCHAR(1000),
    `short_link` TEXT,
    `link` TEXT,
    `locked` TINYINT(1),
    `trash` TINYINT(1),
    `status` VARCHAR(255),
    `pre_status` VARCHAR(255),
    `status_note` VARCHAR(1000),
    `draft` TINYINT(1),
    `read` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `accesspoint_i18n_fk_085207`
        FOREIGN KEY (`id`)
        REFERENCES `accesspoint` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

-- ---------------------------------------------------------------------
-- accesspoint_category_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `accesspoint_category_i18n`;

CREATE TABLE `accesspoint_category_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'vi' NOT NULL,
    `name` VARCHAR(1000),
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `accesspoint_category_i18n_fk_a0aa2b`
        FOREIGN KEY (`id`)
        REFERENCES `accesspoint_category` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8' COLLATE='utf8_unicode_ci';

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
