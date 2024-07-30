{include common/header@php94/admin}
<h1 class="py-3">功能地图</h1>

<div style="margin-top: 20px;">
    <h4>已固定</h4>
    <div style="display: flex;flex-direction: row;flex-wrap: wrap;gap: 20px;margin-top: 10px;">
        {foreach $sticks as $vo}
        <div>
            <a href="{$vo.url}">{$vo.title}</a>
            <a href="{echo $router->build('/php94/admin/menu/stick', $vo)}" title="取消固定" class="text-decoration-none link-danger">★</a>
        </div>
        {/foreach}
    </div>
</div>

<div style="margin-top: 20px;">
    <h4>功能地图</h4>
    <div style="display: flex;flex-direction: row;flex-wrap: wrap;gap: 20px;margin-top: 10px;">
        {foreach $groups as $appname => $vo}
        {if $vo['menus']}
        <div>
            <h6>{$vo['title']}</h6>
            {foreach $vo['menus'] as $menu}
            <div>
                <a href="{$menu.url}">{$menu.title}</a>
                {if $menu['stick']}
                <a href="{echo $router->build('/php94/admin/menu/stick', $menu)}" title="取消固定" class="text-decoration-none link-danger">★</a>
                {else}
                <a href="{echo $router->build('/php94/admin/menu/stick', $menu)}" title="点击固定" class="text-decoration-none link-dark">☆</a>
                {/if}
            </div>
            {/foreach}
        </div>
        {/if}
        {/foreach}
    </div>
</div>
{include common/footer@php94/admin}