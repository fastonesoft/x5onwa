// pages/index/subset_add.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var data = JSON.parse(e.json)
    let {title, addurl, fields, rules, messages} = data
    this.setData({ title, addurl, fields, rules, messages })
  },

  formSubmit: function (e) {
    var that = this
    var form = e.detail
    x5on.ppost(that.data.addurl, form)
      .then(memb => {
        x5on.prevPage(page => {
          var membs = page.data.membs
          membs = x5on.add(membs, memb, 'id')
          page.setData({ membs })
          //
          wx.navigateBack()
        })
      })
      .catch(error => {
        x5on.showError(that, error)
      })


    // mode: 3,
    // label: '选择测试1',
    // name: 'selec1',
    // url: x5on.url.typeset,
    // picks: [{id: 0, name: '测试'}, {id: 1, name: '姓名'}],
    // rangeKey: 'name',
    // selectKey: 'name',
    // valueKey: 'uid',
  },

})