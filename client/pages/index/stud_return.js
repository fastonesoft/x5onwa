// pages/index/stud_return.js
var x5on = require('../x5on.js')

Page({

  data: {
    tasks: [],
  },

  onLoad: function(e) {
    var tasks = JSON.parse(e.tasks)
    this.setData({ tasks })
  },

  gradeChange: function(e) {
    var that = this
    var students = []
    var classIndex = -1
    var gradeIndex = e.detail.value
    that.setData({ gradeIndex, classIndex, students })
    //
    var grades = that.data.grades
    var grade_id = grades[gradeIndex].id
    x5on.postFormEx({
      url: x5on.url.gradestudclass,
      data: { grade_id },
      success: classes => {
        that.setData({ classes })
      }
    })
  },

  classChange: function(e) {
    var that = this
    var classes = that.data.classes
    var classIndex = e.detail.value
    if (classes.length == 0 || classIndex == -1) return
    that.setData({ classIndex })

    var grades = that.data.grades
    var gradeIndex = that.data.gradeIndex
    var cls_id = classes[classIndex].id
    var grade_id = grades[gradeIndex].id
    x5on.postFormEx({
      url: x5on.url.gradestudcls,
      data: { grade_id, cls_id },
      success: (result) => {
        var students = result.data
        that.setData({ students })
      }
    })
  },

  studreturnSubmit: function (e) {

  },

})