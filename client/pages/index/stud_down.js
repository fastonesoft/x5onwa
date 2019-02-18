// pages/index/stud_down.js
var x5on = require('../x5on.js')
import x5va from '../x5va.js'

Page({

  onLoad: function (e) {
    var that = this
    x5on.postForm({
      url: x5on.url.gradestuduid,
      data: e,
      success: student => {
        that.setData({ student })
      }
    })
  },

  studdownSubmit: function (e) {
    var that = this
    that.x5va = new x5va({
      down_date: {
        required: true,
        date: true,
      },
      end_date: {
        required: true,
        date: true,
      },
      down_reason: {
        required: true,
        chinese: true,
        rangelength: [2, 10],
      },
      teach_name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      },
    }, {
        down_date: {
          required: '休学时间'
        },
        end_date: {
          required: '结束时间'
        },
        down_reason: {
          required: '休学理由'
        },
        teach_name: {
          required: '班主任姓名'
        },
      })

    that.x5va.checkForm(e, task_memo => {
      var form = {}
      form.grade_stud_id = that.data.student.id
      form.stud_status_id = that.data.student.stud_status_id
      form.task_status_id = x5on.data.status_down
      form.task_memo = JSON.stringify(task_memo)

      x5on.postForm({
        url: x5on.url.gradestuddown,
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
    }, error => {
      x5on.showError(that, error)
    })
  },

})