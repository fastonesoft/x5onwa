// pages/index/typeset.js
var x5on = require('../x5on.js')

Page({

  data: {
    typeseturl: x5on.url.typeset,
  },

  memberRemove: function (e) {
    var types = []
    types.push(e.detail.removed)
    this.setData({
      types
    })
  },


  addClick: function (e) {
    wx.navigateTo({ url: 'typeset_add' })
  },

  returnClick: function (e) {
    wx.navigateBack()
  },












})