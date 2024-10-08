<?php

use App\Php94\Admin\Http\Common;
use App\Php94\Admin\Middleware\AuthMiddleware;
use PHP94\Handler;
use PHP94\Request;

return [
    Handler::class => function (
        Handler $handler
    ) {
        if (is_a(Request::attr('handler', ''), Common::class, true)) {
            $handler->pushMiddleware(AuthMiddleware::class);
        }
    },
];
