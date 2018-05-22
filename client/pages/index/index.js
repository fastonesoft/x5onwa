//index.js
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')

var app = getApp();

Page({
    data: {
        cores: [],
        can_use: true,
        imgUrls: [
          'http://img02.tooopen.com/images/20150928/tooopen_sy_143912755726.jpg',
          'http://img06.tooopen.com/images/20160818/tooopen_sy_175866434296.jpg',
          'http://img06.tooopen.com/images/20160818/tooopen_sy_175833047715.jpg'
        ]
    },

    onShow: function() {



/*
        qcloud.request({
            url: config.service.roleUrl,
            login: true,
            success(result) {
                that.setData({
                    cores: result.data
                })
            },

            fail(error) {
                util.showModel('查询过期', error.message)
            }
        })
*/
        util.showBusy('请求中...')
        var that = this
        var options = {
          url: config.service.roleUrl,
          login: true,
          success(result) {
            util.showSuccess('请求成功完成')
            console.log(result.data)
            that.setData({
              cores: result.data.data
            })
          },
          fail(error) {
            util.showModel('请求失败', error);
            console.log('request fail', error);
          }
        }
        wx.request(options)

    }
/*

      // 查看是否授权
      var that = this;
      wx.getSetting({
        success: function (res) {
          if (res.authSetting['scope.userInfo']) {

            // 检查登录是否过期
            wx.checkSession({
              success: function () {
                // 登录态未过期
                util.showSuccess('登录成功1');
              },

              fail: function () {
                qcloud.clearSession();
                // 登录态已过期，需重新登录
                var options = {
                  encryptedData: e.detail.encryptedData,
                  iv: e.detail.iv,
                  userInfo: userInfo
                }
                that.doLogin(options);
              },
            });
          } else {
            util.showModel('用户未授权', e.detail.errMsg);
          }
        }
      });




    doLogin: function (options) {
      var that = this;

      wx.login({
        success: function (loginResult) {
          var loginParams = {
            code: loginResult.code,
            encryptedData: options.encryptedData,
            iv: options.iv,
          }
          qcloud.requestLogin({
            loginParams, success() {
              util.showSuccess('登录成功');

              that.setData({
                userInfo: options.userInfo,
                logged: true
              })
            },
            fail(error) {
              util.showModel('登录失败', error)
              console.log('登录失败', error)
            }
          });
        },
        fail: function (loginError) {
          util.showModel('登录失败', loginError)
          console.log('登录失败', loginError)
        },
      });
    }
        */
});