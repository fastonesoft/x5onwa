// pages/index/mydivisionset.js
var x5on = require('../x5on.js')

Page({

  data: {
    errorArray: [0, 0],
  },

  onLoad: function (e) {
    var that = this
    x5on.request({
      url: x5on.url.mydivisionset,
      success: function (result) {
        // 年级列表
        that.setData(result.data)
      }
    })
  },

  gradeChange: function (e) {
    var that = this
    var gradeIndex = e.detail.value
    that.setData({ gradeIndex })

    var grades = that.data.grades
    var grade_id = grades[gradeIndex].id
    x5on.postForm({
      url: x5on.url.mydivisionsetdata,
      data: { grade_id },
      success: (result) => {
        var sets = result.data
        that.setData({ sets })
      }
    })
  },

  checkInput: function (e) {
    x5on.checkInput(e, this);
  },

  mydivisionsetSubmit: function (e) {
    var that = this
    var grades = this.data.grades
    var gradeIndex = this.data.gradeIndex
    var data = e.detail.value
    data.grade_id = grades[gradeIndex].id

    x5on.postForm({
      url: x5on.url.mydivisionsetupdate,
      data: data,
      success: (result) => {
        var sets = {}
        that.setData({ sets })
      }
    })
  },

})