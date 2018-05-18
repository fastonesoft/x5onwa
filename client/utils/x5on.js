var util = require('./util.js')

// 调用登录接口
var qcloudLogin = function (app) {
    qcloud.login({
        success(result) {
            if (result) {
                app.logged = true
                app.userInfo = result
                util.showSuccess('登录成功')
            } else {
                // 如果不是首次登录，不会返回用户信息，请求用户信息接口获取
                qcloud.request({
                    url: config.service.userUrl,
                    login: true,
                    success(result) {
                        app.logged = true
                        app.userInfo = result.data.data
                        util.showSuccess('查询成功')
                    },

                    fail(error) {
                        util.showModel('出错信息', '查询已过期，请重新登录')
                    }
                })
            }
        },

        fail(error) {
            util.showModel('登录失败', '请转到“我的”页面授权登录')
        }
    })
}

module.exports = { qcloudLogin }
