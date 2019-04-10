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
    attached() {
      var that = this
      !that.data.checked && that.setData({ checked: 'checked' })
      //
      that.data.url && x5on.request({
        url: that.data.url,
        success(radios) {
          that.setData({ radios })
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
      success(radios) {
        that.setData({ radios })
      }
    })
  },

  methods: {
    radioChange: function (e) {
      var that = this
      var uid = e.detail.value

      x5on.setRadioex(that.data.radios, uid, that.data.checked, radios => {
        that.setData({ radios })
        var radio = x5on.getArrex(that.data.radios, 'uid', uid)
        radio && that.triggerEvent('radioChange', { uid, radio })
      })
    }
  }
})
