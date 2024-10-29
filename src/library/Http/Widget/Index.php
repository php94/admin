<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Widget;

use App\Php94\Admin\Http\Common;
use App\Php94\Admin\Model\Widget;
use PHP94\Db;
use PHP94\Logger;
use PHP94\Session;
use PHP94\Template;
use Throwable;

class Index extends Common
{
    public function get(
        Widget $widget
    ) {
        if ($tmp = Db::get('php94_admin_info', 'value', [
            'account_id' => Session::get('admin_id'),
            'key' => 'php94_admin_widgets',
        ])) {
            $keys = unserialize($tmp);
        } else {
            $keys = [];
        }

        $all = $widget->getWidgets();

        $widgets = [];
        foreach ($keys as $key) {
            if (!is_string($key) || !isset($all[$key])) {
                $widgets[] = [
                    'key' => '',
                    'title' => '挂件失效，请移除!',
                    'content' => '',
                ];
            }
            $wid = $all[$key];
            try {
                $wid['content'] = Template::renderString($wid['tpl']);
            } catch (Throwable $th) {
                Logger::alert($th->getMessage(), $th->getTrace());
                $wid['content'] = '<span style="color:red;">挂件解析错误！</span>';
            }
            $widgets[] = $wid;
        }

        return Template::render('widget/index@php94/admin', [
            'widgets' => $widgets,
        ]);
    }
}
