// pages/index/mydivision.js
var x5on = require('../x5on.js')

Page({

  data: {
    errorMessage: '错误提示',
    errorArray: [1],

    grades: []
  },

  onLoad: function (options) {
    var that = this
    x5on.request({
      url: x5on.url.mydivision,
      success: function (result) {
        // 年级列表
        that.setData(result.data)
      }
    })
  },

  gradeChange: function (e) {
    var that = this
    var gradeIndex = e.detail.value
    if (gradeIndex == -1) return

    that.setData({ gradeIndex })

    // 班级列表
    var grade_id = this.data.grades[gradeIndex].id
    x5on.postForm({
      url: x5on.url.mydivisionclass,
      data: { grade_id },
      success: function (result) {
        var classes = result.data
        that.setData({ classes })
      }
    })
  },

  classChange: function (e) {
    var that = this
    var values = e.detail.value
    var classes = that.data.classes
    classes.forEach(function (item) {
      item.checked = false
      for (var i = 0; i < values.length; i++) {
        if (item.id == values[i]) {
          item.checked = true
          break
        }
      }
    })
    that.setData({ classes })
  },

  checkInput: function (e) {
    x5on.checkInput(e, this)
  },

  findSubmit: function (e) {
    var that = this;
    x5on.checkForm(that, 0, 0, function () {
      x5on.postFormEx({
        url: x5on.url.mydivisionteachs,
        data: e.detail.value,
        success: (result) => {
          
          var teaches = result.data
          that.setData({ teaches })
          if (teaches.length === 0) {
              x5on.showError(that, '没有找到你说的老师！')
          } 
        }
      })
    })
  },

  teachChange: function (e) {
    var that = this
    var teaches = that.data.teaches

    console.log(e.detail.value)
    console.log(teaches)

    for (var index=0; index<teaches.length; index++) {
      var item = teaches[index]
      item.checked = item.user_id === e.detail.value
    }
    that.setData({ teaches })
  },

})