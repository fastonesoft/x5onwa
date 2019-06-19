// pages/index/rolegroup.js
var x5on = require('../x5on.js')

Page({

  onLoad: function () {
    var that = this
    x5on.request({
      url: x5on.url.rolegroup,
      success(rolegroups) {
        that.setData({ rolegroups })
      }
    })
  },

  rolegroupChange: function (e) {
    var that = this
    x5on.setPick(e, groupIndex => {
      var uid = x5on.getValue(this.data.rolegroups, groupIndex, 'uid')
      that.setData({ groupIndex })
      //
      x5on.post({
        url: x5on.url.rolegrouprole,
        data: { uid },
        success(roles) {
          that.setData({ roles })
        }
      })
    })
  },

  rolegroupSubmit: function (e) {
    var that = this
    var rules = {
      uid: {
        required: true,
      }
    }
    var messages = {
      uid: {
        required: '分组设置'
      }
    }
    var value = {}
    value.uid = x5on.getValue(this.data.rolegroups, this.data.groupIndex, 'uid')
    x5on.checkForm(value, rules, messages, (form, error) => {
      value.groups = JSON.stringify(e.detail.value)
      x5on.post({
        url: x5on.url.rolegroupupdate,
        data: value,
        success(number) {
          x5on.showSuccess('更新' + number + '条记录')
          that.setData({ roles: [] })
        }
      })
    }, (message, error) => {
      x5on.showError(message)
    })
  },

})