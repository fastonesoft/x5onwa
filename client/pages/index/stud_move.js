// pages/index/stud_move.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.postFormEx({
      url: x5on.url.gradestuduid,
      data: e,
      success: student => {
        that.setData({ student })
        var cls_id = student.cls_id
        var grade_id = student.grade_id
        //
        x5on.postFormEx({
          url: x5on.url.gradestudclass,
          data: { grade_id },
          success: classes => {
            var classIndex = x5on.getIndex(classes, cls_id)
            that.setData({ classes, classIndex })
          }
        })
      }
    })
  },

  classChange: function (e) {
    var classIndex = e.detail.value
    this.setData({ classIndex })
  },

  studmoveSubmit: function (e) {
    var that = this
    var uid = that.data.student.uid
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