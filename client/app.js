//app.js
var qcloud = require('./vendor/wafer2-client-sdk/index')
var config = require('./config')
var x5on = require('./utils/x5on.js')

App({
    logged: false,
    userInfo: {},
    onLaunch: function () {
        qcloud.setLoginUrl(config.service.loginUrl)
    }
})