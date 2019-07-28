// pages/index/userview.js
var x5on = require('../x5on.js')

Page({

  findSubmit: function (e) {
    var that = this
    x5on.http(x5on.url.userdistuser, e.detail)
    .then(sch_users => {
      sch_users.length !== 0 && that.setData({ sch_users, user_sch_uid: null, groups: [] })
      sch_users.length === 0 && x5on.showError('没有找到你要的教师！')
    })
  },

  radioChange: function (e) {
    var that = this
    that.setData(e.detail)
    x5on.http(x5on.url.userview, e.detail)
    .then(groups=>{
      that.setData({ groups })
    })
  },

  formSubmit: function (e) {
    var that = this
    var groups_json = JSON.stringify(e.detail)
    var user_sch_uid = that.data.user_sch_uid
    groups_json && user_sch_uid && x5on.http(x5on.url.userviewupdate, { groups_json, user_sch_uid })
    .then(res=>{
      that.setData({ sch_users: [], groups: [] })
    })
  },

})