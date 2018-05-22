var qcloud = require('../vendor/wafer2-client-sdk/index')
var config = require('../config')
var util = require('./util.js')

// 调用登录接口
var login = function (app) {
    qcloud.login({
        success(result) {
            if (result) {
                app.logged = true
                app.userInfo = result
                //util.showSuccess('登录成功')
            } else {
                // 如果不是首次登录，不会返回用户信息，请求用户信息接口获取
                qcloud.request({
                    url: config.service.requestUrl,
                    login: true,
                    success(result) {
                        app.logged = true
                        app.userInfo = result.data.data
                        //util.showSuccess('查询成功')
                    },

                    fail(error) {
                        util.showModel('查询过期', '请转到“我的”页面下拉刷新')
                    }
                })
            }
        },

        fail(error) {
            util.showModel('登录失败', '请转到“我的”页面授权登录')
        }
    })
}


/* @method
 * 数据查询
 *
 * @param {Object} options 登录配置
 * @param {string} options.url 
 * @param {Function} options.success(result) 登录成功后的回调函数
 */

var request = function(options) {
    qcloud.request({
        url: options.url,
        login: true,
        success(result) {
            options.success(result.data)
        },
        fail(error) {
            var message = options.error || error.message
            util.showModel('查询失败', message)
        }
    })
}


module.exports = { login,  request}
