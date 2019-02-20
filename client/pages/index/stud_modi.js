// pages/index/stud_modi.js
var x5on = require('../x5on.js')

Page({

  data: {
    files: [
      'http://wafer-1253456186.cossh.myqcloud.com/569045613.jpg',
      'http://wafer-1253456186.cossh.myqcloud.com/860039340.jpg',
    ],
  },

  onLoad: function (e) {
    var that = this
    x5on.post({
      url: x5on.url.gradestuduid,
      data: e,
      success: student => {
        // 学生
        var stud_type_id = student.stud_type_id
        var stud_status_id = student.stud_status_id
        x5on.request({
          url: x5on.url.gradestudstatus,
          success: status => {
            // 状态
            var stud_status = x5on.getIndex(status, stud_status_id)
            x5on.request({
              url: x5on.url.gradestudtype,
              success: types => {
                // 来源
                var stud_type = x5on.getIndex(types, stud_type_id)
                that.setData({ student, status, types, stud_status, stud_type })
              }
            })
          }
        })
      }
    })
  },

  typesChange: function (e) {
    var stud_type = e.detail.value
    this.setData({ stud_type })
  },

  statusChange: function (e) {
    var stud_status = e.detail.value
    this.setData({ stud_status })
  },

  studmodiSubmit: function (e) {
    var that = this
    var rules = {
      stud_idc: {
        required: true,
        idcard: true,
        idcardrange: [7, 18],
      },
      stud_name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      },
      stud_type: {
        required: true,
        min: 0,
      },
      stud_status: {
        required: true,
        min: 0,
      }
    }
    var messages = {
      stud_idc: {
        required: '身份证号'
      },
      stud_name: {
        required: '学生姓名'
      },
      stud_type: {
        required: '学生来源'
      },
      stud_status: {
        required: '学籍状态'
      }
    }
    x5on.checkForm(e, rules, messages, form => {
      form.uid = that.data.student.uid
      form.stud_type_id = x5on.getId(that.data.types, form.stud_type)
      form.stud_status_id = x5on.getId(that.data.status, form.stud_status)
      x5on.post({
        url: x5on.url.gradestudmodi,
        data: form,
        success: students => {
          var pages = getCurrentPages()
          var prevPage = pages[pages.length - 2]
          //
          var male = 0, female = 0
          students.forEach(student => {
            student.stud_sex_num ? male++ : female++
          })
          var comeshow = students.length !== 0
          prevPage.setData({ students, comeshow, male, female })
          //
          wx.navigateBack()
        }
      })
    }, message => {
      x5on.showError(that, message)
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