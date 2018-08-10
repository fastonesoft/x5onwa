// pages/index/roleset.js
var x5on = require('../x5on.js')

Page({
  data: {
    errorShow: false,
    errorMessage: '错误提示',
    errorArray: [0],

    roleItems: []
  },

  onLoad: function () {
    var that = this
    x5on.check({
      showError: true,
      success: () => x5on.request({
        url: x5on.url.roleset,
        success: function (result) {
          that.setData({ roleItems: result.data })
        }
      })
    })
  },

  rolesetSubmit: function (e) {
    // 不需要检测
    x5on.postFormEx({
      url: x5on.url.rolesetupdate,
      data: e.detail.value,
      success: (res) => {
        x5on.showSuccess('更新' + res.data + '条记录')
      }
    })
  }
})