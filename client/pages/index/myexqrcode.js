// pages/index/myexqrcode.js
var x5on = require('../x5on.js')

Page({
  data: {
    student: [],
    exchangestuds: [],
  },

  onLoad: function (options) {
    var that = this
    var grade_stud_uid = options.uid
    that.setData({ grade_stud_uid })
    x5on.post({
      url: x5on.url.myadjustmovingqrcode,
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
        var exchange_grade_stud_uid = res.result
        var move_grade_stud_uid = that.data.grade_stud_uid

        x5on.post({
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
  },

  closeClick: function (e) {
    wx.navigateBack()
  },

  exchangeChange: function (e) {
    var that = this
    var exchangestuds = this.data.exchangestuds

    for (var index = 0; index < exchangestuds.length; index++) {
      var item = exchangestuds[index]
      var grade_stud_uid = e.detail.value
      item.checked = item.uid === e.detail.value
    }
    this.setData({ exchangestuds })
  },

  exchangeSubmit: function (e) {
    var that = this
    var pages = getCurrentPages();
    var currPage = pages[pages.length - 1];
    var prevPage = pages[pages.length - 2];

    var move_grade_stud_uid = that.data.grade_stud_uid
    var exchange_grade_stud_uid = e.detail.value.grade_stud_uid
    x5on.post({
      url: x5on.url.myadjuststudexchangeself,
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