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
            console.log(res)
          }
        })
      }
    })
  }

})