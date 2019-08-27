// pages/index/mydiviset.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.http(x5on.url.mydiviset)
    .then(grades=>{
      that.setData({ grades })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  gradeChange: function (e) {
    var that = this
    that.setData(e.detail)
    x5on.http(x5on.url.mydivisetdata, e.detail)
    .then(diviset=>{
      var fields = [{
        mode: 1,
        label: '调动分差',
        message: '调动上浮区间，高分换低',
        name: 'section',
        type: 'number',
        maxlength: 1,
        value: diviset.section,
      }, {
        mode: 1,
        label: '显示个数',
        message: '返回几条数据',
        name: 'limit_num',
        type: 'number',
        maxlength: 1,
        value: diviset.limit_num,
      }, {
        mode: 2,
        label: '同性调动',
        name: 'samesex',
        value: diviset.samesex,
      }, {
        mode: 2,
        label: '向下浮动',
        name: 'godown',
        value: diviset.godown,
      }, {
        mode: 2,
        label: '是否完成',
        name: 'finished',
        value: diviset.finished,
      }]
      var rules = {
        section: {
          required: true,
          minlength: 1,
          digits: true,
        },
        limit_num: {
          required: true,
          minlength: 1,
          digits: true,
        },
        samesex: {
          required: true,
        },
        godown: {
          required: true,
        },
        finished: {
          required: true,
        },
      }
      that.setData({ fields, rules })
    })
    .catch(error=>{
      x5on.showError(error)
    })

  },

  mydivisetSubmit: function (e) {
    var that = this
    let { grade_id } = that.data
    Object.assign(e.detail, { grade_id })

    x5on.http(x5on.url.mydivisetupdate, e.detail)
    .then(number=>{
      x5on.updateSuccess(number)
      that.setData({ fields: [], rules: [] })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

})