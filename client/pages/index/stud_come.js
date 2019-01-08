// pages/index/stud_come.js
var x5on = require('../x5on.js')
import x5va from '../x5va.js'

Page({

  data: {
    trans: [{ id: 0, name: '区县' }, { id: 1, name: '跨市' }, { id: 2, name: '跨省'}]
  },

  transChange: function (e) {
    var that = this
    var stud_trans = e.detail.value
    that.setData({ stud_trans })
  },

  studcomeSubmit: function (e) {
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
      stud_trans: {
        required: true,
        min: 0,
      },
      stud_auth: {
        required: true,
      }
    }, {
        stud_idc: {
          required: '身份证号'
        },
        stud_name: {
          required: '学生姓名'
        },
        come_date: {
          required: '转学时间'
        },
        memo: {
          required: '转出学校'
        },
        stud_trans: {
          required: '转入方式'
        }
    })

    that.x5va.checkForm(e, function (form) {
      var pages = getCurrentPages()
      var prevPage = pages[pages.length - 2]
      var grades = prevPage.data.grades
      var gradeIndex = prevPage.data.gradeIndex
      var grade_id = grades[gradeIndex].id
      var classes = prevPage.data.classes
      var classIndex = prevPage.data.classIndex
      var cls_id = classes[classIndex].id

      var stud_trans = that.data.stud_trans
      var trans = that.data.trans
      form.stud_type_id = 1
      form.stud_status_id = 3
      form.stud_trans_name = trans[stud_trans].name
      form.grade_id = grade_id
      form.cls_id = cls_id

      console.log(form)
      x5on.postFormEx({
        url: x5on.url.gradestudcome,
        data: form,
        success: (result) => {
          var students = result.data
          prevPage.setData({ students })
          // 
          wx.navigateBack()
        }
      })
    }, function (error) {
      x5on.showError(that, error)
    })
  },

})