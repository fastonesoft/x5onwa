// pages/index/usereset.js
var x5on = require('../x5on.js')

Page({

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
        url: x5on.url.usereset,
        data: form,
        success(users) {
          that.setData({ users, user: null })
          users.length === 0 && x5on.showError('没有找到你要的用户！')
        }
      })
    }, message => {
      x5on.showError(message)
    })
  },

  userChange: function (e) {
    var that = this
    x5on.setRadio(that.data.users, e.detail.value, users => {
      x5on.getRadio(that.data.users, user => {
        that.setData({ users, user })
      }, () => {
        that.setData({ users, user: null })
      })
    })
  },

  userSubmit: function (e) {
    var that = this
    var rules = {
      confirmed: {
        required: true,
      },
      fixed: {
        required: true,
      }
    }
    x5on.checkForm(e.detail.value, rules, {}, form => {
      form.uid = that.data.user.uid
      x5on.post({
        url: x5on.url.useresetupdate,
        data: form,
        success(number) {
          x5on.showSuccess(`更新${number}条记录`)
          that.setData({ users: [], user: null })
        }
      })
    }, message => {
      x5on.showError(message)
    })
  },

  returnClick: function (e) {
    wx.navigateBack()
  }

})