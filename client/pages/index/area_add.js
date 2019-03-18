// pages/index/area_add.js
var x5on = require('../x5on.js')

Page({

  areaddSubmit: function (e) {
    var that = this
    var rules = {
      id: {
        required: true,
        digits: true,
        minlength: 6,
        maxlength: 6,
      },
      name: {
        required: true,
        chinese: true,
        minlength: 2,
        maxlength: 20,
      }
    }
    var messages = {
      id: {
        required: '地区编码'
      },
      name: {
        required: '地区名称'
      }
    }
    x5on.checkForm(e.detail.value, rules, messages, form => {
      var pages = getCurrentPages();
      var prevPage = pages[pages.length - 2];
      form.area_type = x5on.getId(prevPage.data.areatypes, prevPage.data.areatypeIndex)
      x5on.post({
        url: x5on.url.areadistadd,
        data: form,
        success(areas_members) {
          areas_members.areaIndex = -1
          prevPage.setData(areas_members)
          //
          x5on.showSuccess('地区添加成功')
          wx.navigateBack()
        }
      })
    }, mes => {
      x5on.showError(that, mes)
    })
  }

})