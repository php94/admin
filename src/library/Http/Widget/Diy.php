<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Widget;

use App\Php94\Admin\Http\Common;
use App\Php94\Admin\Model\Widget;
use PHP94\Logger;
use PHP94\Template;
use Throwable;

class Diy extends Common
{
    public function get(
        Widget $widget
    ) {
        $widgets = [];
        foreach ($widget->getWidgets() as $vo) {
            try {
                $vo['content'] = Template::renderString($vo['tpl']);
            } catch (Throwable $th) {
                Logger::alert($th->getMessage(), $th->getTrace());
                $vo['content'] = '<span style="color:red;">挂件解析错误！</span>';
            }
            $widgets[$vo['key']] = $vo;
        }
        return Template::render('widget/diy@php94/admin', [
            'widgets' => $widgets,
        ]);
    }
}
