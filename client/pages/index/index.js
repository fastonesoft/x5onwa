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