// pages/index/stud_come.js
var x5on = require('../x5on.js')
import x5va from '../x5va.js'

Page({

  data: {
    trans: [{ id: 0, name: '区县' }, { id: 1, name: '跨市' }, { id: 2, name: '跨省'}]
  },

  onLoad: function (options) {

  },

  transChange: function (e) {
    var that = this
    var stud_trans = e.detail.value
    that.setData({ stud_trans })
  },

  studcomeSubmit: function (e) {
    var that = this
    that.x5va = new x5va({
      stud_name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      },
      stud_idc: {
        required: true,
        idcard: true,
        idcardrange: [7, 18],
      },
      come_date: {
        required: true,
        date: true,
      },
      memo: {
        required: true,
        chinese: true,
        minlength: 4,
      },
      stud_trans: {
        required: true,
        min: 0,
      }
    }, {
        stud_idc: {
          required: '身份证号'
        },
        stud_name: {
          required: '学生姓名'
        },
        come_date: {
          required: '转学时间'
        },
        memo: {
          required: '转出学校'
        },
        stud_trans: {
          required: '转入方式'
        }
    })
    that.x5va.checkForm(e, function (form) {
      x5on.postFormEx({
        url: x5on.url.gradestudcome,
        data: e.detail.value,
        success: (result) => {
          var pages = getCurrentPages()
          var prevPage = pages[pages.length - 2]
          // 更新上一页数据
          var students = result.data
          prevPage.setData({ students })
          // 
          wx.navigateBack()
        }
      })
    }, function (error) {
      x5on.showError(that, error)
    })
  },

})