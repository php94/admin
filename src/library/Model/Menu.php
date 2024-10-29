<?php

declare(strict_types=1);

namespace App\Php94\Admin\Model;

use PHP94\Db;
use PHP94\Event;
use PHP94\Router;
use PHP94\Session;

class Menu
{
    private $menus = [];

    public function __construct()
    {
        Event::dispatch($this);
    }

    public function addMenu(string $title, string $node, array $query = [], array $options = [])
    {
        $path = $this->buildPathFromNode($node);
        $paths = explode('/', $path);
        $appname = $paths[1] . '/' . $paths[2];
        $key = md5($path . '_' . serialize($query));
        $this->menus[$key] = [
            'key' => $key,
            'title' => $title,
            'node' => $node,
            'query' => $query,
            'options' => $options,
            'appname' => $appname,
            'url' => Router::build($path, $query),
        ];
    }

    public function getMenus(): array
    {
        return $this->menus;
    }

    public function getAuthMenus(): array
    {
        $menus = $this->menus;
        if (Session::get('admin_id') != 1) {
            $nodes = $this->getAuthNodes();
            foreach ($menus as $key => $value) {
                if (!in_array($value['node'], $nodes)) {
                    unset($menus[$key]);
                }
            }
        }
        return $menus;
    }

    private function getAuthNodes(): array
    {
        $role_ids = Db::select('php94_admin_account_role', 'role_id', [
            'account_id' => Session::get('admin_id'),
        ]);
        return Db::select('php94_admin_role_node', ['node'], [
            'role_id' => $role_ids ?: ['_'],
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
