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
      .then(item => {
        x5on.prevPage(page => {
          if (that.data.url_r) {
            // 指定刷新地址，更新数据（这个选项不能少，目的是为了应对有些记录添加会影响别的记录的情况）
            x5on.http(that.data.url_r, that.data.data_r)
            .then(arrs => {
              var arrsName = that.data.arrsName
              // 指定字段，则更新字段；没有字段，则更新数据
              arrsName ? page.setData({ [arrsName]: arrs }) : page.setData(arrs)
            })
          } else {
            // 没有地址，指定字段，更新字段
            var arrsName = that.data.arrsName
            if (arrsName) {
              var arrs = page.data[arrsName]
              arrs = x5on.add(arrs, item, 'id')
              page.setData({ [arrsName]: arrs })
            } else {
              // 没有地址，没有字段，更新数据
              page.setData(item)
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