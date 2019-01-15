// pages/index/stud_down.js
var x5on = require('../x5on.js')
import x5va from '../x5va.js'

Page({

  onLoad: function (e) {
    var that = this
    x5on.postFormEx({
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

    that.x5va.checkForm(e, function (task_memo) {
      var student = that.data.student
      var form = {}
      form.stud_id = student.stud_id
      form.year_id = student.year_id
      form.sch_id = student.sch_id
      form.grade_id = student.grade_id
      form.cls_id = student.cls_id
      form.stud_status_id = student.stud_status_id
      form.task_memo = task_memo

      x5on.postFormEx({
        url: x5on.url.gradestuddown,
        data: form,
        success: students => {
          that.setData({ students })
        }
      })
    }, function (error) {
      x5on.showError(that, error)
    })
  },

})