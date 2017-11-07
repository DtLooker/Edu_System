
-- ----------------------------
--  Table structure for `edu_klass`
-- ----------------------------
DROP TABLE IF EXISTS `edu_klass`;
CREATE TABLE `edu_klass` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(40) NOT NULL DEFAULT '' COMMENT '名称',
    `teacher_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '教师ID',
    `create_time` int(11) NOT NULL DEFAULT '0',
    `update_time` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
)ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `edu_klass`
-- ----------------------------
INSERT INTO `edu_klass` VALUES
('1', '实验1班', '1', '0', '0'),
('2', '实验2班', '2', '0', '0'),
('3', '实验3班', '1', '0', '0'), 
('4', '实验4班', '2', '0', '0');
