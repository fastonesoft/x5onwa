// pages/index/usersch.js
var x5on = require('../x5on.js')

Page({
  
  onLoad: function () {
    var that = this
    x5on.request({
      url: x5on.url.usersch,
      success(schos) {
        that.setData({ schos })
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
          that.setData({ users })
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

  schoChange: function (e) {
    var that = this
    x5on.setPick(e, schoIndex => {
      that.setData({ schoIndex })
      var sch_uid = x5on.getUid(that.data.schos, that.data.schoIndex)
      x5on.post({
        url: x5on.url.userschmember,
        data: { sch_uid },
        success(members) {
          that.setData({ members })
        }
      })
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
      form.sch_uid = x5on.getUid(that.data.schos, that.data.schoIndex)
      x5on.post({
        url: x5on.url.userschreg,
        data: form,
        success(members) {
          // 刷新members，清空users
          var users = []
          that.setData({ users, members })
        }
      })
    }, message => {
      x5on.showError(that, message)
    })
  },

  returnClick: function (e) {
    wx.navigateBack()
  },
})