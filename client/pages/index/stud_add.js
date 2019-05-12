// pages/index/stud_add.js
var x5on = require('../x5on.js')

Page({

  studaddSubmit: function (e) {
    var that = this
    var rules = {
      stud_name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      },
      stud_idc: {
        required: true,
        idcard: true,
        idcardrange: [7, 18],
      },
      come_date: {
        required: true,
        date: true,
      },
      stud_auth: {
        required: true,
      }
    }
    var messages = {
      stud_name: {
        required: '学生姓名'
      },
      stud_idc: {
        required: '身份证号'
      },
      come_date: {
        required: '转学时间'
      },
      memo: {
        required: '转出学校'
      },
    }
    x5on.checkForm(e, rules, messages, form => {
      var pages = getCurrentPages()
      var prevPage = pages[pages.length - 2]
      form.grade_id = prevPage.getGradeid()
      form.cls_id = prevPage.getClsid()

      form.stud_type_id = 1
      form.stud_status_id = 1

      x5on.post({
        url: x5on.url.gradestudadd,
        data: form,
        success: students => {
          prevPage.setData({ students })
          wx.navigateBack()
        }
      })
    }, error => {
      x5on.showError(error)
    })
  }

})