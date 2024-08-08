<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Account;

use App\Php94\Admin\Http\Common;
use PHP94\Db;
use PHP94\Request;
use PHP94\Form\Field\Text;
use PHP94\Form\Form;
use PHP94\Response;

/**
 * 添加账户
 */
class Create extends Common
{
    public function get()
    {
        $form = new Form('添加账户');
        $form->addItem(
            (new Text('账户', 'name'))->setRequired(),
            (new Text('密码', 'password'))->setRequired()
        );
        return $form;
    }

    public function post()
    {
        if (Db::get('php94_admin_account', '*', [
            'name' => Request::post('name'),
        ])) {
            return Response::error('账户重复！');
        }
        Db::insert('php94_admin_account', [
            'name' => Request::post('name'),
            'password' => md5(Request::post('password', '') . ' love php94 forever!'),
            'disabled' => 0,
        ]);
        return Response::success('操作成功！');
    }
}
