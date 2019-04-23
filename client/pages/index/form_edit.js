// pages/index/form_edit.jsvar x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var data = JSON.parse(e.json)
    let {title, editurl, fields, rules} = data
    this.setData({ title, editurl, fields, rules })
  },

  formSubmit: function (e) {
    var that = this
    var form = e.detail
    x5on.ppost(that.data.editurl, form)
      .then(memb => {
        x5on.prevPage(page => {
          var membs = page.data.membs
          membs = x5on.delArr(membs, 'id', memb.id)
          membs = x5on.add(membs, memb, 'id')
          page.setData({ membs })
          //
          wx.navigateBack()
        })
      })
      .catch(error => {
        x5on.showError(that, error)
      })
  },

})