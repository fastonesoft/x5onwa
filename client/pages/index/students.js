// pages/index/students.js
var x5on = require('../x5on.js')

Page({

  data: {
    comeshow: 1,
  },

  onLoad: function (options) {
    var that = this
    x5on.http(x5on.url.gradestudgrade)
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
    .then(classes=>{
      that.setData({ classes })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  classChange: function(e) {
    var that = this
    that.setData(e.detail)

    const { grade_id, cls_id } = that.data
    x5on.http(x5on.url.gradestudcls, { grade_id, cls_id })
    .then(students=>{

      var male = 0, female = 0
      students.forEach(student => {
        student.stud_sex_num ? male++ : female++
      })
      var comeshow = students.length !== 0
      that.setData({ students, comeshow, male, female })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  findSubmit: function (e) {
    var that = this

    const { grade_id, cls_id } = that.data
    let form = Object.assign({ grade_id, cls_id }, e.detail)

    x5on.http(x5on.url.gradestudquery, form)
    .then(students=>{
      var male = 0, female = 0
      students.forEach(student => {
        student.stud_sex_num ? male++ : female++
      })
      var comeshow = students.length === 0 ? false : that.data.comeshow
      that.setData({ students, comeshow, male, female })
    })
    .catch(error=>{
      x5on.showError(error)
    })

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