//app.js
var qcloud = require('./vendor/wafer2-client-sdk/index')
var x5on = require('./pages/x5on.js')

App
({

  globalData: {
    user: null,
  },

  onLaunch: function () {
    qcloud.setLoginUrl(x5on.url.login);
  },


})