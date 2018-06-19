// pages/index/userset.js
var x5on = require('../x5on.js')

Page({
  data: {
    errorShow: false,
    errorMessage: '错误提示',
    userkeys: [],
  },

  checkInput: function (e) {
    x5on.checkInputEx(e, this)
  },

  onLoad: function () {
    var that = this
    x5on.check({
      showError: true,
      success: () => x5on.request({
        url: x5on.url.userset,
        success: function (result) {
          var keys = result.data
          console.log(result)
          that.setData({ userkeys: keys })
        }
      })
    })
  }
})