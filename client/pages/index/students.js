// pages/index/students.js
var x5on = require('../x5on.js')
import x5va from '../x5va.js'

Page({

  data: {
    students: [],
  },

  onLoad: function (options) {
    var that = this
    x5on.request({
      url: x5on.url.gradestudgrade,
      success: function (result) {
        var grades = result.data
        that.setData({ grades })
      }
    })
  },

  gradeChange: function (e) {
    var that = this
    var students = []
    var classIndex = -1
    var gradeIndex = e.detail.value
    that.setData({ gradeIndex, classIndex, students })
    //
    var grades = that.data.grades
    var grade_id = grades[gradeIndex].id
    x5on.postFormEx({
      url: x5on.url.gradestudclass,
      data: { grade_id },
      success: (result) => {
        var classes = result.data
        that.setData({ classes })
      }
    })
  },

  classChange: function (e) {
    var that = this
    var students = []
    var classIndex = e.detail.value
    that.setData({ classIndex, students })
  },

  findSubmit: function (e) {
    var that = this
    that.x5va = new x5va({
      stud_name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      },
    })
    that.x5va.checkForm(e, function (form) {
      var grades = that.data.grades
      var classes = that.data.classes
      var gradeIndex = that.data.gradeIndex
      var classIndex = that.data.classIndex
      var cls_id = classIndex && classIndex != -1 ? classes[classIndex].id : ''
      var grade_id = gradeIndex && gradeIndex != -1 ? grades[gradeIndex].id : ''

      var cls_id = cls_id
      var grade_id = grade_id
      var stud_name = form.stud_name.viewValue
      x5on.postFormEx({
        url: x5on.url.gradestudquery,
        data: { grade_id, cls_id, stud_name },
        success: (result) => {
          var students = result.data
          that.setData({ students })
        }
      })
    }, function (error) {
      x5on.showError(that, error)
    })
  },

})