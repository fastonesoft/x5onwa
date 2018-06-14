// pages/index/roledist.js
var x5on = require('../x5on.js')

Page({
  data: {
    errorShow: false,
    errorMessage: '错误提示',
    errorArray: [1],

    radios: [],
    rIndex: 0,
  },

  checkInput: function (e) {
    x5on.checkInput(e, this)
  },

  findSubmit: function (e) {
    var that = this;
    // 检测登录
    x5on.check({
      showError: true,
      success: () => x5on.checkForm(that, 0, 0, function () {
        x5on.postForm({
          url: x5on.url.roledist,
          data: e.detail.value,
          success: (result) => {
            var data = result.data
            data.length === 0 ? x5on.showError(that, '没有找到你说的老师！') : that.setData({ radios: result.data })
          }
        })
      })
    });
  },

  radioChange: function (e) {
    var index = 0
    var radios = this.data.radios
    for (var i = 0; i < radios.length; ++i) {
      radios[i].checked = radios[i].id == e.detail.value
      index = radios[i].checked ? i : index
    }
    this.setData({ radios: radios, rIndex: index })
  },
})