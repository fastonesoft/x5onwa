// pages/index/roledist.js
var x5on = require('../x5on.js')

Page({

  onLoad: function () {
    var that = this
    x5on.request({
      url: x5on.url.roledist,
      success(groups) {
        that.setData({ groups })
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
        required: '教师姓名'
      }
    }
    x5on.checkForm(e, rules, messages, form => {
      x5on.post({
        url: x5on.url.roledistuser,
        data: form,
        success(users) {
          users.length === 0 ? x5on.showError(that, '没有找到你要的老师！') : that.setData({ users })
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

  groupChange: function (e) {
    var that = this
    x5on.setPick(e, groupIndex => {
      this.setData({ groupIndex })

      var uid = x5on.getUid(that.data.groups, groupIndex)
      x5on.post({
        url: x5on.url.roledistmember,
        data: { uid },
        success(members) {
          that.setData({ members })
        }
      })
    })
  },

  roledistSubmit: function (e) {
    var that = this
    var rules = {
      user_uid: {
        required: true,
      },
      group: {
        required: true,
      }
    }
    var messages = {
      user_uid: {
        required: '教师选择',
      },
      group: {
        required: '分组选择',
      }
    }
    x5on.checkForm(e, rules, messages, form => {
      x5on.post({
        url: x5on.url.roledistadd,
        data: form,
        success(members) {
          that.setData({ members })
        }
      })
    }, message => {
      x5on.showError(that, message)
    })
  },

  roledistRemove: function (e) {
    var uid = e.currentTarget.dataset.uid
    x5on.post({
      url: x5on.url.roledistdel,
      data: { uid },
      success(number) {
        x5on.showSuccess('删除' + number + '个教师')
      }
    })
  },
})