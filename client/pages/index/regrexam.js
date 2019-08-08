// pages/index/regexam.js
var x5on = require('../x5on.js')

Page({

  data: {
    regstuds: [],
    groups: [
      {id: 'A', name: 'A组'},
      {id: 'B', name: 'B组'},
      {id: 'C', name: 'C组'},
      {id: 'D', name: 'D组'},
      {id: 'E', name: 'E组'},
      {id: 'F', name: 'F组'},
      {id: 'G', name: 'G组'},
      {id: 'H', name: 'H组'},
      {id: 'J', name: 'J组'},
      {id: 'K', name: 'K组'},
      {id: 'M', name: 'M组'},
      {id: 'N', name: 'N组'},
    ]
  },

	onLoad: function(e) {
    var that = this
    var mes = {
      child_name: { label: '报名学生', type: 0 },
      schs_steps: { label: '报名学校', type: 0 },
      qrcode: { label: '审核二维码', type: 2 },
      is_auth: { label: '是否指标生', type: 1 },
      group_num: { label: '分组编号', type: 0 },
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
        var { steps_id } = that.data
        x5on.http(x5on.url.regrexamfields, { uid, steps_id })
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
    var { uid, steps_id, group_name } = that.data
    // 提交确认
    x5on.http(x5on.url.regrexamrexam, { uid, steps_id, group_name })
    .then(regstuds=>{
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
    // 提交退回
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