// pages/index/stud_move.js
var x5on = require('../x5on.js')

Page({

  data: {

  },

  onLoad: function (e) {
    var that = this
    var pages = getCurrentPages();
    var prevPage = pages[pages.length - 2]
    var classes = prevPage.data.classes
    var classIndex = prevPage.data.classIndex
    that.setData({ classes, classIndex })

    var uid = e.uid
    x5on.postFormEx({
      url: x5on.url.gradestuduid,
      data: { uid },
      success: (result) => {
        var student = result.data
        that.setData({ uid, student })
      }
    })
  },

  classChange: function (e) {
    var that = this
    var classes = that.data.classes
    var classIndex = e.detail.value
    that.setData({ classIndex })
  },

  studmoveSubmit: function (e) {
    var that = this
    var uid = that.data.uid
    var classes = that.data.classes
    var classIndex = e.detail.value.classIndex
    var cls_id = classes[classIndex].id

    x5on.postFormEx({
      url: x5on.url.gradestudmove,
      data: { uid, cls_id },
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