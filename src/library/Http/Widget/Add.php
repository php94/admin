<?php

declare (strict_types = 1);

namespace App\Php94\Admin\Http\Widget;

use App\Php94\Admin\Http\Common;
use PHP94\Db;
use PHP94\Request;
use PHP94\Router;
use PHP94\Session;
use PHP94\Response;

class Add extends Common
{
    public function get()
    {
        $widgets = [];
        if ($tmp = Db::get('php94_admin_info', 'value', [
            'key' => 'php94_admin_widgets',
            'account_id' => Session::get('admin_id'),
        ])) {
            $widgets = unserialize($tmp);
        }
        $widgets[] = Request::get('file');

        if (Db::get('php94_admin_info', '*', [
            'account_id' => Session::get('admin_id'),
            'key' => 'php94_admin_widgets',
        ])) {
            Db::update('php94_admin_info', [
                'value' => serialize($widgets),
            ], [
                'account_id' => Session::get('admin_id'),
                'key' => 'php94_admin_widgets',
            ]);
        } else {
            Db::insert('php94_admin_info', [
                'account_id' => Session::get('admin_id'),
                'key' => 'php94_admin_widgets',
                'value' => serialize($widgets),
            ]);
        }
        return Response::redirect(Router::build('/php94/admin/widget/index', ['diy' => 1]));
    }
}
