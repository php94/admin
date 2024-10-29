<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http;

use App\Php94\Admin\Model\Menu;
use PHP94\Db;
use PHP94\Session;
use PHP94\Template;

/**
 * 后台主页
 */
class Index extends Common
{
    public function get(
        Menu $menu
    ) {
        if ($tmp = Db::get('php94_admin_info', 'value', [
            'account_id' => Session::get('admin_id'),
            'key' => 'php94_admin_menu',
        ])) {
            $sticks = unserialize($tmp);
        } else {
            $sticks = [];
        }
        return Template::render('index@php94/admin', [
            'account' => Db::get('php94_admin_account', '*', [
                'id' => Session::get('admin_id'),
            ]),
            'sticks' =>  $sticks,
            'menus' =>  $menu->getAuthMenus(),
        ]);
    }
}
