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
    x5on.requestEx({
      url: x5on.url.gradestudgrade,
      success: grades => {
        that.setData({ grades })
      }
    })
  },

  getGradeid: function () {
    var grades = this.data.grades
    var gradeIndex = this.data.gradeIndex
    if (grades && grades.length>0 && gradeIndex && gradeIndex>-1) {
      return grades[gradeIndex].id
    }
    return null
  },

  getClsid: function () {
    var classes = this.data.classes
    var classIndex = this.data.classIndex
    if (classes && classes.length>0 && classIndex && classIndex>-1) {
      return classes[classIndex].id
    }
    return null
  },

  gradeChange: function (e) {
    var that = this
    var students = []
    var classIndex = -1
    var gradeIndex = e.detail.value
    var comeshow = false
    that.setData({ gradeIndex, classIndex, students, comeshow })
    //
    var grade_id = that.getGradeid()
    x5on.postFormEx({
      url: x5on.url.gradestudclass,
      data: { grade_id },
      success: classes => {
        that.setData({ classes })
      }
    })
  },

  classChange: function (e) {
    var that = this
    x5on.pickChange(e, classIndex => {
      that.setData({ classIndex })
      // 
      var cls_id = that.getClsid()
      var grade_id = that.getGradeid()
      x5on.postFormEx({
        url: x5on.url.gradestudcls,
        data: { grade_id, cls_id },
        success: students => {
          var comeshow = students.length !== 0
          that.setData({ students, comeshow })
        }
      })
    })
  },

  findSubmit: function (e) {
    var that = this
    that.x5va = new x5va({
      stud_name: {
        required: true,
        chinese: true,
        rangelength: [1, 3],
      }
    }, {
        stud_name: {
          required: '学生姓名'
        }
    })
    that.x5va.checkForm(e, function (form) {
      form.cls_id = that.getClsid()
      form.grade_id = that.getGradeid()
      x5on.postFormEx({
        url: x5on.url.gradestudquery,
        data: form,
        success: students => {
          var comeshow = students.length !== 0
          that.setData({ students, comeshow })
        }
      })
    }, function (error) {
      x5on.showError(that, error)
    })
  },

  studentsChange: function (e) {
    x5on.setRadio(this.data.students, e.detail.value, students => {
      this.setData({ students })
    })
  },

  studentClick: function (e) {
    wx.navigateTo({
      url: 'student?uid=' + e.currentTarget.dataset.uid,
      success: () => {
      }
    })
  },

  // 添加
  studaddClick: function (event) {
    wx.navigateTo({ url: 'stud_add' })
  },

  // 修改
  studmodiClick: function (event) {
    var that = this
    x5on.getRadio(this.data.students, res => {
      wx.navigateTo({ url: 'stud_modi?uid=' + res.uid })
    }, () => {
      x5on.showError(that, '没有选中相关学生')
    })
  },

  // 指标
  studauthClick: function (event) {
    var that = this
    x5on.getRadio(this.data.students, res => {
      wx.navigateTo({ url: 'stud_auth?uid=' + res.uid })
    }, () => {
      x5on.showError(that, '没有选中相关学生')
    })
  },

  // 转入
  studcomeClick: function (e) {
    wx.navigateTo({ url: 'stud_come' })
  },

  // 调动
  studmoveClick: function (e) {
    var that = this
    x5on.getRadio(this.data.students, res => {
      wx.navigateTo({ url: 'stud_move?uid=' + res.uid })
    }, () => {
      x5on.showError(that, '没有选中相关学生')
    })
  },

  // 跳级
  studjumpClick: function (e) {
    x5on.getRadio(this.data.students, res => {
      console.log(res)
    }, () => {
      console.log('error')
    })
    // wx.navigateTo({ url: 'stud_jump' })
  },

  // 复学
  studreturnClick: function (e) {
    var that = this
    var grade_id = that.getGradeid()
    if (grade_id) {
      var stud_status_id = 6
      var form = { grade_id, stud_status_id }
      x5on.postFormEx({
        url: x5on.url.gradestudtask,
        data: form,
        success: tasks => {
          if (tasks.length === 0) return
          wx.navigateTo({ url: 'stud_return?tasks=' + JSON.stringify(tasks) })
        }
      })
    } else {
      x5on.showError(that, '没有选中相关学生')
    }
  },

  // 重读
  studrepetClick: function (e) {
    wx.navigateTo({ url: 'stud_repetition' })
  },

  // 借读
  studreadClick: function (e) {
    wx.navigateTo({ url: 'stud_read' })
  },

  // 休学
  studdownClick: function (e) {
    var that = this
    x5on.getRadio(this.data.students, res => {
      wx.navigateTo({ url: 'stud_down?uid=' + res.uid })
    }, () => {
      x5on.showError(that, '没有选中相关学生')
    })
  },

  // 转出
  studleaveClick: function (e) {
    wx.navigateTo({ url: 'stud_leave' })
  },

  // 离校
  studoutClick: function (e) {
    wx.navigateTo({ url: 'stud_out' })
  },
})