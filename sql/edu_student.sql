-- ----------------------------
--  Table structure for `edu_student`
-- ----------------------------
DROP TABLE IF EXISTS `edu_student`;
CREATE TABLE `edu_student` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(40) NOT NULL DEFAULT '' COMMENT '姓名',
    `num` varchar(40) NOT NULL DEFAULT '',
    `sex` tinyint(2) NOT NULL DEFAULT '0',
    `klass_id` int(11) NOT NULL DEFAULT '0',
    `email` varchar(40) NOT NULL DEFAULT '',
    `create_time` int(11) NOT NULL DEFAULT '0',
    `update_time` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY(`id`)
)ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


-- ----------------------------
--  Records of `edu_student`
-- ----------------------------
INSERT INTO `edu_student` VALUES
('1', '徐琳杰', '111', '0', '1', 'xulinjie@yunzhiclub.com', '0', '0'),
('2', '魏静云', '112', '1', '2', 'weijingyun@yunzhiclub.com', '0', '0'),
('3', '刘茜', '113', '0', '2', 'liuxi@yunzhiclub.com', '0', '0'),
('4', '李甜', '114', '1', '1', 'litian@yunzhiclub.com', '0', '0'),
('5', '李翠彬', '115', '1', '3', 'licuibin@yunzhiclub.com', '0', '0'), 
('6', '孔瑞平', '115', '0', '4', 'kongruiping@yunzhiclub.com', '0', '0');
