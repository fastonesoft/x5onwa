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
    var rules = {
      user_uid: {
        required: true,
      },
      grade: {
        required: true,
        min: 0,
      },
      cls_uids: {
        required: true,
        arr: true,
      }
    }
    var messages = {
      user_uid: {
        required: '教师选择'
      },
      grade: {
        required: '年级选择'
      },
      cls_uids: {
        required: '班级选择'
      }
    }
    x5on.checkForm(e.detail.value, rules, messages, form => {
      form.grade_id = x5on.getId(that.data.grades, form.grade)
      form.cls_uid_jsons = JSON.stringify(form.cls_uids)
      console.log(form)
      x5on.post({
        url: x5on.url.mydividist,
        data: form,
        success(class_classed) {
          that.setData(class_classed)
        }
      })
    }, mes => {
      x5on.showError(that, mes)
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