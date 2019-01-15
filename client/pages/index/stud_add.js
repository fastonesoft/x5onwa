// pages/index/stud_add.js
var x5on = require('../x5on.js')
import x5va from '../x5va.js'

Page({

  studaddSubmit: function (e) {
    var that = this
    that.x5va = new x5va({
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
    }, {
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
    })
    that.x5va.checkForm(e, form => {
      var pages = getCurrentPages()
      var prevPage = pages[pages.length - 2]
      form.grade_id = prevPage.getGradeid()
      form.cls_id = prevPage.getClsid()

      form.stud_type_id = 1
      form.stud_status_id = 1

      x5on.postFormEx({
        url: x5on.url.gradestudadd,
        data: form,
        success: students => {
          prevPage.setData({ students })
          wx.navigateBack()
        }
      })
    }, error => {
      x5on.showError(that, error)
    })
  }

})