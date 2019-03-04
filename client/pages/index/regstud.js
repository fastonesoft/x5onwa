// pages/index/regstud.js
var x5on = require('../x5on.js')

Page({

  data: {
    areaIndex: 0,
  },

  onLoad: function () {
    var that = this
    x5on.request({
      url: x5on.url.regstud,
      success(childs_areas_edutypes_studregs) {
        that.setData(childs_areas_edutypes_studregs)
      }
    })
  },

  schoolQuery: function (formValue) {
    var that = this
    var rules = {
      area: {
        required: true,
      },
      edutype: {
        required: true,
      },
    }
    var messages = {
      area: {
        required: '报名地区'
      },
      edutype: {
        required: '学校类型'
      }
    }
    x5on.checkForm(formValue, rules, messages, form => {
      form.area_id = x5on.getId(that.data.areas, form.area)
      form.edu_type_id = x5on.getId(that.data.edutypes, form.edutype)
      x5on.post({
        url: x5on.url.regstudstep,
        data: form,
        success(steps) {
          that.setData({
            steps,
            stepIndex: -1
          })
        }
      })
    }, message => {
      x5on.showError(that, message)
    })
  },

  areaChange: function (e) {
    x5on.setPick(e, areaIndex => {
      this.setData({ areaIndex })
      //
      var form = {}
      form.area = areaIndex
      form.edutype = this.data.edutypeIndex
      this.schoolQuery(form)
    })
  },

  edutypeChange: function (e) {
    x5on.setPick(e, edutypeIndex => {
      this.setData({ edutypeIndex })
      //
      var form = {}
      form.area = this.data.areaIndex
      form.edutype = edutypeIndex
      this.schoolQuery(form)
    })
  },

  stepChange: function (e) {
    x5on.setPick(e, stepIndex => {
      this.setData({ stepIndex })
    })
  },

  childChange: function (e) {
    x5on.setPick(e, childIndex => {
      this.setData({ childIndex })
    })
  },

  regstudSubmit: function (e) {
    var that = this
    var rules = {
      step: {
        required: true,
        min: 0,
      },
      child: {
        required: true,
        min: 0,
      }
    }
    var messages = {
      step: {
        required: '学校选择'
      },
      child: {
        required: '孩子选择'
      }
    }
    x5on.checkForm(e.detail.value, rules, messages, form => {
      form.steps_id = x5on.getId(that.data.steps, form.step)
      form.child_id = x5on.getValue(that.data.childs, form.child, 'child_id')
      x5on.post({
        url: x5on.url.regstudreg,
        data: form,
        success(studreg) {
          var studregs = that.data.studregs
          studregs.push(studreg)
          that.setData({ studregs })
        }
      })
    }, message => {
      x5on.showError(that, message)
    })
  },

  checkClick: function (e) {
    var that = this
    x5on.post({
      data: e.currentTarget.dataset,
      url: x5on.url.regstudcheck,
      success(stud_reg_uid) {
        var studregs = x5on.setValues(that.data.studregs, 'uid', stud_reg_uid, {
          confirmed: 1
        })
        that.setData({ studregs })
      }
    })
  },

  cancelClick: function (e) {
    var that = this
    x5on.post({
      data: e.currentTarget.dataset,
      url: x5on.url.regstudcancel,
      success(stud_reg_uid) {
        var studregs = that.data.studregs
        x5on.delValue(studregs, 'uid', stud_reg_uid)
        that.setData({
          studregs
        })
      }
    })
  },

  regedClick: function (e) {
    wx.navigateTo({
      url: `/pages/index/studenroll?uid=${e.currentTarget.dataset.uid}`
    })
  },

  returnClick: function (e) {
    wx.navigateBack()
  }

})