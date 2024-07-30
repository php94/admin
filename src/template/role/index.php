{include common/header@php94/admin}
<h1 class="py-3">角色管理</h1>

<div class="d-flex flex-column gap-3">
    <div>
        <a class="btn btn-primary" href="{echo $router->build('/php94/admin/role/create')}">创建角色</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered mb-0 d-table-cell">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>角色名称</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                {foreach $roles as $vo}
                <tr>
                    <td>{$vo.id}</td>
                    <td class="text-nowrap">{$vo.title}</td>
                    <td class="text-nowrap">
                        <a href="{echo $router->build('/php94/admin/role/update', ['id'=>$vo['id']])}">编辑</a>
                        <a href="{echo $router->build('/php94/admin/role/delete', ['id'=>$vo['id']])}" onclick="return confirm('确定删除吗？删除后不可恢复！');">删除</a>
                        <a href="{echo $router->build('/php94/admin/role/access', ['id'=>$vo['id']])}">权限设置</a>
                    </td>
                </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</div>
{include common/footer@php94/admin}