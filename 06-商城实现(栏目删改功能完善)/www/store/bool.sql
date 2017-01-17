#商城sql语句

#栏目表
create table category(
category_id int auto_increment primary key,
category_name varchar(20) not null default '',
category_desc varchar(100) not null default '',
parent_id int not null default 0
)engine myisam charset utf8;