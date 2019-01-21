// pages/index/stud_temp.js
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

  studtempSubmit: function (e) {
    var that = this
    that.x5va = new x5va({
      temp_date: {
        required: true,
        date: true,
      },
      temp_reason: {
        required: true,
        chinese: true,
        rangelength: [4, 10],
      },
    }, {
        temp_date: {
          required: '离校时间'
        },
        temp_reason: {
          required: '离校原因'
        },
      })
    that.x5va.checkForm(e, task_memo => {
      var form = {}
      form.id = that.data.student.id
      form.uid = that.data.student.uid
      form.task_memo = JSON.stringify(task_memo)
      
      x5on.postFormEx({
        url: x5on.url.gradestudtemp,
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
    }, function (error) {
      x5on.showError(that, error)
    })
  },

})