// pages/index/mykaoscore.js

var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    var mes = {
      in_count: { label: '参加人数', type: 0 },
      notin_count: { label: '：未参加', type: 0 },
    }
    that.setData({ mes })

    x5on.http(x5on.url.mykaoscore)
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

    x5on.http(x5on.url.mykaoscorekaos, e.detail)
    .then(kaos=>{
      that.setData({ counts: null, kaos, kao_id: null, subs: [], sub_id: null })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },
  
  kaoChange: function(e) {
    var that = this
    that.setData(e.detail)

    x5on.http(x5on.url.mykaoscoresubs, e.detail)
    .then(subs=>{
      that.setData({ counts: null, subs, sub_id: null })    
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  subChange: function(e) {
    var that = this
    that.setData(e.detail)
    let { grade_id, kao_id, sub_id } = that.data

    x5on.http(x5on.url.mykaoscorecounts, { grade_id, kao_id, sub_id })
    .then(counts=>{
      that.setData({ counts })    
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  addClick: function(e) {
    var that = this
    let { grade_id, kao_id, sub_id } = that.data

    x5on.http(x5on.url.mykaoscoreadd, { grade_id, kao_id, sub_id })
    .then(counts=>{
      that.setData({ counts })    
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

})