// pages/index/students.js
var x5on = require('../x5on.js')
import x5va from '../x5va.js'

Page({

  data: {
    grades: [],
    classes: [],
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
    var comeshow = false
    that.setData({ gradeIndex, classIndex, students, comeshow })
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
    var classes = that.data.classes
    var classIndex = e.detail.value
    if (classes.length==0 || classIndex==-1) return
    var comeshow = true
    that.setData({ classIndex, comeshow })

    var grades = that.data.grades
    var gradeIndex = that.data.gradeIndex
    var cls_id = classes[classIndex].id
    var grade_id = grades[gradeIndex].id
    x5on.postFormEx({
      url: x5on.url.gradestudcls,
      data: { grade_id, cls_id },
      success: (result) => {
        var students = result.data
        that.setData({ students })
      }
    })

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

  studentsChange: function (e) {
    var that = this
    var uid = e.detail.value
    var students = this.data.students
    for (var i = 0; i < students.length; i++) {
      var item = students[i]
      item.checked = item.uid === uid
    }
    this.setData({ students })

  },

  studentClick: function (e) {
    var uid = e.currentTarget.dataset.uid
    // 跳转信息查询
    wx.navigateTo({
      url: 'student?uid=' + uid,
      success: () => {

      }
    })
  },

  // 正常添加
  studaddClick: function (event) {
    wx.navigateTo({ url: 'stud_add' })
  },

  // 学生调动
  studmoveClick: function (e) {
    var that = this
    // 检测是否有选择的学生
    var uid;
    var students = this.data.students
    for (var i=0; i<students.length; i++) {
      var item = students[i]
      if (item.checked) {
        uid = item.uid
        break
      }
    }
    if (uid) {
      wx.navigateTo({ url: 'stud_move?uid=' + uid })
    } else {
      x5on.showError(that, '没有选中相关学生')
    }
  },
  
})