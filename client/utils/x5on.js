var qcloud = require('../vendor/wafer2-client-sdk/index')
var config = require('../config')
var util = require('./util.js')

/*
 * 程序登录
 * @param {Object} app 登录配置
 * @param {Object} e open_type 传递的参数
 */
var doLogin = function (app, e, succ) {
  if (app.logged) {
    succ();
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
            succ();
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
                    succ();
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
            options.success(result.data)
        },
        fail(error) {
            var message = options.error || error.message
            util.showModel('查询失败', message)
        }
    })
}

var doCheck = function (app, succ) {
  // 查看是否授权
  wx.getSetting({
    success: function (res) {
      if (res.authSetting['scope.userInfo']) {
        // 检查登录是否过期
        wx.checkSession({
          success: function () {
            // 登录态未过期
            app.logged = true;
            app.userInfo = doSession.get();
            // 执行回调
            succ();
          },
          fail: function () {
            // 登录态清除
            qcloud.clearSession();
            doSession.clear();
            // 清除登录标志
            app.logged = false;
            app.userInfo = null;
          },
        });
      }
    }
  });
}

// 缓存登录用户基本信息
const X5ON_NICK_NAME = 'X5ON-Nick-Name';
var doSession = {
  get: function () {
    return wx.getStorageSync(X5ON_NICK_NAME) || null;
  },
  set: function (session) {
    wx.setStorageSync(X5ON_NICK_NAME, session);
  },
  clear: function () {
    wx.removeStorageSync(X5ON_NICK_NAME);
  }
};

// 请求列表
var host = config.service.host;
var url = {
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
  url,
  login: doLogin,
  check: doCheck,
  request: doRequest,
  session: doSession
}
