// pages/index/regstud.js
var x5on = require('../x5on.js')
import x5va from '../x5va.js'

Page({

  onShow: function () {
    var that = this
    x5on.check({
      success() {
        x5on.request({
          url: x5on.url.regstud,
          success(childs_schools_studregs) {
            that.setData(childs_schools_studregs)
          }
        })
      },
      fail() {
        wx.switchTab({ url: '/pages/login/login' })
      }
    });
  },

  schoolChange: function (e) {
    x5on.setPick(e, schIndex => {
      this.setData({ schIndex })
    })
  },

  childChange: function (e) {
    x5on.setPick(e, childIndex => {
      this.setData({ childIndex })
    })
  },

  regstudSubmit: function (e) {
    var that = this
    var regstud = new x5va({
      school: {
        required: true,
        min: 0,
      },
      child: {
        required: true,
        min: 0,
      }
    }, {
        school: {
          required: '学校选择'
        },
        schild: {
          required: '孩子选择'
        }
      })
    regstud.checkForm(e, form => {
      form.sch_id = x5on.getId(that.data.schools, form.school)
      form.child_id = x5on.getValue(that.data.childs, form.child, 'child_id')
      x5on.post({
        url: x5on.url.regstudreg,
        data: form,
        success(studreg) {
          var studregs = that.data.studregs
          studregs.push(studreg)
          that.setData({ studregs })
        }
      })
    }, error => {
      x5on.showError(that, error)
    })
  },

  checkClick: function (e) {
    var that = this
    var form = e.currentTarget.dataset
    x5on.post({
      data: form,
      url: x5on.url.regstudcheck,
      success(stud_reg_uid) {
        var studregs =  x5on.setValue(that.data.studregs, 'uid', stud_reg_uid, 'checked', 1)
        that.setData({ studregs })
      }
    })
  },

  cancelClick: function (e) {
    var that = this
    var form = e.currentTarget.dataset
    x5on.post({
      data: form,
      url: x5on.url.regstudcancel,
      success(stud_reg_uid) {
        var studregs = that.data.studregs
        x5on.delValue(studregs, 'uid', stud_reg_uid)
        that.setData({ studregs })
      }
    })
  },


  cancelSubmit: function (e) {
    var that = this
    x5on.check({
      success: () => {
        x5on.post({
          data: e.detail.value,
          url: x5on.url.regstudcancel,
          success: function (result) {
            that.setData(result.data)
          }
        })
      }
    })
  },

  // 动态创建的picker脚本（只能创一个）
  dynamChange: function (e) {
    var dynamIndex = e.detail.value
    if (dynamIndex == -1 || this.data.items.length == 0) return

    var uid = e.currentTarget.dataset.uid
    var items = this.data.items
    for (var i = 0; i < items.length; i++) {
      if (items[i].uid === uid) {
        items[i].error = false
        items[i].value = dynamIndex
      }
    }
    this.setData({ items })
  },

  uploadSubmit: function (e) {
    var that = this;
    x5on.checkFormEx(this, function () {
      x5on.post({
        data: e.detail.value,
        url: x5on.url.schoolformvalueupdate,
        success: function (result) {
          var infor_added = true
          var not_added = false
          var form_show = false
          var user_forms = result.data.user_forms
          var qrcode_data = result.data.qrcode_data
          that.setData({ form_show, infor_added, not_added, user_forms, qrcode_data })
          //
        }
      })
    })
  },

  returnClick: function (e) {
    wx.navigateBack()
  }

})