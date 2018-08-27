// pages/index/myexchange.js
var x5on = require('../x5on.js')

Page({

  data: {
    godown: false,
    samesex: true,
  },

  onLoad: function (options) {
  
  },

  scanSubmit: function (e) {
    var that = this
    var godown = e.detail.value.godown
    var samesex = e.detail.value.samesex

console.log(e)

    wx.scanCode({
      onlyFromCamera: true,
      success: (res) => {
        var move_grade_stud_uid = res.result
        x5on.postForm({
          url: x5on.url.myadjuststudscanmove,
          data: { move_grade_stud_uid, godown, samesex },
          success: function (result) {
            var students = result.data
            that.setData({ students })

          },
          fail: function (error) {
            var students = []
            that.setData({ students })
          }
        })
      }
    })
  },


  studentChange: function (e) {
    var that = this
    var students = this.data.students
    var btn_show = true
    that.setData({ btn_show })

    for (var index = 0; index < students.length; index++) {
      var item = students[index]
      item.checked = item.uid === e.detail.value
      if (item.checked) {

      }
    }
    this.setData({ students })
  },


})