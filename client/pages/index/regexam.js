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
    }
    that.setData({ mes })
    
		x5on.http(x5on.url.regexam)
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
      success: res=>{
        var uid = res.result
        // 请求表单数据
        var { step_id } = that.data
        x5on.http(x5on.url.regexamfields, { uid, step_id })
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

  closeClick: function(e) {
    this.setData({ regstuds: [] })
  },


  examClick: function(e) {
    var that = this
    var { uid, stud_auth, regstuds } = that.data
    // 提交确认
    x5on.http(x5on.url.regexamexam, { uid, stud_auth })
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

  rejectClick: function(e) {
    var that = this
    var { uid } = that.data
    // 提交确认
    x5on.http(x5on.url.regexamreject, { uid })
    .then(number=>{
      // 清除显示
      this.setData({ regstuds: [], fields: [] })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

})