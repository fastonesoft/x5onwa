// pages/index/form_lists.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var data = JSON.parse(e.json)
    this.setData(data)
  },

  returnClick: function(e) {
    wx.navigateBack()
  },
  
})