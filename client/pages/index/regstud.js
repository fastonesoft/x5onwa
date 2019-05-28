// pages/index/regstud.js
var x5on = require('../x5on.js')

Page({

  onLoad: function () {
    var that = this
    var mes = {
      edu_type_name: { label: '学校类型', type: 0 },
      child_name: { label: '报名学生', type: 0 },
      schs_steps: { label: '报名学校', type: 0 },
      passed: { label: '审核通过', type: 1 },
      qrcode: { label: '审核二维码', type: 2, disable: 0 },
    }
    that.setData({ mes })
    //
    x5on.http(x5on.url.regstud)
    .then(childs_areas_studregs=>{
      that.setData(childs_areas_studregs)
    })
    .catch(error=>{
      x5on.showError(error)
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
      x5on.showError(error)
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
      x5on.showError(error)
    })
  },

  refClick: function(e) {
    var that = this
    x5on.http(x5on.url.regstudref, e.detail)
    .then(studreg=>{
      var studregs = x5on.setArr(that.data.studregs, 'uid', e.detail.uid, studreg)
      that.setData({ studregs })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  okClick: function(e) {

  },

  delClick: function(e) {
    var that = this
    x5on.http(x5on.url.regstudcancel, e.detail)
    .then(number=>{
      x5on.delSuccess(number)
      var studregs = x5on.delArr(that.data.studregs, 'uid', e.detail.uid)
      that.setData({ studregs })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

})