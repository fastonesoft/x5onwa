// pages/index/schgradegroup.js

var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.prequest(x5on.url.schgrade)
      .then(radios => {
        that.setData({ radios })
      })
  },

  radioChange: function (e) {
    let that = this
    let { uid, radio } = e.detail
    let grade_id = radio.id
    that.setData({ grade_id })
    x5on.ppost(x5on.url.schgradegroup, { grade_id })
    .then(membs => {
      console.log(membs)
      that.setData({ membs })
    })
    .catch(error => {
      console.log(error)
    })
  },

  removeClick: function (e) {
    let that = this
    let { removed, membs } = e.detail
    let uid = removed.uid
    x5on.ppost(x5on.url.schgradegroupdel, { uid })
      .then(number => {
        that.setData({ membs })
      })
      .catch(error => {
        console.log(error)
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
    json.uid = memb.uid
    json.title = '分组设置'
    json.url = x5on.url.schgradegroupedit
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
    json.url = x5on.url.schgradegroupadd
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

  returnClick: function (e) {
    wx.navigateBack()
  },
  
})