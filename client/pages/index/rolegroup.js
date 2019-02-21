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
      group: {
        required: true,
      }
    }
    var messages = {
      group: {
        required: '分组选择'
      }
    }
    x5on.checkForm(e, rules, messages, (form, error) => {
      var value = e.detail.value
      value.uid = x5on.getValue(that.data.rolegroups, form.group, 'uid')
      delete value.group   // 删除无用属性

      x5on.post({
        url: x5on.url.rolegroupupdate,
        data: value,
        success(number) {
          x5on.showSuccess('更新' + number + '条记录')
        }
      })
    }, (message, error) => {
      x5on.showError(that, message)
    })
  }

})