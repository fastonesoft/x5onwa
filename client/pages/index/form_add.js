// pages/index/subset_add.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var data = JSON.parse(e.json)
    console.log(data)
    this.setData(data)
  },

  formSubmit: function (e) {
    var that = this
    var form = e.detail
    Object.assign(form, that.data.data_u)
    that.data.url_u && x5on.http(that.data.url_u, form)
      .then(memb => {
        x5on.prevPage(page => {
          if (that.data.url_r) {
            x5on.http(that.data.url_r, that.data.data_r)
            .then(membs => {
              var membsName = that.data.membsName
              membsName ? page.setData({ [membsName]: membs }) : page.setData({ membs })
            })
          } else {
            var membsName = that.data.membsName
            if (membsName) {
              var membs = page.data[membsName]
              membs = x5on.add(membs, memb, 'id')
              page.setData({ [membsName]: membs })
            } else {
              var membs = page.data.membs
              membs = x5on.add(membs, memb, 'id')
              page.setData({ membs })
            }

          }
          wx.navigateBack()
        })
      })
      .catch(error => {
        x5on.showError(that, error)
      })
  },

})