// pages/index/myadjust.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this

    x5on.http(x5on.url.myadjust)
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

    x5on.http(x5on.url.myadjustcls, e.detail)
    .then(classes=>{
      that.setData({ classes, cls_id: null, studs: [], comes: [], moveds: [], grade_stud_uid: null, grade_cls_id: null, outs: [], out_stud_uid: null, come_stud_uid: null })
    })
    .catch(error=>{
      x5on.showError(error)
    })

  },

  classChange: function (e) {
    var that = this
    that.setData(e.detail)

    // 读取调动成功的、未成功的学生
    x5on.http(x5on.url.myadjustmoves, e.detail)
    .then(moves=>{
      that.setData(moves)
      that.setData({ studs: [], grade_stud_uid: null, grade_cls_id: null, outs: [], out_stud_uid: null, come_stud_uid: null })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  findSubmit: function (e) {
    var that = this
    let { comes, grade_id } = that.data
    Object.assign(e.detail, { grade_id })

    // 查询要调动的学生
    x5on.http(x5on.url.myadjustquery, e.detail)
    .then(studs=>{
      that.setData({ comes, studs, grade_stud_uid: null, grade_cls_id: null, outs: [], out_stud_uid: null, come_stud_uid: null })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  studChange: function (e) {
    var that = this
    var { uid, cls_id } = e.detail

    let grade_stud_uid = uid
    let grade_cls_id = cls_id

    that.setData({ grade_stud_uid, grade_cls_id, outs: [], out_stud_uid: null, come_stud_uid: null })
  },

  localClick: function (e) {
    var that = this
    let { studs, moveds, grade_stud_uid } = that.data

    x5on.http(x5on.url.myadjustlocal, { grade_stud_uid })
    .then(moved=>{
      // 删除
      studs = x5on.delArr(studs, 'uid', grade_stud_uid)
      // 添加
      moveds = x5on.add(moveds, moved)
      that.setData({ studs, moveds, grade_stud_uid: null, outs: [], out_stud_uid: null, come_stud_uid: null })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  requestClick: function (e) {
    var that = this
    let { studs, comes, grade_stud_uid, cls_id } = that.data

    x5on.http(x5on.url.myadjustreq, { grade_stud_uid, cls_id })
    .then(moved=>{
      // 删除
      studs = x5on.delArr(studs, 'uid', grade_stud_uid)
      // 添加
      comes = x5on.add(comes, moved)
      that.setData({ studs, comes, grade_stud_uid: null, outs: [], out_stud_uid: null, come_stud_uid: null })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  removeClick: function (e) {
    var that = this
    let { comes } = that.data
    let { uid } = e.detail

    x5on.http(x5on.url.myadjustremove, e.detail)
    .then(number=>{
      x5on.delSuccess(number)
      // 删除
      comes = x5on.delArr(comes, 'uid', uid)
      that.setData({ comes, outs: [], out_stud_uid: null, come_stud_uid: null })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  comeChange: function (e) {
    var that = this
    let { cls_id } = that.data
    let form = Object.assign({ cls_id }, e.detail)

    that.setData(e.detail)
    x5on.http(x5on.url.myadjustout, form)
    .then(outs=>{
      that.setData({ outs, out_stud_uid: null })
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
    x5on.http(x5on.url.myadjustchange, { come_stud_uid, out_stud_uid })
    .then(moveds=>{
      // 删除
      comes = x5on.delArr(comes, 'uid', come_stud_uid)
      that.setData({ comes, moveds, outs: [], come_stud_uid: null, out_stud_uid: null })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  }

})