// pages/index/subset_add.js
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
    console.log(formData)
    // 存在，字段
    field && (
      formData = { update: 'field', field: JSON.stringify(formData) }
    )
    // 存在，规则
    rule && (
      formData = { update: 'rule', rule: JSON.stringify(x5on.delRule(formData)) }
    )
    // 不存在，则封装数据与参数
    Object.assign(data, formData)
    that.data.url_u && x5on.http(that.data.url_u, data)
      .then(item => {
        x5on.prevPage(page => {
          if (that.data.url_r) {
            // 指定刷新地址，更新数据（这个选项不能少，目的是为了应对有些记录添加会影响别的记录的情况）
            x5on.http(that.data.url_r, that.data.data_r)
            .then(arrs => {
              var arrsName = that.data.arrsName
              // 指定字段，则更新字段；
              // 没有字段，则不更新数据
              arrsName && page.setData({ [arrsName]: arrs })
            })
          } else {
            // 没有地址，指定字段，更新字段
            var arrsName = that.data.arrsName
            if (arrsName) {
              var arrs = page.data[arrsName]
              if (Array.isArray(arrs)) {
                // 检测是否为数组，是数组，删除原始，插入新值
                arrs = x5on.add(arrs, item, 'id')
                page.setData({ [arrsName]: arrs })
              } else {
                // 不是数组，直接更新字段
                page.setData({ [arrsName]: result })
              }
            } else {
              // 没有地址，没有字段，不更新数据
              // page.setData(item)
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