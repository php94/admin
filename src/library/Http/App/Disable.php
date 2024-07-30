<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\App;

use App\Php94\Admin\Http\Common;
use Composer\Autoload\ClassLoader;
use PHP94\Facade\App;
use PHP94\Help\Request;
use PHP94\Help\Response;
use ReflectionClass;

class Disable extends Common
{
    public function get()
    {
        $appname = Request::get('appname');
        if ($appname == 'php94/admin') {
            return Response::error('该应用不支持此操作');
        }
        if (!App::isInstalled($appname)) {
            return Response::error('未安装！');
        }
        $root = dirname((new ReflectionClass(ClassLoader::class))->getFileName(), 3);
        $disabled_file = $root . '/config/' . $appname . '/disabled.lock';
        if (Request::get('disabled')) {
            if (!file_exists($disabled_file)) {
                if (!is_dir(dirname($disabled_file))) {
                    mkdir(dirname($disabled_file), 0755, true);
                }
                touch($disabled_file);
            }
        } else {
            if (file_exists($disabled_file)) {
                unlink($disabled_file);
            }
        }
        return Response::redirect($_SERVER['HTTP_REFERER'] ?? '');
    }
}
