// coms/comRadioMemb.js
// 带删除的radio
var x5on = require('../pages/x5on.js')

Component({

  options: {
    styleIsolation: 'apply-shared'
  },

  properties: {
    name: String,
    title: String,
    notitle: Boolean,
    radios: Array,
    key: String,
    split: String,
    memo: String,
    checked: String,
    url: String,
    valueKey: String,
  },

  lifetimes: {
    ready() {
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

  methods: {
    removeClick: function (e) {
      var uid = e.currentTarget.dataset.uid
      var radios = x5on.delArr(this.data.radios, 'uid', uid)
      this.setData({ radios })
      this.triggerEvent('removeClick', { uid })
    },

    radioChange: function (e) {
      var that = this
      var uid = e.detail.value

      x5on.setRadioex(that.data.radios, uid, that.data.checked, radios => {
        that.setData({ radios })
        var name = that.data.name
        var key = that.data.valueKey
        var radio = x5on.getArrex(that.data.radios, 'uid', uid)
        if (name && key && radio.hasOwnProperty(key)) {
          that.triggerEvent('radioChange', { [name]: radio[key] })
        } else {
          that.triggerEvent('radioChange', radio)
        }
      })
    }
  }
})
