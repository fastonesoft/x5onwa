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
	},

	pickChange: function(e) {
		var that = this
		x5on.http(x5on.url.schvaluevalues, e.detail)
		.then(fields_values=>{
		  var { fields, values } = fields_values
		  var { fields, rules } = x5on.fieldsRules(fields, values)
		  //
		  that.setData({ fields })	
		})
		.catch(error=>{
		  x5on.showError(error)
		})
	}
})