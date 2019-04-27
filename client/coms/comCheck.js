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
    data: Object,
  },

  lifetimes: {
    ready() {
      var that = this
      !that.data.checked && that.setData({ checked: 'checked' })
      //
      if (that.data.url) {
        !that.data.data && x5on.request({
          url: that.data.url,
          success(checks) {
            console.log('------1-----')
            that.setData({ checks })
          }
        })
        that.data.data && x5on.post({
          data: that.data.data,
          url: that.data.url,
          success(checks) {
            console.log('------2-----')
            that.setData({ checks })
          }
        })
      }
    },
  },

  ready() {
    var that = this
    !that.data.checked && that.setData({ checked: 'checked' })
    //
    if (that.data.url) {
      !that.data.data && x5on.request({
        url: that.data.url,
        success(checks) {
          console.log(checks)
          that.setData({ checks })
        }
      })
      that.data.data && x5on.post({
        data: that.data.data,
        url: that.data.url,
        success(checks) {
          console.log(checks)
          that.setData({ checks })
        }
      })
    }
  },

  methods: {
    checkChange: function (e) {
      var that = this
      var uids = e.detail.value

      x5on.setCheckboxex(that.data.checks, uids, that.data.checked, checks => {
        that.setData({ checks })
        x5on.getCheckboxex(that.data.checks, that.data.checked, checked => {
          that.triggerEvent('checkChange', { uids, checked })
        })
      })
    }
  }
})
