// pages/index/mykaomodi.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this

    x5on.http(x5on.url.mykaomodi)
    .then(grades=>{
      that.setData({ grades })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  gradeChange: function(e) {
    var that = this
    that.setData(e.detail)
  },

  findSubmit: function(e) {
    var that = this
    var { grade_id } = that.data
    Object.assign(e.detail, { grade_id })

    x5on.http(x5on.url.mykaomodiquery, e.detail)
    .then(studs=>{
      that.setData({ studs })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  editClick: function(e) {
    var that = this
    var value = e.detail

    var fields = [{
      mode: 0,
      label: '学生姓名',
      value: value && value.stud_name ? value.stud_name : null,
    }, {
      mode: 1,
      label: '考试编号',
      message: '考试编号',
      name: 'kao_stud_id',
      type: 'number',
      maxlength: 30,
      value: value && value.kao_stud_id ? value.kao_stud_id : null,
      disabled: true,
    }, {
      mode: 1,
      label: '考试成绩',
      message: '考试成绩',
      name: 'value',
      type: 'number',
      maxlength: 3,
      value: value && value.value ? value.value : null,
    }]
    var rules = {
      kao_stud_id: {
        required: true,
      },
      value: {
        required: true,
        digits: true,
      },
    }

    var json = {}
    json.title = '成绩修改'
    json.notitle = true
    json.url_u = x5on.url.mykaomodiupdate
    json.data_u = { uid: value.uid }
    json.arrsName = 'studs'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_edit?json=' + JSON.stringify(json) })
  },

})