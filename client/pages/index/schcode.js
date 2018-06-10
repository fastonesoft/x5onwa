// pages/index/schcode.js
var x5on = require('../x5on.js')

Page({
  data: {
    errorShow: false,
    errorMessage: '错误提示',
    errorArray: [0, 0, 0, 0, 0, 0, 0, 0]
  },

  checkInput: function (e) {
    x5on.checkInput(e, this)
  },

  paraSubmit: function (e) {
    x5on.checkForm(this, 0, 4, function () {
      x5on.postForm({
        url: x5on.url.schcode,
        data: e.detail.value,
        success: (res) => {
          console.log(res)
        }
      })
    })
  },

  orderSubmit: function (e) {
    x5on.checkForm(this, 5, 7, function () {
      x5on.postForm({
        url: x5on.url.schcode,
        data: e.detail.value,
        success: (res) => {
          console.log(res)
        }
      })
    })
  }
})