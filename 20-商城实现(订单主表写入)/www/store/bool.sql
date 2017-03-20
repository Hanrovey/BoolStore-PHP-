#商城sql语句

#栏目表
create table category(
category_id int auto_increment primary key,
category_name varchar(20) not null default '',
category_desc varchar(100) not null default '',
parent_id int not null default 0
)engine myisam charset utf8;


#商品表
CREATE TABLE IF NOT EXISTS `goods` (
  `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_sn` char(15) NOT NULL DEFAULT '',
  `category_id` smallint(6) NOT NULL DEFAULT '0',
  `brand_id` smallint(6) NOT NULL DEFAULT '0',
  `goods_name` varchar(30) NOT NULL DEFAULT '',
  `shop_price` decimal(9,2) NOT NULL DEFAULT '0.00',
  `market_price` decimal(9,2) NOT NULL DEFAULT '0.00',
  `goods_number` smallint(6) NOT NULL DEFAULT '1',
  `click_count` mediumint(9) NOT NULL DEFAULT '0',
  `goods_weight` decimal(6,3) NOT NULL DEFAULT '0.000',
  `goods_brief` varchar(100) NOT NULL DEFAULT '',
  `goods_desc` text NOT NULL,
  `thumb_img` varchar(30) NOT NULL DEFAULT '',
  `goods_img` varchar(30) NOT NULL DEFAULT '',
  `ori_img` varchar(30) NOT NULL DEFAULT '',
  `is_on_sale` tinyint(4) NOT NULL DEFAULT '1',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0',
  `is_best` tinyint(4) NOT NULL DEFAULT '0',
  `is_new` tinyint(4) NOT NULL DEFAULT '0',
  `is_hot` tinyint(4) NOT NULL DEFAULT '0',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `last_update` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`goods_id`),
  UNIQUE KEY `goods_sn` (`goods_sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


#用户表
create table user (
user_id int unsigned not null auto_increment primary key,
username varchar(16) not null default '',
email varchar(30) not null default '',
passwd char(32) not null default '',
regtime int unsigned not null default 0,
lastlogin int unsigned not null default 0
) engine myisam charset utf8;


#订单表
create table orderinfo(
order_id int unsigned auto_increment primary key,
order_sn char(15) not null default '',
zone varchar(30) not null default '',
user_id int unsigned not null default 0,
username varchar(20) not null default '',
address varchar(30) not null default '',
zipcode char(6) not null default '',
reciver varchar(10) not null default '',
email varchar(40) not null default '',
tel varchar(20) not null default '',
mobile char(11) not null default '',
building varchar(30) not null default '',
best_time varchar(10) not null default '',
add_time int unsigned not null default 0,
order_amount decimal(10,2) not null default 0.0,
pay tinyint(1) not null default 0
)engine myisam charset utf8;


#订单表
create table ordergoods(
og_id int unsigned auto_increment primary key,
order_id int unsigned not null default 0,
order_sn char(15) not null default '',
goods_id int unsigned not null default 0,
goods_name varchar(60) not null default '',
goods_number smallint not null default 1,
shop_price decimal(10,2) not null default 0.0,
subtotal decimal(10,2) not null default 0.0
)engine myisam charset utf8;



