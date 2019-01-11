// pages/index/stud_repetition.js
var x5on = require('../x5on.js')
import x5va from '../x5va.js'

Page({

  studrepetitionSubmit: function (e) {
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
      memo: {
        required: true,
        chinese: true,
        minlength: 4,
      },
    }, {
        stud_name: {
          required: '学生姓名'
        },
        stud_idc: {
          required: '身份证号'
        },
        come_date: {
          required: '进校时间'
        },
        memo: {
          required: '毕业学校'
        },
      })

    that.x5va.checkForm(e, function (form) {
      var pages = getCurrentPages()
      var prevPage = pages[pages.length - 2]
      var grade_id = prevPage.getGradeid()
      var cls_id = prevPage.getClsid()

      form.stud_type_id = 2
      form.stud_status_id = 5
      form.stud_auth = 0
      form.grade_id = grade_id
      form.cls_id = cls_id

      x5on.postFormEx({
        url: x5on.url.gradestudrepet,
        data: form,
        success: students => {
          prevPage.setData({ students })
          wx.navigateBack()
        }
      })
    }, function (error) {
      x5on.showError(that, error)
    })
  },
})