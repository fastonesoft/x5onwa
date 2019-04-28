// pages/index/subset_add.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var data = JSON.parse(e.json)
    this.setData(data)
  },

  formSubmit: function (e) {
    var that = this
    var form = e.detail
    x5on.http(that.data.url_u, form)
      .then(memb => {
        x5on.prevPage(page => {
          if (that.data.url_r) {
            // 有刷新地址，就刷新
            x5on.http(that.data.url_r, that.data.data_r)
            .then(membs => {
              page.setData({ membs })
            })
          } else {
            var membs = page.data.membs
            membs = x5on.add(membs, memb, 'id')
            page.setData({ membs })
          }
          wx.navigateBack()
        })
      })
      .catch(error => {
        x5on.showError(that, error)
      })
  },

})