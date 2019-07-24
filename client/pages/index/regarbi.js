// pages/index/regarbi.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (options) {
    var that = this
		x5on.http(x5on.url.regarbi)
		.then(steps=>{
			that.setData({ steps })
		})
		.catch(error=>{
			x5on.showError(error)
		})
  },

  pickChange: function(e) {
    this.setData(e.detail)
  },

  findSubmit: function(e) {
    var that = this
    var { steps_id } = that.data
    e.detail.steps_id = steps_id
    // 清除
    that.setData({ regstuds: [], uid: null })
    x5on.http(x5on.url.regarbistud, e.detail)
    .then(regstuds=>{
      that.setData({ regstuds })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  studChange: function(e) {
    var { uid } = e.detail
    this.setData({ uid })
  },

  arbiClick: function(e) {
    var that = this
    var { uid } = that.data

    x5on.http(x5on.url.regarbiparent, { uid })
    .then(fields_values=>{
      var { fields, values } = fields_values
      var { fields, rules } = x5on.fieldsRules(fields, values)

      // 显示仲裁
      var json = {}
      json.title = '报表表格'
      json.notitle = true
      json.url_u = x5on.url.regarbiarbi
      json.data_u = { uid }
      json.fields = fields
      json.rules = rules
      
      wx.navigateTo({ url: 'form_edit?json=' + JSON.stringify(json) })
    })
    .catch(error=>{
      x5on.showError(error)
    })

    // 关闭按钮
    that.setData({ uid: null })
  },

})