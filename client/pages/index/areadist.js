var x5on = require('../x5on.js')

Page({

  data: {
    areatypes: ['省份', '地市', '区县'],
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
      },
      areatype: {
        required: true,
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
        success(members) {
          that.setData({ members })
        }
      })
    }, message => {
      x5on.showError(that, message)
    })

  },

  areadistRemove: function (e) {
    var that = this
    var uid = e.currentTarget.dataset.uid
    x5on.post({
      url: x5on.url.areadistdel,
      data: { uid },
      success(number) {
        var members = x5on.delValue(that.data.members, 'uid', uid)
        that.setData({ members })
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