// pages/index/form_edit.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var data = JSON.parse(e.json)
    this.setData(data)
  },

  formSubmit: function (e) {
    var that = this
    var data = that.data.data_u || {}
    var rule = that.data.rule
    var field = that.data.field

    var formData = e.detail
    // 存在，没有指定属性字段 json = JSON.stringif( { id: '11', value: 12 } )
    field && (
      formData = { update: 'field', field: JSON.stringify(formData) }
    )
    // 存在，指定属性字段 => name: { id: '11', value: 12 }
    rule && (
      formData = { update: 'rule', rule: JSON.stringify(x5on.delRule(formData)) }
    )
    // 不存在，则封装数据与参数
    Object.assign(data, formData)
    that.data.url_u && x5on.http(that.data.url_u, data)
      .then(result => {
        x5on.prevPage(page => {
          if (that.data.url_r) {
            x5on.http(that.data.url_r, that.data.data_r)
              .then(arrs => {
                var arrsName = that.data.arrsName
                // 指定字段，则更新字段
                // 没有字段，则不更新数据
                arrsName && page.setData({ [arrsName]: arrs })
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
              // page.setData(result)
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