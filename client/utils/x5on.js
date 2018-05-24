var qcloud = require('../vendor/wafer2-client-sdk/index')
var config = require('../config')
var util = require('./util.js')

/*
 * 程序登录
 * @param {Object} app 登录配置
 * @param {Object} e open_type 的传递参数
 * @param {Function} succ 登录成功后的回调函数
 */
var doLogin = function (app, e, succ) {
  if (app.logged) {
    if (typeof succ === 'function') succ();
    return;
  }

  util.showBusy('正在登录');
  var userInfo = e.detail.userInfo;

  // 查看是否授权
  wx.getSetting({
    success: function (res) {
      if (res.authSetting['scope.userInfo']) {
        // 检查登录是否过期
        wx.checkSession({
          success: function () {
            // 登录态未过期
            util.showSuccess('登录成功');
            app.userInfo = doSession.get();
            app.logged = true;
            // 登录成功
            if (typeof succ === 'function') succ();
          },
          fail: function () {
            // 清除记录、缓存
            qcloud.clearSession();
            doSession.clear();
            app.userInfo = null;
            app.logged = false;
            // 登录态已过期，需重新登录
            wx.login({
              success: function (loginResult) {
                var loginParams = {
                  code: loginResult.code,
                  encryptedData: e.detail.encryptedData,
                  iv: e.detail.iv,
                }
                qcloud.requestLogin({
                  loginParams, success() {
                    util.showSuccess('登录成功');
                    // 保存记录、缓存
                    doSession.set(userInfo);
                    app.userInfo = userInfo;
                    app.logged = true;
                    // 登录成功
                    if (typeof succ === 'function') succ();
                  },
                  fail(error) {
                    util.showModel('登录失败', error)
                  }
                });
              },
              fail: function (loginError) {
                util.showModel('登录失败', loginError)
              },
            })
          },
        });
      } else {
        util.showModel('用户未授权', e.detail.errMsg);
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
var doRequest = function(options) {
    qcloud.request({
        url: options.url,
        login: true,
        success(result) {
            if (typeof options.success == 'function') options.success(result.data)
        },
        fail(error) {
          console.log(options.url)
            var message = options.error || error.message
            util.showModel('查询失败', message)
        }
    })
}

/*
 * 登录检测
 * @param {Object} app 全局变量
 * @param {Function} succ 登录成功后的回调函数
 */
var doCheck = function (app, succ, fail, comp) {
  // 查看是否授权
  wx.getSetting({
    success: function (res) {
      if (res.authSetting['scope.userInfo']) {
        // 检查登录是否过期
        wx.checkSession({
          success: function () {
            // 登录有效
            app.userInfo = doSession.get();
            app.logged = typeof app.userInfo === 'object' ? true : false;
            // 执行回调
            if (typeof succ === 'function') succ();
          },
          fail: function () {
            // 登录清除
            qcloud.clearSession();
            doSession.clear();
            // 清除登录
            app.logged = false;
            app.userInfo = null;
            // 
            if (typeof fail === 'function') fail(); else util.showModel('登录信息', '请转到“我的”页面登录');
          },
        });
      } else {
        // 登录清除
        doSession.clear();
        // 清除登录
        app.logged = false;
        app.userInfo = null;
        //
        if (typeof fail === 'function') fail(); else util.showModel('授权信息', '请转到“我的”页面授权');
      }
    }
  });
  // 执行完毕回调
  if (typeof comp === 'function') comp();
}

/*
 * 缓存检测
 * @param {Object} 提供本地缓存的get\set\clear
 */
const X5ON_NICK_NAME = 'X5ON-Nick-Name';
var doSession = {
  get: function () {
    return wx.getStorageSync(X5ON_NICK_NAME) || null;
  },
  set: function (value) {
    wx.setStorageSync(X5ON_NICK_NAME, value);
  },
  clear: function () {
    wx.removeStorageSync(X5ON_NICK_NAME);
  }
};

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
}

// 对外接口
module.exports = {
  url: doUrl,
  login: doLogin,
  check: doCheck,
  request: doRequest,
  session: doSession
}
