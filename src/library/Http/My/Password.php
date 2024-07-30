<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\My;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Help\Request;
use PHP94\Facade\Session;
use PHP94\Form\Field\Password as FieldPassword;
use PHP94\Form\Form;
use PHP94\Help\Response;

/**
 * 重置自己的密码
 */
class Password extends Common
{
    public function get()
    {
        $form = new Form('修改密码');
        $form->addItem(
            (new FieldPassword('原密码', 'old'))->setRequired(),
            (new FieldPassword('新密码', 'new1'))->setHelp('最少6位')->setRequired(),
            (new FieldPassword('重复新密码', 'new2'))->setHelp('再次输入新密码，防止输错')->setRequired()
        );
        return $form;
    }

    public function post()
    {
        $account = Db::get('php94_admin_account', '*', [
            'id' => Session::get('admin_id'),
        ]);
        if ($account['password'] != md5(Request::post('old', '') . ' love php94 forever!')) {
            return Response::error('原密码不正确~');
        }
        if (Request::post('new1', '1') != Request::post('new2', '2')) {
            return Response::error('两次密码输入不一致~');
        }
        Db::update('php94_admin_account', [
            'password' => md5(Request::post('new1', '1') . ' love php94 forever!')
        ], [
            'id' => Session::get('admin_id'),
        ]);
        return Response::success('修改成功！');
    }
}
