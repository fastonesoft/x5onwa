// coms/comCheck.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    title: String,
    checks: Array,
    key: String,
    memo: String,
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
