// pages/index/student.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    var uid = e.uid
    x5on.postFormEx({
      url: x5on.url.gradestuduid,
      data: { uid },
      success: (result) => {
        var student = result.data
        that.setData({ student })
      }
    })
  },

})