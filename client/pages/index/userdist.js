// pages/index/userdist.js
var x5on = require('../x5on.js')

Page({

  onLoad: function () {
    var that = this
    x5on.http(x5on.url.userdist)
    .then(groups=>{
      that.setData({ groups })
    })
  },

  findSubmit: function (e) {
    var that = this
    x5on.http(x5on.url.userdistuser, e.detail)
    .then(sch_users => {
      sch_users.length !== 0 && that.setData({ sch_users, user_uid: null })
      sch_users.length === 0 && x5on.showError('没有找到你要的用户！')
    })
  },

  radioChange: function (e) {
    var user_uid = e.detail.uid
    this.setData({ user_uid })
  },

  pickChange: function (e) {
    var that = this
    that.setData(e.detail)
    x5on.http(x5on.url.userdistmember, e.detail)
    .then(members => {
      that.setData({ members })
    })
  },

  userdistSubmit: function (e) {
    var that = this
    var user_uid = that.data.user_uid
    var group_uid = that.data.group_uid
    group_uid && user_uid && x5on.http(x5on.url.userdistadd, { user_uid, group_uid })
    .then(members=>{
      that.setData({ members })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  removeClick: function (e) {
    var that = this
    var user_sch_group_uid = e.detail.uid
    x5on.http(x5on.url.userdistdel, { user_sch_group_uid })
    .then(members=>{
      that.setData({ members })
    })
    .catch(error=>{
      x5on.showError(error)
    })

  },

  memberSubmit: function (e) {
    var that = this
    var name = e.detail.name
    var group_uid = that.data.group_uid
    group_uid && x5on.http(x5on.url.userdistdel, { name, group_uid })
    .then(members=>{
      members.length !== 0 && that.setData({ members })
      members.length === 0 && x5on.showError('没有找到你要的分组成员！')
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },
  
})