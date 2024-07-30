<?php

declare (strict_types = 1);

namespace App\Php94\Admin\Http\Role;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Facade\Template;

/**
 * 角色管理
 */
class Index extends Common
{
    public function get()
    {
        return Template::render('role/index@php94/admin', [
            'roles' => Db::select('php94_admin_role', '*', [
                'ORDER' => [
                    'id' => 'ASC',
                ],
            ]),
        ]);
    }
}
