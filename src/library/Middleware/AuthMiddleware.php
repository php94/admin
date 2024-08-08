<?php

declare(strict_types=1);

namespace App\Php94\Admin\Middleware;

use App\Php94\Admin\Http\Auth\Login;
use App\Php94\Admin\Http\Tool\Captcha;
use App\Php94\Admin\Http\Tool\File;
use PHP94\Db;
use PHP94\Factory;
use PHP94\Router;
use PHP94\Session;
use PHP94\Request;
use PHP94\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        if (!Session::has('admin_auth')) {
            return Factory::createResponse(404);
        }

        if (!in_array(Request::attr('handler'), [Captcha::class, Login::class, File::class])) {
            if (!Session::has('admin_id')) {
                return Response::error('请登录', Router::build('/php94/admin/auth/login'));
            }
            if (!Session::get('admin_id') == 1) {
                if (!$role_ids = Db::get('php94_admin_account_role', 'role_id', [
                    'account_id' => Session::get('admin_id'),
                ])) {
                    return Response::error('无权限');
                }
                if (!Db::get('php94_admin_role_node', '*', [
                    'role_id' => $role_ids,
                    'node' => Request::attr('handler'),
                    'method' => $_SERVER['REQUEST_METHOD'] ?? '',
                ])) {
                    return Response::error('无权限');
                }
            }
        }

        return $handler->handle($request);
    }
}
