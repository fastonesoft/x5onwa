// coms/comCheck.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    url: String,
    data: Object,
    checks: Array,
    title: String,
    key: String,
    split: String,
    memo: String,
    checked: String,
  },

  lifetimes: {
    ready() {
      var that = this
      !that.data.checked && that.setData({ checked: 'checked' })
      //
      that.data.url && x5on.http(that.data.url, that.data.data)
      .then(checks => {
        that.setData({ checks })
      })
    },
  },

  ready() {
    var that = this
    !that.data.checked && that.setData({ checked: 'checked' })
    //
    that.data.url && x5on.http(that.data.url, that.data.data)
    .then(checks => {
      that.setData({ checks })
    })
  },

  methods: {
    checkChange: function (e) {
      var that = this
      var uids = e.detail.value
      x5on.setCheckboxex(that.data.checks, uids, that.data.checked, checks => {
        that.setData({ checks })
      })
    },

    formSubmit: function (e) {
      var that = this
      var fields = [{ mode: 1, name: 'uids', label: that.data.title }]
      var rules = { uids: { required: true, arr: true } }
      var messages = x5on.message(fields)
      // 表单验证
      x5on.checkForm(e.detail.value, rules, messages, form => {
        this.triggerEvent('formSubmit', form)
      }, mes => {
        x5on.showError(that, mes)
      })
    }
  }
})
