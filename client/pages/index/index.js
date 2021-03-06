// index.js
var x5on = require('../x5on.js');
var app = getApp()

Page({
  data: {
    imgUrls: [
      'https://www.x5on.cn/content/images/569045613.jpg',
      'https://www.x5on.cn/content/images/860039340.jpg',
    ]
  },

  onShow: function () {
    if (!app.globalData.user || app.globalData.user && app.globalData.user.fixed) {
      this.setData({ types: [], roles: [] })
      wx.switchTab({ url: '/pages/login/login' })
      return
    }
    
    var that = this
    // 检测登录
    x5on.check({
      success() {
        x5on.request({
          donshow: true,
          url: x5on.url.usersetrole,
          success(result) {
            // 重新组织数据
            var types = result.types
            var cores = result.cores
            var roles = []
            types.forEach(type_item => {
              var role = []
              cores.forEach(core => {
                core.type_id === type_item.id && role.push(core)
              });
              roles.push(role)
            });
            that.setData({ types, roles })
          },
          fail() {
            that.setData({ types: [], roles: [] })
            wx.switchTab({ url: '/pages/login/login' })
          }
        })
      },
      fail() {
        that.setData({ types: [], roles: [] })
        wx.switchTab({ url: '/pages/login/login' })
      }
    });
  },

  itemClick: function (e) {
    var itemid = e.currentTarget.dataset.itemid;
    console.log(itemid)
    // todo:检测是否拥有权限
    wx.navigateTo({ url: itemid })
  }
});