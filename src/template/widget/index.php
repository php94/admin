{include common/header@php94/admin}
<h1 class="py-3">信息看板</h1>
<div>
    {if $request->has('get.diy')}
    <a class="btn btn-warning" href="{echo $router->build('/php94/admin/widget/index')}" target="main">退出DIY</a>
    {else}
    <a class="btn btn-primary" href="{echo $router->build('/php94/admin/widget/diy')}" target="main">自定义本页</a>
    {/if}
</div>
<div style="display: flex;flex-direction: row;gap: 10px;flex-wrap: wrap;margin-top: 20px;">
    {foreach $widgets as $key => $vo}
    <div style="width:300px;">
        <details open>
            <summary>
                <span>{$vo['title']?:'无标题'}</span>
                {if $request->has('get.diy')}
                {if $key}
                <a href="{echo $router->build('/php94/admin/widget/left', ['index'=>$key])}">左移</a>
                {/if}
                {if count($widgets)-$key-1}
                <a href="{echo $router->build('/php94/admin/widget/right', ['index'=>$key])}">右移</a>
                {/if}
                <a href="{echo $router->build('/php94/admin/widget/remove', ['index'=>$key])}">移除</a>
                {/if}
            </summary>
            {echo $vo['content']}
        </details>
    </div>
    {/foreach}
</div>
{include common/footer@php94/admin}