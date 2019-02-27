// index.js
var x5on = require('../x5on.js');

Page({
  data: {
    imgUrls: [
      'http://wafer-1253456186.cossh.myqcloud.com/569045613.jpg',
      'http://wafer-1253456186.cossh.myqcloud.com/860039340.jpg',
    ]
  },

  onShow: function () {
    var that = this
    // 检测登录
    x5on.check({
      success() {
        x5on.request({
          url: x5on.url.usersetrole,
          success(result) {
            // 更新
            console.log(result)
            that.setData(result)
          }
        })
      },
      fail() {
        that.setData({ types: [], cores: [] })
        wx.switchTab({ url: '/pages/login/login'})
      }
    });
  },

  itemClick: function (event) {
    var itemid = event.currentTarget.dataset.itemid;
    console.log(itemid)
    // 检测是否拥有权限    
    wx.navigateTo({ url: itemid })
  }
});