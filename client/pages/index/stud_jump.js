// pages/index/stud_jump.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (options) {
    var that = this
    x5on.request({
      url: x5on.url.gradestudgrade,
      success: function (result) {
        var grades = result.data
        that.setData({ grades })
      }
    })
  },

  gradeChange: function (e) {
    var that = this
    var classIndex = -1
    var gradeIndex = e.detail.value
    that.setData({ gradeIndex, classIndex })
    //
    var grades = that.data.grades
    var grade_id = grades[gradeIndex].id
    x5on.postForm({
      url: x5on.url.gradestudclass,
      data: { grade_id },
      success: (result) => {
        var classes = result.data
        that.setData({ classes })
      }
    })
  },

  classChange: function (e) {
    var that = this
    var classes = that.data.classes
    var classIndex = e.detail.value
    if (classes.length == 0 || classIndex == -1) return
    that.setData({ classIndex })

    var grades = that.data.grades
    var gradeIndex = that.data.gradeIndex
    var cls_id = classes[classIndex].id
    var grade_id = grades[gradeIndex].id
    x5on.postForm({
      url: x5on.url.gradestudcls,
      data: { grade_id, cls_id },
      success: (result) => {
        var students = result.data
        that.setData({ students })
      }
    })
  },

  studjumpSubmit: function (e) {

  },

})