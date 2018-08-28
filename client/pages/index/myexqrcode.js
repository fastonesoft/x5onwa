// pages/index/myexqrcode.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (options) {
    var that = this
    var grade_stud_uid = options.uid
    that.setData({ grade_stud_uid })
    x5on.postForm({
      url: x5on.url.myadjustexqrcode,
      data: { grade_stud_uid },
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

    wx.scanCode({
      onlyFromCamera: true,
      success: (res) => {
        console.log(res)
        var exchange_grade_stud_uid = res.result
        var move_grade_stud_uid = that.data.grade_stud_uid

        console.log(exchange_grade_stud_uid)
        console.log(move_grade_stud_uid)

        x5on.postForm({
          url: x5on.url.myadjuststudexchange,
          data: { move_grade_stud_uid, exchange_grade_stud_uid },
          success: function (result) {
            var studmoves = result.data.studmoves
            var studmoveds = result.data.studmoveds
            prevPage.setData({ studmoves, studmoveds })
            //
            wx.navigateBack()
          }
        })
      }
    })
  }

})