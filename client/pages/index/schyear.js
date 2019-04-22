// pages/index/schyear.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.prequest(x5on.url.typeset)
      .then(membs => {
        that.setData({ membs })
      })
  },

  memberRemove: function (e) {
    let that = this
    let { removed, membs } = e.detail
    let uid = removed.uid
    x5on.ppost(x5on.url.typesetdel, { uid })
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
      label: '分类编号',
      message: '输入分类编号',
      name: 'id',
      type: 'number',
      maxlength: 2,
    }, {
      mode: 1,
      label: '分类名称',
      message: '输入分类名称',
      name: 'name',
      type: 'text',
      maxlength: 2,
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
    }
    var messages = {
      id: {
        required: '分类编号'
      },
      name: {
        required: '分类名称'
      },
    }

    var json = {}
    json.title = '分类设置'
    json.addurl = x5on.url.typesetadd
    json.fields = fields
    json.rules = rules
    json.messages = messages

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

  returnClick: function (e) {
    wx.navigateBack()
  },
  
})