//index.js
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')
var app = getApp();

Page({
  data: {
    cores: [],
    can_use: true,
  },

  onShow: function() {
      var that = this;
      wx.request({
          url: config.service.roleUrl,
          success: function (res) {
              that.setData({
                  cores: res.data.data
              })
          }
      })
  }

});