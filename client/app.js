//app.js
var qcloud = require('./vendor/wafer2-client-sdk/index')
var config = require('./config')
var util = require('./utils/util.js')

App({
    logged: false,
    userInfo: {},
    onLaunch: function () {
        qcloud.setLoginUrl(config.service.loginUrl)

        // 用户登录示例
        var that = this

        // 调用登录接口
        qcloud.login({
            success(result) {
                if (result) {
                    that.logged = true
                    that.userInfo = result
                    util.showSuccess('登录成功')
                } else {
                    // 如果不是首次登录，不会返回用户信息，请求用户信息接口获取
                    qcloud.request({
                        url: config.service.userUrl,
                        login: true,
                        success(result) {
                            that.logged = true
                            that.userInfo = result.data.data
                            util.showSuccess('查询成功')
                        },

                        fail(error) {
                            util.showModel('查询过期', error.message)
                        }
                    })
                }
            },

            fail(error) {
                util.showModel('登录失败', '请转到“我的”页面授权登录')
            }
        })

    }
})