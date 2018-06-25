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
      success: () => x5on.request({
        url: x5on.url.relation,
        success: function (result) {
          that.setData({ pickers: result.data })
        }
      })
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
        x5on.postForm({
          url: x5on.url.schcode,
          data: e.detail.value,
          success: (res) => {
            console.log(res)
          }
        })
      })
    } else {
      x5on.showError(that, '孩子信息、亲子关系不得为空！')
    }
  },

})