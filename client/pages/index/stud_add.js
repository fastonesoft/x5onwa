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
        idcardrange: [7, 19],
      },
      come_date: {
        required: true,
        date: true,
      }
    })
    that.x5va.checkForm(e, function (form) {
      var pages = getCurrentPages();
      var currPage = pages[pages.length - 1];
      var prevPage = pages[pages.length - 2];
      var grades = prevPage.data.grades
      var gradeIndex = prevPage.data.gradeIndex
      var grade_id = grades[gradeIndex].id
      var classes = prevPage.data.classes
      var classIndex = prevPage.data.classIndex
      var cls_id = classes[classIndex].id
      var stud_idc = form.stud_idc.viewValue
      var stud_name = form.stud_name.viewValue
      var come_date = form.come_date.viewValue

      x5on.postFormEx({
        url: x5on.url.gradestudadd,
        data: { grade_id, cls_id, stud_idc, stud_name, come_date },
        success: (result) => {
          console.log(result.data)
        }
      })

 

    }, function (error) {
      x5on.showError(that, error)
    })

  }

})