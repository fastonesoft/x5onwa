// pages/index/sysvalue.js

var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.http(x5on.url.syskey)
      .then(keys => {
        that.setData({ keys })
      })
  },

  pickChange: function (e) {
    var that = this
    that.setData(e.detail)
    x5on.http(x5on.url.sysvalue, e.detail)
    .then(membs => {
      that.setData({ membs })
    })
    .catch(error => {
      x5on.showError(error)
    })
  },

  removeClick: function (e) {
    let that = this
    x5on.http(x5on.url.sysvaluedel, e.detail)
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
    var that = this
    var fields = [{
      mode: 1,
      name: 'code',
      label: '列表序号',
      message: '输入列表序号，1~6位数字',
      type: 'number',
      maxlength: 6,
    }, {
      mode: 1,
      name: 'value',
      label: '列表值',
      message: '输入列表值，文字或编号',
      type: 'text',
      maxlength: 50,
    }, {
      mode: 1,
      name: 'valuex',
      label: '列表补充',
      message: '输入列表补充，默认为空值',
      type: 'text',
      maxlength: 50,
    }]
    var rules = {
      code: {
        required: true,
        digits: true,
        minlength: 1,
        maxlength: 6,
      },
      value: {
        required: true,
        char: true,
        minlength: 1,
        maxlength: 50,
      },
      valuex: {
        required: false,
        chinese: true,
        maxlength: 50,
      },
    }

    var json = {}
    json.title = '键值设置'
    json.notitle = true
    json.url_u = x5on.url.sysvalueadd
    json.data_u = { key_id: that.data.key_id }
    json.arrsName = 'membs'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

})