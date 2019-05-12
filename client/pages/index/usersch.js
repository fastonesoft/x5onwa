// pages/index/usersch.js
var x5on = require('../x5on.js')

Page({
  
  onLoad: function () {
    var that = this
    x5on.http(x5on.url.usersch)
    .then(members => {
      that.setData({ members })
    })
  },

  findSubmit: function (e) {
    var that = this
    x5on.http(x5on.url.userschuser, e.detail)
    .then(users => {
      users.length !== 0 && that.setData({ users, user_uid: null })
      users.length === 0 && x5on.showError('没有找到你要的用户！')
    })
  },

  radioChange: function (e) {
    var user_uid = e.detail.uid
    this.setData({ user_uid })
  },

  userschClick: function (e) {
    var that = this
    var user_uid = that.data.user_uid
    user_uid && x5on.http(x5on.url.userschreg, { user_uid })
    .then(members => {
      var users = x5on.delArr(that.data.users, 'uid', user_uid)
      that.setData({ users, members, user_uid: null })
    })
    .catch(error => {
      x5on.showError(error)
    })
  },

  memberSubmit: function (e) {
    var that = this
    x5on.http(x5on.url.userschmemfind, e.detail)
    .then(members => {
      members.length !== 0 && that.setData({ members })
      members.length === 0 && x5on.showError('没有找到你要的用户！')
    })
    .catch(error => {
      x5on.showError(error)
    })
  },

  removeClick: function (e) {
    var that = this
    x5on.http(x5on.url.userschdel, e.detail)
    .then()
    .catch(error => {
      x5on.showError(error)
    })
  },

})