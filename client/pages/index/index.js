// index.js
var x5on = require('../x5on.js');

Page({
  data: {

    cores: [],
    imgUrls: [
      'http://wafer-1253456186.cossh.myqcloud.com/569045613.jpg',
      'http://wafer-1253456186.cossh.myqcloud.com/860039340.jpg',
    ]
  },

  onLoad: function () {
    // 执行查询
    x5on.request({
      url: x5on.url.role,
      success: function (cores) {
        // 更新
        that.setData({ cores })
      }
    })
  },

  onShow: function () {
    var that = this
    // 检测登录
    x5on.check({
      fail: () => {
        that.setData({ cores: [] })
        wx.navigateTo({ url: '/pages/login/login'})
      }
    });
  },

  itemClick: function (event) {
    var itemid = event.currentTarget.dataset.itemid;
    console.log(itemid)
    // 检测是否拥有权限    
    wx.navigateTo({
      url: itemid,
      success: () => {

      }
    })
  }
});