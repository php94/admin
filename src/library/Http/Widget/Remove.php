<?php

declare (strict_types = 1);

namespace App\Php94\Admin\Http\Widget;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Help\Request;
use PHP94\Facade\Router;
use PHP94\Facade\Session;
use PHP94\Help\Response;

class Remove extends Common
{
    public function get()
    {
        if ($tmp = Db::get('php94_admin_info', 'value', [
            'account_id' => Session::get('admin_id'),
            'key' => 'php94_admin_widgets',
        ])) {
            $files = unserialize($tmp);
        } else {
            $files = [];
        }

        $index = Request::get('index');
        unset($files[$index]);
        $files = array_values($files);

        if (Db::get('php94_admin_info', '*', [
            'account_id' => Session::get('admin_id'),
            'key' => 'php94_admin_widgets',
        ])) {
            Db::update('php94_admin_info', [
                'value' => serialize($files),
            ], [
                'account_id' => Session::get('admin_id'),
                'key' => 'php94_admin_widgets',
            ]);
        } else {
            Db::insert('php94_admin_info', [
                'account_id' => Session::get('admin_id'),
                'key' => 'php94_admin_widgets',
                'value' => serialize($files),
            ]);
        }

        return Response::redirect(Router::build('/php94/admin/widget/index', ['diy' => 1]));
    }
}
