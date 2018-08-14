// pages/index/mytuning.js
var x5on = require('../x5on.js')

Page({
  
  data: {
    grades: [],
    classes: [],
    studmoves: [],
    studchanges: []
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
    var gradeIndex = e.detail.value
    var classIndex = -1
    var studmoves = []
    var studchanges = []
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
    var that = this
    var classIndex = e.detail.value
    if (classIndex == -1) return

    that.setData({ classIndex })
  },

  checkInput: function (e) {
    x5on.checkInput(e, this)
  },

  findSubmit: function (e) {
    var that = this
    console.log(e.detail.value)

    x5on.checkForm(that, 0, 0, function () {
      x5on.postFormEx({
        url: x5on.url.mytuningstudmoves,
        data: e.detail.value,
        success: result => {
          var studmoves = result.data
          studmoves.length === 0 ? x5on.showError(that, '没有找到你要的学生！') : that.setData({ studmoves })
        }
      })
    })
  },


})