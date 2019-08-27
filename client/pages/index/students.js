// pages/index/students.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    var mes = {
      total: { label: '总人数', type: 0 },
      female: { label: '：女生', type: 0 },
      male: { label: '：男生', type: 0 },
    }
    that.setData({ mes })

    x5on.http(x5on.url.gradestud)
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

    x5on.http(x5on.url.gradestudclass, e.detail)
    .then(classes_counts=>{
      that.setData(classes_counts)
      // 清除班级编号残留、学生记录
      that.setData({ studs: [], cls_id: null })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  classChange: function(e) {
    var that = this
    that.setData(e.detail)

    x5on.http(x5on.url.gradestudstudcls, e.detail)
    .then(studs=>{
      var male = 0, female = 0
      studs.forEach(stud => {
        stud.sex_num ? male++ : female++
      })
      var counts = { total: studs.length, male, female }
      that.setData({ studs, counts })    
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  findSubmit: function (e) {
    var that = this
    const { grade_id, cls_id } = that.data
    let form = Object.assign({ grade_id, cls_id }, e.detail)

    !grade_id && delete form.grade_id
    !cls_id && delete form.cls_id

    x5on.http(x5on.url.gradestudquery, form)
    .then(studs=>{
      var male = 0, female = 0
      studs.forEach(stud => {
        stud.sex_num ? male++ : female++
      })
      var counts = { total: studs.length, male, female }
      that.setData({ studs, counts })    
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  addClick: function(e) {
    var that = this
    var value = null
    var fields = [{
      mode: 1,
      label: '学生姓名',
      message: '输入学生姓名',
      name: 'stud_name',
      type: 'text',
      maxlength: 4,
    }, {
      mode: 1,
      label: '身份证号',
      message: '输入身份证号',
      name: 'stud_idc',
      type: 'idcard',
      maxlength: 18,
    }, {
      mode: 3,
      name: 'type_id',
      label: '学生来源',
      url: x5on.url.gradestudtype,
      valueKey: 'id',
      rangeKey: 'name',
      selectKey: 'name',
      value: value && value.type_id ? value.type_id : null,
    }, {
      mode: 3,
      name: 'stud_auth',
      label: '是否指标',
      url: x5on.url.gradestudauth,
      valueKey: 'id',
      rangeKey: 'name',
      selectKey: 'name',
      value: value && value.stud_auth ? value.stud_auth : null,
    }, {
      mode: 3,
      name: 'status_id',
      label: '学籍状态',
      url: x5on.url.gradestudstatusin,
      valueKey: 'id',
      rangeKey: 'name',
      selectKey: 'name',
      value: value && value.status_id ? value.status_id : null,
    }]
    var rules = {
      stud_name: {
        required: true,
        chinese: true,
        minlength: 2,
      },
      stud_idc: {
        required: true,
        idcard: true,
        minlength: 18,
      },
      type_id: {
        required: true,
      },
      stud_auth: {
        required: true,
      },
      status_id: {
        required: true,
      },
    }
    let { grade_id, cls_id } = that.data
    var json = {}
    json.title = '年度学生'
    json.notitle = true
    json.url_u = x5on.url.gradestudadd
    json.data_u = { grade_id, cls_id }
    json.arrsName = 'studs'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

  editClick: function(e) {
    var that = this
    var value = e.detail
    var { uid, grade_id } = value

    var fields = [{
      mode: 0,
      label: '学生姓名',
      value: value && value.stud_name ? value.stud_name : null,
    }, {
      mode: 0,
      label: '身份证号',
      value: value && value.stud_idc ? value.stud_idc : null,
    }, {
      mode: 3,
      name: 'cls_id',
      label: '目标班级',
      url: x5on.url.gradestudcls,
      data: { grade_id },
      valueKey: 'id',
      rangeKey: 'cls_name',
      selectKey: 'cls_name',
      value: value && value.cls_id ? value.cls_id : null,
    }, {
      mode: 3,
      name: 'type_id',
      label: '学生来源',
      url: x5on.url.gradestudtype,
      valueKey: 'id',
      rangeKey: 'name',
      selectKey: 'name',
      value: value && value.type_id ? value.type_id : null,
    }, {
      mode: 3,
      name: 'stud_auth',
      label: '是否指标',
      url: x5on.url.gradestudauth,
      valueKey: 'id',
      rangeKey: 'name',
      selectKey: 'name',
      value: value && value.stud_auth ? value.stud_auth : null,
    }, {
      mode: 3,
      name: 'status_id',
      label: '学籍状态',
      url: x5on.url.gradestudstatusin,
      valueKey: 'id',
      rangeKey: 'name',
      selectKey: 'name',
      value: value && value.status_id ? value.status_id : null,
    }]
    var rules = {
      cls_id: {
        required: true,
      },
      type_id: {
        required: true,
      },
      stud_auth: {
        required: true,
      },
      status_id: {
        required: true,
      },
    }

    var json = {}
    json.title = '年度学生'
    json.notitle = true
    json.url_u = x5on.url.gradestudedit
    json.data_u = { uid }
    json.arrsName = 'studs'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_edit?json=' + JSON.stringify(json) })
  },

  removeClick: function(e) {
    var that = this
    let { uid } = e.detail
    let { studs, notins } = that.data
    x5on.http(x5on.url.gradestudtemp, e.detail)
    .then(notin=>{
      // 删除studs
      studs = x5on.delArr(studs, 'uid', uid)
      // 添加notins
      notins = x5on.add(notins, notin)
      that.setData({ studs, notins })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  backClick: function(e) {
    var that = this
    var value = e.detail
    var { uid, grade_id } = value

    x5on.http(x5on.url.gradestudbackck, { uid })
    .then(()=>{
      // 检测是否可以回校

      var fields = [{
        mode: 0,
        label: '学生姓名',
        value: value && value.stud_name ? value.stud_name : null,
      }, {
        mode: 0,
        label: '身份证号',
        value: value && value.stud_idc ? value.stud_idc : null,
      }, {
        mode: 3,
        name: 'cls_id',
        label: '目标班级',
        url: x5on.url.gradestudcls,
        data: { grade_id },
        valueKey: 'id',
        rangeKey: 'cls_name',
        selectKey: 'cls_name',
        value: value && value.cls_id ? value.cls_id : null,
      }, {
        mode: 3,
        name: 'status_id',
        label: '学籍状态',
        url: x5on.url.gradestudstatusin,
        valueKey: 'id',
        rangeKey: 'name',
        selectKey: 'name',
        value: value && value.status_id ? value.status_id : null,
      }]
      var rules = {
        cls_id: {
          required: true,
        },
        status_id: {
          required: true,
        },
      }
  
      var json = {}
      json.title = '年度学生'
      json.notitle = true
      json.url_u = x5on.url.gradestudback
      json.data_u = { uid }
      json.url_r = x5on.url.gradestudbackref
      json.data_r = { grade_id }
      json.arrsName = 'notins'
      json.fields = fields
      json.rules = rules
  
      wx.navigateTo({ url: 'form_edit?json=' + JSON.stringify(json) })
  
    })
    .catch(error=>{
      x5on.showError(error)
    })

  },

})