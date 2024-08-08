<?php

declare (strict_types = 1);

namespace App\Php94\Admin\Http\Account;

use App\Php94\Admin\Http\Common;
use PHP94\Db;
use PHP94\Request;
use PHP94\Form\Field\Hidden;
use PHP94\Form\Field\Text;
use PHP94\Form\Form;
use PHP94\Response;

/**
 * 给账户重置密码
 */
class Password extends Common
{
    public function get()
    {
        $account = Db::get('php94_admin_account', '*', [
            'id' => Request::get('id'),
        ]);
        if ($account['id'] == 1) {
            return Response::error('不支持对超级管理员进行该操作~');
        }
        $form = new Form('给账户重置密码');
        $form->addItem(
            (new Hidden('id', $account['id'])),
            (new Text('账户', 'name', $account['name']))->setDisabled(),
            (new Text('密码', 'password'))->setRequired()
        );
        return $form;
    }

    public function post()
    {
        $account = Db::get('php94_admin_account', '*', [
            'id' => Request::post('id', 0, ['intval']),
        ]);
        if ($account['id'] == 1) {
            return Response::error('不支持对超级管理员进行该操作~');
        }

        Db::update('php94_admin_account', [
            'password' => md5(Request::post('password', '') . ' love php94 forever!'),
        ], [
            'id' => $account['id'],
        ]);

        return Response::success('操作成功！');
    }
}
