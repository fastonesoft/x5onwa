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
    Object.assign(form, that.data.data_u)
    that.data.url_u && x5on.http(that.data.url_u, form)
      .then(memb => {
        x5on.prevPage(page => {
          if (that.data.url_r) {
            // 指定刷新地址，更新数据
            x5on.http(that.data.url_r, that.data.data_r)
            .then(membs => {
              var membsName = that.data.membsName
              // 指定字段，则更新字段；没有字段，则更新数据
              membsName ? page.setData({ [membsName]: membs }) : page.setData(membs)
            })
          } else {
            // 没有地址，必须要指定字段
            var membsName = that.data.membsName
            if (membsName) {
              var membs = page.data[membsName]
              membs = x5on.add(membs, memb, 'id')
              page.setData({ [membsName]: membs })
            } else {
              throw '没有指定数据字段、没有指定更新地址'
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