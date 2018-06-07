// pages/index/schcode.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    showTopTips: false,
    errorMessage: '错误提示',
    numCheck: new Array(0,0,0,0,0,0)
  },

  /**
   * 检测输入是否为数值
   */
  checkInput: function (event) {
    var reg = event.currentTarget.dataset.reg
    var index = event.currentTarget.dataset.index
    var message = event.currentTarget.dataset.message
    var value = event.detail.value
    var patt = new RegExp(reg, 'g')
    this.replaceDataOnPath([this.data.numCheck, index], !patt.test(value))
    this.setData({
      errorMessage: message
    })
  },
  showTopTips: function () {
    var that = this;
    this.setData({
      showTopTips: true
    });
    setTimeout(function () {
      that.setData({
        showTopTips: false
      });
    }, 3000);
  },
  orderReset: function () {
    
  }
})