// pages/index/typeset.js
var x5on = require('../x5on.js')

Page({

  data: {
    schoIndex: 0,
  },

  onload: function (e) {
    var that = this
    x5on.request({
      url: x5on.url.typeset,
      success(schos_typesets) {
        that.setData(schos_typesets)
      }
    })
  },

  typesetRemove: function (e) {
    var that = this
    x5on.request({
      url: x5on.url.typesetdel,
      success(typesets) {
        that.setData({ typesets })
      }
    })
  },

  returnClick: function (e) {
		wx.navigateBack()
  },


})