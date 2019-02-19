// pages/index/mysameset.js
var x5on = require('../x5on.js')

Page({

  data: {
    grades: [],
    classes: [],
    students: []
  },

  onLoad: function (options) {
    var that = this
    x5on.request({
      url: x5on.url.mysameset,
      success: function (result) {
        // 年级列表
        that.setData(result.data)
      }
    })
  },

  gradeChange: function (e) {
    var that = this
    var gradeIndex = e.detail.value
    var classIndex = -1
    var students = []
    that.setData({ gradeIndex, classIndex, students })

    // 班级列表
    var grade_id = this.data.grades[gradeIndex].id
    x5on.post({
      url: x5on.url.mysamesetclass,
      data: { grade_id },
      success: function (result) {
        var classes = result.data
        that.setData({ classes })
      }
    })
  },

  classChange: function (e) {
    var that = this
    var classIndex = e.detail.value
    if (classIndex == -1) return
    that.setData({ classIndex })

    // 学生列表
    var cls_id = this.data.classes[classIndex].id
    x5on.post({
      url: x5on.url.mysamesetstudent,
      data: { cls_id },
      success: function (result) {
        var students = result.data
        that.setData({ students })
      }
    })
  },

  samesetSubmit: function (e) {
    var that = this
    x5on.post({
      url: x5on.url.mysamesetstudentupdate,
      data: e.detail.value,
      success: function (result) {
        x5on.showSuccess('更新' + result.data + '条记录')
      }
    })
  },

})