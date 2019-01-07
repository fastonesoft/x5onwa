// pages/index/stud_modi.js
var x5on = require('../x5on.js')
import x5va from '../x5va.js'

Page({

  data: {
    files: [
      'http://wafer-1253456186.cossh.myqcloud.com/569045613.jpg',
      'http://wafer-1253456186.cossh.myqcloud.com/860039340.jpg',
    ],
  },

  onLoad: function (e) {
    var that = this
    var uid = e.uid
    x5on.postFormEx({
      url: x5on.url.gradestuduid,
      data: { uid },
      success: (result) => {
        var student = result.data
        that.setData({ student })
      }
    })
  },

  studmodiSubmit: function (e) {
    var that = this
    e.detail.value.uid = that.data.student.uid
    that.x5va = new x5va({
      stud_idc: {
        required: true,
        idcard: true,
        idcardrange: [7, 18],
      },
      stud_name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      }
    }, {
      stud_idc: {
        required: '身份证号不得为空'
      },
      stud_name: {
        required: '学生姓名不得为空'
      }      
    })
    that.x5va.checkForm(e, function (form) {
      x5on.postFormEx({
        url: x5on.url.gradestudmodi,
        data: e.detail.value,
        success: (result) => {
          var pages = getCurrentPages()
          var prevPage = pages[pages.length - 2]
          // 更新上一页数据
          var students = result.data
          prevPage.setData({ students })
          // 
          wx.navigateBack()
        }
      })
    }, function (error) {
      x5on.showError(that, error)
    })
  },

  chooseImage: function (e) {
    var that = this;
    wx.chooseImage({
      sizeType: ['original'], // 可以指定是原图还是压缩图，默认二者都有
      sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
      success: function (res) {
        // 返回选定照片的本地文件路径列表，tempFilePath可以作为img标签的src属性显示图片
        console.log(res)
        that.setData({
          files: that.data.files.concat(res.tempFilePaths)
        });
      }
    })
  },
  previewImage: function (e) {
    wx.previewImage({
      current: e.currentTarget.id, // 当前显示图片的http链接
      urls: this.data.files // 需要预览的图片http链接列表
    })
  }

})