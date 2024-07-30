<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Auth;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Help\Request;
use PHP94\Facade\Router;
use PHP94\Facade\Session;
use PHP94\Facade\Template;
use PHP94\Help\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * 登录后台，无需权限认证
 */
class Login extends Common
{
    public function get()
    {
        return Template::render('auth/login@php94/admin');
    }

    public function post(): ResponseInterface
    {
        $captcha = strtolower(Request::post('captcha', ''));
        if (!strlen($captcha) || $captcha != Session::get('admin_captcha')) {
            return Response::error('验证码无效！');
        }
        Session::delete('admin_captcha');

        if (!$account = Db::get('php94_admin_account', '*', [
            'name' => Request::post('name', ''),
        ])) {
            return Response::error('账户或密码不正确');
        }

        if (md5(Request::post('password', '') . ' love php94 forever!') != $account['password']) {
            return Response::error('账户或密码不正确');
        }

        Session::set('admin_id', $account['id']);

        return Response::success('登录成功', Router::build('/php94/admin/index'));
    }
}
