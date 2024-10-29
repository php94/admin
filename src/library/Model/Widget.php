<?php

declare(strict_types=1);

namespace App\Php94\Admin\Model;

use PHP94\Event;

class Widget
{
    private $widgets = [];

    public function __construct()
    {
        Event::dispatch($this);
    }

    public function addWidget(string $title, string $tpl)
    {
        $key = md5($title . '_' . $tpl);
        $this->widgets[$key] = [
            'key' => $key,
            'title' => $title,
            'tpl' => $tpl,
        ];
    }

    public function getWidgets(): array
    {
        return $this->widgets;
    }
}
