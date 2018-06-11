// pages/index/tchreg.js
var x5on = require('../x5on.js')

Page({

  data: {
    errorShow: false,
    errorMessage: '错误提示',
    errorArray: [1],

    radioItems: [],

    schId: '',
    schName: '学校选择',
    pickerItems: [],
    pickerDisabled: true
  },

  onLoad: function () {
    // 确定用户身份
    this.setData({
      schId: 'asdfasdfasdf',
      schName: '没有学校'
    })
  },

  checkInput: function (e) {
    x5on.checkInput(e, this)
  },

  findSubmit: function (e) {
    var that = this;
    // 检测登录
    x5on.check({
      showError: true,
      success: () => {
        x5on.checkForm(that, 0, 0, function () {
          x5on.postForm({
            url: x5on.url.tchreg,
            data: e.detail.value,
            success: (res) => {
              that.setData({
                radioItems: res.data
              })
            }
          })
        })      
      }
    });
  },

  updateSubmit: function (e) {

  },

  radioChange: function (e) {
    var radioItems = this.data.radioItems;
    for (var i = 0; i < radioItems.length; ++i) {
      radioItems[i].checked = radioItems[i].id == e.detail.value;
    }
    this.setData({
      radioItems: radioItems
    });
  },

  pickerChange: function (e) {

  }

})