// pages/index/mykaodivi.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    var mes = {
      in_count: { label: '参加人数', type: 0 },
      notin_count: { label: '：未参加', type: 0 },
    }
    that.setData({ mes })

    x5on.http(x5on.url.mykaodivi)
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

    x5on.http(x5on.url.mykaodivikaos, e.detail)
    .then(kaos=>{
      that.setData({ kaos, counts: null, kao_id: null })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },
  
  kaoChange: function(e) {
    var that = this
    that.setData(e.detail)
    let { grade_id } = that.data
    Object.assign(e.detail, { grade_id })

    x5on.http(x5on.url.mykaodivicounts, e.detail)
    .then(counts=>{
      that.setData({ counts })    
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  addClick: function(e) {
    var that = this
    let { grade_id, kao_id } = that.data

    x5on.http(x5on.url.mykaodiviadd, { grade_id, kao_id })
    .then(counts=>{
      that.setData({ counts })    
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

})