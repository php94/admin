<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Auth;

use App\Php94\Admin\Http\Common;
use PHP94\Router;
use PHP94\Session;
use PHP94\Response;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * 退出后台
 */
class Logout extends Common
{
    public function get(): ResponseInterface
    {
        try {
            Session::delete('admin_id');
            return Response::success('退出成功', Router::build('/php94/admin/index'));
        } catch (Throwable $th) {
            return Response::error($th->getMessage());
        }
    }
}
