// pages/index/regexam.js
var x5on = require('../x5on.js')

Page({

  data: {
    not_scan: true
  },

  scanClick: function (e) {
    var that = this
    x5on.check({
      success: () => {
        wx.scanCode({
          onlyFromCamera: true,
          success: (res) => {
            that.setData({ not_scan: false })
            var uid = res.result
            x5on.postFormEx({
              url: x5on.url.studexam,
              data: {uid},
              success: function (result) {
                var data = result.data
                x5on.data(that, data)
              }
            })
          }
        })
      }
    })
  }

})