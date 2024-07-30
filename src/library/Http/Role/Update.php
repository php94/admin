<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Role;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Help\Request;
use PHP94\Form\Field\Hidden;
use PHP94\Form\Field\Text;
use PHP94\Form\Field\Textarea;
use PHP94\Form\Form;
use PHP94\Help\Response;

/**
 * 编辑角色信息
 */
class Update extends Common
{
    public function get()
    {
        $role = Db::get('php94_admin_role', '*', [
            'id' => Request::get('id'),
        ]);
        $form = new Form('编辑角色');
        $form->addItem(
            (new Hidden('id', $role['id'])),
            (new Text('角色名称', 'title', $role['title'])),
            (new Textarea('角色备注', 'description', $role['description'])),
        );
        return $form;
    }

    public function post()
    {
        $role = Db::get('php94_admin_role', '*', [
            'id' => Request::post('id'),
        ]);

        Db::update('php94_admin_role', [
            'title' => Request::post('title'),
            'description' => Request::post('description'),
        ], [
            'id' => $role['id'],
        ]);

        return Response::success('操作成功！');
    }
}
