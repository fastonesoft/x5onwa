// pages/index/mystud.js
var x5on = require('../x5on.js');
import x5va from '../x5va.js'

Page({

  data: {
    dd: [{name:'name1'}, {name:'name2'}]
  },

  onLoad: function (options) {

  },

  findSubmit: function (e) {
    this.x5va = new x5va({
      name: {
        required: true,
        idcard: true,
      },
      name1: {
        required: true,
        custom: '^\\d{3}-\\d{2}-\\d{2}$'
      }
    })
    var that = this
    if (!that.x5va.checkForm(e)) {
      const error = that.x5va.errorList[0]
      x5on.showError(that, error.msg)
    }
    var form = that.x5va.form
    that.setData({ form })
    console.log(this)
  }

})