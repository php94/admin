<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\App;

use App\Php94\Admin\Http\Common;
use Composer\Autoload\ClassLoader;
use PHP94\App;
use PHP94\Framework;
use PHP94\Request;
use PHP94\Response;
use ReflectionClass;
use Throwable;

class Install extends Common
{
    public function get()
    {
        $appname = Request::get('appname');
        if (App::isCore($appname)) {
            return Response::error('核心应用无需安装');
        }
        if (App::isInstalled($appname)) {
            return Response::error('已经安装，若要重装请先卸载！');
        }

        try {
            Framework::execute(function () use ($appname) {
                $file = App::getDir($appname) . '/src/package/install.php';
                if (file_exists($file)) {
                    require $file;
                }
            });
            $root = dirname((new ReflectionClass(ClassLoader::class))->getFileName(), 3);
            $installed_lock = $root . '/config/' . $appname . '/installed.lock';
            if (!is_dir(dirname($installed_lock))) {
                mkdir(dirname($installed_lock), 0755, true);
            }
            file_put_contents($installed_lock, date(DATE_ATOM));

            return Response::redirect($_SERVER['HTTP_REFERER'] ?? '');
        } catch (Throwable $th) {
            return Response::success('安装错误：' . $th->getMessage());
        }
    }
}
