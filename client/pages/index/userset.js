// pages/index/userset.js
var x5on = require('../x5on.js')

Page({

  onShow: function () {
    var that = this
    x5on.check({
      success() {
        x5on.request({
          url: x5on.url.userset,
          success(users) {
            users.notchecked = !users.checked
            that.setData(users)
          }
        })
      },
      fail() {
        wx.switchTab({ url: '/pages/login/login' })
      }
    });
  },

  usersetSubmit: function (e) {
    var that = this
    var rules = {
      name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      },
      mobil: {
        required: true,
        tel: true,
      }
    }
    var messages = {
      name: {
        required: '学生姓名'
      },
      mobil: {
        required: '手机号码'
      }
    }
    x5on.checkForm(e, rules, messages, form => {
      x5on.post({
        url: x5on.url.usersetupdate,
        data: form,
        success(users) {
          users.notchecked = !users.checked
          that.setData(users)
        }
      })
    }, error => {
      x5on.showError(that, error)
    })
  },

  returnClick: function (e) {
    wx.navigateBack()
  }

})