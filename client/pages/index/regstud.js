// pages/index/regstud.js
var x5on = require('../x5on.js')

Page({

  onLoad: function () {
    var that = this
    var mes = {
      edu_type_name: { label: '学校类型', type: 0 },
      schs_steps: { label: '学校分级', type: 0 },
      child_name: { label: '报名学生', type: 0 },
      passed: { label: '审核通过', type: 1 },
    }
    that.setData({ mes })
    //
    x5on.http(x5on.url.regstud)
    .then(childs_areas_edutypes_studregs=>{
      that.setData(childs_areas_edutypes_studregs)
    })
    .catch(error=>{
      x5on.showError(that, error)
    })
  },

  childChange: function(e) {
    var child_uid = e.detail.uid
    this.setData({ child_uid })
  },

  
  pickChange: function(e) {
    var that = this
    x5on.http(x5on.url.regstudstep, e.detail)
    .then(steps=>{
      that.setData({ steps, steps_uid: null })
    })
    .catch(error=>{
      x5on.showError(that, error)
    })
  },

  stepChange: function(e) {
    var steps_uid = e.detail.uid
    this.setData({ steps_uid })
  },

  checkClick: function(e) {
    var that = this
    var steps_uid = that.data.steps_uid
    var child_uid = that.data.child_uid
    steps_uid && child_uid && x5on.http(x5on.url.regstudreg, { steps_uid, child_uid })
    .then(studreg=>{
      var studregs = that.data.studregs
      studregs.push(studreg)
      that.setData({ studregs })
    })
    .catch(error=>{
      x5on.showError(that, error)
    })
  },


  detailClick: function(e) {
    wx.navigateTo({
      url: `/pages/index/studenroll?uid=${e.detail.uid}`
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



  cancelClick: function (e) {
    var that = this
    x5on.post({
      data: e.currentTarget.dataset,
      url: x5on.url.regstudcancel,
      success(stud_reg_uid) {
        var studregs = that.data.studregs
        x5on.delArr(studregs, 'uid', stud_reg_uid)
        that.setData({
          studregs
        })
      }
    })
  },



})