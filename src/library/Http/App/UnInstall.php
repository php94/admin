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

class UnInstall extends Common
{
    public function get()
    {
        $appname = Request::get('appname');
        if (App::isCore($appname)) {
            return Response::error('核心应用不能卸载');
        }
        if (!App::isInstalled($appname)) {
            return Response::error('未安装不能卸载');
        }
        if (!App::isDisabled($appname)) {
            return Response::error('请先停用！');
        }

        try {
            $fn = $this->getFn(App::getDir($appname) . '/src/config/package.php');
            if ($fn) {
                Framework::execute($fn);
            }
            $root = dirname((new ReflectionClass(ClassLoader::class))->getFileName(), 3);
            $installed_lock = $root . '/config/' . $appname . '/installed.lock';
            unlink($installed_lock);
            return Response::redirect($_SERVER['HTTP_REFERER'] ?? '');
        } catch (Throwable $th) {
            return Response::success('卸载错误：' . $th->getMessage());
        }
    }

    private function getFn($file): ?callable
    {
        if (file_exists($file)) {
            $x = include $file;
            if (isset($x['unInstall'])) {
                return $x['unInstall'];
            }
        }
        return null;
    }
}
