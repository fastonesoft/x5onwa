// pages/index/typeset_add.js
var x5on = require('../x5on.js')

Page({

  typesetaddSubmit: function (e) {
    var that = this
    var rules = {
      id: {
        required: true,
        digits: true,
        minlength: 1,
      },
      name: {
        required: true,
        chinese: true,
        minlength: 2,
      },
    }
    var messages = {
      id: {
        required: '分类编号'
      },
      name: {
        required: '分类名称'
      },
    }
    x5on.checkForm(e.detail.value, rules, messages, form => {
      x5on.post({
        url: x5on.url.mydividist,
        data: form,
        success(class_classed) {
          that.setData(class_classed)
        }
      })
    }, mes => {
      x5on.showError(that, mes)
    })
  },

})