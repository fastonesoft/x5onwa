// pages/index/typeset_add.js
var x5on = require('../x5on.js')

Page({

  data: {
    typeseturl: x5on.url.typeset,
  },


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
    }, {
      mode: 3,
      label: '选择测试1',
      name: 'selec1',
      picks: [{id: 0, name: '测试'}, {id: 1, name: '姓名'}],
      rangeKey: 'name',
      selectKey: 'name',
      valueKey: 'id',
    }, {
      mode: 3,
      label: '选择测试2',
      name: 'selec2',
      picks: [{id: 0, name: '李四'}, {id: 1, name: '王八'}],
      rangeKey: 'name',
      selectKey: 'name',
      valueKey: 'id',
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
      selec1: {
        required: true,
        min: 0,
      },
      selec2: {
        required: true,
        min: 0,
      },
    }
    var messages = {
      id: {
        required: '分类编号'
      },
      name: {
        required: '分类名称'
      },
      selec1: {
        required: '选择测试1',
      },
      selec2: {
        required: '选择测试2',
      },
    }
    this.setData({ fields, rules, messages })
  },

  formSubmit: function (e) {
    var that = this
    // wx.navigateBack()
  },

})