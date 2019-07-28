// pages/index/childset.js
var x5on = require('../x5on.js')

Page({

  findSubmit: function(e) {
    var that = this
    that.setData({ child: null, childs: [] })
    x5on.http(x5on.url.childset, e.detail)
		.then(childs=>{
			that.setData({ childs })
		})
		.catch(error=>{
			x5on.showError(error)
		})

  },

  radioChange: function(e) {
    this.setData({ child: e.detail })
  },

  buttonClick: function(e) {
    var { child } = this.data
    var fields = [{
      mode: 1,
      label: '孩子姓名',
      message: '输入孩子姓名',
      name: 'name',
      value: child.name,
      type: 'text',
      maxlength: 4,
    }, {
      mode: 1,
      label: '身份证号',
      message: '输入身份证号',
      name: 'idc',
      value: child.idc,
      type: 'idcard',
      maxlength: 18,
    }]
    var rules = {
      name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      },
      idc: {
        required: true,
        minlength: 18,
        idcard: true,
      }
    }

    var json = {}
    json.title = '孩子变更'
    json.notitle = true
    json.url_u = x5on.url.childsetupdate
    json.data_u = { uid: child.uid }
    json.arrsName = 'childs'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_edit?json=' + JSON.stringify(json) })
  }

})