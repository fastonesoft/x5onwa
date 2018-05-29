var qcloud = require('../vendor/wafer2-client-sdk/index')
var config = require('../config')
var util = require('./util.js')
var session = require('../vendor/wafer2-client-sdk/lib/session.js')


/*
 * 登录检测
 * @param {Object} app 全局变量
 * @param {Function} succ 登录成功后的回调函数
 */
var doCheck = function (options) {
  // 查看是否授权
  wx.getSetting({
    success: function (res) {
      if (res.authSetting['scope.userInfo']) {
        // 检查登录是否过期
        wx.checkSession({
          success: function () {
            // 执行回调
            if (typeof options.success === 'function') options.success();
          },
          fail: function () {
            // 登录清除
            qcloud.clearSession();
            // 错误提示
            if (options.showError) util.showModel('登录信息', '请转到“登录”页面登录');
            if (typeof options.fail === 'function') options.fail();
          },
        });
      } else {
        // 错误提示
        if (options.showError) util.showModel('授权信息', '请转到“登录”页面授权');
        if (typeof options.fail === 'function') options.fail();
      }
    }
  });
}

/*
 * 程序登录
 * @param {Object} app 登录配置
 * @param {Object} e open_type 的传递参数
 * @param {Function} succ 登录成功后的回调函数
 */
var doLogin = function (options) {
  util.showBusy('正在登录')
  // 查看是否授权
  wx.getSetting({
    success: function (res) {
      if (res.authSetting['scope.userInfo']) {
        // 登录态已过期，需重新登录
        wx.login({
          success: function (loginResult) {
            // 清除
            qcloud.clearSession();
            // 更新
            var loginParams = {
              code: loginResult.code,
              encryptedData: options.e.detail.encryptedData,
              iv: options.e.detail.iv,
            };
            qcloud.requestLogin({
              loginParams,
              success: function () {
                util.showSuccess('登录成功');
                // 登录成功
                if (typeof options.success === 'function') options.success();
              },
              fail: function (qcloudError) {
                util.showModel('微信登录', qcloudError.message)
              }
            });
          },
          fail: function (loginError) {
            util.showModel('微信登录', '登录出错，请重试')
          }
        })
      } else {
        util.showModel('微信授权', '拒绝授权，有些操作将无法完成');
      }
    }
  });
}

/*
 * 数据查询
 * @param {Object} options 登录配置
 * @param {string} options.url 请求地址
 * @param {string} options.error 错误提示
 * @param {Function} options.success(result) 登录成功后的回调函数
 */
var doRequest = function (options) {
  qcloud.request({
    url: options.url,
    login: false,
    success: function (result) {
      // 请求成功
      if (typeof options.success === 'function') options.success(result.data)
    },
    fail: function (error) {
      if (typeof options.fail === 'function') options.fail()
      var message = options.error || error.message
      util.showModel('查询失败', message)
    }
  })
}

/*
 * 请求列表
 * @param {String} 地外服务地址列表
 */
var host = config.service.host;
var doUrl = {
  host,
  // 权限地址
  role: `${host}/weapp/role`,
  // 登录地址
  login: `${host}/weapp/login`,
  // TODO用户请求
  user: `${host}/weapp/user`,
  // 错误测试地址
  error: `${host}/weapp/error`,
}

// 对外接口
module.exports = {
  url: doUrl,
  login: doLogin,
  check: doCheck,
  request: doRequest
}
