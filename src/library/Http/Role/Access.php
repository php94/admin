<?php

declare(strict_types=1);

namespace App\Php94\Admin\Http\Role;

use App\Php94\Admin\Http\Common;
use PHP94\App;
use PHP94\Db;
use PHP94\Request;
use PHP94\Template;
use PHP94\Form\Field\Hidden;
use PHP94\Form\Field\Text;
use PHP94\Form\Form;
use PHP94\Form\Help\Html;
use PHP94\Response;
use ReflectionClass;
use Throwable;

/**
 * 给角色设置权限
 */
class Access extends Common
{
    public function get()
    {
        $role = Db::get('php94_admin_role', '*', [
            'id' => Request::get('id', 0, ['intval']),
        ]);
        $form = new Form('设置权限');
        $form->addItem(
            (new Hidden('id', $role['id'])),
            (new Text('角色名称', 'title', $role['title']))->setDisabled(),
            (new Html((function () use ($role): string {
                $values = Db::select('php94_admin_role_node', 'node', [
                    'role_id' => $role['id'],
                ]);
                $nodes = [];
                foreach (App::all() as $appname) {
                    $nodes[$appname] = [];
                    foreach ($this->getNodesByApp($appname) as $no) {
                        $no['methods'] = Db::select('php94_admin_role_node', 'method', [
                            'role_id' => $role['id'],
                            'node' => $no['node'],
                        ]);
                        $nodes[$appname][] = $no;
                    }
                }
                $tpl = <<<'str'
<div>
    <div>权限设置</div>
    <div>
        <table class="table table-bordered mb-0 d-table-cell">
        {foreach $nodes as $appname => $nos}
            <tr>
                <th colspan="2">{$appname}</th>
            </tr>
            {foreach $nos as $vo}
            <tr>
                <td>
                    <span title="{$vo.doc}">{$vo.node}</span>
                </td>
                <td>
                    {foreach ['GET', 'POST', 'DELETE'] as $me}
                    <label>
                        <input type="checkbox" name="nodes[{$vo['node']}][]" value="{$me}" {:in_array($me, $vo['methods'])?'checked':''}>
                        <span>{$me}</span>
                    </label>
                    {/foreach}
                </td>
            </tr>
            {/foreach}
        {/foreach}
        </table>
    </div>
</div>
str;
                return Template::renderString($tpl, [
                    'nodes' => $nodes,
                    'values' => $values,
                ]);
            })()))
        );
        return $form;
    }

    public function post()
    {
        $role = Db::get('php94_admin_role', '*', [
            'id' => Request::post('id'),
        ]);

        Db::delete('php94_admin_role_node', [
            'role_id' => $role['id'],
        ]);

        $nodes = [];
        foreach (Request::post('nodes', []) as $node => $methods) {
            foreach ($methods as $method) {
                $nodes[] = [
                    'role_id' => $role['id'],
                    'node' => $node,
                    'method' => $method,
                ];
            }
        }
        Db::insert('php94_admin_role_node', $nodes);

        return Response::success('操作成功！');
    }

    private function getNodesByApp(string $appname): array
    {
        $nodes = [];
        $base = App::getDir($appname) . '/src/library/Http';
        if (!is_dir($base)) {
            return $nodes;
        }
        $files = $this->getFileList($base);
        foreach ($files as $file) {
            if (substr($file, -4) != '.php') {
                continue;
            }
            $cls = str_replace(['-', '/'], ['', '\\'], ucwords('App\\' . $appname . '\\Http' . substr($file, strlen($base), -4), '/\\-'));
            try {
                $rfc = new ReflectionClass($cls);
                if (!$rfc->isInstantiable()) {
                    continue;
                }
                if (!$rfc->isSubclassOf(Common::class)) {
                    continue;
                }
                $nodes[] = [
                    'node' => $cls,
                    'doc' => $rfc->getDocComment(),
                ];
            } catch (Throwable $th) {
            }
        }
        return $nodes;
    }

    private function getFileList($dir): array
    {
        $file_list = [];
        $file_dir_list = [];

        $dir_list = scandir($dir);

        foreach ($dir_list as $r) {
            if ($r == '.' || $r == '..') {
                continue;
            }
            $new_dir = $dir . DIRECTORY_SEPARATOR . $r;
            if (is_dir($new_dir)) {
                $file_dir = $this->getFileList($new_dir);
                $file_dir_list = array_merge($file_dir_list, $file_dir);
            } else {
                $file_list[] = $new_dir;
            }
        }

        return array_merge($file_list, $file_dir_list);
    }
}
