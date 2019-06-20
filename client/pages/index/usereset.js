// pages/index/usereset.js
var x5on = require('../x5on.js')

Page({

  findSubmit: function (e) {
    var that = this
    x5on.http(x5on.url.usereset, e.detail)
    .then(users=>{
      users.length !== 0 && that.setData({ users, user: null })
      users.length === 0 && x5on.showError('没有找到你要的用户！')
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  userChange: function (e) {
    var user = e.detail
    var fields = [{
      mode: 0,
      label: '用户姓名',
      value: user.name,
    }, {
      mode: 0,
      label: '手机号码',
      value: user.mobil,
    }, {
      mode: 2,
      label: '是否确认',
      name: 'confirmed',
      value: user.confirmed
    }, {
      mode: 2,
      label: '冻结帐号',
      name: 'fixed',
      value: user.fixed
    }]
    var rules = {
      confirmed: {
        required: true,
      },
      fixed: {
        required: true,
      },
    }
    // 显示
    this.setData({ user, fields, rules })
  },

  userSubmit: function (e) {
    var that = this
    var { user } = that.data
    e.detail.uid = user.uid
    //
    x5on.http(x5on.url.useresetupdate, e.detail)
    .then(number=>{
      x5on.updateSuccess(number)
      var users = x5on.delArr(that.data.users, 'uid', user.uid)
      that.setData({ users, user: null, fields: [], rules: [] })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

})