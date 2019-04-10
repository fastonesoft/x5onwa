// pages/index/typeset.js
var x5on = require('../x5on.js')

Page({

  data: {
    typeseturl: x5on.url.typeset,
  },

  onLoad: function (e) {
    var that = this
    // x5on.request({
    //   url: x5on.url.typeset,
    //   success(schos_typesets) {
    //     that.setData(schos_typesets)
    //   }
    // })

  },


  memberRemove: function (e) {
    console.log(e)
  },

  findSubmit: function (e) {
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