// pages/index/myadjust.js
var x5on = require('../x5on.js')

Page({

  data: {
    errorMessage: '错误提示',
    errorArray: [1],

    grades: [],
    classes: [],
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
    var students = []
    var classIndex = -1
    var gradeIndex = e.detail.value
    that.setData({ gradeIndex, classIndex, students })

    // 分管班级列表
    var grades = that.data.grades
    var grade_id = grades[gradeIndex].id
    x5on.postFormEx({
      url: x5on.url.myadjustclass,
      data: { grade_id },
      success: (result) => {
        var classes = result.data.classes
        that.setData({ classes })
      }
    })
  },

  checkInput: function (e) {
    x5on.checkInput(e, this)
  },

  findSubmit: function (e) {
    var that = this
    var grades = this.data.grades
    var gradeIndex = this.data.gradeIndex
    if (!gradeIndex) {
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

  classChange: function (e) {
    var classIndex = e.detail.value
    this.setData({ classIndex })
  },

  studentChange: function (e) {
    var students = this.data.students
    for (var index = 0; index < students.length; index++) {
      var item = students[index]
      item.checked = item.uid === e.detail.value
    }
    this.setData({ students })
  },

  studmoveSubmit: function (e) {
    var that = this
    var classIndex = this.data.classIndex
    var kao_stud_id = e.detail.value.kao_stud_id
    if (!classIndex || classIndex == -1 || !kao_stud_id) {
      x5on.showError(that, '目标班级、调动学生必须设置！')
      return
    }
    var cls_id = this.data.classes[classIndex].cls_id
    x5on.postFormEx({
      url: x5on.url.myadjuststudmove,
      data: { kao_stud_id, cls_id },
      success: (result) => {
        var students = []

        that.setData({ studmoves, studchanges })
        x5on.showSuccess('调动' + result.data + '个学生')
      }
    })
  }

})