// pages/index/typeset_add.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var fields = [{
      mode: 1,
      label: '分类编号',
      name: 'id',
      type: 'number',
      maxlength: 2,
      min: 1,
    }, {
      mode: 1,
      label: '分类名称',
      name: 'name',
      type: 'text',
      maxlength: 2,
    }]
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
    this.setData({ fields, rules, messages })
  },

  formSubmit: function (e) {
    var that = this
    console.log(e)

  },

})