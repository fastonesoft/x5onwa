// pages/index/myexqrcode.js
Page({

  onLoad: function (options) {
    var kao_stud_id = options.kao_stud_id
    console.log(kao_stud_id)
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