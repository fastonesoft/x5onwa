// pages/index/stud_back.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var tasks = JSON.parse(e.tasks)
    this.setData({ tasks })

    var pages = getCurrentPages()
    var prevPage = pages[pages.length - 2]
    var grade_id = prevPage.getGradeid()

    x5on.post({
      url: x5on.url.gradestudclass,
      data: { grade_id },
      success: classes => {
        this.setData({ classes })
      }
    })
  },

  studentsChange: function (e) {
    var that = this
    x5on.setRadio(that.data.tasks, e.detail.value, tasks => {
      that.setData({ tasks })
      // 
      x5on.getRadio(that.data.tasks, task => {
        var classIndex = x5on.getIndex(that.data.classes, task.cls_id)
        that.setData({ classIndex })
      })
    })
  },

  studentClick: function (e) {
    var task_memo = e.currentTarget.dataset.task_memo
    var memos = JSON.parse(task_memo)
    this.setData({ memos })
  },

  classChange: function (e) {
    x5on.pickChange(e, classIndex => {
      this.setData({ classIndex })
    })
  },

  studbackSubmit: function (e) {
    var that = this
    var rules = {
      task_uid: {
        required: true,
      },
      cls_id: {
        required: true,
      },
    }
    var messages = {
      task_uid: {
        required: '学生选择'
      },
      cls_id: {
        required: '目标班级'
      },
    }
    x5on.checkForm(e, rules, messages, form => {
      form.cls_id = x5on.getId(that.data.classes, form.cls_id)

      x5on.post({
        url: x5on.url.gradestudback,
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