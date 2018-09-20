// pages/index/userchilds.js
var x5on = require('../x5on.js')
import x5va from '../x5va.js'

Page({
  data: {
    pIndex: -1,
    pickers: [],
    relation_id: 0,
    childs: [],

    mychildShow: false,
    userchildShow: false,
  },

  onLoad: function (e) {
    this.x5va = new x5va({
      name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      },
      idc: {
        required: true,
        digits: true,
        idcard: true,
        idcardrange: [7, 16],
      },
      relation_id: {
        required: true,
        digits: true,
      }
    })
    var that = this
    x5on.request({
      url: x5on.url.relation,
      success: function (result) {
        that.setData({ pickers: result.data })
      }
    })
    x5on.request({
      url: x5on.url.parentchilds,
      success: function (result) {
        var childs = result.data
        var mychildShow = childs.length > 0
        var userchildShow = childs.length < 1
        that.setData({ childs, mychildShow, userchildShow })
      }
    })
  },

  inputCheck: function (e) {
    let that = this
    that.x5va.checkInput(e, function (error) {
      x5on.showError(that, error)
    }, function (form) {
      console.log(form)
      that.setData({ form })
    })
  },

  pickerChange: function (e) {
    var index = e.detail.value
    if (index == -1) return

    var relation_id = this.data.pickers[index].id
    this.setData({ pIndex: index, relation_id: relation_id });
  },

  userchildSubmit: function (e) {
    var that = this
    console.log(that.x5va)
    that.x5va.checkForm(e, function () {
      x5on.postFormEx({
        url: x5on.url.userchildupdate,
        data: e.detail.value,
        success: (res) => {
          var childs = res.data
          var mychildShow = childs.length > 0
          var userchildShow = false
          that.setData({ childs, mychildShow, userchildShow })
        }
      })
    }, function (error, form) {
      x5on.showError(that, error)
      that.setData({ form })
    })
  },

  returnClick: function (e) {
    wx.navigateBack()
  }

})