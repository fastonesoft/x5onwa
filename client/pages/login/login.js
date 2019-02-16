//index.js
var x5on = require('../x5on.js')
import x5va from '../x5va.js'

Page({

  onShow: function () {
    var that = this
    // 授权检测登录
    x5on.check({
      success() {
        x5on.request({
          donshow: true,
          url: x5on.url.user,
          success(users) {
            // 显示用户信息
            users.reged = true
            that.setData(users)
          },
          fail() {
            // 显示注册信息
            that.setData({ notreg: true })
          }
        })
      },
      fail() {
        // 显示授权按钮
        that.setData({ notauth: true })
      }
    });
  },

  bindAuth: function (e) {
    var that = this
    x5on.auth('scope.userInfo', () => {
      x5on.login({
        auth: e.detail,
        success(res) {
          // 登录成功，检测用户
          x5on.request({
            donshow: true,
            url: x5on.url.user,
            success(users) {
              users.notauth = false
              users.reged = true
              that.setData(users)
            },
            fail() {
              that.setData({ notauth: false, notreg: true })
            }
          })
        }
      });
    }, () => {
      x5on.showError(that, '拒绝授权，获取微信用户信息失败')
    })
  },

  regSubmit: function (e) {
    var that = this
    var reg = new x5va({
      name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      },
      mobil: {
        required: true,
        tel: true,
      }
    }, {
        name: {
          required: '学生姓名'
        },
        mobil: {
          required: '手机号码'
        }
    })
    reg.checkForm(e, function (form) {
      x5on.postFormEx({
        url: x5on.url.userreg,
        data: form,
        success: users => {
          users.reged = true
          users.notreg = false
          that.setData(users)
        }
      })
    }, function (error) {
      x5on.showError(that, error)
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

  childAdd: function () {
    wx.navigateTo({
      url: '/pages/index/userchilds',
      success: () => {
        // 
      }
    })
  },



  // // 上传图片接口
  // doUpload: function () {
  //   var that = this

  //   // 选择图片
  //   wx.chooseImage({
  //     count: 1,
  //     sizeType: ['compressed'],
  //     sourceType: ['album', 'camera'],
  //     success: function (res) {
  //       util.showBusy('正在上传')
  //       var filePath = res.tempFilePaths[0]

  //       // 上传图片
  //       wx.uploadFile({
  //         url: config.service.uploadUrl,
  //         filePath: filePath,
  //         name: 'file',

  //         success: function (res) {
  //           util.showSuccess('上传图片成功')
  //           console.log(res)
  //           res = JSON.parse(res.data)
  //           console.log(res)
  //           that.setData({
  //             imgUrl: res.data.imgUrl
  //           })
  //         },

  //         fail: function (e) {
  //           util.showModel('上传图片失败')
  //         }
  //       })

  //     },
  //     fail: function (e) {
  //       console.error(e)
  //     }
  //   })
  // },

  // // 预览图片
  // previewImg: function () {
  //   wx.previewImage({
  //     current: this.data.imgUrl,
  //     urls: [this.data.imgUrl]
  //   })
  // },

})
