<?php

declare (strict_types = 1);

namespace App\Php94\Admin\Http\Menu;

use App\Php94\Admin\Http\Common;
use PHP94\Db;
use PHP94\Request;
use PHP94\Router;
use PHP94\Session;
use PHP94\Response;

/**
 * 收藏菜单
 */
class Stick extends Common
{
    public function get(
    ) {
        $sticks = [];
        if ($tmp = Db::get('php94_admin_info', 'value', [
            'key' => 'php94_admin_menu',
            'account_id' => Session::get('admin_id'),
        ])) {
            $sticks = unserialize($tmp);
        }

        $menu = [
            'url' => Request::get('url'),
            'title' => Request::get('title'),
        ];
        $key = array_search($menu, $sticks);
        if ($key !== false) {
            unset($sticks[$key]);
        } else {
            $sticks[] = $menu;
        }

        if (Db::get('php94_admin_info', '*', [
            'account_id' => Session::get('admin_id'),
            'key' => 'php94_admin_menu',
        ])) {
            Db::update('php94_admin_info', [
                'value' => serialize($sticks),
            ], [
                'account_id' => Session::get('admin_id'),
                'key' => 'php94_admin_menu',
            ]);
        } else {
            Db::insert('php94_admin_info', [
                'account_id' => Session::get('admin_id'),
                'key' => 'php94_admin_menu',
                'value' => serialize($sticks),
            ]);
        }

        return Response::redirect(Router::build('/php94/admin/menu/index'));
    }
}
