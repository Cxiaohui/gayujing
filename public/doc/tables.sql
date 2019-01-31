-- 系统使用用户
create table ga_sysusers(
id int unsigned NOT NULL AUTO_INCREMENT,
status tinyint NOT NULL DEFAULT '1' COMMENT '账号状态',
name varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
gender tinyint NOT NULL DEFAULT '0' COMMENT '性别：0未知，1男，2女',
mobile varchar(16) NOT NULL DEFAULT '' COMMENT '手机号',
education varchar(16) NOT NULL DEFAULT '' COMMENT '学历',
logaccount varchar(32) NOT NULL DEFAULT '' COMMENT '登录账号',
logpwd varchar(32) NOT NULL DEFAULT '' COMMENT '登录密码',
logstat varchar(10) NOT NULL DEFAULT '' ,
headpic varchar(125) NOT NULL DEFAULT '' COMMENT '头像',
province_id int unsigned NOT NULL DEFAULT 0,
province varchar(32) NOT NULL DEFAULT '' COMMENT '省',
city_id int unsigned NOT NULL DEFAULT 0,
city varchar(32) NOT NULL DEFAULT '' COMMENT '市',
county_id int unsigned NOT NULL DEFAULT 0,
county varchar(32) NOT NULL DEFAULT '' COMMENT '县/区',
district_id int unsigned NOT NULL DEFAULT 0,
district varchar(32) NOT NULL DEFAULT '' COMMENT '乡镇',
isdel  tinyint NOT NULL DEFAULT '0' COMMENT '删除标记：0否，1是',
create_time datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
update_time datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统使用用户表';


-- 人员信息
create table ga_peoples(
id int unsigned NOT NULL AUTO_INCREMENT,
name varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
idnumber varchar(32) NOT NULL DEFAULT '' COMMENT '身份证号',
mobile varchar(32) NOT NULL DEFAULT '' COMMENT '通讯号码',
idcardpic0 varchar(125) NOT NULL DEFAULT '' COMMENT '身份证正面照',
idcardpic1 varchar(125) NOT NULL DEFAULT '' COMMENT '身份证反面照',
create_time datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
update_time datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='人员信息';

-- 特护期工作表

create table ga_tehuworks(
id int unsigned NOT NULL AUTO_INCREMENT,
post_user_id int unsigned NOT NULL DEFAULT 0,
status tinyint NOT NULL DEFAULT '0' COMMENT '状态',
xinfang_name varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
xinfang_idnumber varchar(32) NOT NULL DEFAULT '' COMMENT '身份证号',
xinfang_mobile varchar(32) NOT NULL DEFAULT '' COMMENT '通讯号码',
xinfang_idcardpic0 varchar(125) NOT NULL DEFAULT '' COMMENT '身份证正面照',
xinfang_idcardpic1 varchar(125) NOT NULL DEFAULT '' COMMENT '身份证反面照',
tongxi_name varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
tongxi_idnumber varchar(32) NOT NULL DEFAULT '' COMMENT '身份证号',
tongxi_mobile varchar(32) NOT NULL DEFAULT '' COMMENT '通讯号码',
tongxi_idcardpic0 varchar(125) NOT NULL DEFAULT '' COMMENT '身份证正面照',
tongxi_idcardpic1 varchar(125) NOT NULL DEFAULT '' COMMENT '身份证反面照',
gobeijing_path varchar(32) NOT NULL DEFAULT '' COMMENT '进京途径',
gobeijing_type varchar(32) NOT NULL DEFAULT '' COMMENT '进京方式',
acttype_inbeijing varchar(32) NOT NULL DEFAULT '' COMMENT '在京行为类型',
address_inbeijing varchar(125) NOT NULL DEFAULT '' COMMENT '在京巡回地点',
lost_time datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '失联时间',
find_time datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '找到时间',
content text,
create_time datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
update_time datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
isdel  tinyint NOT NULL DEFAULT '0' COMMENT '删除标记：0否，1是',
PRIMARY KEY (`id`),
key(post_user_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='特护期工作表';


-- 日常性工作

create table ga_daliyworks(
id int unsigned NOT NULL AUTO_INCREMENT,
post_user_id int unsigned NOT NULL DEFAULT 0,
status tinyint NOT NULL DEFAULT '0' COMMENT '状态',
people_name varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
people_idnumber varchar(32) NOT NULL DEFAULT '' COMMENT '身份证号',
people_mobile varchar(32) NOT NULL DEFAULT '' COMMENT '通讯号码',
people_idcardpic0 varchar(125) NOT NULL DEFAULT '' COMMENT '身份证正面照',
people_idcardpic1 varchar(125) NOT NULL DEFAULT '' COMMENT '身份证反面照',
gobeijing_path varchar(32) NOT NULL DEFAULT '' COMMENT '进京途径',
content text comment '详细诉求',
gotype varchar(32) NOT NULL DEFAULT '' COMMENT '上访方式',
action_name varchar(32) NOT NULL DEFAULT '' COMMENT '过激行为',
action_desn text COMMENT '行为描述',
work_content text comment '上访工作',
create_time datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
update_time datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
isdel  tinyint NOT NULL DEFAULT '0' COMMENT '删除标记：0否，1是',
PRIMARY KEY (`id`),
key(post_user_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='日常性工作';

-- 工作中上传的图片

create table ga_works_photos(
id int unsigned NOT NULL AUTO_INCREMENT,
work_id int unsigned NOT NULL DEFAULT 0,
type tinyint NOT NULL DEFAULT '1' COMMENT '类型：1现场工作照，2信访人生活照',
sort tinyint unsigned NOT NULL DEFAULT '1' COMMENT '排序',
path varchar(125) NOT NULL DEFAULT '' COMMENT '图片',
create_time datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
isdel  tinyint NOT NULL DEFAULT '0' COMMENT '删除标记：0否，1是',
PRIMARY KEY (`id`),
key(work_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='日常性工作';

-- 事件采集
create table ga_events(
id int unsigned NOT NULL AUTO_INCREMENT,
post_user_id int unsigned NOT NULL DEFAULT 0,
status tinyint NOT NULL DEFAULT '1' COMMENT '状态',
type tinyint NOT NULL DEFAULT '1' COMMENT '类型：1已/正发生的，2预报的',
group_name  varchar(32) NOT NULL DEFAULT '' COMMENT '涉及群体',
event_cate varchar(32) NOT NULL DEFAULT '' COMMENT '事件类别',
happen_time datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
address varchar(125) NOT NULL DEFAULT '' COMMENT '地点',
people_number varchar(32) NOT NULL DEFAULT '' COMMENT '人数规模',
content text comment '事因\诉求',
do_unit_name varchar(125) NOT NULL DEFAULT '' COMMENT '处置单位',
create_time datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
update_time datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
isdel  tinyint NOT NULL DEFAULT '0' COMMENT '删除标记：0否，1是',
PRIMARY KEY (`id`),
key(post_user_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='事件采集';

-- 事件采集人员信息

create table ga_event_peoples(
id int unsigned NOT NULL AUTO_INCREMENT,
event_id int unsigned NOT NULL DEFAULT 0,
name varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
idnumber varchar(32) NOT NULL DEFAULT '' COMMENT '身份证号',
mobile varchar(32) NOT NULL DEFAULT '' COMMENT '通讯号码',
create_time datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
update_time datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
isdel  tinyint NOT NULL DEFAULT '0' COMMENT '删除标记：0否，1是',
PRIMARY KEY (`id`),
key(event_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='事件采集人员信息';