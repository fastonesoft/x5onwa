// pages/class/class.js
var x5on = require('../x5on.js');

Page({

  onShow: function () {
    var that = this
    // 检测登录
    x5on.check({
      success() {
        that.setData({ types: [], roles: [] })
        wx.switchTab({ url: '/pages/index/index' })
      },
      fail() {
        that.setData({ types: [], roles: [] })
        wx.switchTab({ url: '/pages/login/login' })
      }
    });
  },
  
})