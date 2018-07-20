// pages/index/regexam.js
var x5on = require('../x5on.js')

Page({

  scanClick: function (e) {
    var that = this
    x5on.check({
      success: () => {
        wx.scanCode({
          onlyFromCamera: true,
          success: (res) => {
            // 请求学生数据
            var uid = res.result
          }
        })
      }
    })
  }

})