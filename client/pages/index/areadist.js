var x5on = require('../x5on.js')

Page({

  data: {
    areatypes: [{id: 0, name: '省份'}, {id: 1, name: '地市'}, {id: 2, name: '区县'}]
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

  areaChange: function (e) {
		var that = this
		that.setData(e.detail)
		// e.detail => { area_id }
		x5on.http(x5on.url.schsdistschs, e.detail)
		.then(schs_members=>{
			that.setData(schs_members)
		})
  },

  areadistSubmit: function (e) {
    var that = this
    var rules = {
      user_uid: {
        required: true,
      },
      area: {
        required: true,
        min: 0,
      },
      areatype: {
        required: true,
        min: 0,
      }
    }
    var messages = {
      user_uid: {
        required: '用户选择'
      },
      area: {
        required: '地区设置'
      },
      areatype: {
        required: '地区类型'
      }
    }
    x5on.checkForm(e.detail.value, rules, messages, form => {
      form.area_uid = x5on.getUid(that.data.areas, form.area)
      form.area_type = x5on.getId(that.data.areatypes, form.areatype)
      x5on.post({
        url: x5on.url.areadistdist,
        data: form,
        success(areas_members) {
          areas_members.areaIndex = -1
          that.setData(areas_members)
        }
      })
    }, message => {
      x5on.showError(message)
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
      var areatypeIndex = that.data.areatypeIndex
      form.area_type = x5on.getId(that.data.areatypes, areatypeIndex)
      x5on.post({
        url: x5on.url.areadistmemfind,
        data: form,
        success(members) {
          members.length !== 0 && that.setData({ members })
          members.length === 0 && x5on.showError('没有找到你要的地区成员！')
        }
      })
    }, message => {
      x5on.showError(message)
    })
  },

  areadistRemove: function (e) {
    var that = this
    var form = {}
    var areatypeIndex = that.data.areatypeIndex
    form.uid = e.currentTarget.dataset.uid
    form.area_type = x5on.getId(that.data.areatypes, areatypeIndex)
    x5on.post({
      url: x5on.url.areadistdel,
      data: form,
      success(areas_members) {
        areas_members.areaIndex = -1
        that.setData(areas_members)
      }
    })
  },

  addClick: function (e) {
    wx.navigateTo({ url: '/pages/index/area_add' })
  },

  returnClick: function (e) {
    wx.navigateBack()
  },

})