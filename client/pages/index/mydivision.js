// pages/index/mydivision.js
var x5on = require('../x5on.js')

Page({

  data: {
    errorMessage: '错误提示',
    errorArray: [1],

    grades: []
  },

  onLoad: function (options) {
    var that = this
    x5on.request({
      url: x5on.url.mydivision,
      success: function (result) {
        // 年级列表
        that.setData(result.data)
      }
    })
  },

  gradeChange: function (e) {
    var that = this
    var gradeIndex = e.detail.value
    if (gradeIndex == -1) return

    that.setData({ gradeIndex })

    // 班级列表
    var grade_id = this.data.grades[gradeIndex].id
    x5on.postForm({
      url: x5on.url.mydivisionclass,
      data: { grade_id },
      success: function (result) {
        var classes = result.data
        that.setData({ classes })
      }
    })
  },

  classChange: function (e) {
    var that = this
    var values = e.detail.value
    var classes = that.data.classes
    classes.forEach(function (item) {
      item.checked = false
      for (var i = 0; i < values.length; i++) {
        if (item.id == values[i]) {
          item.checked = true
          break
        }
      }
    })
    that.setData({ classes })
  },

})