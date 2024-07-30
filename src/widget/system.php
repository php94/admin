<?php

use Composer\InstalledVersions;

$root = InstalledVersions::getRootPackage();
$infos = [[
    'title' => '软件版本',
    'body' => $root['name'] . ' ' . $root['pretty_version'],
], [
    'title' => 'PHP版本',
    'body' => phpversion(),
], [
    'title' => '服务器引擎',
    'body' => $_SERVER['SERVER_SOFTWARE'],
], [
    'title' => '文件上传限制',
    'body' => get_cfg_var('upload_max_filesize'),
], [
    'title' => '操作系统',
    'body' => php_uname(),
]];
?>
<div>
    {foreach $infos as $vo}
    <div>
        <div>{$vo.title}</div>
        <div><code>{echo strip_tags($vo['body'], '<a><span>')}</code></div>
    </div>
    {/foreach}
</div>
