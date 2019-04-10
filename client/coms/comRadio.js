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

  ready() {
    var that = this
    that.data.url && x5on.request({
      url: that.data.url,
      success(radios) {
        that.setData({ radios })
      }
    })
  },

  methods: {
    radioChange: function (e) {
      var that = this
      var uid = e.detail.value
      var selected = that.data.checked ? that.data.checked : 'checked'

      console.log(selected)

      x5on.setRadioex(that.data.radios, uid, selected, radios => {
        that.setData({ radios })
        var radio = x5on.getArrex(that.data.radios, 'uid', uid)
        that.triggerEvent('radioChange', { uid, radio })
      })
    }
  }
})
