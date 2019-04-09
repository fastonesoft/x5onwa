// coms/comCheck.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    title: String,
    checks: Array,
    key: String,
    memo: String,
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

  methods: {
    checkChange: function (e) {
      var uids = e.detail.value
      x5on.setCheckbox(this.data.checks, uids, checks => {
        this.setData({ checks })
        this.triggerEvent('checkChange', { uids, checks })
      })
    }
  }
})
