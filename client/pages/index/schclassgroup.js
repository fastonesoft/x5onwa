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
    that.setData({ grade_id, grade_group_id: null })
    x5on.http(x5on.url.schgradegroup, { grade_id })
    .then(groups => {
      that.setData({ groups })
    })
    .catch(error => {
      console.log(error)
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
      console.log(error)
    })
  },

  removeClick: function (e) {
    let that = this
    let { removed, membs } = e.detail
    let uid = removed.uid
    x5on.http(x5on.url.schclassgroupdel, { uid })
      .then(number => {
        that.setData({ membs })
      })
      .catch(error => {
        console.log(error)
      })
  },

  setClick: function (e) {
    var that = this

    var json = {}
    json.title = '班级选择'
    json.url_q = x5on.url.schclassgroupclass2div
    json.data_q = { grade_id: that.data.grade_id }
    json.key = 'cls_name'
    json.url_u = x5on.url.schclassgroupadds
    json.data_u = { grade_group_id: that.data.grade_group_id }
    json.url_r = x5on.url.schclassgroupclass
    json.data_r = { grade_group_id: that.data.grade_group_id }

    wx.navigateTo({ url: 'form_check?json=' + JSON.stringify(json) })
  },

  returnClick: function (e) {
    wx.navigateBack()
  },
  
})