// pages/index/form_check.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var data = JSON.parse(e.json)
    this.setData(data)
  },

  formSubmit: function (e) {
    var that = this
    var data_u = that.data.data_u || {}
    data_u.uids = e.detail.uids
    that.data.url_u && x5on.http(that.data.url_u, data_u)
    .then(memb => {
      x5on.prevPage(page => {
        that.data.url_r && x5on.http(that.data.url_r, that.data.data_r)
        .then(membs => {
          page.setData({ membs })
        })
        wx.navigateBack()
      })
    })
    .catch(error => {
      x5on.showError(error)
    })
  },

})