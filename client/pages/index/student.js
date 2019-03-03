// pages/index/student.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.request({
      url: x5on.url.userchilds,
      success(childs) {
        that.setData({ childs })
      }
    })
  },

  childChange: function (e) {
    var that = this
    x5on.setPick(e, childIndex => {
      that.setData({ childIndex })

      var formValue = {}
      formValue.uid = x5on.getValue(that.data.childs, childIndex, 'child_uid')
      var rules = {
        uid: {
          required: true,
        }
      }
      var messages = {
        uid: {
          required: '孩子编号'
        }
      }
      x5on.checkForm(formValue, rules, messages, form => {
        x5on.post({
          url: x5on.url.userchildstudent,
          data: form,
          success(studinfor) {
            that.setData(studinfor)
          }
        })
      }, message => {
        x5on.showError(that, message)
      })
    })
  },

  returnClick: function (e) {
    wx.navigateBack()
  }

})