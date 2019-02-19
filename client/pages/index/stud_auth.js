// pages/index/stud_auth.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.post({
      url: x5on.url.gradestuduid,
      data: e,
      success: student => {
        that.setData({ student })
      }
    })
  },

  studauthSubmit: function (e) {
    var that = this
    e.detail.value.uid = that.data.student.uid
    x5on.post({
      url: x5on.url.gradestudauth,
      data: e.detail.value,
      success: students => {
        var pages = getCurrentPages()
        var prevPage = pages[pages.length - 2]
        //
        var male = 0, female = 0
        students.forEach(student => {
          student.stud_sex_num ? male++ : female++
        })
        var comeshow = students.length !== 0
        prevPage.setData({ students, comeshow, male, female })
        // 
        wx.navigateBack()
      }
    })
  },

})