// pages/index/userset.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.http(x5on.url.userset)
    .then(user=>{
      var mes = {
        name: { label: '用户姓名', type: 0 },
        mobil: { label: '手机号码', type: 0 },
      }
      user.notconfirmed = !user.confirmed
      that.setData({ mes, user })
    })
  },

  setClick: function (e) {
    var user = this.data.user
    var fields = [{
      mode: 1,
      label: '用户姓名',
      message: '输入用户姓名',
      name: 'name',
      value: user.name,
      type: 'text',
      maxlength: 4,
    }, {
      mode: 1,
      label: '手机号码',
      message: '输入手机号码',
      name: 'mobil',
      value: user.mobil,
      type: 'number',
      maxlength: 11,
    }]
    var rules = {
      name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      },
      mobil: {
        required: true,
        minlength: 11,
        tel: true,
      }
    }

    var json = {}
    json.title = '信息变更'
    json.notitle = true
    json.url_u = x5on.url.usersetupdate
    json.arrsName = 'user'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_edit?json=' + JSON.stringify(json) })
  },

})