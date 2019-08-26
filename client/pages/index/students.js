// pages/index/students.js
var x5on = require('../x5on.js')

Page({

  data: {
    comeshow: 1,
  },

  onLoad: function (options) {
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
      // 清除班级编号残留
      that.setData({ cls_id: null })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  classChange: function(e) {
    var that = this
    that.setData(e.detail)

    x5on.http(x5on.url.gradestudcls, e.detail)
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
      name: 'status_id',
      label: '学籍状态',
      url: x5on.url.gradestudstatusin,
      valueKey: 'id',
      rangeKey: 'name',
      selectKey: 'name',
      value: value && value.status_id ? value.status_id : null,
    }, {
      mode: 3,
      name: 'stud_auth',
      label: '学籍状态',
      url: x5on.url.gradestudauth,
      valueKey: 'id',
      rangeKey: 'name',
      selectKey: 'name',
      value: value && value.stud_auth ? value.stud_auth : null,
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
      status_id: {
        required: true,
      },
      stud_auth: {
        required: true,
      },
    }
    let { grade_id, cls_id } = that.data
    var json = {}
    json.title = '年度学生'
    json.notitle = true
    json.url_u = x5on.url.subsetadd
    json.data_u = { grade_id, cls_id }
    json.arrsName = 'studs'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },



  studentsChange: function (e) {
    x5on.setRadio(this.data.students, e.detail.value, students => {
      this.setData({ students })
    })
  },

  studentClick: function (e) {
    wx.navigateTo({
      url: 'student?uid=' + e.currentTarget.dataset.uid,
      success: () => {
      }
    })
  },

  // 添加
  studaddClick: function (event) {
    wx.navigateTo({ url: 'stud_add' })
  },

  // 修改
  studmodiClick: function (event) {
    var that = this
    x5on.getRadio(this.data.students, stud => {
      wx.navigateTo({ url: 'stud_modi?uid=' + stud.uid })
    }, () => {
      x5on.showError('没有选中相关学生')
    })
  },

  // 指标
  studauthClick: function (event) {
    var that = this
    x5on.getRadio(this.data.students, stud => {
      wx.navigateTo({ url: 'stud_auth?uid=' + stud.uid })
    }, () => {
      x5on.showError('没有选中相关学生')
    })
  },

  // 转入
  studcomeClick: function (e) {
    wx.navigateTo({ url: 'stud_come' })
  },

  // 调动
  studmoveClick: function (e) {
    var that = this
    x5on.getRadio(this.data.students, stud => {
      wx.navigateTo({ url: 'stud_move?uid=' + stud.uid })
    }, () => {
      x5on.showError('没有选中相关学生')
    })
  },

  // 跳级，一定要变更学生编号
  studjumpClick: function (e) {
    x5on.getRadio(this.data.students, stud => {
      console.log(stud)
    }, () => {
      console.log('error')
    })
    // wx.navigateTo({ url: 'stud_jump' })
  },

  // 回校
  studbackClick: function (e) {
    var that = this
    var grade_id = that.getGradeid()
    var task_status_id = x5on.data.status_temp
    var form = { grade_id, task_status_id }
    x5on.post({
      url: x5on.url.gradestudtask,
      data: form,
      success: tasks => {
        tasks.length === 0 && x5on.showError('本年度没有要回校的学生')
        tasks.length !== 0 && wx.navigateTo({ url: 'stud_back?tasks=' + JSON.stringify(tasks) })
      }
    })
  },

  // 复学
  studreturnClick: function (e) {
    var that = this
    var grade_id = that.getGradeid()
    var task_status_id = x5on.data.status_down
    var form = { grade_id, task_status_id }
    x5on.post({
      url: x5on.url.gradestudtask,
      data: form,
      success: tasks => {
        tasks.length === 0 && x5on.showError('本年度没有要复学的学生')
        tasks.length !== 0 && wx.navigateTo({ url: 'stud_return?tasks=' + JSON.stringify(tasks) })
      }
    })
  },

  // 重读
  studrepetClick: function (e) {
    wx.navigateTo({ url: 'stud_repetition' })
  },

  // 借读
  studreadClick: function (e) {
    wx.navigateTo({ url: 'stud_read' })
  },

  // 休学
  studdownClick: function (e) {
    var that = this
    x5on.getRadio(this.data.students, stud => {
      wx.navigateTo({ url: 'stud_down?uid=' + stud.uid })
    }, () => {
      x5on.showError('没有选中相关学生')
    })
  },

  // 转出
  studoutClick: function (e) {
    var that = this
    x5on.getRadio(this.data.students, stud => {
      wx.navigateTo({ url: 'stud_out?uid=' + stud.uid })
    }, () => {
      x5on.showError('没有选中相关学生')
    })
  },

  // 离校
  studleaveClick: function (e) {
    var that = this
    x5on.getRadio(this.data.students, stud => {
      wx.navigateTo({ url: 'stud_leave?uid=' + stud.uid })
    }, () => {
      x5on.showError('没有选中相关学生')
    })
  },

  // 临时
  studtempClick: function (e) {
    var that = this
    x5on.getRadio(this.data.students, stud => {
      wx.navigateTo({ url: 'stud_temp?uid=' + stud.uid })
    }, () => {
      x5on.showError('没有选中相关学生')
    })
  },

})