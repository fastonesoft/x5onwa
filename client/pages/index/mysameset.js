// pages/index/mysameset.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (e) {
    var that = this
    x5on.http(x5on.url.mysameset)
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
    x5on.http(x5on.url.mysamesetcls, e.detail)
    .then(classes=>{
      that.setData({ classes, cls_id: null, studs: [] })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  classChange: function (e) {
    var that = this
    that.setData(e.detail)
    x5on.http(x5on.url.mysamesetstuds, e.detail)
    .then(studs=>{
      that.setData({ studs })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  checkSubmit: function(e) {
		const that = this
		x5on.http(x5on.url.mysamesetupdate, e.detail)
		.then(number => {
			x5on.updateSuccess(number)
		})
		.catch(error => {
			x5on.showError(error)
		})
	},

})