// pages/index/userset.js
var x5on = require('../x5on.js')
import x5va from '../x5va.js'

Page({

  onShow: function () {
    var that = this
    // 检测登录
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
        wx.switchTab({ url: '/pages/login/login'})
      }
    });
  },

  usersetSubmit: function (e) {
    var that = this
    var update = new x5va({
      name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      },
      mobil: {
        required: true,
        tel: true,
      }
    }, {
        name: {
          required: '学生姓名'
        },
        mobil: {
          required: '手机号码'
        }
    })
    update.checkForm(e, form => {
      x5on.postFormEx({
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