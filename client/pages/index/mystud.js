// pages/index/mystud.js
var x5on = require('../x5on.js');
import x5valid from '../x5valid.js'

Page({

  data: {
  
  },

  onLoad: function (options) {
    this.x5valid = new x5valid({
      name: {
        required: true
      }
    }, {
      name: {
        required: '不能为空'
      }
    })
  },

  findSubmit: function (e) {
    var that = this
    console.log(e)
    if (!that.x5valid.checkForm(e)) {
      const error = that.x5valid.errorList[0]
      console.log(error)
      x5on.showError(that, error.msg)
    }
  }

})