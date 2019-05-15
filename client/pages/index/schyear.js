// pages/index/schyear.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.http(x5on.url.schyear)
      .then(membs => {
        that.setData({ membs })
      })
  },

  removeClick: function (e) {
    let that = this
    x5on.http(x5on.url.schyeardel, e.detail)
      .then(number => {
                // todo,是不是有问题
        that.setData({ membs })
      })
      .catch(error => {
        console.log(error)
      })
  },

  editClick: function (e) {
    var memb = e.detail
    var fields = [{
      mode: 0,
      label: '年度年份',
      value: memb.year,
    }, {
      mode: 2,
      label: '当前年度',
      name: 'current_year',
      value: memb.current_year
    }]
    var rules = {
      current_year: {
        required: true,
      },
    }

    var json = {}
    json.title = '年度设置'
    json.notitle = true
    json.url_u = x5on.url.schyearedit
    json.data_u = { uid: memb.uid }
    json.fields = fields
    json.rules = rules
    json.url_r = x5on.url.schyear

    wx.navigateTo({ url: 'form_edit?json=' + JSON.stringify(json) })
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
      name: 'current_year',
    }]
    var rules = {
      year: {
        required: true,
        digits: true,
        minlength: 4,
      },
      current_year: {
        required: true,
      },
    }

    var json = {}
    json.title = '年度设置'
    json.notitle = true
    json.url_u = x5on.url.schyearadd
    json.fields = fields
    json.rules = rules
    json.url_r = x5on.url.schyear

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

  returnClick: function (e) {
    wx.navigateBack()
  },
  
})