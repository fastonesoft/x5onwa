// pages/index/mytuning.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this

    x5on.http(x5on.url.mytuning)
    .then(grades=>{
      that.setData({ grades })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  gradeChange: function (e) {
    var that = this
    that.setData(e.detail)

    x5on.http(x5on.url.mytuningcls, e.detail)
    .then(classes=>{
      that.setData({ classes, cls_id: null, come_stud_uid: null, out_stud_uid: null })
    })
    .catch(error=>{
      x5on.showError(error)
    })

  },

  classChange: function (e) {
    var that = this
    that.setData(e.detail)
    that.setData({ comes: [], outs: [], out_stud_uid: null, come_stud_uid: null })
  },

  findSubmit: function (e) {
    var that = this
    let { grade_id } = that.data
    Object.assign(e.detail, { grade_id })

    // 查询要调动的学生
    x5on.http(x5on.url.mytuningquery, e.detail)
    .then(comes=>{
      that.setData({ comes, outs: [], out_stud_uid: null, come_stud_uid: null })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  studChange: function (e) {
    var that = this
    let { uid, cls_id } = e.detail
    let come_stud_uid = uid
    let come_cls_id = cls_id
    that.setData({ come_stud_uid, come_cls_id })

    x5on.http(x5on.url.mytuningout, { come_stud_uid, cls_id: that.data.cls_id })
    .then(outs=>{
      that.setData({ outs, out_stud_uid: null })
    })
    .catch(error=>{
      x5on.showError(error)
    })

  },

  localClick: function (e) {
    var that = this
    let { come_stud_uid } = that.data

    x5on.http(x5on.url.mytuninglocal, { come_stud_uid })
    .then(moved=>{
      that.setData({ comes: [], outs: [], out_stud_uid: null, come_stud_uid: null })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },


  outChange: function (e) {
    var that = this
    that.setData(e.detail)
  },

  exchangeClick: function(e) {
    var that = this
    let { comes, come_stud_uid, out_stud_uid } = that.data
    x5on.http(x5on.url.mytuningchange, { come_stud_uid, out_stud_uid })
    .then(moveds=>{
      that.setData({ comes: [], outs: [], out_stud_uid: null, come_stud_uid: null })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  }

})