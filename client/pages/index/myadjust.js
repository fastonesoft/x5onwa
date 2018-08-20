// pages/index/myadjust.js
var x5on = require('../x5on.js')

Page({

  data: {
    errorMessage: '错误提示',
    errorArray: [1],
    
    gradeIndex: -1,
  },

  onLoad: function (options) {
    var that = this
    x5on.request({
      url: x5on.url.myadjust,
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
  },

  checkInput: function (e) {
    x5on.checkInput(e, this)
  },

  findSubmit: function (e) {
    var that = this
    var grades = this.data.grades
    var gradeIndex = this.data.gradeIndex
    if (gradeIndex == -1) {
      x5on.showError(that, '没有选择年级！')
      return
    }

    var grade_id = grades[gradeIndex].id
    var stud_name = e.detail.value.stud_name
    x5on.checkForm(that, 0, 0, function () {
      x5on.postFormEx({
        url: x5on.url.myadjuststudent,
        data: { grade_id, stud_name },
        success: (result) => {
          var students = result.data
          that.setData({ students })
          if (students.length === 0) {
            x5on.showError(that, '没有找到你说的学生！')
          }
        }
      })
    })

  },

})