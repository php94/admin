<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="applicable-device" content="pc,mobile">
    <title>{$config->get('copyright.name@php94.admin', '管理系统')}</title>
    <script src="{echo $router->build('/php94/admin/tool/file', ['file'=>'jquery'])}"></script>
    <script src="{echo $router->build('/php94/admin/tool/file', ['file'=>'bsjs'])}"></script>
    <link href="{echo $router->build('/php94/admin/tool/file', ['file'=>'bscss'])}" rel="stylesheet">
    <style>
        a {
            text-underline-offset: 0.25em;
        }
    </style>
</head>

<body>
    <div class="container-fluid">