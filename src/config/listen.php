<?php

use App\Php94\Admin\Http\Account\Index as AccountIndex;
use App\Php94\Admin\Http\App\Index as AppIndex;
use App\Php94\Admin\Http\Cache\Index as CacheIndex;
use App\Php94\Admin\Http\Role\Index as RoleIndex;

use App\Php94\Admin\Http\Common;
use App\Php94\Admin\Middleware\AuthMiddleware;
use App\Php94\Admin\Model\Menu;
use App\Php94\Admin\Model\Widget;
use PHP94\Handler;
use PHP94\Request;

return [
    Handler::class => function (
        Handler $handler
    ) {
        if (is_a(Request::attr('handler', ''), Common::class, true)) {
            $handler->pushMiddleware(AuthMiddleware::class);
        }
    },
    Menu::class => function (
        Menu $menu
    ) {
        $menu->addMenu('角色管理', RoleIndex::class);
        $menu->addMenu('账户管理', AccountIndex::class);
        $menu->addMenu('应用管理', AppIndex::class);
        $menu->addMenu('缓存管理', CacheIndex::class);
    },
    Widget::class => function (
        Widget $widget
    ) {
        $tpl = <<<'str'
<?php
$root = \Composer\InstalledVersions::getRootPackage();
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
str;
        $widget->addWidget('系统信息', $tpl);
    }
];
