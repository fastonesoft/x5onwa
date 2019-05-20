// pages/index/subset.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.http(x5on.url.subset)
      .then(membs => {
        that.setData({ membs })
      })
  },

  removeClick: function (e) {
    let that = this
    x5on.http(x5on.url.subsetdel, e.detail)
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
      mode: 1,
      label: '学科编号',
      message: '输入学科编号',
      name: 'id',
      type: 'number',
      maxlength: 2,
    }, {
      mode: 1,
      label: '学科名称',
      message: '输入学科名称',
      name: 'name',
      type: 'text',
      maxlength: 2,
    }, {
      mode: 1,
      label: '学科简称',
      message: '输入学科简称',
      name: 'short',
      type: 'text',
      maxlength: 1,
    }]
    var rules = {
      id: {
        required: true,
        digits: true,
        minlength: 1,
        min: 1,
      },
      name: {
        required: true,
        chinese: true,
        minlength: 2,
      },
      short: {
        required: true,
        chinese: true,
        minlength: 1,
      },
    }
    var json = {}
    json.title = '学科设置'
    json.notitle = true
    json.url_u = x5on.url.subsetadd
    json.arrsName = 'membs'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

})