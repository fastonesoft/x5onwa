//index.js
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')


Page({
  data: {
    cores: []
  },


  onLoad: function(){
    var that = this;
    wx.request({
      url: config.service.roleUrl,
      success: function (res) {
        console.log(res);
        that.setData({
          cores: res.data.data
        })
      }
    })
  },
  login: function(){
    var _this = this;
    //如果有缓存，则提前加载缓存
    if(app.cache.version === app.version){
      try{
        _this.response();
      }catch(e){
        //报错则清除缓存
        app.cache = {};
        wx.clearStorage();
      }
    }

  },
});