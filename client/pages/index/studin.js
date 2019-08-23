// pages/index/studin.js
var x5on = require('../x5on.js')

Page({

  onLoad: function(e) {
    var that = this
    
		x5on.http(x5on.url.regexam)
		.then(steps_auths=>{
			that.setData(steps_auths)
		})
		.catch(error=>{
			x5on.showError(error)
		})
  },

  pickChange: function(e) {
    this.setData(e.detail)
  },

})