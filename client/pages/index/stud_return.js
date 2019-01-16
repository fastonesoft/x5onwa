// pages/index/stud_return.js
var x5on = require('../x5on.js')

Page({

  data: {
    tasks: [],
    grades: [],
    classes: [],
  },

  onLoad: function(e) {
    var that = this
    var tasks = JSON.parse(e.tasks)
    this.setData({ tasks })

    var pages = getCurrentPages()
    var prevPage = pages[pages.length - 2]
    var grade_id = prevPage.getGradeid()

    x5on.postFormEx({
      url: x5on.url.gradestudgradedown,
      data: { grade_id },
      success: grades => {
        that.setData({ grades })
      }
    })
  },

  gradeChange: function(e) {
    var that = this
    var classIndex = -1
    var gradeIndex = e.detail.value
    that.setData({ gradeIndex, classIndex })
    //
    var grade_id = x5on.getId(this.data.grades, gradeIndex)
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
    var classIndex = e.detail.value
    if (classes.length == 0 || classIndex == -1) return
    that.setData({ classIndex })
  },

  studreturnSubmit: function (e) {

  },

})