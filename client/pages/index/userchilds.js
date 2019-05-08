// pages/index/userchilds.js
var x5on = require('../x5on.js')

Page({

  onLoad: function () {
    var that = this
    x5on.http(x5on.url.userchilds)
    .then(userchilds=>{
      var mes = {
        child_name: '孩子姓名',
        child_idc: '身份证号',
        child_relation: '亲子关系',
      }
      that.setData({ mes, userchilds })
    })
    .catch(error=>{
      x5on.showError(that, error)
    })
    // x5on.request({
    //   url: x5on.url.userchildsrelation,
    //   success(relations) {
    //     that.setData({ relations })
    //   }
    // })
  },

  addClick: function(e) {
    var that = this
    var fields = [{
      mode: 1,
      label: '孩子姓名',
      message: '输入孩子姓名',
      name: 'name',
      type: 'text',
      maxlength: 4,
    }, {
      mode: 1,
      label: '身份证号',
      message: '输入身份证号',
      name: 'idc',
      type: 'text',
      maxlength: 18,
    }, {
      mode: 3,
      label: '亲子称谓',
      name: 'relation_id',
      url: x5on.url.userchildsrelation,
      valueKey: 'id',
      rangeKey: 'name',
      selectKey: 'name',
    }]
    var rules = {
      name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      },
      idc: {
        required: true,
        idcard: true,
        idcardrange: [7, 18],
      },
      relation_id: {
        required: true,
        min: 0,
      }
    }

    var json = {}
    json.title = '孩子添加'
    json.notitle = true
    json.url_u = x5on.url.userchildsreg
    json.arrsName = 'userchilds'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

  relationChange: function (e) {
    x5on.setPick(e, relationIndex => {
      this.setData({ relationIndex })
    })
  },

  userchildSubmit: function (e) {
    var that = this
    var rules = {
      name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      },
      idc: {
        required: true,
        idcard: true,
        idcardrange: [7, 18],
      },
      relation: {
        required: true,
        min: 0,
      }
    }
    var messages = {
      name: {
        required: '孩子姓名'
      },
      idc: {
        required: '身份证号'
      },
      relation: {
        required: '亲子称谓'
      }
    }
    x5on.checkForm(e.detail.value, rules, messages, (form, error) => {
      form.relation_id = x5on.getId(that.data.relations, form.relation)
      x5on.post({
        url: x5on.url.userchildsreg,
        data: form,
        success(userchilds) {
          that.setData({ userchilds, error })
        },
        fail() {
          that.setData({ error })
        }
      })
    }, (message, error) => {
      that.setData({ error })
      x5on.showError(that, message)
    })
  },

  returnClick: function (e) {
    wx.navigateBack()
  }

})