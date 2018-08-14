// pages/index/myrename.js
var x5on = require('../x5on.js')

Page({

  data: {
    grades: [],
    classes: [],
  },

  onLoad: function (options) {
    var that = this
    x5on.request({
      url: x5on.url.myrename,
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
    that.setData({ gradeIndex, classIndex })

    // 班级列表
    var grade_id = this.data.grades[gradeIndex].id
    x5on.postForm({
      url: x5on.url.myrenameclass,
      data: { grade_id },
      success: function (result) {
        var classes = result.data
        that.setData({ classes })
      }
    })
  },

  checkInput: function (e) {
    x5on.checkInput(e, this)
  },

})