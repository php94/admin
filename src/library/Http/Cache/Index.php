<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Cache;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Cache;
use PHP94\Facade\Template;
use PHP94\Help\Response;

class Index extends Common
{
    public function get()
    {
        return Template::render('cache/index@php94/admin');
    }
}
