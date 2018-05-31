//index.js
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')
var x5on = require('../../utils/x5on.js')


Page({
  data: {
    logged: false,
    cores: [],
    can_use: true,
    imgUrls: [
      'http://img02.tooopen.com/images/20150928/tooopen_sy_143912755726.jpg',
      'http://img06.tooopen.com/images/20160818/tooopen_sy_175866434296.jpg',
      'http://img06.tooopen.com/images/20160818/tooopen_sy_175833047715.jpg'
    ]
  },

  onShow: function () {
    var that = this;
    // 检测登录
    x5on.check({
      showError: true,
      success: () => {
        // 执行查询
        x5on.request({
          url: x5on.url.role,
          success: function (result) {
            // 更新数据
            that.setData({
              logged: result ? true : false,
              cores: result ? result.data : []
            })
          },
          fail: function () {
            that.setData({ logged: false, cores: [] })
          }
        })
      },
      fail: () => {
        that.setData({ logged: false, cores: [] })
      }
    });
  },
});