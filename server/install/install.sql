
CREATE DATABASE IF NOT EXISTS jewelry CHARACTER SET UTF8 COLLATE utf8_general_ci;

USE jewelry;

-- user
CREATE TABLE IF NOT EXISTS `user`
(
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` CHAR(20) NOT NULL COMMENT 'username',
    `password` CHAR(32) NOT NULL,
    `type` ENUM("SuperAdmin", "Admin", "Customer") NOT NULL DEFAULT 'Customer',
    `realname` CHAR(40) NOT NULL DEFAULT '',
    `phone` CHAR(20) NOT NULL DEFAULT '',
    `email` CHAR(40) NOT NULL DEFAULT '',
    `create_time` DATETIME,
    PRIMARY KEY(`id`),
    UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=101;

-- customer
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `account` int(10) NOT NULL,
  `state` char(20) NOT NULL COMMENT '是否被通过',
  `gender` char(4) NOT NULL,
  `qq` char(20) NOT NULL,
  `city` char(20) NOT NULL,
  `remark` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=361 ;

-- customer_address
CREATE TABLE IF NOT EXISTS `customer_address` (
  `customer` int(10) unsigned NOT NULL,
  `address` int(10) unsigned NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- address never del(for bill to ref)
CREATE TABLE IF NOT EXISTS `address`
(
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `is_del` TINYINT(1) NOT NULL DEFAULT '0',
    `name` CHAR(20) NOT NULL COMMENT '姓名',
    `phone` CHAR(20) NOT NULL,
    `detail` TEXT NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE=MyISAM AUTO_INCREMENT=101;

-- account
CREATE TABLE IF NOT EXISTS `account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `remain` decimal(10,2) DEFAULT '0.00',
  `num_remain` int(10) NOT NULL COMMENT 'in fact we didn''t need that',
  `done` decimal(10,2) DEFAULT '0.00',
  `undone` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='钱的账户或者辅石的账户' AUTO_INCREMENT=826 ;

-- product, actually, it's product type
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no` char(20) NOT NULL COMMENT '款号',
  `name` char(60) NOT NULL,
  `is_customized` tinyint(1) NOT NULL DEFAULT '0',
  `is_brand` tinyint(1) NOT NULL DEFAULT '0',
  `brand` int(10) NOT NULL,
  `image1` varchar(100) DEFAULT NULL,
  `image2` varchar(100) DEFAULT NULL,
  `image3` varchar(100) DEFAULT NULL,
  `image1_400` varchar(100) NOT NULL,
  `image2_400` varchar(100) NOT NULL,
  `image3_400` varchar(100) NOT NULL,
  `image1_thumb` varchar(100) NOT NULL,
  `image2_thumb` varchar(100) NOT NULL,
  `image3_thumb` varchar(100) NOT NULL,
  `type` char(20) NOT NULL,
  `material` char(120) NOT NULL COMMENT 'JSON',
  `weight` decimal(10,2) DEFAULT NULL,
  `rabbet_start` decimal(2,2) NOT NULL,
  `rabbet_end` decimal(2,2) NOT NULL,
  `small_stone` tinyint(4) NOT NULL,
  `st_weight` decimal(6,2) NOT NULL DEFAULT '0.00',
  `remark` text,
  `carve_allow` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `post_time` datetime DEFAULT NULL,
  `sold_count` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6422 ;

-- product_type
CREATE TABLE IF NOT EXISTS `product_type`
(
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` CHAR(60) NOT NULL,
    PRIMARY KEY(`id`),
    UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=101;

CREATE TABLE IF NOT EXISTS `product_brand` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_2` (`name`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- cart
CREATE TABLE IF NOT EXISTS `cart`
(
    `customer` INT(10) UNSIGNED NOT NULL,
    `small_order` INT(10) UNSIGNED NOT NULL
) ENGINE=MyISAM;

-- big_order is an ...
CREATE TABLE IF NOT EXISTS `big_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sn` char(20) NOT NULL,
  `customer` int(10) NOT NULL,
  `address` int(10) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=110 ;

-- small_order
CREATE TABLE IF NOT EXISTS `small_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `big_order` int(10) NOT NULL,
  `product` int(10) unsigned NOT NULL,
  `factory` int(10) unsigned NOT NULL,
  `stone` int(10) unsigned NOT NULL COMMENT '主石，0代表无',
  `size` smallint(4) unsigned NOT NULL,
  `carve_text` varchar(120) DEFAULT NULL,
  `material` char(20) NOT NULL,
  `weight_ratio` decimal(6,2) NOT NULL DEFAULT '1.00',
  `state` char(18) NOT NULL,
  `factory_st` smallint(3) NOT NULL DEFAULT '0' COMMENT '工厂配石（粒）',
  `factory_st_weight` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '工厂配石重量（克拉）',
  `factory_price` int(10) unsigned NOT NULL,
  `customer_price` int(10) unsigned NOT NULL,
  `add_cart_time` datetime DEFAULT NULL,
  `submit_time` datetime DEFAULT NULL,
  `confirm_time` datetime DEFAULT NULL,
  `factory_confirm_time` datetime DEFAULT NULL,
  `factory_done_time` datetime DEFAULT NULL,
  `done_time` datetime DEFAULT NULL,
  `real_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `estimate_price` decimal(10,2) NOT NULL,
  `paid` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'customer_paid',
  `paid_factory` decimal(10,2) NOT NULL DEFAULT '0.00',
  `customer_remark` text,
  `admin_remark` text,
  `is_customized` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35990 ;

-- price_data
CREATE TABLE IF NOT EXISTS `price_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gold_weight` decimal(6,2) NOT NULL,
  `wear_tear` tinyint(2) NOT NULL,
  `gold_price` decimal(10,2) NOT NULL,
  `labor_expense` decimal(10,2) NOT NULL,
  `small_stone` smallint(3) NOT NULL,
  `st_expense` decimal(10,2) DEFAULT NULL,
  `st_price` decimal(10,2) DEFAULT NULL,
  `st_weight` decimal(10,2) DEFAULT NULL,
  `model_expense` decimal(10,2) DEFAULT NULL,
  `risk_expense` decimal(10,2) DEFAULT NULL,
  `final_price` decimal(10,2) DEFAULT NULL COMMENT '因为可能会直接强行修改这个值?',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=609 ;

-- factory
CREATE TABLE IF NOT EXISTS `factory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(60) NOT NULL COMMENT '工厂名称',
  `contact` char(20) DEFAULT NULL COMMENT '联系人',
  `gender` char(10) DEFAULT NULL COMMENT '性别',
  `phone` char(20) DEFAULT NULL COMMENT '联系电话',
  `email` char(50) NOT NULL,
  `qq` char(20) DEFAULT NULL COMMENT 'QQ',
  `city` char(20) DEFAULT NULL COMMENT '区域',
  `address` char(50) NOT NULL,
  `remark` varchar(200) NOT NULL,
  `account` int(10) NOT NULL,
  `st_account` int(10) NOT NULL,
  `done` int(6) DEFAULT '0' COMMENT '成交',
  `undone` int(6) DEFAULT '0' COMMENT '未结清',
  `st_remain` decimal(6,2) DEFAULT '0.00' COMMENT '剩余辅石,we need this?',
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=117 ;

-- setting 全局设定
CREATE TABLE IF NOT EXISTS `setting`
(
    `key` CHAR(30) NOT NULL,
    `value` CHAR(30) NOT NULL,
    UNIQUE KEY (`key`)
) ENGINE=MyISAM;

-- price
CREATE TABLE IF NOT EXISTS `price`
(
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `type` CHAR(10) NOT NULL, -- ENUM('PT950', 'AU750')
    `price` DECIMAL(10,2) NOT NULL,
    `time` DATETIME NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE=MyISAM AUTO_INCREMENT=101;

-- log for everthing...
CREATE TABLE IF NOT EXISTS `user_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject` int(10) unsigned NOT NULL COMMENT '主语 user_id or customer_id or ???',
  `action` char(20) NOT NULL COMMENT '动词',
  `target` int(10) unsigned DEFAULT NULL COMMENT '宾语',
  `info` varchar(50) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=237 ;

-- log special for account
CREATE TABLE IF NOT EXISTS `account_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` int(10) unsigned NOT NULL COMMENT 'id of account',
  `name` char(20) NOT NULL COMMENT '名称|备注',
  `order` int(10) unsigned NOT NULL COMMENT '相关订单',
  `money` decimal(10,2) NOT NULL COMMENT '金额 ',
  `num` int(9) NOT NULL,
  `type` char(20) NOT NULL COMMENT ' 类型',
  `remain` decimal(10,2) NOT NULL COMMENT '账户余额',
  `pay_type` char(20) NOT NULL COMMENT '支付方式',
  `remark` varchar(200) NOT NULL,
  `time` datetime NOT NULL,
  `ms` smallint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=640 ;

-- stone
CREATE TABLE IF NOT EXISTS `stone` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weight` decimal(6,2) NOT NULL,
  `cut` varchar(11) NOT NULL,
  `color` varchar(11) NOT NULL,
  `polish` varchar(10) NOT NULL COMMENT '抛光',
  `clarity` varchar(10) NOT NULL COMMENT '净度',
  `symmetry` varchar(10) NOT NULL COMMENT '对称',
  `certificate` varchar(20) NOT NULL COMMENT '证书',
  `no` varchar(20) NOT NULL COMMENT '证书号',
  `remark` varchar(200) NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='主石' AUTO_INCREMENT=1245 ;

CREATE TABLE IF NOT EXISTS `customize_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order` int(10) unsigned NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
