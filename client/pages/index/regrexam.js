// pages/index/regexam.js
var x5on = require('../x5on.js')

Page({

  data: {
    regstuds: [],
  },

	onLoad: function(e) {
    var that = this
    var mes = {
      child_name: { label: '报名学生', type: 0 },
      schs_steps: { label: '报名学校', type: 0 },
      qrcode: { label: '审核二维码', type: 2 },
      stud_auth: { label: '是否指标生', type: 1 },
    }
    that.setData({ mes })
    
		x5on.http(x5on.url.regrexam)
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
  
  scanClick: function (e) {
    var that = this
    wx.scanCode({
      onlyFromCamera: true,
      success: res=>{
        var uid = res.result
        // 请求表单数据
        var { step_id } = that.data
        x5on.http(x5on.url.regrexamfields, { uid, step_id })
        .then(regstuds_fields_values=>{
          var { regstuds, fields, values } = regstuds_fields_values
          var { fields, rules } = x5on.fieldsRules(fields, values)
          // 显示
          that.setData({ uid, regstuds, fields })	
        })
        .catch(error=>{
          x5on.showError(error)
        })
      }
    })
  },

  closeClick: function (e) {
    this.setData({ regstuds: [] })
  },

  rexamClick: function (e) {
    var that = this
    var { uid, regstuds } = that.data
    // 提交确认
    x5on.http(x5on.url.regrexamrexam, { uid })
    .then(number=>{
      // 显示结果：一、打开学生关闭按钮，二、清除表格数据
      if (regstuds.length>0) {
        regstuds[0].canClose = 1
        that.setData({ regstuds })
      }
      that.setData({ fields: [] })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  rejectClick: function (e) {
    var that = this
    var { uid, regstuds } = that.data
    // 提交确认
    x5on.http(x5on.url.regrexamreject, { uid })
    .then(number=>{
      // 清除显示
      if (regstuds.length>0) {
        regstuds[0].canClose = 1
        that.setData({ regstuds })
      }
      that.setData({ fields: [] })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

})