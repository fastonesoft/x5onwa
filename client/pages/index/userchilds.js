// pages/index/userchilds.js
var x5on = require('../x5on.js')

Page({

  onLoad: function () {
    var that = this
    x5on.http(x5on.url.userchilds)
    .then(userchilds=>{
      var mes = {
        child_name: { label: '孩子姓名', type: 0 },
        child_idc: { label: '身份证号', type: 0 },
        child_relation: { label: '亲子关系', type: 0 },
      }
      that.setData({ mes, userchilds })
    })
    .catch(error=>{
      x5on.showError(that, error)
    })
  },

  addClick: function(e) {
    var that = this
    var fields = [{
      mode: 1,
      label: '孩子姓名',
      message: '输入孩子姓名',
      name: 'name',
      type: 'text',
      maxlength: 4,
    }, {
      mode: 1,
      label: '身份证号',
      message: '输入身份证号',
      name: 'idc',
      type: 'text',
      maxlength: 18,
    }, {
      mode: 3,
      label: '亲子称谓',
      name: 'relation_id',
      url: x5on.url.userchildsrelation,
      valueKey: 'id',
      rangeKey: 'name',
      selectKey: 'name',
    }]
    var rules = {
      name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      },
      idc: {
        required: true,
        idcard: true,
        idcardrange: [7, 18],
      },
      relation_id: {
        required: true,
        min: 0,
      }
    }

    var json = {}
    json.title = '孩子添加'
    json.notitle = true
    json.url_u = x5on.url.userchildsreg
    json.arrsName = 'userchilds'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

})