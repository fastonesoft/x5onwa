// pages/index/stud_return.js
var x5on = require('../x5on.js')

Page({

  data: {
    tasks: [],
    grades: [],
    classes: [],
  },

  onLoad: function (e) {
    var tasks = JSON.parse(e.tasks)
    this.setData({ tasks })

    var pages = getCurrentPages()
    var prevPage = pages[pages.length - 2]
    var grade_id = prevPage.getGradeid()

    x5on.post({
      url: x5on.url.gradestudgradesdown,
      data: { grade_id },
      success: grades => {
        this.setData({ grades })
      }
    })
  },

  gradeChange: function (e) {
    x5on.pickChange(e, gradeIndex => {
      var classIndex = 0
      this.setData({ gradeIndex, classIndex })
      //
      var grade_id = x5on.getId(this.data.grades, gradeIndex)
      x5on.post({
        url: x5on.url.gradestudclass,
        data: { grade_id },
        success: classes => {
          this.setData({ classes })
        }
      })
    })
  },

  classChange: function (e) {
    x5on.pickChange(e, classIndex => {
      this.setData({ classIndex })
    })
  },

  studentsChange: function (e) {
    x5on.setRadio(this.data.tasks, e.detail.value, tasks => {
      this.setData({ tasks })
    })
  },

  studentClick: function (e) {
    var task_memo = e.currentTarget.dataset.task_memo
    var memos = JSON.parse(task_memo)
    this.setData({ memos })
  },

  studreturnSubmit: function (e) {
    var that = this
    var rules = {
      task_uid: {
        required: true,
      },
      grade_id: {
        required: true,
      },
      cls_id: {
        required: true,
      },
    }
    var messages = {
      task_uid: {
        required: '学生列表'
      },
      grade_id: {
        required: '目标年级'
      },
      cls_id: {
        required: '目标班级'
      },
    }
    x5on.checkForm(e, rules, messages, form => {
      form.cls_id = x5on.getId(that.data.classes, form.cls_id)
      form.grade_id = x5on.getId(that.data.grades, form.grade_id)

      x5on.post({
        url: x5on.url.gradestudreturns,
        data: form,
        success: students => {
          var pages = getCurrentPages()
          var prevPage = pages[pages.length - 2]
          //
          var male = 0, female = 0
          students.forEach(student => {
            student.stud_sex_num ? male++ : female++
          })
          var comeshow = students.length !== 0
          prevPage.setData({ students, comeshow, male, female })
          // 
          wx.navigateBack()
        }
      })
    }, message => {
      x5on.showError(message)
    })
  },

})