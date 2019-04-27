// Com/comPick.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    name: String,
    title: String,
    label: String,
    url: String,
    picks: Array,
    rangeKey: String,
    selectKey: String,
  },

  lifetimes: {
    ready() {
      var that = this
      that.data.url && x5on.request({
        url: that.data.url,
        success(picks) {
          that.setData({ picks })
        }
      })
    },
  },

  ready() {
    var that = this
    that.data.url && x5on.request({
      url: that.data.url,
      success(picks) {
        that.setData({ picks })
      }
    })
  },

  methods: {
    pickChange: function (e) {
      var that = this
      x5on.setPick(e, selectIndex => {
        that.setData({ selectIndex })
        // 推送数据
        var name = that.data.name
        var picked = x5on.getArr(that.data.picks, selectIndex)
        that.triggerEvent('pickChange', { name, picked })
      })
    }
  }
})
