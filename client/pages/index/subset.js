// pages/index/subset.js
var x5on = require('../x5on.js')

Page({

  subsetSubmit: function (e) {
    var that = this
    var rules = {
      user_uid: {
        required: true,
      },
      grade: {
        required: true,
        min: 0,
      },
      cls_uids: {
        required: true,
        arr: true,
      }
    }
    var messages = {
      user_uid: {
        required: '教师选择'
      },
      grade: {
        required: '年级选择'
      },
      cls_uids: {
        required: '班级选择'
      }
    }
    x5on.checkForm(e.detail.value, rules, messages, form => {
      form.grade_id = x5on.getId(that.data.grades, form.grade)
      form.cls_uid_jsons = JSON.stringify(form.cls_uids)
      x5on.post({
        url: x5on.url.mydividist,
        data: form,
        success(class_classed) {
          that.setData(class_classed)
        }
      })
    }, mes => {
      x5on.showError(that, mes)
    })
  },

})