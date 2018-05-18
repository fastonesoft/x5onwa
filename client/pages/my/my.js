//index.js
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')
var x5on = require('../../utils/x5on.js')

var app = getApp();
Page({
    data: {
        logged: false,
        userInfo: {},
    },

    onPullDownRefresh: function () {
        // 检测是否登录
        if (!logged) x5on.qcloudLogin(app)
        else util.showSuccess('已经登录了')

        // 停止动画
        wx.stopPullDownRefresh();
    },

    onShow: function () {
        this.setData({
            logged: app.logged,
            userInfo: app.userInfo
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
                        res = JSON.parse(res.data)
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
        });
    }
})
