// pages/index/schfield.js
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
        that.setData({ canadd: false, forms, fields: [] })
      })
      .catch(error=>{
        x5on.showError(error)
      })
  },

  formChange: function(e) {
    var that = this
    x5on.http(x5on.url.schfieldfields, e.detail)
      .then(fields => {
        that.setData({ canadd: true, form_id: e.detail.form_id, fields })
      })
      .catch(error=>{
        x5on.showError(error)
      })
  },

  addClick: function(e) {
    var that = this
    var fields = [{
      mode: 3,
      name: 'mode',
      label: '字段类型',
      url: x5on.url.schfieldmodes,
      valueKey: 'id',
      rangeKey: 'name',
      selectKey: 'name',
    }, {
      mode: 1,
      label: '字段代码',
      message: '输入字段代码，英文字母',
      name: 'name',
      type: 'text',
      maxlength: 10,
    }, {
      mode: 1,
      label: '字段名称',
      message: '输入字段名称',
      name: 'label',
      type: 'text',
      maxlength: 10,
    }, {
      mode: 1,
      label: '字段序号',
      message: '输入字段序号',
      name: 'orde',
      type: 'number',
      maxlength: 2,
    }]
    var rules = {
      mode: {
        required: true,
      },
      name: {
        required: true,
        iden: true,
        minlength: 4,
        maxlength: 20,
      },
      label: {
        required: true,
        chinese: true,
        minlength: 4,
        maxlength: 20,
      },
      orde: {
        required: true,
        digits: true,
        maxlength: 2,
      },
    }

    var json = {}
    json.title = '字段设置'
    json.notitle = true
    json.url_u = x5on.url.schfieldadd
    json.data_u = { form_id: that.data.form_id }
    json.arrsName = 'fields'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

  removeClick: function(e) {
    var that = this
    x5on.http(x5on.url.schfielddel, e.detail)
      .then(number => {
        x5on.delSuccess(number)
        var fields = that.data.fields
        fields = x5on.delArr(fields, 'uid', e.detail.uid)
        //
        that.setData({ fields })
      })
      .catch(error=>{
        x5on.showError(error)
      })
  },

  editClick: function(e) {
    var field = e.detail
    var fields = [{
      mode: 1,
      label: '字段代码',
      message: '输入字段代码，英文字母',
      name: 'name',
      type: 'text',
      maxlength: 10,
      value: field.name,
    }, {
      mode: 1,
      label: '字段名称',
      message: '输入字段名称',
      name: 'label',
      type: 'text',
      maxlength: 10,
      value: field.label,
    }, {
      mode: 1,
      label: '字段序号',
      message: '输入字段序号',
      name: 'orde',
      type: 'number',
      maxlength: 2,
      value: field.orde,
    }]
    var rules = {
      name: {
        required: true,
        iden: true,
        minlength: 4,
        maxlength: 20,
      },
      label: {
        required: true,
        chinese: true,
        minlength: 4,
        maxlength: 20,
      },
      orde: {
        required: true,
        digits: true,
        maxlength: 2,
      },
    }
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