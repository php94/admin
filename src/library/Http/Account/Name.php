<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Account;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Help\Request;
use PHP94\Form\Field\Hidden;
use PHP94\Form\Field\Text;
use PHP94\Form\Form;
use PHP94\Help\Response;

/**
 * 修改账户名
 */
class Name extends Common
{
    public function get()
    {
        $account = Db::get('php94_admin_account', '*', [
            'id' => Request::get('id'),
        ]);
        if ($account['id'] == 1) {
            return Response::error('不支持对超级管理员进行该操作~');
        }
        $form = new Form('修改账户名');
        $form->addItem(
            (new Hidden('id', $account['id'])),
            (new Text('账户', 'name', $account['name']))
        );
        return $form;
    }

    public function post()
    {
        $account = Db::get('php94_admin_account', '*', [
            'id' => Request::post('id'),
        ]);
        if ($account['id'] == 1) {
            return Response::error('不支持对超级管理员进行该操作~');
        }

        if (Db::get('php94_admin_account', '*', [
            'id[!]' => Request::post('id'),
            'name' => Request::post('name'),
        ])) {
            return Response::error('账户名重复~');
        }

        Db::update('php94_admin_account', [
            'name' => Request::post('name'),
        ], [
            'id' => $account['id'],
        ]);

        return Response::success('操作成功！');
    }
}
