// pages/index/student.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (param) {
    var that = this
    x5on.post({
      url: x5on.url.userchildstudent,
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