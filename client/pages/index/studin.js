// pages/index/studin.js
var x5on = require('../x5on.js')

Page({

	onLoad: function (e) {
		var that = this
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
			that.setData({ notins, ins: [] })
		})
		.catch(error => {
			x5on.showError(error)
		})
	},

	findSubmit: function(e) {
		const that = this
		const { steps_id } = that.data
		Object.assign(e.detail, { steps_id })

		x5on.http(x5on.url.studinquery, e.detail)
		.then(ins => {
			that.setData({ ins })
		})
		.catch(error => {
			x5on.showError(error)
		})
	},

	checkSubmit: function(e) {
		const that = this
		const { steps_id } = that.data
		let form = Object.assign({ steps_id }, e.detail)

		x5on.http(x5on.url.studinenter, form)
		.then(number => {
			x5on.updateSuccess(number)
			// 清除选中
			let { notins } = that.data
			notins = x5on.delArrs(notins, 'uid', e.detail.uids)
			that.setData({ notins })
		})
		.catch(error => {
			x5on.showError(error)
		})
	},

	delSubmit: function(e) {
		const that = this
		const { steps_id } = that.data
		let form = Object.assign({ steps_id }, e.detail)

		x5on.http(x5on.url.studinout, form)
		.then(number => {
			x5on.updateSuccess(number)
			// 清除选中
			let { ins } = that.data
			ins = x5on.delArrs(ins, 'uid', e.detail.uids)
			that.setData({ ins })
		})
		.catch(error => {
			x5on.showError(error)
		})
	},
})