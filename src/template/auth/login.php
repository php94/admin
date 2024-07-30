<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="applicable-device" content="pc,mobile">
    <title>{$config->get('copyright.name@php94.admin', '管理系统')}</title>
    <style>
        a {
            text-underline-offset: 0.25em;
        }
    </style>
</head>

<body>
    <script>
        function reloadcaptcha() {
            document.getElementById("captcha").src = "{echo $router->build('/php94/admin/tool/captcha')}?time=" + (new Date()).getTime();
        }
        window.addEventListener('load', function() {
            reloadcaptcha();
        });
    </script>
    <style>
        input {
            padding: 10px;
        }
    </style>
    <form method="POST">
        <div style="padding-top: 150px;margin: 0 auto;width: 200px;">
            <div style="display:flex;flex-direction: column;gap: 10px;">
                <h1 style="text-align:center;">登录</h1>
                <div>
                    <input type="text" name="name" placeholder="账户" autocomplete="off" required>
                </div>
                <div>
                    <input type="password" name="password" placeholder="密码" autocomplete="off" required>
                </div>
                <div>
                    <img style="vertical-align: middle;cursor: pointer;margin-bottom:5px;border:1px solid gray;width:150px;height:40px;" id="captcha" src="#" onclick="reloadcaptcha()">
                    <input type="text" name="captcha" placeholder="验证码" autocomplete="off" autocomplete="off" required>
                </div>
                <div>
                    <input type="submit" style="padding: 5px 10px;" value="登录">
                </div>
            </div>
        </div>
    </form>
</body>

</html>