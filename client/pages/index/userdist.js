// pages/index/userdist.js
var x5on = require('../x5on.js')

Page({

  onLoad: function () {
    var that = this
    x5on.http(x5on.url.userdist)
    .then(groups=>{
      that.setData({ groups })
    })
  },

  findSubmit: function (e) {
    var that = this
    x5on.http(x5on.url.userdistuser, e.detail)
    .then(users => {
      users.length !== 0 && that.setData({ users, user_uid: null })
      users.length === 0 && x5on.showError(that, '没有找到你要的用户！')
    })
  },

  radioChange: function (e) {
    var user_uid = e.detail.uid
    this.setData({ user_uid })
  },

  pickChange: function (e) {
    var that = this
    x5on.http(x5on.url.userdistmember, e.detail)
    .then(members => {
      that.setData({ members })
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
    var user_sch_group_uid = e.currentTarget.dataset.uid
    x5on.post({
      url: x5on.url.userdistdel,
      data: { user_sch_group_uid },
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
      form.group_uid = x5on.getUid(that.data.groups, groupIndex)
      x5on.post({
        url: x5on.url.userdistmemfind,
        data: form,
        success(members) {
          members.length !== 0 && that.setData({ members })
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