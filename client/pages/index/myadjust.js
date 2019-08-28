// pages/index/myadjust.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this

    x5on.http(x5on.url.myadjust)
    .then(grades=>{
      that.setData({ grades })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  gradeChange: function (e) {
    var that = this

    x5on.http(x5on.url.myadjustcls, e.detail)
    .then(classes=>{
      that.setData({ classes })
    })
    .catch(error=>{
      x5on.showError(error)
    })

  },

  findSubmit: function (e) {
    var that = this
    var grades = this.data.grades
    var classes = this.data.classes
    var gradeIndex = this.data.gradeIndex
    var classIndex = this.data.classIndex
    if (!gradeIndex || !classIndex || classIndex == -1 || gradeIndex == -1) {
      x5on.showError('年级选择、目标班级不得为空')
      return
    }
    var btn_show = false
    that.setData({ btn_show })

    var grade_id = grades[gradeIndex].id
    var stud_name = e.detail.value.stud_name
    x5on.checkForm(that, 0, 0, function () {
      x5on.post({
        url: x5on.url.myadjuststudent,
        data: { grade_id, stud_name },
        success: (result) => {
          var students = result.data
          that.setData({ students })
          if (students.length === 0) {
            x5on.showError('没有找到你要的学生！')
          }
        }
      })
    })

  },

  classChange: function (e) {
    var that = this
    var classIndex = e.detail.value
    var students = []
    this.setData({ classIndex, students })
    if (!classIndex || classIndex == -1) {
      x5on.showError('目标班级、调动学生必须设置！')
      return
    }
    var cls_id = this.data.classes[classIndex].cls_id
    x5on.post({
      url: x5on.url.myadjustclassmove,
      data: { cls_id },
      success: (result) => {
        var studmoves = result.data.studmoves
        var studmoveds = result.data.studmoveds
        that.setData({ studmoves, studmoveds })
      }
    })

  },

  studentChange: function (e) {
    var that = this
    var students = this.data.students
    var btn_show = true
    that.setData({ btn_show })
    
    for (var index = 0; index < students.length; index++) {
      var item = students[index]
      item.checked = item.uid === e.detail.value
      if (item.checked) {
        var cls_id = item.cls_id
        var classes = that.data.classes
        var classIndex = that.data.classIndex
        var localcls_id = classes[classIndex].cls_id

        if (cls_id === localcls_id) {
          var grade_stud_uid = item.uid
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
      x5on.showError('目标班级、调动学生必须设置！')
      return
    }
    var cls_id = this.data.classes[classIndex].cls_id
    x5on.post({
      url: x5on.url.myadjuststudmove,
      data: { grade_stud_uid, cls_id },
      success: (result) => {
        var students = []
        var studmoves = result.data
        that.setData({ students, studmoves })
      }
    })
  },

  localtap: function (e) {
    var that = this
    var grade_stud_uid = this.data.grade_stud_uid
    if (grade_stud_uid.length == 0) {
      x5on.showError('不是同班学生选择，无法提交')
      return
    }
    x5on.post({
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

  myadjustRemove: function (e) {
    var that = this
    var studmoves = this.data.studmoves
    var grade_stud_uid = e.currentTarget.dataset.uid
    x5on.post({
      url: x5on.url.myadjuststudremove,
      data: { grade_stud_uid },
      success: result => {
        studmoves.forEach(function (item, index) {
          if (item.uid == grade_stud_uid) {
            studmoves.splice(index, 1)
          }
        })
        that.setData({ studmoves })
        x5on.showSuccess('删除' + result.data + '个调动')
      }
    })
  },

  showexchange: function (e) {
    var uid = e.currentTarget.dataset.uid
    wx.navigateTo({
      url: '/pages/index/myexqrcode?uid=' + uid,
    })
  },
})