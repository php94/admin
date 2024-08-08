<?php

declare (strict_types = 1);

namespace App\Php94\Admin\Http\Role;

use App\Php94\Admin\Http\Common;
use PHP94\Db;
use PHP94\Request;
use PHP94\Response;

/**
 * 删除角色
 */
class Delete extends Common
{
    public function get(
    ) {
        Db::delete('php94_admin_role', [
            'id' => Request::get('id'),
        ]);
        Db::delete('php94_admin_account_role', [
            'role_id' => Request::get('id'),
        ]);
        Db::delete('php94_admin_role_node', [
            'role_id' => Request::get('id'),
        ]);
        return Response::success('操作成功！');
    }
}
