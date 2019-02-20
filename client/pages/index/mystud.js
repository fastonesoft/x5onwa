// pages/index/mystud.js
var x5on = require('../x5on.js');

Page({

  data: {
    dd: [{ name: 'name1' }, { name: 'name2' }]
  },

  onLoad: function (options) {

  },

  findSubmit: function (e) {
    var that = this
    var rules = {
      name: {
        required: true,
        idcard: true,
      },
      name1: {
        required: true,
        custom: '^\\d{3}-\\d{2}-\\d{2}$'
      }
    }
    var messages = {}

    x5on.checkForm(e, rules, messages, form => {
      that.setData({ form })
    }, message => {
      x5on.showError(that, message)
    })

  }

})