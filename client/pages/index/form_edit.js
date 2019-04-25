// pages/index/form_edit.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var data = JSON.parse(e.json)
    this.setData(data)
  },

  formSubmit: function (e) {
    var that = this
    var form = e.detail
    form.uid = this.data.uid
    x5on.ppost(that.data.url, form)
      .then(memb => {
        x5on.prevPage(page => {
          if (that.data.refresh_url) {
            // 有刷新地址，就刷新
            if (that.data.data) {
              x5on.ppost(that.data.refresh_url, that.data.data)
              .then(membs => {
                page.setData({ membs })
              })
            } else {
              x5on.prequest(that.data.refresh_url)
              .then(membs => {
                page.setData({ membs })
              })
            }
          } else {
            var membs = page.data.membs
            membs = x5on.delArr(membs, 'id', memb.id)
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