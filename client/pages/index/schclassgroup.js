// pages/index/schclassgroup.js

var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.http(x5on.url.schgrade)
      .then(radios => {
        that.setData({ radios })
      })
  },

  radioChange: function (e) {
    let that = this
    let { uid, radio } = e.detail
    let grade_id = radio.id
    that.setData({ grade_id, grade_group_id: null, membs: [] })
    x5on.http(x5on.url.schgradegroup, { grade_id })
    .then(groups => {
      that.setData({ groups })
    })
    .catch(error => {
      x5on.showError(error)
    })
  },

  groupChange: function (e) {
    let that = this
    let { uid, radio } = e.detail
    let grade_group_id = radio.id
    that.setData({ grade_group_id })
    x5on.http(x5on.url.schclassgroupclass, { grade_group_id })
    .then(membs => {
      that.setData({ membs })
    })
    .catch(error => {
      x5on.showError(error)
    })
  },

  removeClick: function (e) {
    let that = this
    x5on.http(x5on.url.schclassgroupdel, e.detail)
      .then(number => {
        x5on.delSuccess(number)
        var membs = that.data.membs
        membs = x5on.delArr(membs, 'uid', e.detail.uid)
        //
        that.setData({ membs })
      })
      .catch(error => {
        x5on.showError(error)
      })
  },

  setClick: function (e) {
    var that = this

    var json = {}
    json.title = '班级选择'
    json.notitle = true
    json.key = 'cls_name'
    json.url_q = x5on.url.schclassgroupclass2div
    json.data_q = { grade_id: that.data.grade_id }
    json.url_u = x5on.url.schclassgroupadds
    json.data_u = { grade_group_id: that.data.grade_group_id }
    json.url_r = x5on.url.schclassgroupclass
    json.data_r = { grade_group_id: that.data.grade_group_id }

    // 检测是否有数据
    x5on.http(json.url_q, json.data_q)
    .then(res => {
      if (res.length === 0) {
        throw '年级班级已全部分配'
      } else {
        wx.navigateTo({ url: 'form_check?json=' + JSON.stringify(json) })
      }
    })
    .catch(error => {
      x5on.showError(error)
    })
  },
  
})