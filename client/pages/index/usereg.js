// pages/index/tchreg.js
var x5on = require('../x5on.js')

Page({

  onLoad: function () {
    var that = this
    x5on.request({
      url: x5on.url.tchreg,
      success(schools) {
        that.setData({ schools })
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
        required: '用户姓名',
      }
    }
    x5on.checkForm(e, rules, messages, forms => {
      x5on.post({
        url: x5on.url.tchreguser,
        data: forms,
        success(teachs) {
          that.setData({ teachs })
          teachs.length === 0 && x5on.showError(that, '没有找到你要的用户！')
        }
      })
    }, error => {
      x5on.showError(that, error)
    })
  },

  teachChange: function (e) {
    var that = this
    x5on.setRadio(that.data.teachs, e.detail.value, teachs => {
      that.setData({ teachs })
    })
  },

  schoolChange: function (e) {
    var that = this
    x5on.setPick(e, schIndex => {
      that.setData({ schIndex })
      var sch_uid = x5on.getUid(that.data.schools, schIndex)
      x5on.post({
        url: x5on.url.tchregmember,
        data: { sch_uid },
        success(members) {
          that.setData({ members })
        }
      })
    })
  },

  teachSubmit: function (e) {
    var that = this
    var rules = {
      user_uid: {
        required: true,
      },
      school: {
        required: true,
      }
    }
    var messages = {
      user_uid: {
        required: '教师选择',
      },
      school: {
        required: '注册学校',
      }
    }
    x5on.checkForm(e, rules, messages, forms => {
      forms.sch_uid = x5on.getUid(that.data.schools, forms.school)
      x5on.post({
        url: x5on.url.tchregreg,
        data: forms,
        success(members) {
          that.setData({ members })
        }
      })
    }, error => {
      x5on.showError(that, error)
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
        required: '教师姓名',
      }
    }
    x5on.checkForm(e, rules, messages, form => {
      var schIndex = that.data.schIndex
      form.sch_uid = x5on.getUid(that.data.schools, schIndex)
      x5on.post({
        url: x5on.url.tchregmemfind,
        data: form,
        success(members) {
          that.setData({ members })
          members.length === 0 && x5on.showError(that, '没有找到你要的教师！')
        }
      })
    }, error => {
      x5on.showError(that, error)
    })
  },

  useregRemove: function (e) {
    var that = this
    var user_uid = e.currentTarget.dataset.uid
    x5on.post({
      url: x5on.url.tchregdel,
      data: { user_uid },
      success() {
        var members = x5on.delValue(that.data.members, 'uid', user_uid)
        that.setData({ members })
      }
    })
  },

  returnClick: function (e) {
    wx.navigateBack()
  }

})