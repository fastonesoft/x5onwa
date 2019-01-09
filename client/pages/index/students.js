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

  getGradeid: function () {
    var grades = this.data.grades
    var gradeIndex = this.data.gradeIndex
    if (grades.length>0 && gradeIndex && gradeIndex>-1) {
      return grades[gradeIndex].id
    }
    return null
  },

  getClsid: function () {
    var classes = this.data.classes
    var classIndex = this.data.classIndex
    if (classes.length>0 && classIndex && classIndex>-1) {
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

    var cls_id = that.getClsid()
    var grade_id = that.getGradeid()
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
    x5on.setChecked(students, uid, )
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

  // 添加
  studaddClick: function (event) {
    wx.navigateTo({ url: 'stud_add' })
  },

  // 修改
  studmodiClick: function (event) {
    var that = this
    var students = this.data.students
    x5on.getChecked(students, res => {
      var uid = res.uid;
      wx.navigateTo({ url: 'stud_modi?uid=' + uid })
    }, () => {
      x5on.showError(that, '没有选中相关学生')
    })
  },

  // 指标
  studauthClick: function (event) {
    var that = this
    var students = this.data.students
    x5on.getChecked(students, res => {
      var uid = res.uid;
      wx.navigateTo({ url: 'stud_auth?uid=' + uid })
    }, () => {
      x5on.showError(that, '没有选中相关学生')
    })
  },

  // 调动
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

  // 复学
  studreturnClick: function (e) {
    wx.navigateTo({ url: 'stud_return' })
  },
  
  // 跳级
  studjumpClick: function (e) {
    wx.navigateTo({ url: 'stud_jump' })
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
    wx.navigateTo({ url: 'stud_down' })
  },

  // 转入
  studcomeClick: function (e) {
    wx.navigateTo({ url: 'stud_come' })
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