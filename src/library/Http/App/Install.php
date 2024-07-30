<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\App;

use App\Php94\Admin\Http\Common;
use Composer\Autoload\ClassLoader;
use PHP94\Facade\App;
use PHP94\Facade\Framework;
use PHP94\Help\Request;
use PHP94\Help\Response;
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
            $fn = $this->getFn(App::getDir($appname) . '/src/config/package.php');
            if ($fn) {
                Framework::execute($fn);
            }
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

    private function getFn($file): ?callable
    {
        if (file_exists($file)) {
            $x = include $file;
            if (isset($x['install'])) {
                return $x['install'];
            }
        }
        return null;
    }
}
