// coms/comSubPick.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    name: String,
    label: String,
    url: String,
    picks: Array,
    rangeKey: String,
    valueKey: String,
    selectKey: String,
  },

  lifetimes: {
    attached() {
      var that = this
      that.data.url && x5on.request({
        url: that.data.url,
        success(picks) {
          that.setData({ picks })
        }
      })
    },
  },

  attached() {
    var that = this
    that.data.url && x5on.request({
      url: that.data.url,
      success(picks) {
        that.setData({ picks })
      }
    })
  },

  methods: {
    subpickChange: function (e) {
      var that = this
      x5on.setPick(e, selectIndex => {
        that.setData({ selectIndex })
        // 推送数据
        var name = that.data.name
        var picked = x5on.getArr(that.data.picks, selectIndex)
        var value = picked[that.data.valueKey]
        that.triggerEvent('subpickChange', { name, value })
      })
    }
  }
})
