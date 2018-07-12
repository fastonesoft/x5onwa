// pages/index/regexam.js
var x5on = require('../x5on.js')

Page({

  data: {
  
  },

  onLoad: function (options) {
  
  },

  scanClick: function (e) {
    var that = this
    x5on.check({
      success: () => {
        wx.scanCode({
          onlyFromCamera: true,
          success: (res) => {
            data = res.result
            // 请求学生数据
            
          }
        })
      }
    })
  }

})