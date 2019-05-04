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
			users.length !== 0 && that.setData({ users })
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

	areaChange: function (e) {
		var that = this
		that.setData(e.detail)
		x5on.http(x5on.url.schsdistschs, e.detail)
		.then(schs_members=>{
			that.setData(schs_members)
		})
  },
	
  schsChange: function (e) {
		var schs_uid = e.detail.uid
		this.setData({ schs_uid })
  },

  schsdistClick: function (e) {
		var that = this
		var user_uid = that.data.user_uid
		var schs_uid = that.data.schs_uid
		user_uid && schs_uid && x5on.http(x5on.url.schsdistdist, { user_uid, schs_uid })
		.then(schs_members=>{
			that.setData(schs_members)
		})
	},
	
	memberSubmit: function (e) {
		var that = this
		x5on.http(x5on.url.schsdistmemfind, e.detail)
		.then(members=>{
			members.length !== 0 && that.setData({ members })
			members.length === 0 && x5on.showError(that, '没有找到你要的集团成员！')
		})
		.catch(error=>{
			x5on.showError(that, error)
		})
	},

  schsdistRemove: function (e) {
    var that = this
		x5on.http(x5on.url.schsdistdel, e.detail)
		.then(schs_members=>{
			that.setData(schs_members)
		})
  },

  addClick: function (e) {
		var area_id = this.data.area_id
		area_id && wx.navigateTo({ url: '/pages/index/schs_add' })
		!area_id && x5on.showError(this, '地区没有设置')
  },

})


