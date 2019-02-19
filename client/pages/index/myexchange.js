// pages/index/myexchange.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.request({
      url: x5on.url.myadjustexchangelist,
      success: function (result) {
        var exchangelists = result.data
        that.setData({ exchangelists })
      }
    })
  },

  scanSubmit: function (e) {
    var that = this
    wx.scanCode({
      onlyFromCamera: true,
      success: (res) => {
        var btn_show = false
        var qrcode_data = ''
        var movestud = []
        var exchangestud = []
        var exchangestuds = []
        that.setData({ btn_show, qrcode_data, movestud, exchangestud, exchangestuds })

        var move_grade_stud_uid = res.result
        that.setData({ move_grade_stud_uid })
        x5on.post({
          url: x5on.url.myadjuststudscanmove,
          data: { move_grade_stud_uid },
          success: function (result) {
            var exchangestuds = result.data
            that.setData({ exchangestuds })
          }
        })
      }
    })
  },

  studentChange: function (e) {
    var that = this
    var exchangestuds = this.data.exchangestuds

    for (var index = 0; index < exchangestuds.length; index++) {
      var item = exchangestuds[index]
      var grade_stud_uid = e.detail.value
      item.checked = item.uid === e.detail.value
    }
    this.setData({ exchangestuds })
  },

  exchangeSubmit: function (e) {
    var that = this
    var grade_stud_uid = e.detail.value.grade_stud_uid
    var exchange_grade_stud_uid = this.data.move_grade_stud_uid
    x5on.post({
      url: x5on.url.myadjustaddexchange,
      data: { grade_stud_uid, exchange_grade_stud_uid },
      success: function (result) {
        var exchangestuds = []
        var exchangelists = result.data
        that.setData({ exchangelists, exchangestuds })
      }
    })
  },

  showexchangestud: function (e) {
    var that = this
    var grade_stud_uid = e.currentTarget.dataset.uid
    x5on.post({
      url: x5on.url.myadjustqueryexchange,
      data: { grade_stud_uid },
      success: function (result) {
        var data = result.data
        var btn_show = true
        var movestud = data.movestud
        var exchangestud = data.exchangestud
        var qrcode_data = data.qrcode_data
        that.setData({ btn_show, movestud, exchangestud, qrcode_data })
      }
    })
  },

  liststudRemove: function (e) {
    var that = this
    var grade_stud_uid = e.currentTarget.dataset.uid
    x5on.post({
      url: x5on.url.myadjustremoveliststud,
      data: { grade_stud_uid },
      success: function (result) {
        var btn_show = false
        var qrcode_data = ''
        var movestud = []
        var exchangestud = []
        var exchangestuds = []
        var exchangelists = result.data
        that.setData({ btn_show, qrcode_data, movestud, exchangestud, exchangelists })
      }
    })
  },

})