<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>校务在线</title>
  <script src="https://res.wx.qq.com/connect/zh_CN/htmledition/js/jquery.min3696b4.js"></script>
  <script src="https://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
  <script type="text/javascript">

    $(function () {
      //窗体大小调整
      $(window).resize(function () {
        var awid = $(window).width();
        var ahei = $(window).height();

        $('#login_code').css({ 'left': awid / 2 - 180, 'top': ahei / 2 - 220 });
        $('#cloud1').css({ 'left': awid / 4 * Math.random(), 'top': ahei / 4 * Math.random() });
        $('#cloud2').css({ 'left': awid / 2 + awid / 4 * Math.random(), 'top': ahei / 4 * Math.random() });
      });
      $(window).resize();

      var obj = new WxLogin({
        id: "login_code",
        appid: "wxecca347b5d64f5c3",
        scope: "snsapi_login",
        redirect_uri: "https://www.x5on.cn/oauth",
        state: "web",
        style: "black",
        href: "https://www.x5on.cn/content/codesite.css?v=" + Math.random()
      });
    });

  </script>

  <style type="text/css">

    #cloudBody { width: 100%; height: 100%; position: absolute; z-index: -1; }
    .my-login-cloud { top: 0px; left: 0px; width: 100%; height: 100%; position: absolute; background: url(/content/images/logincloud.png) no-repeat; z-index: 1; opacity: 0.5; }
    .my-login-body { width: 100%; height: 100%; overflow: hidden; position: absolute; background: url(/content/images/loginbg3.png) no-repeat center center; }
    .my-login-code { position: fixed; padding-top: 30px; text-align: center;  width: 360px; height: 360px; background-color: white; border-radius: 5px; box-shadow: 1px 1px 5px #333333, -1px -1px 5px #333333; }

  </style>

</head>
<body style="background-color: #1c77ac; background-image: url(/content/images/light.png); background-repeat: no-repeat; background-position: center top; overflow: hidden; ">

<div id="cloudBody">
  <div id="cloud1" class="my-login-cloud"></div>
  <div id="cloud2" class="my-login-cloud"></div>
</div>
<div class="my-login-body">
  <div class="my-login-code" id="login_code">
  </div>
</div>

</body>
</html>