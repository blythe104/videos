DROP TABLE IF EXISTS Vcontent;
CREATE TABLE Vcontent(
id INT NOT NULL  AUTO_INCREMENT  PRIMARY KEY COMMENT '视频ID',
title VARCHAR(50) NOT NULL COMMENT '视频标题',
instroduct TEXT COMMENT '视频简介',
path VARCHAR(255) COMMENT '视频路径',
avatar_path VARCHAR(255)  COMMENT '图片路径',
create_time INT DEFAULT 0 COMMENT "创建时间"
)ENGINE = MYISAM CHARSET = utf8;


DROP TABLE IF EXISTS Vdetail;
CREATE TABLE `Vdetail`(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT "视频附表ID",
Vid  INT COMMENT "视频ID",
support_count INT DEFAULT 0 COMMENT "点赞数",
comment_count INT DEFAULT 0 COMMENT "评论数",
repost_count INT  DEFAULT 0 COMMENT "转发数",
update_time INT COMMENT "更新时间"
)ENGINE = MYISAM CHARSET = utf8;



DROP TABLE IF EXISTS VComment;
CREATE TABLE Vcomment(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT "视频评论ID",
uid INT DEFAULT 0 NOT NULL COMMENT "用户ID",
content VARCHAR(1000) NULL DEFAULT "什么都没有说！" COMMENT "评论内容信息",
comment_Pid INT NOT NULL DEFAULT 0 COMMENT "上级评论ID",
Vlevel FLOAT NOT NULL COMMENT "评论星级",
create_time INT COMMENT "评论时间"
)ENGINE = MYISAM CHARSET = utf8;