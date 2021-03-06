// pages/index/schclass.js

var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.http(x5on.url.schgrade)
      .then(grades => {
        that.setData({ grades })
      })
  },

  pickChange: function (e) {
    let that = this
    that.setData(e.detail)
    x5on.http(x5on.url.schclass, e.detail)
    .then(membs => {
      that.setData({ membs })
    })
    .catch(error => {
      x5on.showError(error)
    })
  },

  removeClick: function (e) {
    let that = this
    x5on.http(x5on.url.schclassdel, e.detail)
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
  
  editClick: function (e) {
    var memb = e.detail
    var fields = [{
      mode: 0,
      label: '班级条号',
      value: memb.cls_order,
    }, {
      mode: 1,
      name: 'num',
      label: '班级序号',
      message: '输入班级序号',
      type: 'number',
      value: memb.num,
      maxlength: 2,
    }]
    var rules = {
      num: {
        required: true,
      },
    }
    
    var json = {}
    json.title = '班级设置'
    json.notitle = true
    json.url_u = x5on.url.schclassedit
    json.data_u = { uid: memb.uid }
    json.arrsName = 'membs'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_edit?json=' + JSON.stringify(json) })
  },

  addClick: function (e) {
    var that = this
    var fields = [{
      mode: 1,
      name: 'grade_id',
      label: '年级编号',
      type: 'text',
      maxlength: 20,
      value: that.data.grade_id,
      disabled: true,
    }, {
      mode: 1,
      name: 'num',
      label: '班级序号',
      message: '输入班级序号',
      type: 'number',
      maxlength: 2,
    }]
    var rules = {
      grade_id: {
        required: true,
      },
      num: {
        required: true,
        digits: true,
        min: 1,
      },
    }

    var json = {}
    json.title = '班级设置'
    json.notitle = true
    json.url_u = x5on.url.schclassadd
    json.arrsName = 'membs'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

  setClick: function (e) {
    var that = this
    var fields = [{
      mode: 1,
      name: 'grade_id',
      label: '年级编号',
      type: 'text',
      maxlength: 20,
      value: that.data.grade_id,
      disabled: true,
    }, {
      mode: 1,
      name: 'nums',
      label: '班级总数',
      message: '输入班级总数',
      type: 'number',
      maxlength: 2,
    }]
    var rules = {
      grade_id: {
        required: true,
      },
      nums: {
        required: true,
        digits: true,
        min: 1,
      },
    }

    var json = {}
    json.title = '批量设置'
    json.notitle = true
    json.url_u = x5on.url.schclassadds
    json.arrsName = 'membs'
    json.fields = fields
    json.rules = rules
    json.url_r = x5on.url.schclass
    json.data_r = { grade_id: that.data.grade_id }

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

})