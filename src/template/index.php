<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="applicable-device" content="pc,mobile">
    <title>{$config->get('copyright.name@php94.admin', '管理系统')}</title>
    <style>
        html,
        body {
            height: 100%;
            width: 100%;
            padding: 0;
            margin: 0;
        }

        a {
            text-decoration: none;
            color: #000;
        }

        a:hover {
            font-weight: bold;
        }
    </style>
</head>

<body style="position: relative;">
    <div style="position:absolute;left:0;right:0;top:0;height: 50px;z-index: 111;background:black;box-shadow:0px 0px 9px 0px black;">
        <div onclick="this.parentNode.nextElementSibling.nextElementSibling.style.left=this.parentNode.nextElementSibling.nextElementSibling.style.left=='250px'?'0':'250px'" style="display:flex;align-items:center;height:100%;color:#fff;">
            <div style="font-size: 2em;padding:0 15px;">≡</div>
            <div style="font-size: 1.5em;">{$config->get('copyright.name@php94.admin', '后台管理系统')}</div>
        </div>
    </div>
    <div style="position:absolute;left:0;bottom:0;top: 50px;width: 250px;background:#eee;">
        <div style="padding: 10px;line-height: 1.7em;background:#ddd">
            <div>
                <span>欢迎您: <span style="font-weight:bold;">{$account.name}</span></span>
            </div>
            <div>
                <a href="{echo $router->build('/php94/admin/my/name')}" class="link-secondary small text-decoration-none" target="main">修改账户</a>
                <a href="{echo $router->build('/php94/admin/my/password')}" class="link-secondary small text-decoration-none" target="main">修改密码</a>
                <a href="{echo $router->build('/php94/admin/auth/logout')}" class="link-secondary small text-decoration-none">退出</a>
            </div>
            <div>
                <span id="time-display"></span>
                <span id="week-display"></span>
                <script>
                    document.getElementById('time-display').textContent = (new Date).toLocaleString();
                    document.getElementById('week-display').textContent = new Intl.DateTimeFormat('zh-CN', {
                        weekday: 'long'
                    }).formatToParts(new Date())[0].value;
                    setInterval(function() {
                        document.getElementById('time-display').textContent = (new Date).toLocaleString();
                        document.getElementById('week-display').textContent = new Intl.DateTimeFormat('zh-CN', {
                            weekday: 'long'
                        }).formatToParts(new Date())[0].value;
                    }, 1000);
                </script>
            </div>
        </div>
        <style>
            .menu {
                display: flex;
                flex-direction: column;
                border-top: 1px solid #ccc;
            }

            .menu>a {
                padding: 7px 10px;
                font-size: 1.1em;
                /* font-weight: bold; */
            }

            .menu>a:hover {
                background: #ddd;
            }

            .menu>a.active {
                background: #5d5d5d;
                color: #fff;
                font-weight: bold;
            }
        </style>
        <div class="menu">
            <a class="active" href="{echo $router->build('/php94/admin/widget/index')}" target="main">主页</a>
            {foreach $sticks as $vo}
            {if is_scalar($vo) && isset($menus[$vo])}
            <a href="{echo $menus[$vo]['url']}" target="main">{$menus[$vo]['title']}</a>
            {/if}
            {/foreach}
            <a href="{echo $router->build('/php94/admin/menu/index')}" target="main">更多</a>
        </div>
        <script>
            document.querySelectorAll(".menu a").forEach(element => {
                element.addEventListener('click', function() {
                    document.querySelectorAll(".menu a").forEach(el => {
                        if (el == this) {
                            this.setAttribute('class', 'active');
                        } else {
                            el.setAttribute('class', '');
                        }
                    });
                });
            });

            function changemenu(src) {
                document.querySelectorAll(".menu a").forEach(element => {
                    if (element.href == src) {
                        document.querySelectorAll(".menu a").forEach(el => {
                            if (el.href == src) {
                                el.setAttribute('class', 'active');
                            } else {
                                el.setAttribute('class', '');
                            }
                        });
                    }
                });
            }
        </script>
    </div>
    <div style="position:absolute;bottom:0;top:50px;right:0;left: 250px;top: 50px;z-index: 100;background:#fff;">
        <iframe src="{echo $router->build('/php94/admin/widget/index')}" onload="changemenu(this.contentWindow.location.href)" name="main" frameborder="0" style="height:100%;width:100%;display: block;"></iframe>
    </div>
</body>

</html>