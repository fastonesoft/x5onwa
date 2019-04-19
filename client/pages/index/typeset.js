// pages/index/typeset.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.prequest(x5on.url.typeset)
      .then(typesets => {
        that.setData({ typesets })
      })
  },

  memberRemove: function (e) {
    let that = this
    let { removed, membs } = e.detail
    let uid = removed.uid
    x5on.ppost(x5on.url.typesetdel, { uid })
      .then(number => {
        that.setData({ typesets: membs })
      })
      .catch(error => {
        console.log(error)
      })
  },

  addClick: function (e) {
    wx.navigateTo({ url: 'typeset_add' })
  },

  returnClick: function (e) {
    wx.navigateBack()
  },

})