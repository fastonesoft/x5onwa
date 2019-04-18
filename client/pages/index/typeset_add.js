// pages/index/typeset_add.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var fields = [{
      mode: 1,
      label: '分类编号',
      message: '输入分类编号',
      name: 'id',
      type: 'number',
      maxlength: 2,
    }, {
      mode: 1,
      label: '分类名称',
      message: '输入分类名称',
      name: 'name',
      type: 'text',
      maxlength: 2,
    }]
    var rules = {
      id: {
        required: true,
        digits: true,
        minlength: 1,
        min: 1,
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
    var form = e.detail
    x5on.ppost(x5on.url.typesetadd, form)
    .then(typeset => {
      console.log(typeset)
    }, error => {

    })
    // wx.navigateBack()

    // mode: 3,
    // label: '选择测试1',
    // name: 'selec1',
    // url: x5on.url.typeset,
    // picks: [{id: 0, name: '测试'}, {id: 1, name: '姓名'}],
    // rangeKey: 'name',
    // selectKey: 'name',
    // valueKey: 'uid',
  },

})