//index.js
var config = require('../../config')
var util = require('../../utils/util.js')
var x5on = require('../x5on.js')

Page({

  onShow: function () {
    var that = this
    // 授权检测登录
    x5on.check({
      success: () => {
        x5on.request({
          donshow: true,
          url: x5on.url.user,
          success: users => {
            // 显示用户信息
            users.reged = true
            that.setData(users)
          },
          fail: error => {
            // 显示注册信息
            that.setData({ notreg: true })
          }
        })
      },
      fail: () => {
        // 显示授权按钮
        that.setData({ notauth: true })
      }
    });
  },

  inforClick: function () {
    wx.navigateTo({
      url: '/pages/index/userset',
      success: () => {
        // 
      }
    })
  },

  childAdd: function () {
    wx.navigateTo({
      url: '/pages/index/userchilds',
      success: () => {
        // 
      }
    })
  },

  bindGetUserInfo: function (e) {
    var that = this
    x5on.auth('scope.userInfo', () => {
      x5on.login({
        auth: e.detail,
        success(res) {
          // 登录成功，检测用户
          x5on.request({
            donshow: true,
            url: x5on.url.user,
            success: users => {
              users.reged = true
              that.setData(users)
            },
            fail: error => {
              that.setData({ notreg: true })
            }
          })
        }
      });
    }, () => {
      x5on.showError(that, '拒绝授权，获取微信用户信息失败')
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
