//index.js
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')
var x5on = require('../../utils/x5on.js')

var app = getApp();
Page({
  data: {
    logged: false,
    userInfo: null,
  },

  onLoad: function () {
    this.setData({
      logged: app.logged,
      userInfo: app.userInfo
    })
  },

  onPullDownRefresh: function () {
    // 检测是否登录
    x5on.check(app, function () { });
    // 停止动画
    wx.stopPullDownRefresh();
  },


})
