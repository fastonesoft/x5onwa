// pages/index/schdist.js
var x5on = require('../x5on.js')

Page({

	onLoad: function (e) {
		var that = this
		x5on.http(x5on.url.schdist)
		.then(schs=>{
			that.setData({ schs })
		})
	},

	findSubmit: function (e) {
		var that = this
		// e.detail => { name: value }
		x5on.http(x5on.url.schdistuser, e.detail)
		.then(users=>{
			users.length !== 0 && that.setData({ users, user_uid: null })
			users.length === 0 && x5on.showError(that, '没有找到你要的用户！')
		})
		.catch(error=>{
			x5on.showError(that, error)
		})
	},

	userChange: function (e) {
		var user_uid = e.detail.uid
		this.setData({ user_uid })
	},

	schsPick: function (e) {
		var that = this
		that.setData(e.detail)
		// e.detail => { schs_id }
		x5on.http(x5on.url.schdistsch, e.detail)
		.then(schos_members=>{
			that.setData(schos_members)
		})
	},

	schosChange: function (e) {
		var schos_uid = e.detail.uid
		this.setData({ schos_uid })
	},

	schosRemove: function(e) {
		var that = this
		var schos_uid = that.data.schos_uid
		e.detail.uid === schos_uid && that.setData({ schos_uid: null })
		//
		x5on.http(x5on.url.schdistremove, e.detail)
		.then(number=>{
			x5on.delSuccess(number)
		})
		.catch(error=>{
			x5on.showError(that, error)
		})
	},

	updateClick: function (e) {
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


		var that = this
		var user_uid = that.data.user_uid
		var schs_uid = that.data.schs_uid
		user_uid && schs_uid && x5on.http(x5on.url.schsdistdist, { user_uid, schs_uid })
		.then(schs_members=>{
			schs_members.schs_uid = null
			that.setData(schs_members)
		})
	},

	memberRemove: function (e) {
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
		var schs_id = this.data.schs_id
		var fields = [{
      mode: 1,
      label: '学校编号',
      message: '输入学校编号',
      name: 'code',
      type: 'number',
      maxlength: 2,
    }, {
      mode: 1,
      label: '学校名称',
      message: '输入学校名称',
      name: 'name',
      type: 'text',
      maxlength: 20,
    }, {
      mode: 3,
      label: '学制类型',
			name: 'edu_type_id',
			url: x5on.url.schdistedutype,
			data: {},
			valueKey: 'id',
			rangeKey: 'name',
			selectKey: 'name',
    }]
		var rules = {
      code: {
        required: true,
        digits: true,
        minlength: 2,
        maxlength: 2,
      },
      name: {
        required: true,
        chinese: true,
        minlength: 4,
        maxlength: 20,
      },
      edu_type_id: {
        required: true,
        min: 1,
      },
    }

    var json = {}
    json.title = '学校设置'
		json.url_u = x5on.url.schdistadd
		json.data_u = { schs_id }
		json.arrsName = 'schos'
    json.fields = fields
		json.rules = rules
		
		schs_id && wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
		!schs_id && x5on.showError(that, '集团设置没有选择')
	},

})
