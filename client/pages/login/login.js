//index.js
var x5on = require('../x5on.js')

var app = getApp()

Page({

  onShow: function () {
    var that = this
    // 授权检测登录
    x5on.check({
      success() {
        x5on.request({
          donshow: true,
          url: x5on.url.user,
          success(user_schs) {
            // 显示格式
            var mes = {
              name: { label: '用户姓名', type: 0 },
              mobil: { label: '手机号码', type: 0 },
            }
            // 显示用户信息
            user_schs.reged = true
            that.setData(user_schs)
            that.setData({ mes })
            // 记录状态
            app.globalData.user = user_schs.user
          },
          fail() {
            // 注册字段
            var fields = [{
              mode: 1,
              label: '用户姓名',
              message: '输入您的姓名',
              name: 'name',
              type: 'text',
              maxlength: 4,
            }, {
              mode: 1,
              label: '手机号码',
              message: '输入您的手机号码',
              name: 'mobil',
              type: 'number',
              maxlength: 11,
            }]
            var rules = {
              name: {
                required: true,
                minlength: 2,
                maxlength: 4,
                chinese: true,
              },
              mobil: {
                required: true,
                minlength: 11,
                maxlength: 11,
                tel: true,
              },
            }
            // 显示注册信息
            that.setData({ notreg: true, fields, rules })
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
      x5on.showError('拒绝授权，获取微信用户信息失败')
    })
  },

  regSubmit: function (e) {
    var that = this

    console.log(e.detail)

    x5on.post({
      url: x5on.url.userreg,
      data: form,
      success(user) {
        var users = {}
        users.user = user
        users.reged = true
        users.notreg = false
        that.setData(users)
      }
    })

  },

  userschsChange: function (e) {
    var that = this
    x5on.setRadioex(that.data.userschs, e.detail.value, 'is_current', userschs => {
      that.setData({ userschs })
      // 切换学校
      x5on.post({
        url: x5on.url.usersetchange,
        data: { uid: e.detail.value },
        success(sch_members) {
          x5on.showSuccess('切换成功')
        }
      })
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
