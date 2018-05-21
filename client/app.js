//app.js
var qcloud = require('./vendor/wafer2-client-sdk/index')
var config = require('./config')

App({
    logged: false,
    userInfo: {},
    onLaunch: function () {
        qcloud.setLoginUrl(config.service.loginUrl)
    }
})