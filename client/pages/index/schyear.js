// pages/index/schyear.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.prequest(x5on.url.schyear)
      .then(membs => {
        that.setData({ membs })
      })
  },

  memberRemove: function (e) {
    let that = this
    let { removed, membs } = e.detail
    let uid = removed.uid
    x5on.ppost(x5on.url.schyeardel, { uid })
      .then(number => {
        that.setData({ membs })
      })
      .catch(error => {
        console.log(error)
      })
  },

  addClick: function (e) {
    var fields = [{
      mode: 1,
      label: '年度年份',
      message: '输入年度年份',
      name: 'year',
      type: 'number',
      maxlength: 4,
    }, {
      mode: 2,
      label: '当前年度',
      message: '输入当前年度',
      name: 'is_current',
    }]
    var rules = {
      year: {
        required: true,
        digits: true,
        minlength: 4,
      },
      is_current: {
        required: true,
      },
    }
    var messages = {
      year: {
        required: '年度年份'
      },
      is_current: {
        required: '当前年度'
      },
    }

    var json = {}
    json.title = '年度设置'
    json.addurl = x5on.url.schyearadd
    json.fields = fields
    json.rules = rules
    json.messages = messages

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

  returnClick: function (e) {
    wx.navigateBack()
  },
  
})