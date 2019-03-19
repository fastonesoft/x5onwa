// pages/index/sch_add.js
var x5on = require('../x5on.js')

Page({

  schaddSubmit: function (e) {
    var that = this
    var rules = {
      code: {
        required: true,
        digits: true,
        minlength: 2,
        maxlength: 2,
      },
      name: {
        required: true,
        chinese: true,
        minlength: 4,
        maxlength: 20,
      },
      edutype: {
        required: true,
        min: 0,
      }
    }
    var messages = {
      code: {
        required: '学校编号'
      },
      name: {
        required: '学校名称'
      },
      edutype: {
        required: '学制类型'
      }
    }
    x5on.checkForm(e.detail.value, rules, messages, form => {
      var pages = getCurrentPages();
      var prevPage = pages[pages.length - 2];
      form.schs_id = x5on.getId(prevPage.data.schs, prevPage.data.schsIndex)
      form.edu_type_id = x5on.getId(that.data.edutypes, form.edutype)
      x5on.post({
        url: x5on.url.schdistadd,
        data: form,
        success(schs_members) {
          schs_members.schsIndex = -1
          prevPage.setData(schs_members)
          //
          x5on.showSuccess('添加成功')
          wx.navigateBack()
        }
      })
    }, mes => {
      x5on.showError(that, mes)
    })

  },

  edutypeChange: function (e) {
		var that = this
		x5on.setPick(e, edutypeIndex => {
			that.setData({ edutypeIndex })
		})
  },

})