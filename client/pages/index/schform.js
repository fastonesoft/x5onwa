// pages/index/form.js
var x5on = require('../x5on.js')

Page({

  onLoad: function(e) {
    var that = this
    x5on.http(x5on.url.schform)
    .then(steps_types=>{
      that.setData(steps_types)
    })
    .catch(error=>{
      x5on.showError(error)
    })

  },

  stepChange: function(e) {
    var that = this
    var steps_id = e.detail.steps_id
    that.setData({ steps_id, years_id: null })
    // 取分级年度
    x5on.http(x5on.url.schformyears, { steps_id: e.detail.steps_id })
    .then(years=>{
      that.setData({ years })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  pickChange: function(e) {
    this.setData(e.detail)
  },

  findClick: function(e) {
    var that = this
    var { steps_id, years_id, type_id } = that.data
    x5on.http(x5on.url.schformforms, { steps_id, years_id, type_id })
    .then(forms=>{
      that.setData({ forms })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  removeClick: function(e) {
    var that = this
    x5on.http(x5on.url.schformdel, e.detail)
    .then(number=>{
      x5on.delSuccess(number)
      //
      var forms = that.data.forms
      forms = x5on.delArr(forms, 'uid', e.detail.uid)
      that.setData({ forms })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  addClick: function(e) {
    var that = this
    var fields = [{
      mode: 1,
      label: '表单名称',
      message: '输入表单名称',
      name: 'title',
      type: 'text',
      maxlength: 20,
    }, {
      mode: 2,
      label: '是否启用',
      name: 'notfixed',
    }]
    var rules = {
      title: {
        required: true,
        char: true,
        minlength: 4,
        maxlength: 20,
      },
      notfixed: {
        required: true,
      },
    }

    var json = {}
    json.title = '表单设置'
    json.notitle = true
    json.url_u = x5on.url.schformadd
    json.data_u = that.data
    json.arrsName = 'forms'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

  editClick: function(e) {
    var memb = e.detail
    var that = this
    var fields = [{
      mode: 1,
      label: '表单名称',
      message: '输入表单名称',
      name: 'title',
      value: memb.title,
      type: 'text',
      maxlength: 20,
    }, {
      mode: 2,
      label: '是否启用',
      name: 'notfixed',
      value: memb.notfixed,
    }]
    var rules = {
      title: {
        required: true,
        char: true,
        minlength: 4,
        maxlength: 20,
      },
      notfixed: {
        required: true,
      },
    }

    var json = {}
    json.title = '表单设置'
    json.notitle = true
    json.url_u = x5on.url.schformedit
    json.data_u = { uid: memb.uid }
    json.arrsName = 'forms'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_edit?json=' + JSON.stringify(json) })
  },

})