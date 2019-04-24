// pages/index/subset.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.prequest(x5on.url.subset)
      .then(membs => {
        that.setData({ membs })
      })
  },

  removeClick: function (e) {
    let that = this
    let { removed, membs } = e.detail
    let uid = removed.uid
    x5on.ppost(x5on.url.subsetdel, { uid })
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
      label: '学科编号',
      message: '输入学科编号',
      name: 'id',
      type: 'number',
      maxlength: 2,
    }, {
      mode: 1,
      label: '学科名称',
      message: '输入学科名称',
      name: 'name',
      type: 'text',
      maxlength: 2,
    }, {
      mode: 1,
      label: '学科简称',
      message: '输入学科简称',
      name: 'short',
      type: 'text',
      maxlength: 1,
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
      short: {
        required: true,
        chinese: true,
        minlength: 1,
      },
    }
    var json = {}
    json.title = '学科设置'
    json.url = x5on.url.subsetadd
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

  returnClick: function (e) {
    wx.navigateBack()
  },

})