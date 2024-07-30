<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Tool;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Factory;
use PHP94\Help\Request;
use Psr\Http\Message\ResponseInterface;

class File extends Common
{
    public function get(): ResponseInterface
    {
        switch (Request::get('file')) {
            case 'jquery':
                $response = Factory::createResponse(200)
                    ->withHeader('Content-Type', 'application/javascript')
                    ->withHeader('Pragma', 'public')
                    ->withHeader('Cache-Control', 'max-age=3600')
                    ->withHeader('Expires', gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
                $response->getBody()->write(file_get_contents(__DIR__ . '/../../../static/jquery/jquery.min.js'));
                return $response;
                break;
            case 'bsjs':
                $response = Factory::createResponse(200)
                    ->withHeader('Content-Type', 'application/javascript')
                    ->withHeader('Pragma', 'public')
                    ->withHeader('Cache-Control', 'max-age=3600')
                    ->withHeader('Expires', gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
                $response->getBody()->write(file_get_contents(__DIR__ . '/../../../static/bootstrap/js/bootstrap.bundle.min.js'));
                return $response;
                break;
            case 'bscss':
                $response = Factory::createResponse(200)
                    ->withHeader('Content-Type', 'text/css')
                    ->withHeader('Pragma', 'public')
                    ->withHeader('Cache-Control', 'max-age=3600')
                    ->withHeader('Expires', gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
                $response->getBody()->write(file_get_contents(__DIR__ . '/../../../static/bootstrap/css/bootstrap.min.css'));
                return $response;
                break;

            default:
                return Factory::createResponse(404);
                break;
        }
    }
}
