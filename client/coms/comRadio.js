// coms/comRadio.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    title: String,
    radios: Array,
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
        success(radios) {
          that.setData({ radios })
        }
      })
    },
  },

  methods: {
    radioChange: function (e) {
      var uid = e.detail.value
      x5on.setRadioex(this.data.radios, uid, this.data.checked, radios => {
        this.setData({ radios })
        this.triggerEvent('radioChange', { uid, radios })
      })
    }
  }
})
