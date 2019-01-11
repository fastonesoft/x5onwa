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
    x5on.postFormEx({
      url: x5on.url.gradestuduid,
      data: e,
      success: student => {
        that.setData({ student })
        //
        var stud_status_id = student.stud_status_id
        x5on.requestEx({
          url: x5on.url.gradestudstatus,
          success: status => {
            var stud_status = x5on.getIndex(status, stud_status_id)
            that.setData({ status, stud_status })
          }
        })
      }
    })

  },

  studmodiSubmit: function (e) {
    var that = this
    e.detail.value.uid = that.data.student.uid
    that.x5va = new x5va({
      uid: {
        required: true,
        minlength: 32,
        maxlength: 32,
      },
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
        required: '身份证号'
      },
      stud_name: {
        required: '学生姓名'
      }      
    })
    that.x5va.checkForm(e, function (form) {
      x5on.postFormEx({
        url: x5on.url.gradestudmodi,
        data: form,
        success: students => {
          var pages = getCurrentPages()
          var prevPage = pages[pages.length - 2]
          prevPage.setData({ students })
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