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
      var group_id = x5on.getIndex(this.data.group)
      x5on.post({
        url: x5on.url.rolegrouprole,
        data: {group_id, group_id},
        success: (res) => {
          that.setData({ roleItems: res.data })        
        }
      })
    })

    // 不需要检测

  },

  rolegroupSubmit: function (e) {
    // 不需要检测
    x5on.post({
      url: x5on.url.rolegroupupdate,
      data: e.detail.value,
      success: (res) => {
        x5on.showSuccess('更新' + res.data + '条记录')
      }
    })
  }
})