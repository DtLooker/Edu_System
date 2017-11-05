DROP DATABASE IF EXISTS `eduSystem`;
CREATE DATABASE `eduSystem`;
-- ----------------------------
--  Table structure for `edu_teacher`
-- ----------------------------
DROP TABLE IF EXISTS `edu_teacher`;
CREATE TABLE `edu_teacher` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(30) DEFAULT '' COMMENT '姓名',
    `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0男，1女',
    `username` varchar(16) NOT NULL COMMENT '用户名',
    `email` varchar(30) DEFAULT '' COMMENT '邮箱',
    `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
    `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
    PRIMARY KEY (`id`)
)ENGINE=MyISAM AUTO_INCREMENT = 3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `yunzhi_teacher`
-- ----------------------------
INSERT INTO `edu_teacher` VALUES
 ('1', '张三', '0', 'zhangsan', 'zhangsan@mail.com', '123123', '123213'),
 ('2', '李四', '0', 'lisi', 'lisi@yunzhi.club', '123213', '1232');


 ALTER TABLE `edu_teacher` ADD `password` VARCHAR(40)  NOT NULL COMMENT '密码';
 ALTER TABLE `edu_teacher` DROP `password`;
