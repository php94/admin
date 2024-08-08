<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Role;

use App\Php94\Admin\Http\Common;
use PHP94\Db;
use PHP94\Request;
use PHP94\Form\Field\Text;
use PHP94\Form\Field\Textarea;
use PHP94\Form\Form;
use PHP94\Response;

/**
 * 创建角色
 */
class Create extends Common
{
    public function get()
    {
        $form = new Form('添加角色');
        $form->addItem(
            (new Text('角色名称', 'title')),
            (new Textarea('角色备注', 'description')),
        );
        return $form;
    }

    public function post()
    {
        Db::insert('php94_admin_role', [
            'title' => Request::post('title'),
            'description' => Request::post('description'),
        ]);
        return Response::success('操作成功！');
    }
}
