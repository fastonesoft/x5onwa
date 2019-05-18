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
    console.log(form)
    Object.assign(form, that.data.data_u)
    that.data.url_u && x5on.http(that.data.url_u, form)
      .then(result => {
        x5on.prevPage(page => {
          if (that.data.url_r) {
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
              if (Array.isArray(arrs)) {
                // 检测是否为数组，是数组，修改数组当前改动的对象
                arrs = x5on.setArr(arrs, 'uid', result.uid, result)
                page.setData({ [arrsName]: arrs })
              } else {
                // 不是数组，直接更新字段
                page.setData({ [arrsName]: result })
              }
            } else {
              // 没有地址，没有字段，更新数据
              page.setData(result)
            }
          }
          wx.navigateBack()
        })
      })
      .catch(error => {
        x5on.showError(error)
      })
  },

})