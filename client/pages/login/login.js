//index.js
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')
var x5on = require('../x5on.js')

var app = getApp()
Page({
  data: {

  },

  onShow: function () {
    var that = this
    x5on.check({
      success: function () {
        const session = qcloud.Session.get()
        var userinfor = session ? session.userinfo : null
        var logged = session ? true : false
        var notlogged = !logged
        // 未登录，即出
        if (notlogged) return
        // 个人信息
        x5on.request({
          showError: false,
          url: x5on.url.userset,
          success: function (result) {
            var items = result.data.data
            var inforchecked = result.data.checked
            var notchecked = !inforchecked
            that.setData({ items, inforchecked, notchecked, logged, notlogged, userinfor })
          },
          fail: function () {
            that.setData({ logged: false, notlogged: true, userinfor: null })
          }
        });
        // 孩子信息
        x5on.request({
          showError: false,
          url: x5on.url.parentchilds,
          success: function (result) {
            var childs = result.data
            var mychildShow = childs.length > 0
            var canaddChild = childs.length < 1
            that.setData({ childs, mychildShow, canaddChild })
          },
          fail: function () {
            that.setData({ logged: false, notlogged: true, userinfor: null })
          }
        });
      },
      fail: function () {
        that.setData({ logged: false, notlogged: true, userinfor: null })
      }
    })
  },

  inforClick: function () {
    wx.navigateTo({
      url: '/pages/index/userset',
      success: () => {
        // 
      }
    })
  },
  
  childAdd: function() {
    wx.navigateTo({
      url: '/pages/index/userchilds',
      success: () => {
        // 
      }
    })
  },

  bindGetUserInfo: function (e) {
    var that = this;
    x5on.login({
      e: e,
      success: function () {   
        // 不能改
        that.onShow()
      },
      fail: function() {
        that.setData({ logged: false, notlogged: true, userinfor: null })
      }
    });
  },

  canScan: function () {
    // 只允许从相机扫码
    wx.scanCode({
      onlyFromCamera: true,
      success: (res) => {
        console.log(res)
      }
    })
  },

  // 上传图片接口
  doUpload: function () {
    var that = this

    // 选择图片
    wx.chooseImage({
      count: 1,
      sizeType: ['compressed'],
      sourceType: ['album', 'camera'],
      success: function (res) {
        util.showBusy('正在上传')
        var filePath = res.tempFilePaths[0]

        // 上传图片
        wx.uploadFile({
          url: config.service.uploadUrl,
          filePath: filePath,
          name: 'file',

          success: function (res) {
            util.showSuccess('上传图片成功')
            console.log(res)
            res = JSON.parse(res.data)
            console.log(res)
            that.setData({
              imgUrl: res.data.imgUrl
            })
          },

          fail: function (e) {
            util.showModel('上传图片失败')
          }
        })

      },
      fail: function (e) {
        console.error(e)
      }
    })
  },

  // 预览图片
  previewImg: function () {
    wx.previewImage({
      current: this.data.imgUrl,
      urls: [this.data.imgUrl]
    })
  },

})
