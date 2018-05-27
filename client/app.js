//app.js
var session = require('./vendor/wafer2-client-sdk/lib/session.js')
var qcloud = require('./vendor/wafer2-client-sdk/index')
var config = require('./config')
var x5on = require('./utils/x5on.js')

App
({
  onLaunch: function () {
    qcloud.setLoginUrl(x5on.url.login);
  },
})