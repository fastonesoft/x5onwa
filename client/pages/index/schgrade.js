// pages/index/schgrade.js

var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.http(x5on.url.schgrade)
      .then(membs => {
        that.setData({ membs })
      })
  },

  removeClick: function (e) {
    let that = this
    x5on.http(x5on.url.schgradedel, e.detail)
      .then(number => {
                // todo,是不是有问题
        that.setData({ membs })
      })
      .catch(error => {
        x5on.showError(error)
      })
  },

  addClick: function (e) {
    var fields = [{
      mode: 3,
      name: 'years_id',
      label: '当前年度',
      url: x5on.url.schgradeyear,
      valueKey: 'id',
      rangeKey: 'year',
      selectKey: 'year',
    }, {
      mode: 3,
      name: 'steps_id',
      label: '学校分级',
      url: x5on.url.schgradestep,
      valueKey: 'id',
      rangeKey: 'name',
      selectKey: 'sch_step',
    }, {
      mode: 3,
      name: 'edus_id',
      label: '学校学制',
      url: x5on.url.schgradeedu,
      valueKey: 'id',
      rangeKey: 'edus_name',
      selectKey: 'edus_name',
    }]
    var rules = {
      years_id: {
        required: true,
      },
      steps_id: {
        required: true,
      },
      edus_id: {
        required: true,
      },
    }

    var json = {}
    json.title = '年级设置'
    json.notitle = true
    json.url_u = x5on.url.schgradeadd
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

  returnClick: function (e) {
    wx.navigateBack()
  },
  
})