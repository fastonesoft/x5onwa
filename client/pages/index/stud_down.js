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

    that.x5va.checkForm(e, function (form) {
      var pages = getCurrentPages()
      var prevPage = pages[pages.length - 2]
      var student = this.data.student
      form.uid = student.uid
      form.grade_id = prevPage.getGradeid()
      form.cls_id = prevPage.getClsid()

      x5on.postFormEx({
        url: x5on.url.gradestudquery,
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