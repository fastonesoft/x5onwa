// pages/index/form.js
var x5on = require('../x5on.js')

Page({

  onLoad: function(e) {
    var that = this
    x5on.http(x5on.url.schform)
    .then(res=>{
      var fields = [{
        mode: 3,
        label: '分类选择',
        name: 'type_id',
        picks: res.types,
        valueKey: 'id',
        rangeKey: 'name',
        selectKey: 'name',
      }, {
        mode: 3,
        label: '分级选择',
        name: 'steps_id',
        picks: res.steps,
        valueKey: 'id',
        rangeKey: 'sch_step',
        selectKey: 'sch_step',
      }, {
        mode: 3,
        label: '年度选择',
        name: 'years_id',
        picks: res.years,
        valueKey: 'id',
        rangeKey: 'year',
        selectKey: 'year',
      }]
      var rules = {
        type_id: {
          required: true,
          min: 0,
        },
        steps_id: {
          required: true,
          min: 0,
        },
        years_id: {
          required: true,
          min: 0,
        }
      }
      that.setData({ fields, rules })
    })
    .catch(error=>{
      x5on.showError(error)
    })

  },

  formSubmit: function(e) {
    console.log(e)
  },

  pickChange: function(e) {
    var that = this
    that.setData(e.detail)
    //
    var type_id = that.data.type_id
    var years_id = that.data.years_id
    var steps_id = that.data.steps_id
    type_id && years_id && steps_id && x5on.http(x5on.url.schformforms, { type_id, years_id, steps_id })
    .then(forms=>{
      that.setData({ forms })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  }
  

})