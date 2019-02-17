// pages/index/userchilds.js
var x5on = require('../x5on.js')
import x5va from '../x5va.js'

Page({

  onShow: function () {
    var that = this
    x5on.check({
      success() {
        x5on.request({
          url: x5on.url.userchilds,
          success(userchilds) {
            that.setData({ userchilds })
          }
        })
        x5on.request({
          url: x5on.url.userchildsrelation,
          success(relations) {
            that.setData({ relations })
          }
        })
      },
      fail() {
        wx.switchTab({ url: '/pages/login/login'})
      }
    });
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
        min: 0,
      }
    }, {
      name: {
        required: '孩子姓名'
      },
      idc: {
        required: '身份证号'
      },
      relation: {
        required: '亲子称谓'
      }
    })
    userchild.checkForm(e, form => {
      console.log(form)

      // x5on.postFormEx({
      //   url: x5on.url.userchildupdate,
      //   data: form,
      //   success: (res) => {
      //     var childs = res.data
      //     var mychildShow = childs.length > 0
      //     var userchildShow = false
      //     that.setData({ childs, mychildShow, userchildShow })
      //   }
      // })
    }, error => {
      x5on.showError(that, error)
    })
  },

  returnClick: function (e) {
    wx.navigateBack()
  }

})