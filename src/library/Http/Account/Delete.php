<?php

declare (strict_types = 1);

namespace App\Php94\Admin\Http\Account;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Help\Request;
use PHP94\Help\Response;

/**
 * 删除账户
 */
class Delete extends Common
{
    public function get()
    {
        if (Request::get('id') == '1') {
            return Response::error('超级管理员不允许删除！');
        }
        Db::delete('php94_admin_account', [
            'id' => Request::get('id'),
        ]);
        Db::delete('php94_admin_account_role', [
            'account_id' => Request::get('id'),
        ]);
        return Response::success('操作成功！');
    }
}
