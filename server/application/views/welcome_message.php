<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>实验初中校务在线应用平台</title>
  <script src="https://res.wx.qq.com/connect/zh_CN/htmledition/js/jquery.min3696b4.js"></script>
  <script src="https://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
  <script type="text/javascript">

      $(function () {
          //扫码登录
          var obj = new WxLogin({
              id: "login_code",
              appid: "wxecca347b5d64f5c3",
              scope: "snsapi_login",
              redirect_uri: "https://www.x5on.cn/oauth",
              state: "web",
              style: "black",
              href: "https://www.x5on.cn/content/codesite.css"
          });
      });

  </script>

</head>
<body>
<div id="login_code" style="height: 600px; width: 800px;">

</div>
</body>
</html>