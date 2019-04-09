// coms/comRadio.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    radios: Array,
    title: String,
    key: String,
    memo: String,
    checked: String,
  },

  methods: {
    radioChange: function (e) {
      x5on.setRadioex(this.data.radios, e.detail.value, this.data.checked, radios => {
        this.setData({ radios })
        this.triggerEvent('radioChange', { radios })
      })
    }
  }
})
