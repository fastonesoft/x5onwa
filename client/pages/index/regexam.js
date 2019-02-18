// pages/index/regexam.js
var x5on = require('../x5on.js')

Page({

  scanClick: function (e) {
    var that = this
    x5on.check({
      success: () => {
        wx.scanCode({
          onlyFromCamera: true,
          success: (res) => {
            var uid = res.result
            x5on.postForm({
              url: x5on.url.studexam,
              data: { uid },
              success: function (result) {
                var data = result.data
                data.scanned = true
                that.setData(data)
              }
            })
          }
        })
      }
    })
  },

  passClick: function (e) {
    var that = this
    x5on.check({
      success: () => {
        var regged_stud_uid = that.data.regged_stud_uid
        var form_setted_uid = that.data.form_setted_uid
        x5on.postForm({
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
        x5on.postForm({
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