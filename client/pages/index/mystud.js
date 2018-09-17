// pages/index/mystud.js
var x5on = require('../x5on.js');
import x5valid from '../x5valid.js'

Page({

  data: {
  
  },

  onLoad: function (options) {
    this.x5valid = new x5valid({
      name: {
        required: true,
        idcard: true,
        idcardrange: [0, 30]
      },
      name1: {
        required: true,
        dateISO: true,
        date: true,
      }
    })
  },

  findSubmit: function (e) {
    var that = this
    if (!that.x5valid.checkForm(e)) {
      const error = that.x5valid.errorList[0]
      x5on.showError(that, error.msg)
    }
    var form = that.x5valid.form
    that.setData({ form })
  }

})