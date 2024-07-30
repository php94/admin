<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Account;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Help\Request;
use PHP94\Form\Field\Checkbox;
use PHP94\Form\Field\Checkboxs;
use PHP94\Form\Field\Hidden;
use PHP94\Form\Field\Text;
use PHP94\Form\Form;
use PHP94\Help\Response;

/**
 * 角色设置
 */
class Role extends Common
{
    public function get()
    {
        $account = Db::get('php94_admin_account', '*', [
            'id' => Request::get('id'),
        ]);

        $role_ids = Db::select('php94_admin_account_role', 'role_id', [
            'account_id' => Request::get('id'),
        ]);

        $checkboxs = new Checkboxs('角色', 'role_ids', $role_ids);
        foreach (Db::select('php94_admin_role', '*') as $vo) {
            $checkboxs->addCheckbox(
                (new Checkbox($vo['title'], $vo['id']))
            );
        }

        $form = new Form('角色设置');
        $form->addItem(
            (new Hidden('account_id', $account['id'])),
            (new Text('账户', 'name', $account['name']))->setDisabled(),
            $checkboxs
        );
        return $form;
    }

    public function post()
    {
        $account = Db::get('php94_admin_account', '*', [
            'id' => Request::post('account_id'),
        ]);

        Db::delete('php94_admin_account_role', [
            'account_id' => $account['id'],
        ]);

        $res = [];
        foreach (Request::post('role_ids', []) as $vo) {
            $res[] = [
                'account_id' => $account['id'],
                'role_id' => $vo,
            ];
        }
        Db::insert('php94_admin_account_role', $res);

        return Response::success('操作成功！');
    }
}
