//index.js
var x5on = require('../x5on.js')

var app = getApp()

Page({

  onShow: function () {
    var that = this
    // 显示格式
    var mes = {
      name: { label: '用户姓名', type: 0 },
      mobil: { label: '手机号码', type: 0 },
    }
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
    that.setData({ mes, fields, rules })
    // 授权检测登录
    x5on.check({
      success() {
        console.log('check-success')
        x5on.request({
          donshow: true,
          url: x5on.url.user,
          success(user_schs) {
            // 显示用户信息
            user_schs.reged = true
            user_schs.notreg = false
            that.setData(user_schs)
            // 记录状态
            app.globalData.user = user_schs.user
          },
          fail() {
            console.log(44)
            // 显示注册信息
            that.setData({ user: null, reged: false, notreg: true })
            // 记录状态
            app.globalData.user = null
          }
        })
      },
      fail() {
        console.log('check-fail')
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
          that.setData({ notauth: false })
          // 授权，检测是否已注册
          x5on.http(x5on.url.user, {}, true)
          .then(user=>{
            console.log(user)
            // 注册，显示用户信息
            user.reged = true
            that.setData(user)
            // 记录状态
            app.globalData.user = user
          })
          .catch(error=>{
            that.setData({ notreg: true })
          })
        }
      });
    }, () => {
      x5on.showError('拒绝授权，获取微信用户信息失败')
    })
  },

  regSubmit: function (e) {
    var that = this
    x5on.http(x5on.url.userreg, e.detail)
    .then(user=>{
      that.setData({ user, reged: true, notreg: false })
      // 记录状态
      app.globalData.user = user
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  userschsChange: function (e) {
    // 切换学校
    var { uid } = e.detail
    x5on.http(x5on.url.usersetchange, { uid })
    .then(res=>{
      x5on.showSuccess('切换成功')
    })
    .catch(error=>{
      x5on.showError(error)
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
