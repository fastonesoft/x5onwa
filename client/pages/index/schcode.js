// pages/index/schcode.js
var x5on = require('../x5on.js')

Page({
  data: {
    errorShow: false,
    errorMessage: '错误提示',
    errorArray: new Array(0,0,0,0,0,0,0,0)
  },

  checkInput: function (e) {
    x5on.checkinput(e, this)
  },

  paraSubmit: function (e) {
    x5on.checkform(this, 0, 4, function () {
      x5on.postform({
        url: x5on.url.test,
        data: e.detail.value,
        success: (res) => {
          console.log(res)
          // 
        }
      })
    })
  },

  orderSubmit: function (e) {
    x5on.checkform(this, 5, 7, function () {
      console.log('form发生了submit事件，携带数据为：', e.detail.value)
    })
  }
})