{include common/header@php94/admin}
<h1 class="py-3">账户管理</h1>

<div class="d-flex flex-column gap-3">
    <div>
        <a class="btn btn-primary" href="{echo $router->build('/php94/admin/account/create')}">创建账户</a>
    </div>

    <div>
        <form class="row g-3 align-items-center" action="{echo $router->build('/php94/admin/account/index')}" method="GET">
            <div class="col-auto">
                <select class="form-select" name="disabled" onchange="this.form.submit();">
                    <option {if $request->get('disabled')=='' }selected{/if} value="">不限</option>
                    <option {if $request->get('disabled')=='0' }selected{/if} value="0">正常</option>
                    <option {if $request->get('disabled')=='1' }selected{/if} value="1">禁用</option>
                </select>
            </div>

            <div class="col-auto">
                <div class="input-group">
                    <div class="input-group-text">搜索:</div>
                    <input type="search" name="q" value="{:$request->get('q')}" onchange="this.form.submit();" class="form-control" placeholder="请输入关键词..">
                </div>
            </div>

            <div class="col-auto">
                <input type="hidden" name="page" value="1">
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered mb-0 d-table-cell">
            <thead>
                <tr>
                    <th>#</th>
                    <th>账户</th>
                    <th>状态</th>
                    <th>角色</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                {foreach $datas as $v}
                <tr>
                    <td>{$v.id}</td>
                    <td class="text-nowrap">{$v.name}</td>
                    <td class="text-nowrap">
                        {if $v['disabled']}
                        <span class="text-warning">禁用</span>
                        {else}
                        <span class="text-success">正常</span>
                        {/if}
                    </td>
                    <td class="text-nowrap">
                        {foreach $v['roles'] as $role}
                        <span>[{$role.title}]</span>
                        {/foreach}
                    </td>
                    <td class="text-nowrap">
                        {if $v['id']!=1}
                        <a href="{echo $router->build('/php94/admin/account/role', ['id'=>$v['id']])}">角色设置</a>
                        <a href="{echo $router->build('/php94/admin/account/name', ['id'=>$v['id']])}">设置账户名</a>
                        <a href="{echo $router->build('/php94/admin/account/disable', ['id'=>$v['id']])}">设置状态</a>
                        <a href="{echo $router->build('/php94/admin/account/password', ['id'=>$v['id']])}">重置密码</a>
                        <a href="{echo $router->build('/php94/admin/account/delete', ['id'=>$v['id']])}" onclick="return confirm('确定删除吗？删除后不可恢复！');">删除</a>
                        {else}
                        <span>超级管理员</span>
                        {/if}
                    </td>
                </tr>
                {/foreach}
            </tbody>
        </table>
    </div>

    <div class="d-flex align-items-center flex-wrap gap-1">
        <a class="btn btn-primary {$page>1?'':'disabled'}" href="{echo $router->build('/php94/admin/account/index', array_merge($_GET, ['page'=>1]))}">首页</a>
        <a class="btn btn-primary {$page>1?'':'disabled'}" href="{echo $router->build('/php94/admin/account/index', array_merge($_GET, ['page'=>max($page-1, 1)]))}">上一页</a>
        <div class="d-flex align-items-center gap-1">
            <input class="form-control" type="number" name="page" min="1" max="{$pages}" value="{$page}" onchange="location.href=this.dataset.url.replace('__PAGE__', this.value)" data-url="{echo $router->build('/php94/admin/account/index', array_merge($_GET, ['page'=>'__PAGE__']))}">
            <span>/{$pages}</span>
        </div>
        <a class="btn btn-primary {$page<$pages?'':'disabled'}" href="{echo $router->build('/php94/admin/account/index', array_merge($_GET, ['page'=>min($page+1, $pages)]))}">下一页</a>
        <a class="btn btn-primary {$page<$pages?'':'disabled'}" href="{echo $router->build('/php94/admin/account/index', array_merge($_GET, ['page'=>$pages]))}">末页</a>
        <div>共{$total}条</div>
    </div>
</div>
{include common/footer@php94/admin}