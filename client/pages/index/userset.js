// pages/index/userset.js
var x5on = require('../x5on.js')

Page({
  data: {
    errorShow: false,
    errorMessage: '错误提示',
    errorArray: [0, 0, 0, 0, 0, 0, 0, 0]
  },

  checkInput: function (e) {
    x5on.checkInput(e, this)
  }
})