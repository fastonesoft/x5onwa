// pages/index/tchreg.js
var x5on = require('../x5on.js')

Page({

  data: {
    errorShow: false,
    errorMessage: '错误提示',
    errorArray: [1]
  },

  checkInput: function (e) {
    x5on.checkInput(e, this)
  },

  findSubmit: function (e) {
    x5on.checkForm(this, 0, 0, function () {
      x5on.postForm({
        url: x5on.url.tchreg,
        data: e.detail.value,
        success: (res) => {
          console.log(res)
        }
      })
    })
  }

})