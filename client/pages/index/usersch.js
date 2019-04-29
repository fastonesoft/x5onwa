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
      users.length !== 0 && that.setData({ users })
      users.length === 0 && x5on.showError(that, '没有找到你要的用户！')
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
      that.setData({ users, members })
    })
    .catch(error => {
      x5on.showError(that, error)
    })
  },

  memberSubmit: function (e) {
    var that = this
    var rules = {
      name: {
        required: true,
        chinese: true,
        rangelength: [1, 3],
      }
    }
    var messages = {
      name: {
        required: '成员姓名'
      }
    }
    x5on.checkForm(e.detail.value, rules, messages, form => {
      x5on.post({
        url: x5on.url.userschmemfind,
        data: form,
        success(members) {
          members.length !== 0 && that.setData({ members })
          members.length === 0 && x5on.showError(that, '没有找到你要的学校成员！')
        }
      })
    }, message => {
      x5on.showError(that, message)
    })
  },

  userschRemove: function (e) {
    var that = this
    var user_sch_uid = e.currentTarget.dataset.uid
    x5on.post({
      url: x5on.url.userschdel,
      data: { user_sch_uid },
      success() {
        var members = x5on.delArr(that.data.members, 'uid', user_sch_uid)
        that.setData({ members })
      }
    })
  },

  returnClick: function (e) {
    wx.navigateBack()
  },
})