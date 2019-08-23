// pages/index/studin.js
var x5on = require('../x5on.js')

Page({

	onLoad: function (e) {
		var that = this
		var fields = [{
			mode: 1,
			label: '分组人数',
			name: 'group_num',
			type: 'number',
			message: '请输入分组人数',
			value: 36,
			maxlength: 2,
		  }]
		  var rules = {
			group_num: {
			  required: true,
			  digits: true,
			  maxlength: 2,
			},
		  }
		that.setData({ fields, rules })

		x5on.http(x5on.url.studin)
			.then(steps => {
				that.setData({ steps })
			})
			.catch(error => {
				x5on.showError(error)
			})
	},

	pickChange: function (e) {
		var that = this
		that.setData(e.detail)
		x5on.http(x5on.url.studinnotin, e.detail)
		.then(notins => {
			that.setData({ notins })
		})
		.catch(error => {
			x5on.showError(error)
		})
},


	formSubmit: function(e) {
		const that = this
		const { steps_id } = that.data
		Object.assign(e.detail, { steps_id })
	},


})