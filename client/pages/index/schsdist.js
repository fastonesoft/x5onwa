// pages/index/schsdist.js
var x5on = require('../x5on.js')

Page({

	onLoad: function (e) {
		var that = this
		x5on.http(x5on.url.schsdist)
		.then(areas=>{
			that.setData({ areas })
		})
	},

	findSubmit: function (e) {
		var that = this
		x5on.http(x5on.url.schsdistuser, e.detail)
		.then(users=>{
			users.length !== 0 && that.setData({ users, user_uid: null })
			users.length === 0 && x5on.showError('没有找到你要的用户！')
		})
		.catch(error=>{
			x5on.showError(error)
		})
	},

	userChange: function (e) {
		var user_uid = e.detail.uid
		this.setData({ user_uid })
	},

	areaPick: function (e) {
		var that = this
		that.setData(e.detail)
		// e.detail => { area_id }
		x5on.http(x5on.url.schsdistschs, e.detail)
		.then(schs_members=>{
			that.setData(schs_members)
		})
  },
	
  schsChange: function (e) {
		var schs_uid = e.detail.uid
		this.setData({ schs_uid })
	},

	schsRemove: function (e) {
		var that = this
		var schs_uid = that.data.schs_uid
		e.detail.uid === schs_uid && that.setData({ schs_uid: null })
		//
		x5on.http(x5on.url.schsdistremove, e.detail)
		.then(number=>{
			x5on.delSuccess(number)
		})
		.catch(error=>{
			x5on.showError(error)
		})
	},

  updateClick: function (e) {
		var that = this
		var user_uid = that.data.user_uid
		var schs_uid = that.data.schs_uid
		user_uid && schs_uid && x5on.http(x5on.url.schsdistdist, { user_uid, schs_uid })
		.then(schs_members=>{
			schs_members.schs_uid = null
			that.setData(schs_members)
		})
	},
	
	memberSubmit: function (e) {
		var that = this
		var area_id = that.data.area_id
		e.detail.area_id = that.data.area_id
		area_id && x5on.http(x5on.url.schsdistmemfind, e.detail)
		.then(members=>{
			members.length !== 0 && that.setData({ members })
			members.length === 0 && x5on.showError('没有找到你要的集团成员！')
		})
		.catch(error=>{
			x5on.showError(error)
		})
	},

  memberRemove: function (e) {
		var that = this
		// e.detail => { uid }
		x5on.http(x5on.url.schsdistdel, e.detail)
		.then(schs_members=>{
			that.setData(schs_members)
		})
  },

  addClick: function (e) {
		var area_id = this.data.area_id
		var fields = [{
      mode: 1,
      label: '集团编号',
      message: '输入集团编号',
      name: 'code',
      type: 'number',
      maxlength: 2,
    }, {
      mode: 1,
      label: '集团名称',
      message: '输入集团名称',
      name: 'name',
      type: 'text',
      maxlength: 20,
    }, {
      mode: 1,
      label: '集团全称',
      message: '输入集团全称',
      name: 'full_name',
      type: 'text',
      maxlength: 50,
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
      full_name: {
        required: true,
        chinese: true,
        minlength: 4,
        maxlength: 50,
      },
    }

    var json = {}
		json.title = '集团设置'
		json.notitle = true
		json.url_u = x5on.url.schsdistadd
		json.data_u = { area_id }
		json.arrsName = 'schs'
    json.fields = fields
		json.rules = rules
		
		area_id && wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
		!area_id && x5on.showError('地区设置没有选择')
  },

})


