// pages/index/stud_move.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    var pages = getCurrentPages();
    var prevPage = pages[pages.length - 2]
    var classes = prevPage.data.classes
    var classIndex = prevPage.data.classIndex
    that.setData({ classes, classIndex })

    x5on.postFormEx({
      url: x5on.url.gradestuduid,
      data: e,
      success: student => {
        that.setData({ uid: e.uid, student })
      }
    })
  },

  classChange: function (e) {
    var classIndex = e.detail.value
    this.setData({ classIndex })
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
      success: students => {
        var pages = getCurrentPages()
        var prevPage = pages[pages.length - 2]
        prevPage.setData({ students })
        // 
        wx.navigateBack()
      }
    })
  },

})