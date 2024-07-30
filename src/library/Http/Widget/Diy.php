<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Widget;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\App;
use PHP94\Facade\Config;
use PHP94\Facade\Logger;
use PHP94\Facade\Template;
use Throwable;

class Diy extends Common
{
    public function get()
    {
        $widgets = [];
        foreach (App::allActive() as $appname) {
            foreach (Config::get('admin.widgets@' . $appname, []) as $vo) {
                if (file_exists($vo['file'])) {
                    try {
                        $vo['content'] = Template::render($vo['file']);
                    } catch (Throwable $th) {
                        Logger::alert($th->getMessage(), $th->getTrace());
                        $vo['content'] = '<span style="color:red;">挂件解析错误！</span>';
                    }
                    $widgets[$vo['file']] = $vo;
                }
            }
        }
        return Template::render('widget/diy@php94/admin', [
            'widgets' => $widgets,
        ]);
    }
}
