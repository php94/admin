<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Menu;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\App;
use PHP94\Facade\Config;
use PHP94\Facade\Db;
use PHP94\Facade\Router;
use PHP94\Facade\Session;
use PHP94\Facade\Template;

/**
 * 功能地图
 */
class Index extends Common
{
    public function get()
    {
        $sticks = [];
        if ($tmp = Db::get('php94_admin_info', 'value', [
            'key' => 'php94_admin_menu',
            'account_id' => Session::get('admin_id'),
        ])) {
            $sticks = unserialize($tmp);
        }

        $groups = [];
        $menus = [];
        foreach (App::allActive() as $appname) {
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
            $menus = [];
            foreach (Config::get('admin.menus@' . $appname, []) as $vo) {
                $vo['url'] = Router::build($this->buildPathFromNode($vo['node'] ?? ''), $vo['query'] ?? []);
                $vo['stick'] = array_search([
                    'url' => $vo['url'],
                    'title' => $vo['title'],
                ], $sticks) !== false;
                $menus[] = $vo;
            }
            $groups[$appname]['menus'] = $menus;
        }

        return Template::render('menu/index@php94/admin', [
            'groups' => $groups,
            'sticks' => $sticks,
        ]);
    }

    private function buildPathFromNode(string $node): string
    {
        $paths = [];
        foreach (explode('\\', $node) as $vo) {
            $paths[] = strtolower(preg_replace('/([A-Z])/', "-$1", lcfirst($vo)));
        }
        unset($paths[0]);
        unset($paths[3]);
        return '/' . implode('/', $paths);
    }
}
