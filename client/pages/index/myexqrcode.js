// pages/index/myexqrcode.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (options) {
    var that = this
    var kao_stud_id = options.kao_stud_id
    that.setData({ kao_stud_id })
    x5on.postForm({
      url: x5on.url.myadjustexqrcode,
      data: { kao_stud_id },
      success: (result) => {
        that.setData(result.data)
      }
    })
  },

  scanClick: function (e) {
    var that = this
    var pages = getCurrentPages();
    var currPage = pages[pages.length - 1];
    var prevPage = pages[pages.length - 2];

    var studmoves = []
    prevPage.setData({ studmoves })


    wx.scanCode({
      onlyFromCamera: true,
      success: (res) => {
        var exchange_kao_stud_id = res.result
        var move_kao_stud_id = that.data.kao_stud_id
        x5on.postForm({
          url: x5on.url.studexam,
          data: { move_kao_stud_id, exchange_kao_stud_id },
          success: function (result) {
            var data = result.data



          }
        })
      }
    })


    wx.navigateBack()
  }

})