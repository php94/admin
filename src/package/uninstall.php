<?php

use PHP94\Package;

$sql = <<<'str'
DROP TABLE IF EXISTS `prefix_php94_admin_role`;
DROP TABLE IF EXISTS `prefix_php94_admin_account`;
DROP TABLE IF EXISTS `prefix_php94_admin_account_role`;
DROP TABLE IF EXISTS `prefix_php94_admin_info`;
DROP TABLE IF EXISTS `prefix_php94_admin_role_node`;
str;

Package::execSql($sql);
