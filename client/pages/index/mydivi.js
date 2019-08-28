// pages/index/mydivi.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.http(x5on.url.mydivi)
    .then(grades=>{
      that.setData({ grades })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  findSubmit: function (e) {
    var that = this

    x5on.http(x5on.url.mydiviteachs, e.detail)
    .then(sch_users=>{
      that.setData({ sch_users, user_uid: null })
    })
    .catch(error=>{
      x5on.showError(error)
    })

  },

  userChange: function (e) {
    var that = this
    that.setData(e.detail)
  },

  gradeChange: function (e) {
    var that = this
    that.setData(e.detail)

    x5on.http(x5on.url.mydiviclsdiv, e.detail)
    .then(class_classed=>{
      that.setData(class_classed)
    })
    .catch(error=>{
      x5on.showError(error)
    })

  },

  checkSubmit: function (e) {
    var that = this
    let { grade_id, user_uid, classes } = that.data
    let form = Object.assign({ grade_id, user_uid }, e.detail)

    x5on.http(x5on.url.mydividist, form)
    .then(classed=>{
      // 删除
      let { uids } = e.detail
      uids.forEach(uid => {
        classes = x5on.delArr(classes, 'uid', uid)
      });
      // 显示
      that.setData({ classes, classed })
    })
    .catch(error=>{
      x5on.showError(error)
    })

  },

  removeClick: function (e) {
    var that = this
    x5on.http(x5on.url.mydiviremove, e.detail)
    .then(number=>{
      x5on.delSuccess(number)
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },
  
})