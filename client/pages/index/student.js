// pages/index/student.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.post({
      url: x5on.url.gradestuduid,
      data: e,
      success: student => {
        var canshow = true
        that.setData({ student, canshow })
      }
    })
  },

  returnClick: function (e) {
    wx.navigateBack()
  }

})