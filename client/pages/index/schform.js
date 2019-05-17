// pages/index/form.js
var x5on = require('../x5on.js')

Page({

  onLoad: function(e) {
    var that = this
    x5on.http(x5on.url.schform)
    .then(res=>{
      var fields = [{
        mode: 3,
        label: '分类选择',
        name: 'type_id',
        picks: res.types,
        valueKey: 'id',
        rangeKey: 'name',
        selectKey: 'name',
        itemClick: 'itemClick',
        itemData: 'asdfasdf',
      }, {
        mode: 3,
        label: '分级选择',
        name: 'steps_id',
        picks: res.steps,
        valueKey: 'id',
        rangeKey: 'sch_step',
        selectKey: 'sch_step',
      }, {
        mode: 3,
        label: '年度选择',
        name: 'years_id',
        picks: res.years,
        valueKey: 'id',
        rangeKey: 'year',
        selectKey: 'year',
      }]
      var rules = {
        type_id: {
          required: true,
          min: 0,
        },
        steps_id: {
          required: true,
          min: 0,
        },
        years_id: {
          required: true,
          min: 0,
        }
      }
      that.setData({ fields, rules })
    })
    .catch(error=>{
      x5on.showError(error)
    })

  },

  formSubmit: function(e) {
    var that = this
    var data = e.detail
    that.setData({ data })
    x5on.http(x5on.url.schformforms, data)
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
        chinese: true,
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
    json.data_u = that.data.data
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
        chinese: true,
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

  itemChange: function(e) {
    console.log('---'+e)
  },

})