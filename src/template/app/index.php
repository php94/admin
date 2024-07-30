{include common/header@php94/admin}
<h1 class="py-3">应用管理</h1>

<div class="table-responsive">
    <table class="table table-bordered mb-0 d-table-cell">
        <thead>
            <tr>
                <th>包名</th>
                <th>标题</th>
                <th>版本</th>
                <th>简介</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            {foreach $apps as $vo}
            <tr>
                <td class="text-nowrap">
                    {if $vo['core']}
                    <span>{$vo.name}</span>
                    <sup class="text-danger">核心</sup>
                    {else}
                    <span>{$vo.name}</span>
                    {/if}
                </td>
                <td class="text-nowrap">{$vo['title']??''}</td>
                <td class="text-nowrap">{$vo['version']??''}</td>
                <td>{$vo['description']??''}</td>
                <td class="text-nowrap">
                    {if $vo['installed'] && !$vo['disabled']}
                    <span class="text-info">运行中</span>
                    {elseif $vo['installed'] && $vo['disabled']}
                    <span class="text-secondary">已停用</span>
                    {else}
                    <span class="text-danger">未安装</span>
                    {/if}
                </td>
                <td class="text-nowrap">
                    {if $vo['installed'] && !in_array($vo['name'], ['php94/admin'])}
                    {if $vo['disabled']}
                    <a href="{echo $router->build('/php94/admin/app/disable', ['appname'=>$vo['name'], 'disabled'=>0])}" onclick="return confirm('确定启用该应用？')">启用</a>
                    {else}
                    <a href="{echo $router->build('/php94/admin/app/disable', ['appname'=>$vo['name'], 'disabled'=>1])}" onclick="return confirm('确定停用该应用吗？')">停用</a>
                    {/if}
                    {/if}

                    {if !$vo['core']}
                    {if !$vo['installed']}
                    <a href="{echo $router->build('/php94/admin/app/install', ['appname'=>$vo['name']])}" onclick="return confirm('确定安装该应用吗？')">安装</a>
                    {elseif $vo['disabled']}
                    <a href="{echo $router->build('/php94/admin/app/un-install', ['appname'=>$vo['name']])}" onclick="return confirm('确定卸载该应用吗？卸载会删除数据！')">卸载</a>
                    {/if}
                    {/if}
                </td>
            </tr>
            {/foreach}
        </tbody>
    </table>
</div>

{include common/footer@php94/admin}