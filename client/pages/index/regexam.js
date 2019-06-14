// pages/index/regexam.js
var x5on = require('../x5on.js')

Page({

  data: {
    fields: [],
  },

	onLoad: function(e) {
		var that = this
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
    var fields = []

    wx.scanCode({
      onlyFromCamera: true,
      success: (res) => {
        var uid = res.result
        //
        console.log(res) 
      }
    })
    
    this.setData({ fields })
  },

  examClick: function(e) {
    var fields = []
    this.setData({ fields })
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