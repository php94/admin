<?php

use PHP94\Package;

$sql = <<<'str'
DROP TABLE IF EXISTS `prefix_php94_admin_role`;
CREATE TABLE `prefix_php94_admin_role` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `title` varchar(50) NOT NULL DEFAULT '' COMMENT '角色名称',
    `description` varchar(255) NOT NULL DEFAULT '' COMMENT '角色备注',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='角色表';
DROP TABLE IF EXISTS `prefix_php94_admin_account`;
CREATE TABLE `prefix_php94_admin_account` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL DEFAULT '' COMMENT '账户',
    `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
    `disabled` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0启用 1禁用',
    PRIMARY KEY (`id`) USING BTREE,
    KEY `name` (`name`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='账户表';
INSERT INTO `prefix_php94_admin_account` (`id`, `name`, `password`, `disabled`) VALUES
(1, 'root', 'd213aba72dff561526008b43d23b86ce', 0);
DROP TABLE IF EXISTS `prefix_php94_admin_info`;
CREATE TABLE `prefix_php94_admin_info` (
    `account_id` int(10) unsigned NOT NULL,
    `key` varchar(255) NOT NULL DEFAULT '' COMMENT '键',
    `value` text COMMENT '值',
    KEY `account_id` (`account_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='账户信息表';
DROP TABLE IF EXISTS `prefix_php94_admin_account_role`;
CREATE TABLE `prefix_php94_admin_account_role` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `account_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '账户id',
    `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
    PRIMARY KEY (`id`) USING BTREE,
    KEY `account_id` (`account_id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='账户角色表';
DROP TABLE IF EXISTS `prefix_php94_admin_role_node`;
CREATE TABLE `prefix_php94_admin_role_node` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
    `node` varchar(255) NOT NULL DEFAULT '' COMMENT '节点',
    `method` varchar(255) NOT NULL DEFAULT '' COMMENT '方法',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='角色权限表';
str;

Package::execSql($sql);
