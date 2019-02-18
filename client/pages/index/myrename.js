// pages/index/myrename.js
var x5on = require('../x5on.js')

Page({

  data: {
    grades: [],
    items: [],
  },

  onLoad: function (options) {
    var that = this
    x5on.request({
      url: x5on.url.myrename,
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

    // 班级列表
    var grade_id = this.data.grades[gradeIndex].id
    x5on.postForm({
      url: x5on.url.myrenameclass,
      data: { grade_id },
      success: function (result) {
        var items = result.data
        items.forEach(function (item) {
          item.error = false
        })
        that.setData({ items })
      }
    })
  },

  checkInput: function (event) {
    var that = this
    var data = this.data.items
    var reg = /\d{1,2}/
    var message = '班级号码输入有误'
    x5on.checkInputReg({
      event, that, data, reg, message, success: function (items) {
        that.setData({ items })
    }})  
  },

  myrenameSubmit: function (e) {
    var that = this
    x5on.checkFormReg(that, '班级号码输入有误', function () {
      x5on.postForm({
        url: x5on.url.myrenameupdate,
        data: e.detail.value,
        success: (result) => {
          x5on.showSuccess('更新' + result.data + '条记录')
        }
      })
    })
  },

})