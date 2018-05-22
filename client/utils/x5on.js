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
 * @param {string} options.loginUrl 登录使用的 URL，服务器应该在这个 URL 上处理登录请求
 * @param {string} [options.method] 请求使用的 HTTP 方法，默认为 "GET"
 * @param {Function} options.success() 登录成功后的回调函数
 * @param {Function} options.fail(error) 登录失败后的回调函数，参数 error 错误信息
 */
var request = function (requestOption) {
  util.showBusy('请求中...')
  var that = this
  var options = {
    url: requestOption.url,
    login: requestOption.login,
    success(result) {
      util.showSuccess('请求成功完成')
      console.log('request success', result)
      that.setData(requestOption.data)
    },
    fail(error) {
      util.showModel('请求失败', error);
    }
  }
  if (requestOption.login) {
    qcloud.request(options)
  } else {
    wx.request(options)
  }
}

module.exports = { login,  request}
