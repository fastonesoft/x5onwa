// index.js
var x5on = require('../x5on.js')


Page({
  data: {
    logged: false,
    cores: [],
    imgUrls: [
      'http://wafer-1253456186.cosgz.myqcloud.com/f2d1b449ca7d96c3efc1184d37d2caf6-wxdca8673d324d4384.o6zAJs-J33VQGQKJ2oYgoE6vovRY.2DUKCj5D6WKweaa223c31562996d934eec95c8409cc9.jpg',
      'http://wafer-1253456186.cosgz.myqcloud.com/1fabdbb482d0f6090f8d05ccf9264b94-wxdca8673d324d4384.o6zAJs-J33VQGQKJ2oYgoE6vovRY.X62o9YlGobFN2ed24adb15cdbd96fd24e656395864c2.jpg'
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
            // 更新
            that.setData({ logged: true, cores: result.data })
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

  itemClick: function (event) {
    var itemid = event.currentTarget.dataset.itemid;
    console.log(itemid)
    // 检测是否拥有权限
    
    wx.navigateTo({
      url: itemid,
      success: () => {
        // 
      },
      fail: () => {
        wx.navigateBack();
      }
    })
  }
});