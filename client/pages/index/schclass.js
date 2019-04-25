// pages/index/schclass.js

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
    x5on.ppost(x5on.url.schclass, { grade_id })
    .then(membs => {
      that.setData({ uid, membs })
    })
    .catch(error => {
      console.log(error)
    })
  },

  removeClick: function (e) {
    let that = this
    let { removed, membs } = e.detail
    let uid = removed.uid
    x5on.ppost(x5on.url.schclassdel, { uid })
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
      name: 'num',
      label: '班级序号',
      message: '输入班级序号',
      type: 'number',
      value: memb.num,
      maxlength: 2,
    }]
    var rules = {
      uid: {
        required: true,
      },
      num: {
        required: true,
      },
    }
    
    var json = {}
    json.uid = memb.uid
    json.title = '班级设置'
    json.url = x5on.url.schclassedit
    json.fields = fields
    json.rules = rules
    json.refresh_url = x5on.url.schclass

    wx.navigateTo({ url: 'form_edit?json=' + JSON.stringify(json) })
  },

  addClick: function (e) {
    var fields = [{
      mode: 1,
      name: 'uid',
      label: '班级编号',
      message: '输入班级编号',
      type: 'text',
      maxlength: 36,
      disabled: true,
    }, {
      mode: 1,
      name: 'num',
      label: '班级序号',
      message: '输入班级序号',
      type: 'number',
      maxlength: 2,
    }]
    var rules = {
      uid: {
        required: true,
      },
      num: {
        required: true,
      },
    }

    var json = {}
    json.title = '班级设置'
    json.url = x5on.url.schclassadd
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

  returnClick: function (e) {
    wx.navigateBack()
  },
  
})