// pages/index/roleset.js
var x5on = require('../x5on.js')

Page({

  onLoad: function () {
    var that = this
    x5on.request({
      url: x5on.url.roleset,
      success(rolesets) {
        that.setData({ rolesets })
      }
    })
  },

  rolesetSubmit: function (e) {
    var that = this
    x5on.post({
      url: x5on.url.rolesetupdate,
      data: e.detail.value,
      success(number) {
        x5on.showSuccess('更新' + number + '条记录')
      }
    })
  }
})