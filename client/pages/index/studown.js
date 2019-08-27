// pages/index/studown.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this

    x5on.http(x5on.url.studown)
    .then(grades=>{
      that.setData({ grades })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  gradeChange: function(e) {
    var that = this
    that.setData(e.detail)

    x5on.http(x5on.url.studowndown, e.detail)
    .then(downs_notins=>{
      that.setData(downs_notins)
      // 清除班级编号残留、学生记录
      that.setData({ down_id: null, classes: [], cls_id: null, studs: [], stud_uid: null })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  downChange: function(e) {
    var that = this
    that.setData(e.detail)

    x5on.http(x5on.url.studowncls, e.detail)
    .then(classes=>{
      that.setData({ classes })
      // 学生记录
      that.setData({ cls_id: null, studs: [], stud_uid: null })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  classChange: function(e) {
    var that = this
    that.setData(e.detail)
  },

  findSubmit: function(e) {
    let that = this
    let { grade_id } = that.data
    Object.assign(e.detail, { grade_id })

    that.setData({ stud_uid: null })
    x5on.http(x5on.url.studownquery, e.detail)
    .then(studs=>{
      that.setData({ studs })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  radioChange: function(e) {
    var that = this
    that.setData(e.detail)
  },

  downClick: function(e) {
    var that = this
    let { down_id, cls_id, stud_uid, notins, studs } = that.data
    x5on.http(x5on.url.studowndone, { down_id, cls_id, stud_uid })
    .then(notin=>{
      notins = x5on.add(notins, notin)
      studs = x5on.delArr(studs, 'uid', stud_uid)
      that.setData({ notins, studs })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  }, 

})