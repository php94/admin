<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Account;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Help\Request;
use PHP94\Form\Field\Hidden;
use PHP94\Form\Field\Radio;
use PHP94\Form\Field\Radios;
use PHP94\Form\Field\Text;
use PHP94\Form\Form;
use PHP94\Help\Response;

/**
 * 设置账户状态
 */
class Disable extends Common
{
    public function get()
    {
        $account = Db::get('php94_admin_account', '*', [
            'id' => Request::get('id'),
        ]);
        if ($account['id'] == 1) {
            return Response::error('不支持对超级管理员进行该操作~');
        }
        $form = new Form('设置账户状态');
        $form->addItem(
            (new Hidden('id', $account['id'])),
            (new Text('账户', 'name', $account['name']))->setDisabled(),
            (new Radios('状态', 'disabled', $account['disabled']))->addRadio(
                new Radio('正常', 1),
                new Radio('禁用', 2),
            )
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

        $update = array_intersect_key(Request::post(), [
            'disabled' => '',
        ]);
        Db::update('php94_admin_account', $update, [
            'id' => $account['id'],
        ]);

        return Response::success('操作成功！');
    }
}
