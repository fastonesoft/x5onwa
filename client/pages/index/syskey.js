// pages/index/syskey.js

var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.http(x5on.url.syskey)
      .then(membs => {
        that.setData({ membs })
      })
  },

  removeClick: function (e) {
    let that = this
    x5on.http(x5on.url.syskeydel, e.detail)
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
  
  editClick: function (e) {
    var memb = e.detail
    var fields = [{
      mode: 1,
      name: 'name',
      label: '键值名称',
      message: '输入键值名称',
      type: 'text',
      maxlength: 20,
      value: memb.name,
    }]
    var rules = {
      name: {
        required: true,
        chinese: true,
        minlength: 4,
        maxlength: 20,
      },
    }
    
    var json = {}
    json.title = '键值设置'
    json.notitle = true
    json.url_u = x5on.url.syskeyedit
    json.data_u = { uid: memb.uid }
    json.arrsName = 'membs'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_edit?json=' + JSON.stringify(json) })
  },

  addClick: function (e) {
    var that = this
    var fields = [{
      mode: 1,
      name: 'id',
      label: '键值编号',
      message: '输入键值编号',
      type: 'text',
      maxlength: 10,
    }, {
      mode: 1,
      name: 'name',
      label: '键值名称',
      message: '输入键值名称',
      type: 'text',
      maxlength: 20,
    }]
    var rules = {
      id: {
        required: true,
        english: true,
        minlength: 4,
        maxlength: 10,
      },
      name: {
        required: true,
        chinese: true,
        minlength: 4,
        maxlength: 20,
      },
    }

    var json = {}
    json.title = '键值设置'
    json.notitle = true
    json.url_u = x5on.url.syskeyadd
    json.arrsName = 'membs'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

})