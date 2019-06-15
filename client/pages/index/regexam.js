// pages/index/regexam.js
var x5on = require('../x5on.js')

Page({

  data: {
    fields: [],
  },

	onLoad: function(e) {
    var that = this
    var mes = {
      edu_type_name: { label: '学校类型', type: 0 },
      child_name: { label: '报名学生', type: 0 },
      schs_steps: { label: '报名学校', type: 0 },
      passed: { label: '审核通过', type: 1 },
      qrcode: { label: '审核二维码', type: 2 },
    }
    that.setData({ mes })
    
		x5on.http(x5on.url.studexam)
		.then(steps_auths=>{
			that.setData(steps_auths)
		})
		.catch(error=>{
			x5on.showError(error)
		})
  },

  pickChange: function(e) {
    this.setData(e.detail)
  },
  
  scanClick: function(e) {
    var that = this
    wx.scanCode({
      onlyFromCamera: true,
      success: (res) => {
        var uid = res.result
        var { step_id } = that.data
        // 请求表单数据
        x5on.http(x5on.url.studexamfields, { uid, step_id })
        .then(regstuds_fields_values=>{
          var { regstuds, fields, values } = regstuds_fields_values
          var { fields, rules } = x5on.fieldsRules(fields, values)
          // 显示
          that.setData({ regstuds, fields })	
        })
        .catch(error=>{
          x5on.showError(error)
        })
      }
    })
  },

  closeClick: function(e) {
    this.setData({ regstuds: [] })
  },


  primaryClick: function(e) {
    // 提交确认
    // todo

    // 显示结果
    var json = {}
    json.mode = ''
    // e.detail => { uid: xxx }
    json.data_u = e.detail
    json.arrsName = 'studregs'
    json.fields = fields
    json.rules = rules
    
    wx.navigateTo({ url: 'form_lists?json=' + JSON.stringify(json) })
  },

  warnClick: function(e) {
    console.log('warn')
  },


  passClick: function (e) {
    var that = this
    x5on.check({
      success: () => {
        var regged_stud_uid = that.data.regged_stud_uid
        var form_setted_uid = that.data.form_setted_uid
        x5on.post({
          url: x5on.url.studexampass,
          data: { regged_stud_uid, form_setted_uid },
          success: function (result) {
            var data = result.data
            that.setData(data)
          }
        })
      }
    })
  },

  cancelClick: function (e) {
    var that = this
    x5on.check({
      success: () => {
        var regged_stud_uid = that.data.regged_stud_uid
        var form_setted_uid = that.data.form_setted_uid
        x5on.post({
          url: x5on.url.studexamcancel,
          data: { regged_stud_uid, form_setted_uid },
          success: function (result) {
            var data = result.data
            that.setData(data)
          }
        })
      }
    })
  },

  nextClick: function (e) {
    var data = {}
    data.sch_name = ''
    data.child_name = ''
    data.form_name = ''
    data.user_forms = []
    data.can_show = false
    data.scanned = false
    data.passed = false
    this.setData(data)
  }

})