// pages/index/schs_add.js
var x5on = require('../x5on.js')

Page({

  schsaddSubmit: function (e) {
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
      full_name: {
        required: true,
        chinese: true,
        minlength: 2,
        maxlength: 50,
      },
    }
    var messages = {
      code: {
        required: '集团编号'
      },
      name: {
        required: '集团名称'
      },
      full_name: {
        required: '集团全称'
      },
    }
    x5on.checkForm(e.detail.value, rules, messages, form => {
      var pages = getCurrentPages();
      var prevPage = pages[pages.length - 2];
      form.area_id = x5on.getId(prevPage.data.areas, prevPage.data.areaIndex)
      x5on.post({
        url: x5on.url.schsdistadd,
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
  }

})