// pages/index/stud_come.js
Page({


  data: {

  },

  onLoad: function (options) {

  },

  studcomeSubmit: function (e) {
    var that = this
    e.detail.value.uid = that.data.student.uid
    that.x5va = new x5va({
      stud_idc: {
        required: true,
        idcard: true,
        idcardrange: [7, 18],
      },
      stud_name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      }
    }, {
        stud_idc: {
          required: '身份证号不得为空'
        },
        stud_name: {
          required: '学生姓名不得为空'
        }
      })
    that.x5va.checkForm(e, function (form) {
      x5on.postFormEx({
        url: x5on.url.gradestudmodi,
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