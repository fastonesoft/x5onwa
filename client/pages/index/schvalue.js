// pages/index/schvalue.js
var x5on = require('../x5on.js')

Page({

	onLoad: function(e) {
		var that = this
		x5on.http(x5on.url.schvalueforms)
		.then(forms=>{
			console.log(forms)
			that.setData({ forms })
		})
		.catch(error=>{
			x5on.showError(error)
		})
	}

})