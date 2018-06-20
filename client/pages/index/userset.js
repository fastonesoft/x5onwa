// pages/index/userset.js
var x5on = require('../x5on.js')

Page({
  data: {
    errorShow: false,
    errorMessage: '错误提示',
    items: [],
  },

  checkInput: function (e) {
    var value = e.detail.value
    this.setData({ })
    x5on.checkInputEx(e, this)
  },

  onLoad: function () {
    var that = this
    x5on.check({
      showError: true,
      success: () => x5on.request({
        url: x5on.url.userset,
        success: function (result) {
          console.log(result)
          that.setData({ items: result.data })
        }
      })
    })
  },

  usersetSubmit: function (e) {
    x5on.checkFormEx(this, function () {
      x5on.postForm({
        url: x5on.url.usersetupdate,
        data: e.detail.value,
        success: (res) => {
          console.log(res)
        }
      })
    })
  }
})