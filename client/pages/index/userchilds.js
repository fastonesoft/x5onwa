// pages/index/userchilds.js
var x5on = require('../x5on.js')

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
        wx.switchTab({ url: '/pages/login/login' })
      }
    });
  },

  relationChange: function (e) {
    x5on.setPick(e, relationIndex => {
      this.setData({ relationIndex })
    })
  },

  userchildSubmit: function (e) {
    var that = this
    var rules = {
      name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      },
      idc: {
        required: true,
        idcard: true,
        idcardrange: [7, 18],
      },
      relation: {
        required: true,
        min: 0,
      }
    }
    var messages = {
      name: {
        required: '孩子姓名'
      },
      idc: {
        required: '身份证号'
      },
      relation: {
        required: '亲子称谓'
      }
    }
    x5on.checkForm(e, rules, messages, (form, error) => {
      form.relation_id = x5on.getId(that.data.relations, form.relation)
      x5on.post({
        url: x5on.url.userchildsreg,
        data: form,
        success(userchilds) {
          that.setData({ userchilds })
        }
      })
    }, (message, error) => {
      that.setData({ error })
      x5on.showError(that, message)
    })
  },

  regedClick: function (e) {
    wx.navigateTo({ url: `/pages/index/student?uid=${e.currentTarget.dataset.uid}` })
  },

  returnClick: function (e) {
    wx.navigateBack()
  }

})