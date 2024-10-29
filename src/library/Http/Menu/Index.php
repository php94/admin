<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Menu;

use App\Php94\Admin\Http\Common;
use App\Php94\Admin\Model\Menu;
use PHP94\App;
use PHP94\Db;
use PHP94\Session;
use PHP94\Template;

/**
 * 功能地图
 */
class Index extends Common
{
    public function get(
        Menu $menuModel
    ) {
        $menus = $menuModel->getAuthMenus();

        $sticks = [];
        if ($tmp = Db::get('php94_admin_info', 'value', [
            'key' => 'php94_admin_menu',
            'account_id' => Session::get('admin_id'),
        ])) {
            $sticks = unserialize($tmp);
        }

        $groups = [];
        foreach (App::all() as $appname) {
            $groups[$appname] = [
                'appname' => $appname,
                'title' => $appname,
                'menus' => [],
            ];
            $cfile = App::getDir($appname) . '/composer.json';
            if (file_exists($cfile)) {
                $content = file_get_contents($cfile);
                if (strlen($content)) {
                    $x = json_decode($content, true);
                    if (is_array($x) && isset($x['title'])) {
                        $groups[$appname]['title'] = $x['title'];
                    }
                }
            }
            $tmpm = [];
            foreach ($menus as $vo) {
                if ($vo['appname'] == $appname) {
                    $tmpm[] = $vo;
                }
            }
            $groups[$appname]['menus'] = $tmpm;
        }

        return Template::render('menu/index@php94/admin', [
            'groups' => $groups,
            'sticks' => $sticks,
            'menus' => $menus,
        ]);
    }
}
