// coms/formSwitch.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    url: String,
    data: Object,
    switchs: Array,
    title: String,
    key: String,
    split: String,
    memo: String,
    checked: String,
    mini: Boolean,
  },

  lifetimes: {
    ready() {
      var that = this
      !that.data.checked && that.setData({ checked: 'checked' })
      //
      that.data.url && x5on.http(that.data.url, that.data.data)
      .then(switchs => {
        that.setData({ switchs })
      })
    },
  },

  ready() {
    var that = this
    !that.data.checked && that.setData({ checked: 'checked' })
    //
    that.data.url && x5on.http(that.data.url, that.data.data)
    .then(switchs => {
      that.setData({ switchs })
    })
  },

  methods: {
    formSubmit: function (e) {
      this.triggerEvent('formSubmit', e.detail.value)
    }
  }
})
