// pages/index/schcode.js
var x5on = require('../x5on.js')

Page({
  data: {
    errorShow: false,
    errorMessage: '错误提示',

    pIndex: -1,
    pickers: [],
    form_show: false,
    form_name: '',
    sIndex: -1,
    schers: [],
  },

  onLoad: function () {
    var that = this
    x5on.check({
      success: () => {
        // 学校
        x5on.request({
          url: x5on.url.tchsch,
          success: function (result) {
            var data = result.data
            that.setData({ schers: result.data })
          }
        })
        // 表单
        x5on.request({
          url: x5on.url.appform,
          success: function (result) {
            that.setData({ pickers: result.data })
          }
        })
      }
    })
  },

  checkInput: function (e) {
    x5on.checkInputEx(e, this)
  },

  scherChange: function (e) {
    var sIndex = e.detail.value
    if (sIndex == -1) return

    var sch_id = this.data.schers[sIndex].sch_id
    this.setData({ sIndex, sch_id, pIndex: -1, form_show: false })
  },

  pickerChange: function (e) {
    var that = this
    var pIndex = e.detail.value
    if ( pIndex == -1 ) return

    var form_id = this.data.pickers[pIndex].id
    var form_name = this.data.pickers[pIndex].name
    var sch_id = this.data.sch_id
    x5on.check({
      success: () => {
        x5on.postForm({
          data: { form_id, sch_id },
          url: x5on.url.appformkey,
          success: function (result) {
            var sch_coded = result.data.checked
            var items = result.data.items
            that.setData({ items, form_name, form_show: true, pIndex, form_id, sch_coded })
          }
        })
      }
    })
  },

  codeSubmit: function (e) {
    var that = this
    if (e.detail.value.sch_id && e.detail.value.form_id) {
      x5on.checkFormEx(this, function () {
        x5on.postForm({
          url: x5on.url.appformkeyupdate,
          data: e.detail.value,
          success: (res) => {
            that.setData({ sch_coded: true })
          }
        })
      })
    } else {
      x5on.showError(this, '学校选择、表单设置不得为空')
    }
  }
})