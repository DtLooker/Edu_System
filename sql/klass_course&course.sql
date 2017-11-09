
-- ----------------------------
--  Table structure for `edu_course`
-- ----------------------------
DROP TABLE IF EXISTS `edu_course`;
CREATE TABLE `edu_course`(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(40) NOT NULL DEFAULT '',
    `create_time` int(11) NOT NULL DEFAULT '0',
    `update_time` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
)ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
-- ----------------------------
--  Records of `edu_course`
-- ----------------------------
INSERT INTO `edu_course` VALUES
('1', 'thinkphp5入门实例', '0', '0'),
('2', 'angularjs入门实例', '0', '0');


-- ----------------------------
--  Table structure for `edu_klass_course`
-- ----------------------------
DROP TABLE IF EXISTS `edu_klass_course`;
CREATE TABLE `edu_klass_course`(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `klass_id` int(11) unsigned NOT NULL,
    `course_id` int(11) unsigned NOT NULL,
    `create_time` int(11) unsigned NOT NULL,
    `update_time` int(11) unsigned NOT NULL,
    PRIMARY KEY (`id`)
)ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `edu_klass_course`
-- ----------------------------
INSERT INTO `edu_klass_course` VALUES
('2', '1', '2', '0', '0'),
('4', '2', '2', '0', '0'),
('6', '4', '2', '0', '0'),
('8', '6', '2', '0', '0'),
('9', '1', '3', '0', '0'),
('10', '2', '3', '0', '0'),
('11', '1', '4', '0', '0'),
('12', '2', '4', '0', '0');
