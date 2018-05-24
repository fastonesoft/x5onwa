//app.js
var qcloud = require('./vendor/wafer2-client-sdk/index')
var config = require('./config')
var x5on = require('./utils/x5on.js')

App({
  logged: false,
  userInfo: null,
  onLaunch: function () {
    qcloud.setLoginUrl(x5on.url.login)
    x5on.check(this, function() {});
  }
})