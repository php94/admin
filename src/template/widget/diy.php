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
    <style>
        html,
        body {
            height: 100%;
            width: 100%;
            padding: 0;
            margin: 0;
        }
    </style>
    <div style="display: flex;flex-wrap:nowrap;height: 100%;">
        <div style="flex-grow: 1;">
            <iframe src="{echo $router->build('/php94/admin/widget/index?diy=1')}" name="diy" id="diy" frameborder="0" style="height:100%;width:100%;display: block;"></iframe>
        </div>
        <div class="bg-light p-3" style="width: 370px;">
            <h1 class="py-2">挂件列表</h1>
            <div style="display: flex;flex-direction: column;gap: 20px;margin: 0px auto;">
                {foreach $widgets as $vo}
                <div>
                    <details open>
                        <summary>
                            <span>{$vo['title']??'无标题'}</span>
                            <a href="{echo $router->build('/php94/admin/widget/add', ['file'=>$vo['file']])}" target="diy" class="link-offset-2">添加</a>
                        </summary>
                        {echo $vo['content']}
                    </details>
                </div>
                {/foreach}
            </div>
        </div>
    </div>
    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        });
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
</body>

</html>