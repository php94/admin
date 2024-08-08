<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Cache;

use App\Php94\Admin\Http\Common;
use PHP94\Cache;
use PHP94\Template;
use PHP94\Response;

class Index extends Common
{
    public function get()
    {
        return Template::render('cache/index@php94/admin');
    }
}
