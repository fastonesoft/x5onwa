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

      qcloud.request({
          url: config.service.roleUrl,
          login: true,
          success(result) {
              that.setData({
                  cores: result.data.data
              })
          },

          fail(error) {
              util.showModel('查询过期', error.message)
          }
      })
  }

});