// pages/index/myexqrcode.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (options) {
    var that = this
    var kao_stud_id = options.kao_stud_id
    x5on.postForm({
      url: x5on.url.myadjustexqrcode,
      data: { kao_stud_id },
      success: (result) => {
        that.setData(result.data)
      }
    })
  },

  returnClick: function (e) {
    var pages = getCurrentPages();
    var currPage = pages[pages.length - 1];
    var prevPage = pages[pages.length - 2];

    var studmoves = []
    prevPage.setData({ studmoves })

    wx.navigateBack()
  }

})