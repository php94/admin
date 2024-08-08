<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Widget;

use App\Php94\Admin\Http\Common;
use PHP94\App;
use PHP94\Config;
use PHP94\Db;
use PHP94\Logger;
use PHP94\Session;
use PHP94\Template;
use Throwable;

class Index extends Common
{
    public function get()
    {
        $all = [];
        foreach (App::allActive() as $appname) {
            foreach (Config::get('admin.widgets@' . $appname, []) as $vo) {
                $all[$vo['file']] = $vo;
            }
        }

        if ($tmp = Db::get('php94_admin_info', 'value', [
            'account_id' => Session::get('admin_id'),
            'key' => 'php94_admin_widgets',
        ])) {
            $files = unserialize($tmp);
        } else {
            $files = [];
        }

        $widgets = [];
        foreach ($files as $file) {
            if (!isset($all[$file]) || !file_exists($file)) {
                $widgets[] = [
                    'file' => $file,
                    'title' => '',
                    'content' => '<span style="color:red;">该挂件失效，请移除</span>',
                ];
            } else {
                try {
                    $content = Template::render($file);
                } catch (Throwable $th) {
                    Logger::alert($th->getMessage(), $th->getTrace());
                    $content = '<span style="color:red;">挂件解析错误！</span>';
                }
                $widgets[] = [
                    'file' => $file,
                    'title' => $all[$file]['title'] ?? '',
                    'content' => $content,
                ];
            }
        }

        return Template::render('widget/index@php94/admin', [
            'widgets' => $widgets,
        ]);
    }
}
