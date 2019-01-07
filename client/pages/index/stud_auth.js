// pages/index/stud_auth.js
var x5on = require('../x5on.js')

Page({

  data: {

  },

  onLoad: function (e) {
    var that = this
    var uid = e.uid
    x5on.postFormEx({
      url: x5on.url.gradestuduid,
      data: { uid },
      success: (result) => {
        var student = result.data
        that.setData({ student })
      }
    })
  },

  studauthSubmit: function (e) {
    var that = this
    e.detail.value.uid = that.data.student.uid
    x5on.postFormEx({
      url: x5on.url.gradestudauth,
      data: e.detail.value,
      success: (result) => {
        var pages = getCurrentPages()
        var prevPage = pages[pages.length - 2]
        // 更新上一页数据
        var students = result.data
        prevPage.setData({ students })
        // 
        wx.navigateBack()
      }
    })
  },

})