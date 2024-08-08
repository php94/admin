<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Tool;

use App\Php94\Admin\Http\Common;
use Gregwar\Captcha\CaptchaBuilder;
use PHP94\Factory;
use PHP94\Session;
use Psr\Http\Message\ResponseInterface;

/**
 * 登录验证码，无需权限认证
 */
class Captcha extends Common
{
    public function get(
        CaptchaBuilder $builder
    ): ResponseInterface {
        $response = Factory::createResponse();
        Session::set('admin_captcha', strtolower($builder->getPhrase()));
        $response->getBody()->write($builder->build()->get());
        return $response->withHeader('Content-Type', 'image/jpeg');
    }
}
