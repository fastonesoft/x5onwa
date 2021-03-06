// pages/index/schgradegroup.js

var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.http(x5on.url.schgrade)
      .then(grades => {
        that.setData({ grades })
      })
  },

  pickChange: function (e) {
    let that = this
    that.setData(e.detail)
    x5on.http(x5on.url.schgradegroup, e.detail)
    .then(membs => {
      that.setData({ membs })
    })
    .catch(error => {
      x5on.showError(error)
    })
  },

  removeClick: function (e) {
    let that = this
    x5on.http(x5on.url.schgradegroupdel, e.detail)
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
      label: '分组名称',
      message: '输入分组名称',
      type: 'text',
      value: memb.name,
      maxlength: 10,
    }]
    var rules = {
      name: {
        required: true,
        chinese: true,
        minlength: 3,
      },
    }
    
    var json = {}
    json.title = '分组设置'
    json.notitle = true
    json.url_u = x5on.url.schgradegroupedit
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
      name: 'grade_id',
      label: '年级编号',
      type: 'text',
      maxlength: 20,
      value: that.data.grade_id,
      disabled: true,
    }, {
      mode: 1,
      name: 'name',
      label: '分组名称',
      message: '输入分组名称',
      type: 'text',
      maxlength: 10,
    }]
    var rules = {
      grade_id: {
        required: true,
      },
      name: {
        required: true,
        chinese: true,
        minlength: 3,
      },
    }

    var json = {}
    json.title = '分组设置'
    json.notitle = true
    json.url_u = x5on.url.schgradegroupadd
    json.arrsName = 'membs'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

  returnClick: function (e) {
    wx.navigateBack()
  },
  
})