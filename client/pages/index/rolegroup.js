// pages/index/rolegroup.js
var x5on = require('../x5on.js')

Page({
  data: {
    roleItems: [],
    pickers: [],
    pIndex: -1,
    group_id: ''
  },

  onLoad: function () {
    var that = this
    x5on.check({
      showError: true,
      success: () => x5on.request({
        url: x5on.url.rolegroup,
        success: function (result) {
          that.setData({ pickers: result.data })
        }
      })
    })
  },

  pickerChange: function (e) {
    var that = this
    var index = e.detail.value
    var group_id = this.data.pickers[index].id
    that.setData({ pIndex: index, group_id: group_id });
    // 不需要检测
    x5on.postForm({
      url: x5on.url.rolegrouprole,
      data: {group_id, group_id},
      success: (res) => {
        that.setData({ roleItems: res.data })        
      }
    })
  },

  rolegroupSubmit: function (e) {
    // 不需要检测
    x5on.postForm({
      url: x5on.url.rolegroupupdate,
      data: e.detail.value,
      success: (res) => {
        x5on.showSuccess('更新' + res.data + '条记录')
      }
    })
  }
})