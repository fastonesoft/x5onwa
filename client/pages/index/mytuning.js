// pages/index/mytuning.js
var x5on = require('../x5on.js')

Page({
  
  data: {
    errorMessage: '错误提示',
    errorArray: [1],

    grades: [],
    classes: [],
    studmoves: [],
    studchanges: [],
    all: false,
    grade_stud_uid: '',
  },

  onLoad: function (options) {
    var that = this
    x5on.request({
      url: x5on.url.mytuning,
      success: function (result) {
        // 年级列表
        that.setData(result.data)
      }
    })
  },

  gradeChange: function (e) {
    var that = this
    var studmoves = []
    var studchanges = []
    var classIndex = -1
    var gradeIndex = e.detail.value
    that.setData({ gradeIndex, classIndex, studmoves, studchanges })

    // 班级列表
    var grade_id = this.data.grades[gradeIndex].id
    x5on.postForm({
      url: x5on.url.mytuningclass,
      data: { grade_id },
      success: function (result) {
        var classes = result.data
        that.setData({ classes })
      }
    })
  },

  classChange: function (e) {
    var studmoves = []
    var studchanges = []
    var classIndex = e.detail.value
    this.setData({ classIndex, studmoves, studchanges })
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
        url: x5on.url.mytuningstudmoves,
        data: { grade_id, stud_name },
        success: result => {
          var studmoves = result.data
          var studchanges = []
          var grade_stud_uid = ''
          that.setData({ studmoves, studchanges, grade_stud_uid })
          if (studmoves.length === 0) {
            x5on.showError(that, '没有找到你要的学生！')
          }
        }
      })
    })
  },

  switchtap: function (e) {
    var all = ! this.data.all
    var studchanges = []
    this.setData({ all, studchanges })
  },

  studmoveChange: function (e) {
    var that = this
    var studmoves = this.data.studmoves
    for (var index=0; index<studmoves.length; index++) {
      var item = studmoves[index]
      item.checked = item.uid === e.detail.value
      if (item.checked) {
        var cls_id = item.cls_id
        var classes = that.data.classes
        var classIndex = that.data.classIndex
        var localcls_id = classes[classIndex].id
        if ( cls_id === localcls_id ) {
          var studchanges = []
          var grade_stud_uid = item.uid
          that.setData({ studchanges, grade_stud_uid })
          continue
          // 同班，跳过下面代码，继续更新checked
        } else {
          var grade_stud_uid = ''
          that.setData({ grade_stud_uid })
        }
        var all = this.data.all
        var data = { value: item.value, cls_id: localcls_id, all }
        // 查询用于交换的本班学生
        x5on.postFormEx({
          url: x5on.url.mytuningstudchanges,
          data: data,
          success: result => {
            var studchanges = result.data
            that.setData({ studchanges })
          }
        })
        // break 不能跳出，要清除原先的真
      }
    }
    that.setData({ studmoves })
  },

  studchangeChange: function (e) {
    var that = this
    var values = e.detail.value
    var studchanges = that.data.studchanges
    studchanges.forEach(function (item) {
      item.checked = false
      for (var i=0; i<values.length; i++) {
        if (item.uid == values[i]) {
          item.checked = true
          break
        }
      }
    })
    that.setData({ studchanges })
  },

  mytuningSubmit: function (e) {
    var that = this
    var data = e.detail.value
    if (!data.movestud_uid || data.changestud_uids.length === 0) {
      x5on.showError(that, '选择调动、交换的学生')
      return
    }

    x5on.postFormEx({
      url: x5on.url.mytuningexchange,
      data: data,
      success: result => {
        var studmoves = []
        var studchanges = []
        that.setData({ studmoves, studchanges })
        x5on.showSuccess('调动' + result.data + '个学生')
      }
    })
  },

  localtap: function (e) {
    var that = this
    var grade_stud_uid = this.data.grade_stud_uid
    x5on.postFormEx({
      url: x5on.url.mytuninglocal,
      data: { grade_stud_uid },
      success: result => {
        grade_stud_uid = ''
        var studmoves = []
        var studchanges = []
        that.setData({ grade_stud_uid, studmoves, studchanges })
        x5on.showSuccess('标识' + result.data + '个学生')
      }
    })
  },

})