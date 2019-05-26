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

    if (field.mode === 3) {
      fields = [{
        mode: 1,
        name: 'rangeKey',
        label: '列表字段',
        message: '输入列表字段',
        type: 'text',
        maxlength: 20,
        value: value && value.rangeKey ? value.rangeKey : null,
      }, {
        mode: 1,
        name: 'selectKey',
        label: '选中字段',
        message: '输入选中字段',
        type: 'text',
        maxlength: 20,
        value: value && value.selectKey ? value.selectKey : null,
      }, {
        mode: 1,
        name: 'valueKey',
        label: '返回值字段',
        message: '输入返回值字段',
        type: 'text',
        maxlength: 20,
        value: value && value.valueKey ? value.valueKey : null,
      }, {
        mode: 1,
        name: 'data',
        label: '请求参数',
        message: '输入请求参数，key_id',
        type: 'text',
        maxlength: 100,
        value: value && value.data ? value.data : null,
      }]
      rules = {
        rangeKey: {
          required: true,
          english: true,
          maxlength: 20,
        },
        selectKey: {
          required: true,
          english: true,
          maxlength: 20,
        },
        valueKey: {
          required: true,
          english: true,
          maxlength: 20,
        },
        data: {
          required: true,
          english: true,
          maxlength: 50,
        },
      }
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
    var that = this
    var field = that.data.field
    var value = JSON.parse(field.rule)
    
    var fields = [{
      mode: 2,
      label: '必须字段',
      name: 'required',
      value: value && value.required ? value.required : false,
    }, {
      mode: 2,
      label: '手机号码',
      name: 'tel',
      value: value && value.tel ? value.tel : false,
    }, {
      mode: 2,
      label: '日期',
      name: 'date',
      value: value && value.date ? value.date : false,
    }, {
      mode: 2,
      label: '数字',
      name: 'number',
      value: value && value.number ? value.number : false,
    }, {
      mode: 2,
      label: '非负整数',
      name: 'digits',
      value: value && value.digits ? value.digits : false,
    }, {
      mode: 2,
      label: '英文标识符',
      name: 'iden',
      value: value && value.iden ? value.iden : false,
    }, {
      mode: 2,
      label: '英文字符',
      name: 'english',
      value: value && value.english ? value.english : false,
    }, {
      mode: 2,
      label: '中文字符',
      name: 'chinese',
      value: value && value.chinese ? value.chinese : false,
    }, {
      mode: 2,
      label: '身份证号',
      name: 'idcard',
      value: value && value.idcard ? value.idcard : false,
    }, {
      mode: 2,
      label: '手机号码验证字段',
      name: 'tel',
      value: value && value.tel ? value.tel : false,
    }, {
      mode: 2,
      label: '手机号码验证字段',
      name: 'tel',
      value: value && value.tel ? value.tel : false,
    }, {
      mode: 2,
      label: '手机号码验证字段',
      name: 'tel',
      value: value && value.tel ? value.tel : false,
    }, {
      mode: 2,
      label: '手机号码验证字段',
      name: 'tel',
      value: value && value.tel ? value.tel : false,
    }, {
      mode: 2,
      label: '手机号码验证字段',
      name: 'tel',
      value: value && value.tel ? value.tel : false,
    }]

    // date: '请输入有效的日期，格式XXXX-XX-XX',
    // : '请输入有效的数字',
    // : '请输入有效的非负整数',
    // : '请输入有效的英文标识符',
    // : '请输入有效的英文字符',
    // : '请输入有效的中文字符',
    // : '请输入18位的有效身份证',
    // idcardrange: this.formatTpl('年龄不在 {0} 到 {1} 之间'),
    // equalTo: this.formatTpl('输入值必须和 {0} 相同'),
    // contains: this.formatTpl('输入值必须包含 {0}'),
    // minlength: this.formatTpl('最少输入 {0} 个字符'),
    // maxlength: this.formatTpl('最多输入 {0} 个字符'),
    // rangelength: this.formatTpl('字段长度在 {0} 到 {1} 之间的字符'),
    // min: this.formatTpl('请输入不小于 {0} 的数值'),
    // max: this.formatTpl('请输入不大于 {0} 的数值'),
    // range: this.formatTpl('请输入范围在 {0} 到 {1} 之间的数值'),
    // custom: '请输入满足条件的有效数据',

    var rules = {
      required: {
        required: '是否必须'
      },
      tel: {
        required: '手机号码'
      }
    }

    var json = {}
    json.title = '字段设置'
    json.notitle = true
    json.url_u = x5on.url.schrule
    json.data_u = { uid: field.uid, field: 'rule' }
    json.arrsName = 'fields'
    json.field = false
    json.rule = true
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_edit?json=' + JSON.stringify(json) })
  },
  
})

