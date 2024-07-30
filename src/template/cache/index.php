{include common/header@php94/admin}
<h1 class="py-3">缓存管理</h1>

<div>
    <a class="btn btn-primary" href="{echo $router->build('/php94/admin/cache/clear')}">清理缓存</a>
</div>

{include common/footer@php94/admin}