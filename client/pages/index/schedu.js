// pages/index/schedu.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.http(x5on.url.schedu)
      .then(membs => {
        that.setData({ membs })
      })
  },

  removeClick: function (e) {
    let that = this
    x5on.http(x5on.url.schedudel, e.detail)
      .then(number => {
        x5on.delSuccess(number)
        var membs = that.data.membs
        membs = x5on.delArr(membs, 'uid', e.detail.uid)
        //
        that.setData({ membs })
      })
      .catch(error => {
        x5on.showError(error)
      })
  },

  addClick: function (e) {
    var fields = [{
      mode: 3,
      name: 'edu_id',
      label: '学制选择',
      url: x5on.url.scheduedu,
      valueKey: 'id',
      rangeKey: 'name',
      selectKey: 'name',
    }]
    var rules = {
      edu_id: {
        required: true,
        min: 1,
      },
    }

    var json = {}
    json.title = '学制设置'
    json.notitle = true
    json.url_u = x5on.url.scheduadd
    json.arrsName = 'membs'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },
  
})