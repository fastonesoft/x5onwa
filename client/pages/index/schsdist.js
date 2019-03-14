// pages/index/schsdist.js
var x5on = require('../x5on.js')

Page({

	data: {
		areaIndex: 0
	},

	onLoad: function (e) {
		var that = this
		x5on.request({
			url: x5on.url.schsdist,
			success(areas_members) {
				that.setData(areas_members)
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
				url: x5on.url.schsdistuser,
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

	areaChange: function (e) {
    var that = this
    x5on.setPick(e, areaIndex => {
			that.setData({ areaIndex })
			var area_id = x5on.getId(that.data.areas, areaIndex)
			//
			x5on.post({
				data: { area_id },
        url: x5on.url.schsdistschs,
        success(schs_members) {
					schs_members.schsIndex = -1
          that.setData(schs_members)
        }
      })
    })
  },
	
  schsChange: function (e) {
    var that = this
    x5on.setPick(e, schsIndex => {
      that.setData({ schsIndex })
    })
  },

  schsdistSubmit: function (e) {
    var that = this
    var rules = {
      user_uid: {
        required: true,
			},
      schs: {
        required: true,
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
        success(members) {
          that.setData({ members })
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
			x5on.post({
				url: x5on.url.schsdistmemfind,
				data: form,
				success(members) {
					that.setData({ members })
					members.length === 0 && x5on.showError(that, '没有找到你要的成员！')
				}
			})
		}, message => {
			x5on.showError(that, message)
		})
	},

  schsdistRemove: function (e) {
    var that = this
    var uid = e.currentTarget.dataset.uid
    x5on.post({
      url: x5on.url.schsdistdel,
      data: { uid },
      success(number) {
        var members = x5on.delValue(that.data.members, 'uid', uid)
        that.setData({ members })
      }
    })
  },

  addClick: function (e) {
		var area_id = x5on.getId(this.data.areas, this.data.areaIndex)
		area_id && wx.navigateTo({ url: '/pages/index/schs_add' })
		!area_id && x5on.showError(this, '地区没有设置')
  },

  returnClick: function (e) {
    wx.navigateBack()
  },

})


