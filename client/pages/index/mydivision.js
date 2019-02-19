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
    x5on.post({
      url: x5on.url.mydivisionclass,
      data: { grade_id },
      success: function (result) {
        var classes = result.data
        that.setData({ classes })
      }
    })
    x5on.post({
      url: x5on.url.mydivisionedclass,
      data: { grade_id },
      success: function (result) {
        var classed = result.data
        that.setData({ classed })
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
      x5on.post({
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

    for (var index=0; index<teaches.length; index++) {
      var item = teaches[index]
      item.checked = item.user_id === e.detail.value
    }
    that.setData({ teaches })
  },

  mydivisionSubmit: function (e) {
    var that = this
    var data = e.detail.value
    if (!data.user_id || data.cls_ids.length==0) {
      x5on.showError(that, '教师、班级未做选择')
      return
    }
    var teaches = this.data.teaches
    var classes = this.data.classes
    teaches.forEach(function (item, index) {
      if (item.user_id == data.user_id) {
        teaches.splice(index, 1)
      }
    })
    for (var index = classes.length - 1; index >= 0; index--) {
      var has = false
      var item = classes[index]
      for (var i=0; i < data.cls_ids.length; i++) {
        if (item.id == data.cls_ids[i]) {
          has = true
          break
        }
      }
      if (has) classes.splice(index, 1)
    }
    that.setData({ teaches, classes })
    x5on.post({
      url: x5on.url.mydivisionupdate,
      data: data,
      success: result => {
        var classed = result.data
        that.setData({ classed })
      }
    })
  },

  mydivisionRemove: function (e) {
    var that = this
    var classed = that.data.classed
    var uid = e.currentTarget.dataset.uid
    classed.forEach(function (item, index) {
      if (item.uid == uid) {
        classed.splice(index, 1)
      }
    })
    that.setData({ classed })
    x5on.post({
      url: x5on.url.mydivisionedremove,
      data: {uid},
      success: result => {
        var classes = result.data
        that.setData({ classes })
      }
    })
  }

})