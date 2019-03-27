// pages/index/userview.js
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
        url: x5on.url.userdistuser,
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
    var that = this
    var user_sch_uid = e.detail.value
    x5on.setRadioex(that.data.users, user_sch_uid, 'selected', users => {
      that.setData({ users })
      // 读取用户所在组
      x5on.post({
        url: x5on.url.userview,
        data: { user_sch_uid },
        success(groups) {
          that.setData({ groups })
        }
      })
    })
  },

  userviewSubmit: function (e) {
    var that = this
    var form = {}
    form.groups_json = JSON.stringify(e.detail.value)
    x5on.getRadioex(that.data.users, 'selected', user => {
      form.user_sch_uid = user.uid
      x5on.post({
        url: x5on.url.userviewupdate,
        data: form,
        success() {
          that.setData({ users: [], groups: [] })
        }
      })
    }, () => {
      x5on.showError(that, '教师选择没有设置')
    })
  },

  returnClick: function (e) {
    wx.navigateBack()
  },

})