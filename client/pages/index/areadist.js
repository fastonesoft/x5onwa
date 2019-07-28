var x5on = require('../x5on.js')

Page({

  data: {
    areatypes: [{id: 1, name: '省份'}, {id: 2, name: '地市'}, {id: 3, name: '区县'}]
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

  radioChange: function (e) {
		this.setData(e.detail)
  },

  typeChange: function(e) {
    var that = this
    // e.detail => { area_type }
    that.setData(e.detail)
    that.setData({ area_uid: null })
		x5on.http(x5on.url.areadist, e.detail)
		.then(areas_members=>{
      that.setData(areas_members)
		})
		.catch(error=>{
			x5on.showError(error)
		})
  },

  areaRemove: function (e) {
		x5on.http(x5on.url.areadistremove, e.detail)
		.then(number=>{
			x5on.delSuccess(number)
		})
		.catch(error=>{
			x5on.showError(error)
		})
  },

  addClick: function (e) {
    var fields = [{
      mode: 1,
      label: '地区编号',
      message: '输入地区编号',
      name: 'id',
      type: 'number',
      maxlength: 6,
    }, {
      mode: 1,
      label: '地区名称',
      message: '输入地区名称',
      name: 'name',
      type: 'text',
      maxlength: 20,
    }]
    var rules = {
      id: {
        required: true,
        digits: true,
        minlength: 6,
      },
      name: {
        required: true,
        chinese: true,
        minlength: 2,
      },
    }

    var json = {}
    json.title = '地区设置'
    json.notitle = true
    json.url_u = x5on.url.areadistadd
    json.arrsName = 'areas'
    json.fields = fields
    json.rules = rules

    wx.navigateTo({ url: 'form_add?json=' + JSON.stringify(json) })
  },

  areadistSubmit: function (e) {
    var that = this
    var { area_type, user_uid, area_uid } = that.data
    area_type && user_uid && area_uid && x5on.http(x5on.url.areadistdist, { area_type, user_uid, area_uid })
		.then(areas_members=>{
      that.setData(areas_members)
      that.setData( { user_uid: null, area_uid: null, users: [] })
		})
		.catch(error=>{
			x5on.showError(error)
		})
  },

  areadistRemove: function (e) {
    var that = this
    var uid = e.detail.uid
    var { area_type } = that.data
    area_type && x5on.http(x5on.url.areadistdel, { area_type, uid })
		.then(areas_members=>{
      that.setData(areas_members)
		})
		.catch(error=>{
			x5on.showError(error)
		})
  },

})