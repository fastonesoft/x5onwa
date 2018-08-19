// pages/index/myadjust.js
var x5on = require('../x5on.js')

Page({

  data: {

  },

  onLoad: function (options) {
    var that = this
    x5on.request({
      url: x5on.url.myadjust,
      success: function (result) {
        // 年级列表
        that.setData(result.data)
      }
    })
  },

  gradeChange: function (e) {
    var that = this
    var gradeIndex = e.detail.value
    that.setData({ gradeIndex })
  },

  checkInput: function (e) {
    x5on.checkInput(e, this)
  },

})