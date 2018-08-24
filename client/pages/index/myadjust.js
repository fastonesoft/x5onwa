// pages/index/myadjust.js
var x5on = require('../x5on.js')

Page({

  data: {
    errorMessage: '错误提示',
    errorArray: [1],

    grades: [],
    classes: [],
    grade_stud_uid: '',
  },

  onLoad: function (options) {
    var that = this
    x5on.request({
      url: x5on.url.myadjust,
      success: function (result) {
        // 年级列表
        that.setData(result.data)
      }
    })
  },

  gradeChange: function (e) {
    var that = this
    var students = []
    var classIndex = -1
    var gradeIndex = e.detail.value
    that.setData({ gradeIndex, classIndex, students })

    // 分管班级列表
    var grades = that.data.grades
    var grade_id = grades[gradeIndex].id
    x5on.postFormEx({
      url: x5on.url.myadjustclass,
      data: { grade_id },
      success: (result) => {
        var classes = result.data.classes
        that.setData({ classes })
      }
    })
  },

  checkInput: function (e) {
    x5on.checkInput(e, this)
  },

  findSubmit: function (e) {
    var that = this
    var grades = this.data.grades
    var classes = this.data.classes
    var gradeIndex = this.data.gradeIndex
    var classIndex = this.data.classIndex
    if (!gradeIndex || !classIndex || classIndex == -1 || gradeIndex == -1) {
      x5on.showError(that, '年级选择、目标班级不得为空')
      return
    }

    var grade_id = grades[gradeIndex].id
    var stud_name = e.detail.value.stud_name
    x5on.checkForm(that, 0, 0, function () {
      x5on.postFormEx({
        url: x5on.url.myadjuststudent,
        data: { grade_id, stud_name },
        success: (result) => {
          var students = result.data
          that.setData({ students })
          if (students.length === 0) {
            x5on.showError(that, '没有找到你说的学生！')
          }
        }
      })
    })

  },

  classChange: function (e) {
    var classIndex = e.detail.value
    this.setData({ classIndex })
  },

  studentChange: function (e) {
    var that = this
    var students = this.data.students
    for (var index = 0; index < students.length; index++) {
      var item = students[index]
      item.checked = item.grade_stud_uid === e.detail.value
      if (item.checked) {
        var cls_id = item.cls_id
        var classes = that.data.classes
        var classIndex = that.data.classIndex
        var localcls_id = classes[classIndex].cls_id

        if (cls_id === localcls_id) {
          var grade_stud_uid = item.grade_stud_uid
          that.setData({ grade_stud_uid })
        } else {
          var grade_stud_uid = ''
          that.setData({ grade_stud_uid })
        }
      }
    }
    this.setData({ students })
  },

  studmoveSubmit: function (e) {
    var that = this
    var classIndex = this.data.classIndex
    var grade_stud_uid = e.detail.value.grade_stud_uid
    if (!classIndex || classIndex == -1 || !grade_stud_uid) {
      x5on.showError(that, '目标班级、调动学生必须设置！')
      return
    }
    var cls_id = this.data.classes[classIndex].cls_id
    x5on.postFormEx({
      url: x5on.url.myadjuststudmove,
      data: { grade_stud_uid, cls_id },
      success: (result) => {
        var students = []
        that.setData({ studmoves, studchanges })
        x5on.showSuccess('调动' + result.data + '个学生')
      }
    })
  },

  localtap: function (e) {
    var that = this
    var grade_stud_uid = this.data.grade_stud_uid
    if (grade_stud_uid.length == 0) {
      x5on.showError(that, '不是同班学生选择，无法提交')
      return
    }
    x5on.postFormEx({
      url: x5on.url.myadjuststudlocal,
      data: { grade_stud_uid },
      success: result => {
        grade_stud_uid = ''
        var students = []
        that.setData({ grade_stud_uid, students })
        x5on.showSuccess('标识' + result.data + '个学生')
      }
    })
  },

})