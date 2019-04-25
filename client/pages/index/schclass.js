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
    x5on.ppost(x5on.url.schclassdel, { uid })
      .then(number => {
        that.setData({ membs })
      })
      .catch(error => {
        console.log(error)
      })
  },
  
  editClick: function (e) {

  },

  addClick: function (e) {
    var fields = [{
      mode: 1,
      name: 'code',
      label: '分级代号',
      message: '输入分级代号',
      type: 'number',
      maxlength: 2,
    }]
    var rules = {
      years_id: {
        required: true,
      },
      steps_id: {
        required: true,
      },
      edus_id: {
        required: true,
      },
    }

    var json = {}
    json.title = '年级设置'
    json.url = x5on.url.schclassadd
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

  returnClick: function (e) {
    wx.navigateBack()
  },
  
})