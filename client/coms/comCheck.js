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

  pageLifetimes: {
    ready() {
      console.log(this.data.url)
      
      this.data.url && x5on.request({
        url: this.data.url,
        success(checks) {
          that.setData({ checks })
        }
      })
    }
  },

  methods: {
    checkChange: function (e) {
      x5on.setCheckbox(this.data.checks, e.detail.value, checks => {
        this.setData({ checks })
        this.triggerEvent('checkChange', { checks })
      })
    }
  }
})
