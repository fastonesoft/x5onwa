// pages/index/form.js
var x5on = require('../x5on.js')

Page({

  onLoad: function(e) {
    var that = this
    x5on.http(x5on.url.schform)
    .then(types_years_steps=>{
      that.setData(types_years_steps)
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  pickChange: function(e) {
    var that = this
    that.setData(e.detail)
    //
    var type_id = that.data.type_id
    var years_id = that.data.years_id
    var steps_id = that.data.steps_id
    type_id && years_id && steps_id && x5on.http()
  }
  

})