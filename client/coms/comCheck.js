// coms/comCheck.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    title: String,
    checks: Array,
    key: String,
    memo: String,
    checked: String,
    url: String,
  },

  lifetimes: {
    attached() {
      var that = this
      !that.data.checked && that.setData({ checked: 'checked' })
      //
      that.data.url && x5on.request({
        url: that.data.url,
        success(checks) {
          that.setData({ checks })
        }
      })
    },
  },

  attached() {
    var that = this
    !that.data.checked && that.setData({ checked: 'checked' })
    //
    that.data.url && x5on.request({
      url: that.data.url,
      success(checks) {
        that.setData({ checks })
      }
    })
  },

  methods: {
    checkChange: function (e) {
      var that = this
      var uids = e.detail.value

      x5on.setCheckboxex(that.data.checks, uids, that.data.checked, checks => {
        that.setData({ checks })
        x5on.getCheckboxex(that.data.checks, that.data.checked, checked => {
          that.triggerEvent('checkChange', { uids, checked })
        })
      })
    }
  }
})
