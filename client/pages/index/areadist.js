var x5on = require('../x5on.js')

Page({

  data: {
    areatypes: [{id: 0, name: '省份'}, {id: 1, name: '地市'}, {id: 2, name: '区县'}]
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
        url: x5on.url.areadistuser,
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

  areatypeChange: function (e) {
    var that = this
    x5on.setPick(e, areatypeIndex => {
      that.setData({ areatypeIndex })
      //
      x5on.post({
        url: x5on.url.areadist,
        data: { area_type: areatypeIndex },
        success(areas_members) {
          areas_members.areaIndex = -1
          that.setData(areas_members)
        }
      })
    })
  },

  areaChange: function (e) {
    var that = this
    x5on.setPick(e, areaIndex => {
      that.setData({ areaIndex })
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
      var areatypeIndex = that.data.areatypeIndex
      form.area_type = x5on.getId(that.data.areatypes, areatypeIndex)
      x5on.post({
        url: x5on.url.areadistmemfind,
        data: form,
        success(members) {
          members.length !== 0 && that.setData({ members })
          members.length === 0 && x5on.showError(that, '没有找到你要的地区成员！')
        }
      })
    }, message => {
      x5on.showError(that, message)
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