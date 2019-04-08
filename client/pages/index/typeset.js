// pages/index/typeset.js
var x5on = require('../x5on.js')

Page({

  data: {
    schoIndex: 0,
  },

  onLoad: function (e) {
    var that = this
    // x5on.request({
    //   url: x5on.url.typeset,
    //   success(schos_typesets) {
    //     that.setData(schos_typesets)
    //   }
    // })

    x5on.request({
      url: x5on.url.mydivi,
      success(grades) {
        that.setData({ grades, schos: grades })
      }
    })
  },

  pick1Change: function (e) {
    console.log(e)
  },

  pick2Change: function (e) {
    console.log(e.detail)
  },

  typesetSubmit: function (e) {
    console.log(e)
  },

  memberRemove: function (e) {
    console.log(e)
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