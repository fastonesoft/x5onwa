// pages/index/roledist.js
var x5on = require('../x5on.js')

Page({

  data: {
    schoolIndex: 0,
  },

  onLoad: function () {
    var that = this
    x5on.request({
      url: x5on.url.roledist,
      success(school_groups) {
        that.setData(school_groups)
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
        url: x5on.url.roledistuser,
        data: form,
        success(users) {
          users.length === 0 ? x5on.showError(that, '没有找到你要的用户！') : that.setData({ users })
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
      that.setData({ groupIndex })
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
        required: '用户选择',
      },
      group: {
        required: '分组选择',
      }
    }
    x5on.checkForm(e.detail.value, rules, messages, form => {
      form.group_uid = x5on.getUid(that.data.groups, form.group)
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
    var that = this
    var uid = e.currentTarget.dataset.uid
    x5on.post({
      url: x5on.url.roledistdel,
      data: { uid },
      success(members) {
        that.setData({ members })
      }
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
      var groupIndex = that.data.groupIndex
      form.uid = x5on.getUid(that.data.groups, groupIndex)
      x5on.post({
        url: x5on.url.roledistmemfind,
        data: form,
        success(members) {
          that.setData({ members })
          members.length === 0 && x5on.showError(that, '没有找到你要的分组成员！')
        }
      })
    }, message => {
      x5on.showError(that, message)
    })
  },
})