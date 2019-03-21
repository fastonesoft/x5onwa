// pages/index/userdist.js
var x5on = require('../x5on.js')

Page({

  data: {
    schoIndex: 0,
  },

  onLoad: function () {
    var that = this
    x5on.request({
      url: x5on.url.userdist,
      success(schos_groups) {
        that.setData(schos_groups)
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
    x5on.setRadio(this.data.users, e.detail.value, users => {
      this.setData({ users })
    })
  },

  groupChange: function (e) {
    var that = this
    x5on.setPick(e, groupIndex => {
      that.setData({ groupIndex })
      var group_uid = x5on.getUid(that.data.groups, groupIndex)
      var sch_uid = x5on.getUid(that.data.schos, that.data.schoIndex)
      console.log(sch_uid)
      x5on.post({
        url: x5on.url.userdistmember,
        data: { group_uid, sch_uid },
        success(members) {
          that.setData({ members })
        }
      })
    })
  },

  userdistSubmit: function (e) {
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
        min: 0,
      }
    }
    x5on.checkForm(e.detail.value, rules, messages, form => {
      form.sch_uid = x5on.getUid(that.data.schos, that.data.schoIndex)
      form.group_uid = x5on.getUid(that.data.groups, form.group)
      x5on.post({
        url: x5on.url.userdistadd,
        data: form,
        success(members) {
          that.setData({ members })
        }
      })
    }, message => {
      x5on.showError(that, message)
    })
  },

  userdistRemove: function (e) {
    var that = this
    var uid = e.currentTarget.dataset.uid
    x5on.post({
      url: x5on.url.userdistdel,
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
        url: x5on.url.userdistmemfind,
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

  returnClick: function (e) {
    wx.navigateBack()
  },
  
})