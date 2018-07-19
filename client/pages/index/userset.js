// pages/index/userset.js
var x5on = require('../x5on.js')

Page({
  data: {
    errorShow: false,
    errorMessage: '错误提示',
    items: [],
  },

  checkInput: function (e) {
    x5on.checkInputEx(e, this);
  },

  onLoad: function () {
    var that = this
    x5on.check({
      showError: true,
      success: () => x5on.request({
        url: x5on.url.userset,
        success: function (result) {
          var checked = result.data.checked
          var canModi = ! checked
          that.setData({ items: result.data.data, canModi, checked })
        }
      })
    })
  },

  usersetSubmit: function (e) {
    var that = this
    x5on.checkFormEx(this, function () {
      x5on.postFormEx({
        url: x5on.url.usersetupdate,
        data: e.detail.value,
        success: (res) => {
          that.setData({ canModi: false })
        }
      })
    })
  }
})