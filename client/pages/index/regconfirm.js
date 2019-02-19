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
            x5on.post({
              url: x5on.url.studconfirm,
              data: { uid },
              success: function (result) {
                var data = result.data
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
        x5on.post({
          url: x5on.url.studconfirmpass,
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
        x5on.post({
          url: x5on.url.studconfirmcancel,
          data: { regged_stud_uid },
          success: function (result) {
            var data = result.data
            that.setData(data)
          }
        })
      }
    })
  }
})