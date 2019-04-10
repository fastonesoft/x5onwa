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
    ready() {
      var that = this
      that.data.url && x5on.request({
        url: that.data.url,
        success(checks) {
          that.setData({ checks })
        }
      })
    },
  },

  ready() {
    var that = this
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
      var selected = that.data.checked ? that.data.checked : 'checked'
      
      console.log(selected)

      x5on.setCheckboxex(that.data.checks, uids, selected, checks => {
        that.setData({ checks })
        x5on.getCheckboxex(that.data.checks, selected, checked => {
          that.triggerEvent('checkChange', { uids, checked })
        })
      })
    }
  }
})
