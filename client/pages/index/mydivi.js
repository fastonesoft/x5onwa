// pages/index/mydivi.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.request({
      url: x5on.url.mydivi,
      success(grades) {
        that.setData({ grades })
      }
    })
  },

  findSubmit: function (e) {
    var that = this
    var rules = {
      user_name: {
        required: true,
        chinese: true,
        rangelength: [1, 3],
      }
    }
    var messages = {
      user_name: {
        required: '教师姓名'
      }
    }
    x5on.checkForm(e.detail.value, rules, messages, form => {
      x5on.post({
        url: x5on.url.mydiviteachs,
        data: form,
        success(teachs) {
          teachs.length !== 0 && that.setData({ teachs })
          teachs.length === 0 && x5on.showError(that, '没有找到你要的教师！')
        }
      })
    }, message => {
      x5on.showError(that, message)
    })
  },

  gradeChange: function (e) {
    var that = this
    x5on.setPick(e, gradeIndex => {
      that.setData({ gradeIndex })
      var grade_id = x5on.getId(that.data.grades, gradeIndex)
      x5on.post({
        url: x5on.url.mydiviclsdiv,
        data: { grade_id },
        success(class_classed) {
          that.setData(class_classed)
        }
      })
    })
  },

  classChange: function (e) {
    var that = this
    x5on.setCheckbox(that.data.classes, e.detail.value, classes => {
      that.setData({ classes })
    })
  },

  teachChange: function (e) {
    var that = this
    x5on.setRadio(that.data.teachs, e.detail.value, teachs => {
      that.setData({ teachs })
    })
  },

  mydiviSubmit: function (e) {
    var that = this
    var data = e.detail.value
    if (!data.user_id || data.cls_ids.length==0) {
      x5on.showError(that, '教师、班级未做选择')
      return
    }
    var teachs = this.data.teachs
    var classes = this.data.classes
    teachs.forEach(function (item, index) {
      if (item.user_id == data.user_id) {
        teachs.splice(index, 1)
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
    that.setData({ teachs, classes })
    x5on.post({
      url: x5on.url.mydiviupdate,
      data: data,
      success: result => {
        var classed = result.data
        that.setData({ classed })
      }
    })
  },

  mydiviRemove: function (e) {
    var that = this
    var class_div_uid = e.currentTarget.dataset.uid
    x5on.post({
      url: x5on.url.mydiviremove,
      data: { class_div_uid },
      success(class_classed) {
        that.setData(class_classed)
      }
    })
  },

  
	returnClick: function (e) {
		wx.navigateBack()
	},


})