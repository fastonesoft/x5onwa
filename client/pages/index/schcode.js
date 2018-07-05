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
    sIndex: 0,
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
            var sch_id = data.length > 0 ? data[0].sch_id : ''
            that.setData({ schers: result.data, sch_id })
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
    console.log(e)
  },

  scherChange: function (e) {
    var sIndex = e.detail.value
    var sch_id = this.data.schers[sIndex].sch_id
    this.setData({ sIndex, sch_id })
  },

  pickerChange: function (e) {
    var that = this
    var pIndex = e.detail.value
    var form_id = this.data.pickers[pIndex].id
    var form_name = this.data.pickers[pIndex].name
    var sch_id = this.data.sch_id
    x5on.check({
      success: () => {
        x5on.postFormEx({
          data: { form_id, sch_id },
          url: x5on.url.appformkey,
          success: function (result) {
            var items = result.data
            console.log(items)
            that.setData({ items, form_name, form_show: true, pIndex, form_id })
          }
        })
      }
    })
  },

  codeSubmit: function (e) {
    x5on.checkFormEx(this, function () {
      console.log(e.detail.value)
      x5on.postFormEx({
        url: x5on.url.appformkeyupdate,
        data: e.detail.value,
        success: (res) => {
          console.log(res)
        }
      })
    })
  }
})