<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Account;

use App\Php94\Admin\Http\Common;
use PHP94\Db;
use PHP94\Request;
use PHP94\Template;

/**
 * 查看账户
 */
class Index extends Common
{
    public function get()
    {

        $data = [];
        $where = [];
        $where['ORDER'] = [
            'id' => 'ASC',
        ];

        $disabled = Request::get('disabled');
        if (is_string($disabled) && strlen($disabled)) {
            $where['disabled'] = Request::get('disabled');
        }

        $data['total'] = Db::count('php94_admin_account', $where);
        $data['page'] = Request::get('page', 1) ?: 1;
        $data['size'] = Request::get('size', 20) ?: 20;
        $data['pages'] = ceil($data['total'] / $data['size']) ?: 1;
        $where['LIMIT'] = [($data['page'] - 1) * $data['size'], $data['size']];
        $datas = Db::select('php94_admin_account', '*', $where);

        $roles = [];
        foreach (Db::select('php94_admin_role', '*') as $value) {
            $roles[$value['id']] = $value;
        }

        foreach ($datas as &$value) {
            $value['roles'] = [];
            foreach (Db::select('php94_admin_account_role', 'role_id', [
                'account_id' => $value['id'],
            ]) as $role_id) {
                if (isset($roles[$role_id])) {
                    $value['roles'][] = $roles[$role_id];
                }
            }
        }
        unset($value);
        $data['datas'] = $datas;

        return Template::render('account/index@php94/admin', $data);
    }
}
