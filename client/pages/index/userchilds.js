// pages/index/userchilds.js
var x5on = require('../x5on.js')

Page({
  data: {
    errorShow: false,
    errorMessage: '错误提示',
    errorArray: [1, 1],

    pIndex: -1,
    pickers: [],
    relation_id: 0,
    childs: [],
  },

  onLoad: function (e) {
    var that = this
    x5on.check({
      showError: true,
      success: () => {
        // 关系
        x5on.request({
          url: x5on.url.relation,
          success: function (result) {
            that.setData({ pickers: result.data })
          }
        })
        // 孩子
        x5on.request({
          url: x5on.url.parentchilds,
          success: function (result) {
            that.setData({ childs: result.data })
          }
        })
      }
    })
  },

  checkInput: function (e) {
    x5on.checkInput(e, this)
  },

  pickerChange: function (e) {
    var index = e.detail.value
    var relation_id = this.data.pickers[index].id
    this.setData({ pIndex: index, relation_id: relation_id });
  },

  userchildSubmit: function (e) {
    var that = this
    var value = e.detail.value
    if (value.name && value.idc && value.relation_id) {
      x5on.checkForm(this, 0, 1, function () {
        x5on.postFormEx({
          url: x5on.url.schcode,
          data: e.detail.value,
          success: (res) => {
            // 刷新孩子
            x5on.request({
              url: x5on.url.parentchilds,
              success: function (result) {
                that.setData({ childs: result.data })
              }
            })
          }
        })
      })
    } else {
      x5on.showError(that, '孩子信息、亲子关系不得为空！')
    }
  },

})