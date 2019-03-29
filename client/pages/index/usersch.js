// pages/index/usersch.js
var x5on = require('../x5on.js')

Page({
  
  onLoad: function () {
    var that = this
    x5on.request({
      url: x5on.url.usersch,
      success(members) {
        that.setData({ members })
      }
    })
  },

  findSubmit: function (e) {
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
        required: '用户姓名'
      }
    }
    x5on.checkForm(e.detail.value, rules, messages, form => {
      x5on.post({
        url: x5on.url.userschuser,
        data: form,
        success(users) {
          users.length !== 0 && that.setData({ users })
          users.length === 0 && x5on.showError(that, '没有找到你要的用户！')
        }
      })
    }, message => {
      x5on.showError(that, message)
    })
  },

  userChange: function (e) {
    x5on.setRadio(this.data.users, e.detail.value, users => {
      this.setData({ users })
    })
  },

  userschSubmit: function (e) {
    var that = this
    var rules = {
      user_uid: {
        required: true,
      },
    }
    var messages = {
      user_uid: {
        required: '用户选择',
      },
    }
    x5on.checkForm(e.detail.value, rules, messages, form => {
      x5on.post({
        url: x5on.url.userschreg,
        data: form,
        success(members) {
          var users = x5on.delValue(that.data.users, 'uid', form.user_uid)
          that.setData({ users, members })
        }
      })
    }, message => {
      x5on.showError(that, message)
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
        var members = x5on.delValue(that.data.members, 'uid', user_sch_uid)
        that.setData({ members })
      }
    })
  },

  returnClick: function (e) {
    wx.navigateBack()
  },
})