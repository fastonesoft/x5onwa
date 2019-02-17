// pages/index/userchilds.js
var x5on = require('../x5on.js')
import x5va from '../x5va.js'

Page({

  onShow: function () {
    var that = this
    x5on.check({
      success() {
        x5on.request({
          url: x5on.url.userset,
          success(users) {
            users.notchecked = !users.checked
            that.setData(users)
          }
        })
      },
      fail() {
        wx.switchTab({ url: '/pages/login/login'})
      }
    });
  },

  onLoad: function (e) {

    var that = this
    x5on.request({
      url: x5on.url.relation,
      success: function (result) {
        that.setData({ relations: result.data })
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

  pickerChange: function (e) {
    var index = e.detail.value
    if (index == -1) return

    var relation_id = this.data.relations[index].id
    this.setData({ pIndex: index, relation_id });
  },

  userchildSubmit: function (e) {
    var that = this
    var userchild = new x5va({
      name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      },
      idc: {
        required: true,
        idcard: true,
        idcardrange: [7, 16],
      },
      relation: {
        required: true,
        digits: true,
      }
    })
    userchild.checkForm(e, form => {
      let value = e.detail.value
      value.relation_id = that.data.relation_id


      x5on.postFormEx({
        url: x5on.url.userchildupdate,
        data: form,
        success: (res) => {
          var childs = res.data
          var mychildShow = childs.length > 0
          var userchildShow = false
          that.setData({ childs, mychildShow, userchildShow })
        }
      })
    }, error => {
      x5on.showError(that, error)
    })
  },

  returnClick: function (e) {
    wx.navigateBack()
  }

})