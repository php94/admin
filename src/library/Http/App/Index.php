<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\App;

use App\Php94\Admin\Http\Common;
use Composer\InstalledVersions;
use PHP94\App;
use PHP94\Template;

class Index extends Common
{
    public function get()
    {
        $apps = [];
        foreach (App::all() as $appname) {
            $json = json_decode(file_get_contents(App::getDir($appname) . '/composer.json'), true);
            if (!is_array($json)) {
                continue;
            }
            if (!isset($json['name'])) {
                continue;
            }
            if ($json['name'] != $appname) {
                continue;
            }
            $json['installed'] = App::isInstalled($appname);
            $json['disabled'] = App::isDisabled($appname);
            $json['core'] = App::isCore($appname);
            if ($json['core']) {
                $json['version'] = InstalledVersions::getVersion($appname);
            } else {
                $json['version'] = $json['version'] ?? '';
            }
            $apps[$appname] = $json;
        }

        return Template::render('app/index@php94/admin', [
            'apps' => $apps,
        ]);
    }
}
