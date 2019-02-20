// pages/index/student.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (param) {
    console.log(param)
    var that = this
    x5on.post({
      url: x5on.url.student,
      data: param,
      success(studinfor) {
        that.setData(studinfor)
      }
    })
  },

  returnClick: function (e) {
    wx.navigateBack()
  }

})