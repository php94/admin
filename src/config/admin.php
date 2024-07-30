<?php

use App\Php94\Admin\Http\Account\Index as AccountIndex;
use App\Php94\Admin\Http\App\Index as AppIndex;
use App\Php94\Admin\Http\Cache\Index as CacheIndex;
use App\Php94\Admin\Http\Role\Index as RoleIndex;

return [
    'menus' => [[
        'title' => '角色管理',
        'node' => RoleIndex::class,
    ], [
        'title' => '账户管理',
        'node' => AccountIndex::class,
    ], [
        'title' => '应用管理',
        'node' => AppIndex::class,
    ], [
        'title' => '缓存管理',
        'node' => CacheIndex::class,
    ]],
    'widgets' => [[
        'file' => __DIR__ . '/../widget/system.php',
        'title' => '系统信息',
    ]],
];
