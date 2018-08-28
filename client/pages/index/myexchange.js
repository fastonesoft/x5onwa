// pages/index/myexchange.js
var x5on = require('../x5on.js')

Page({

  data: {
    godown: false,
    samesex: true,
    btn_show: false,
  },

  onLoad: function (options) {
  
  },

  scanSubmit: function (e) {
    var that = this
    var godown = e.detail.value.godown
    var samesex = e.detail.value.samesex
    var btn_show = false
    var students = []
    that.setData({ btn_show, students })

    wx.scanCode({
      onlyFromCamera: true,
      success: (res) => {
        var move_grade_stud_uid = res.result
        that.setData({ move_grade_stud_uid })

        x5on.postForm({
          url: x5on.url.myadjuststudscanmove,
          data: { move_grade_stud_uid, godown, samesex },
          success: function (result) {
            var students = result.data
            that.setData({ students })
          }
        })
      }
    })
  },


  studentChange: function (e) {
    var that = this
    var students = this.data.students

    for (var index = 0; index < students.length; index++) {
      var item = students[index]
      var grade_stud_uid = e.detail.value
      item.checked = item.uid === e.detail.value
    }
    this.setData({ students })
  },

  exchangeSubmit: function (e) {
    var that = this
    var grade_stud_uid = e.detail.value.grade_stud_uid
    var exchange_grade_stud_uid = this.data.move_grade_stud_uid
    x5on.postForm({
      url: x5on.url.myadjuststudqrcode,
      data: { grade_stud_uid, exchange_grade_stud_uid },
      success: function (result) {
        var btn_show = true
        var qrcode_data = result.data
        var students = []
        that.setData({ btn_show, qrcode_data, students })
      }
    })
  },

})