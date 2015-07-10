-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: 10.101.26.49
-- 生成日期: 2015 年 07 月 10 日 09:09
-- 服务器版本: 5.6.23
-- PHP 版本: 5.6.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `itoobao`
--

-- --------------------------------------------------------

--
-- 表的结构 `i_auth_assignment`
--

CREATE TABLE IF NOT EXISTS `i_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `i_auth_item`
--

CREATE TABLE IF NOT EXISTS `i_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '角色或权限名称',
  `type` int(11) NOT NULL COMMENT '类型:1角色,2权限',
  `description` text COLLATE utf8_unicode_ci COMMENT '描述',
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '规则名称:auth_rule表关联',
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `i_auth_item_child`
--

CREATE TABLE IF NOT EXISTS `i_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `i_auth_rule`
--

CREATE TABLE IF NOT EXISTS `i_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `i_auth_user`
--

CREATE TABLE IF NOT EXISTS `i_auth_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(60) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态:-1删除,1正常',
  `is_super` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否为超级管理员:0否，1是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='后台用户表' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `i_auth_user`
--

INSERT INTO `i_auth_user` (`id`, `user_name`, `password`, `status`, `is_super`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 0),
(2, 'asdf', 'e10adc3949ba59abbe56e057f20f883e', -1, 0),
(3, 'd', '8277e0910d750195b448797616e091ad', 1, 0),
(4, 'dd', '1aabac6d068eef6a7bad3fdf50a05cc8', 1, 0),
(5, 'ddd', '8277e0910d750195b448797616e091ad', -1, 0),
(6, 'dda', '8277e0910d750195b448797616e091ad', 1, 0);

--
-- 限制导出的表
--

--
-- 限制表 `i_auth_assignment`
--
ALTER TABLE `i_auth_assignment`
  ADD CONSTRAINT `i_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `i_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `i_auth_item`
--
ALTER TABLE `i_auth_item`
  ADD CONSTRAINT `i_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `i_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `i_auth_item_child`
--
ALTER TABLE `i_auth_item_child`
  ADD CONSTRAINT `i_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `i_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `i_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `i_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
