// pages/index/schstep.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.prequest(x5on.url.schstep)
      .then(membs => {
        that.setData({ membs })
      })
  },

  removeClick: function (e) {
    let that = this
    let { removed, membs } = e.detail
    let uid = removed.uid
    x5on.ppost(x5on.url.schstepdel, { uid })
      .then(number => {
        that.setData({ membs })
      })
      .catch(error => {
        console.log(error)
      })
  },

  editClick: function (e) {
    var memb = e.detail

    var fields = [{
      mode: 0,
      name: 'name',
      label: '分级名称',
      value: memb.name,
    }, {
      mode: 0,
      name: 'come_year',
      label: '入学年度',
      value: memb.come_year,
    }, {
      mode: 1,
      name: 'graduated_year',
      label: '毕业年份',
      message: '输入毕业年份',
      type: 'number',
      maxlength: 4,
      value: memb.graduated_year,
    }, {
      mode: 2,
      name: 'can_recruit',
      label: '是否招生',
      bool: true,
      value: memb.can_recruit,
    }, {
      mode: 2,
      name: 'graduated',
      label: '是否毕业',
      bool: true,
      value: memb.graduated,
    }]
    var rules = {
      graduated_year: {
        required: true,
        digits: true,
        minlength: 4,
      },
      can_recruit: {
        required: true,
      },
      graduated: {
        required: true,
      }
    }
    var json = {}
    json.uid = memb.uid
    json.title = '分级设置'
    json.url = x5on.url.schstepedit
    json.fields = fields
    json.rules = rules
    wx.navigateTo({ url: 'form_edit?json=' + JSON.stringify(json) })
  },

  addClick: function (e) {
    var fields = [{
      mode: 1,
      name: 'name',
      label: '分级名称',
      message: '输入分级名称',
      type: 'text',
      maxlength: 10,
    }, {
      mode: 1,
      name: 'code',
      label: '分级代号',
      message: '输入分级代号',
      type: 'number',
      maxlength: 2,
    }, {
      mode: 1,
      name: 'graduated_year',
      label: '毕业年份',
      message: '输入毕业年份',
      type: 'number',
      maxlength: 4,
    }, {
      mode: 3,
      name: 'years_id',
      label: '当前年度',
      url: x5on.url.schstepyear,
      valueKey: 'id',
      rangeKey: 'year',
      selectKey: 'year',
    }, {
      mode: 2,
      name: 'can_recruit',
      label: '是否招生',
    }, {
      mode: 2,
      name: 'graduated',
      label: '是否毕业',
    }]
    var rules = {
      name: {
        required: true,
        minlength: 4,
        custom: '^[0-9]*[\u4e00-\u9fa5]*$',
      },
      code: {
        required: true,
        digits: true,
        min: 1,
        minlength: 2,
      },
      years_id: {
        required: true,
      },
      graduated_year: {
        required: true,
        digits: true,
        minlength: 4,
      },
      can_recruit: {
        required: true,
      },
      graduated: {
        required: true,
      }
    }

    var json = {}
    json.title = '分级设置'
    json.url = x5on.url.schstepadd
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

  returnClick: function (e) {
    wx.navigateBack()
  },
  
})