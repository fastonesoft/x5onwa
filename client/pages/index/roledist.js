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
    x5on.setPick(this.data.groups, groupIndex => {
      this.setData({ groupIndex })

          // 刷新数据
    x5on.post({
      url: x5on.url.roledistgroupuser,
      data: {group_id},
      success: (res) => {
        that.setData({ teachs: res.data })
      }
    })
    })
   },

  roleChange: function (e) {
    var that = this
    var index = e.detail.value
    var group_id = this.data.pickers[index].id
    that.setData({ pIndex: index, group_id: group_id });

  },

  roledistSubmit: function (e) {
    var that = this
    var value = e.detail.value
    if (value.user_id && value.group_id) {
      x5on.post({
        url: x5on.url.roledistupdate,
        data: value,
        success: (res) => {
          x5on.showSuccess('添加' + res.data.num + '个教师')
          if (res.data && res.data.num === 1) {
            // 添加成功，刷新数据
            var radios = that.data.radios
            radios.splice(that.data.rIndex, 1)
            that.setData({ radios: radios, teachs: res.data.data })
          }
        }
      })
    } else {
      x5on.showError(this, '教师选择、权限分组不得为空！')
    }    
  },

  roledistRemove: function (e) {
    var that = this
    var uid = e.currentTarget.dataset.uid
    var index = e.currentTarget.dataset.index
    x5on.post({
      url: x5on.url.roledistdeleteuser,
      data: {uid},
      success: (res) => {
        x5on.showSuccess('删除' + res.data + '个教师')
        if (res.data && res.data === 1) {
          // 添加成功，刷新数据
          var teachs = that.data.teachs
          teachs.splice(index, 1)
          that.setData({ teachs })
        }
      }
    })
  },
})