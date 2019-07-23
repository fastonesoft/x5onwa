// pages/index/regquery.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (options) {
    var that = this
    var mes = {
      total: { label: '审核总人数', type: 0 },
      female: { label: '：女生', type: 0 },
      male: { label: '：男生', type: 0 },
      notexam: { label: '未审核人数', type: 0 },
    }
    var mes_user = {
      exam_user_name: { label: '初审', type: 0 },
      rexam_user_name: { label: '复核', type: 0 },
      qrcode: { label: '二维码', type: 2 },
      passed: { label: '通过审核', type: 1 },
    }
    that.setData({ mes, mes_user })
    //
		x5on.http(x5on.url.regquery)
		.then(steps_auths=>{
			that.setData(steps_auths)
		})
		.catch(error=>{
			x5on.showError(error)
		})
  },

  pickChange: function(e) {
    var that = this
    that.setData(e.detail)
    var { steps_id, stud_auth } = that.data
    //
		steps_id && stud_auth && x5on.http(x5on.url.regquerycount, { steps_id, stud_auth })
		.then(count=>{
			that.setData({ count })
		})
		.catch(error=>{
			x5on.showError(error)
    })
    //
    steps_id && !stud_auth && x5on.http(x5on.url.regquerycount, { steps_id })
		.then(count=>{
			that.setData({ count })
		})
		.catch(error=>{
			x5on.showError(error)
		})
  },

  findSubmit: function(e) {
    var that = this
    var { steps_id } = that.data
    e.detail.steps_id = steps_id
    // 清除
    that.setData({ regstuds: [], regstud: null, fields: [] })

    x5on.http(x5on.url.regquerystud, e.detail)
    .then(regstuds=>{
      that.setData({ regstuds })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  studChange: function(e) {
    var that = this
    var regstud = e.detail
    var { uid } = e.detail
    // 显示学生信息
    that.setData({ regstud })
    x5on.http(x5on.url.regqueryparent, { uid })
    .then(fields_values=>{
      var { fields, values } = fields_values
      var { fields, rules } = x5on.fieldsRules(fields, values)
      // 显示家长信息
      that.setData({ fields, rules, no_title: true })
    })
    .catch(error=>{
      that.setData({ regstud: null })
      x5on.showError(error)
    })
  },

  arbiClick: function(e) {
    var that = this
    var { fields, rules } = that.data

    var json = {}
    json.title = '报表表格'
    json.notitle = true
    json.url_u = x5on.url.regqueryarbi
    // e.detail => { uid: xxx }
    json.data_u = e.detail
    json.fields = fields
    json.rules = rules
    
    wx.navigateTo({ url: 'form_edit?json=' + JSON.stringify(json) })

    // 关闭数据显示
    that.setData({ fields: [], rules: [], no_title: false })
  },

  retryClick: function(e) {
    var that = this
    x5on.http(x5on.url.regqueryretry, e.detail)
    .then(number=>{
      // 关闭数据显示
      that.setData({ fields: [], rules: [], no_title: false })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

})