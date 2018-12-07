// pages/index/stud_add.js
var x5on = require('../x5on.js')
import x5va from '../x5va.js'

Page({

  data: {
    stud_type: -1,
    stud_status: -1,
  },

  onLoad: function (e) {
    var that = this
    x5on.request({
      url: x5on.url.gradestudtype,
      success: function (result) {
        var types = result.data
        that.setData({ types })
      }
    })

    x5on.request({
      url: x5on.url.gradestudstatus,
      success: function (result) {
        var status = result.data
        that.setData({ status })
      }
    })
  },

  typeChange: function (e) {
    var that = this
    var stud_type = e.detail.value
    that.setData({ stud_type })
  },

  statuChange: function (e) {
    var that = this
    var stud_status = e.detail.value
    that.setData({ stud_status })
  },

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
      stud_type: {
        required: true,
        min: 0,
      },
      stud_status: {
        required: true,
        min: 0,
      },
      stud_auth: {
        required: true,
      }
    })
    that.x5va.checkForm(e, function (form) {
      var pages = getCurrentPages()
      var currPage = pages[pages.length - 1]
      var prevPage = pages[pages.length - 2]
      var grades = prevPage.data.grades
      var gradeIndex = prevPage.data.gradeIndex
      var grade_id = grades[gradeIndex].id
      var classes = prevPage.data.classes
      var classIndex = prevPage.data.classIndex
      var cls_id = classes[classIndex].id
      var stud_idc = form.stud_idc.viewValue
      var stud_name = form.stud_name.viewValue
      var come_date = form.come_date.viewValue
      var stud_type = form.stud_type.viewValue
      var stud_status = form.stud_status.viewValue
      var stud_auth = form.stud_auth.viewValue
      var types = that.data.types
      var status = that.data.status
      var stud_type_id = types[stud_type].id
      var stud_status_id = status[stud_status].id

      x5on.postFormEx({
        url: x5on.url.gradestudadd,
        data: { grade_id, cls_id, stud_idc, stud_name, come_date, stud_type_id, stud_status_id, stud_auth },
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

  }

})