<?php

declare (strict_types = 1);

namespace App\Php94\Admin\Http\Cache;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Cache;
use PHP94\Help\Response;

/**
 * 清理系统缓存
 */
class Clear extends Common
{
    public function get(
    ) {
        if (Cache::clear()) {
            return Response::success('清理成功！');
        }
        return Response::error('清理失败！');
    }
}
