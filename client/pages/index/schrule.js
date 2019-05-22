// pages/index/schrule.js

var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.http(x5on.url.schfield)
      .then(steps => {
        that.setData({ steps })
      })
      .catch(error=>{
        x5on.showError(error)
      })
  },

  pickChange: function(e) {
    var that = this
    x5on.http(x5on.url.schfieldforms, e.detail)
      .then(forms => {
        that.setData({ forms, fields: [] })
      })
      .catch(error=>{
        x5on.showError(error)
      })
  },

  formChange: function(e) {
    var that = this
    x5on.http(x5on.url.schfieldfields, e.detail)
      .then(fields => {
        that.setData({ field: null, form_id: e.detail.form_id, fields })
      })
      .catch(error=>{
        x5on.showError(error)
      })
  },

  fieldChange: function(e) {
    var that = this
    that.setData({ field: e.detail })
  },

  fieldClick: function(e) {
    var that = this
    var field = that.data.field
    var value = JSON.parse(field.field)
    
    var rules = {}
    var fields = []
    if (field.mode === 1) {
      fields = [{
        mode: 1,
        name: 'message',
        label: '输入提示',
        message: '输入提示信息',
        type: 'text',
        maxlength: 10,
        value: value && value.message ? value.message : null,
      }, {
        mode: 1,
        name: 'maxlength',
        label: '最大长度',
        message: '输入最大长度',
        type: 'number',
        maxlength: 4,
        value: value && value.maxlength ? value.maxlength : null,
      }, {
        mode: 3,
        name: 'type',
        label: '输入类型',
        picks: [{name: 'text'}, {name: 'number'}, {name: 'idcard'}],
        rangeKey: 'name',
        selectKey: 'name',
        valueKey: 'name',
        value: value && value.type ? value.type : null,
      }]
      rules = {
        message: {
          required: true,
          chinese: true,
          minlength: 4,
          maxlength: 20,
        },
        maxlength: {
          required: true,
          digits: true,
          min: 1,
        },
        type: {
          required: true,
        },
      }
    }

    if (field.mode === 2) {
      x5on.showError('选择框不必设置相关字段')
      return
    }


    var json = {}
    json.title = '字段设置'
    json.notitle = true
    json.url_u = x5on.url.schrule
    json.data_u = { uid: field.uid, field: 'field' }
    json.arrsName = 'fields'
    json.field = true
    json.rule = false
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_edit?json=' + JSON.stringify(json) })
  },

  ruleClick: function(e) {
    var field = e.detail    
    var json = {}
    json.title = '字段设置'
    json.notitle = true
    json.url_u = x5on.url.schfieldedit
    json.data_u = { uid: field.uid }
    json.arrsName = 'fields'
    json.fields = fields
    json.rules = rules
    
    wx.navigateTo({ url: 'form_edit?json=' + JSON.stringify(json) })
  },
  
})