// pages/index/schdist.js
var x5on = require('../x5on.js')

Page({

	onLoad: function (e) {
		var that = this
		x5on.request({
			url: x5on.url.schdist,
			success(schs) {
				that.setData({ schs })
			}
		})
	},

	findSubmit: function (e) {
		var that = this
		var rules = {
			name: {
				required: true,
				chinese: true,
				rangelength: [1, 3],
			}
		}
		var messages = {
			name: {
				required: '用户姓名'
			}
		}
		x5on.checkForm(e.detail.value, rules, messages, form => {
			x5on.post({
				url: x5on.url.schdistuser,
				data: form,
				success(users) {
					that.setData({ users })
					users.length === 0 && x5on.showError(that, '没有找到你要的用户！')
				}
			})
		}, message => {
			x5on.showError(that, message)
		})
	},

	userChange: function (e) {
		x5on.setRadio(this.data.users, e.detail.value, users => {
			this.setData({ users })
		})
	},

	schsChange: function (e) {
		var that = this
		x5on.setPick(e, schsIndex => {
			that.setData({ schsIndex })
			var schs_id = x5on.getId(that.data.schs, schsIndex)
			//
			x5on.post({
				data: { schs_id },
				url: x5on.url.schdistsch,
				success(schos_members) {
					schos_members.schoIndex = -1
					that.setData(schos_members)
				}
			})
		})
	},

	schoChange: function (e) {
		var that = this
		x5on.setPick(e, schoIndex => {
			that.setData({ schoIndex })
		})
	},

	schdistSubmit: function (e) {
		var that = this
		var rules = {
			user_uid: {
				required: true,
			},
			sch: {
				required: true,
				min: 0,
			},
		}
		var messages = {
			user_uid: {
				required: '用户选择'
			},
			sch: {
				required: '学校名称'
			},
		}
		x5on.checkForm(e.detail.value, rules, messages, form => {
			form.sch_uid = x5on.getUid(that.data.schos, form.sch)
			x5on.post({
				url: x5on.url.schdistdist,
				data: form,
				success(schos_members) {
					schos_members.schoIndex = -1
					that.setData(schos_members)
				}
			})
		}, message => {
			x5on.showError(that, message)
		})

	},

	schdistRemove: function (e) {
		var that = this
		var uid = e.currentTarget.dataset.uid
		x5on.post({
			url: x5on.url.schdistdel,
			data: { uid },
			success(schos_members) {
				schos_members.schoIndex = -1
				that.setData(schos_members)
			}
		})
	},

	addClick: function (e) {
		var schs_id = x5on.getId(this.data.schs, this.data.schsIndex)
		schs_id && wx.navigateTo({ url: '/pages/index/sch_add' })
		!schs_id && x5on.showError(this, '集团没有设置')
	},

	returnClick: function (e) {
		wx.navigateBack()
	},

})
