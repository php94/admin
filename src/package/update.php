<?php

$updates = [];
foreach ($updates as $version => $fn) {
    if (version_compare($oldversion, $version, '<')) {
        $fn();
    }
}
