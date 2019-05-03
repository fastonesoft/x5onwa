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
		console.log(e)
	},

	areaChange: function (e) {
		console.log(e)
    var that = this
		x5on.http(x5on.url.schsdistschs, e.detail)
		.then(schs_members=>{
			that.setData(schs_members)
		})
  },
	
  schsChange: function (e) {
		var that = this
		console.log(e)
  },

  schsdistSubmit: function (e) {
    var that = this
    var rules = {
      user_uid: {
        required: true,
			},
      schs: {
				required: true,
				min: 0,
      },
    }
    var messages = {
      user_uid: {
        required: '用户选择'
			},
      schs: {
        required: '集团名称'
      },
    }
    x5on.checkForm(e.detail.value, rules, messages, form => {
      form.schs_uid = x5on.getUid(that.data.schs, form.schs)
      x5on.post({
        url: x5on.url.schsdistdist,
        data: form,
        success(schs_members) {
					schs_members.schsIndex = -1
          that.setData(schs_members)
        }
      })
    }, message => {
      x5on.showError(that, message)
    })

	},
	
	memberSubmit: function (e) {
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
				required: '成员姓名'
			}
		}
		x5on.checkForm(e.detail.value, rules, messages, form => {
			var areaIndex = that.data.areaIndex
			form.area_id = x5on.getId(that.data.areas, areaIndex)
			x5on.post({
				url: x5on.url.schsdistmemfind,
				data: form,
				success(members) {
					members.length !== 0 && that.setData({ members })
					members.length === 0 && x5on.showError(that, '没有找到你要的集团成员！')
				}
			})
		}, message => {
			x5on.showError(that, message)
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
		var area_id = x5on.getId(this.data.areas, this.data.areaIndex)
		area_id && wx.navigateTo({ url: '/pages/index/schs_add' })
		!area_id && x5on.showError(this, '地区没有设置')
  },

})


