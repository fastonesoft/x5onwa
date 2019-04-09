// Com/comPick.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    title: String,
    label: String,
    picks: Array,
    key: String,
    value: String,
    index: Number,
  },

  methods: {
    pickChange: function (e) {
      var that = this
      x5on.setPick(e, index => {
        that.setData({ index })
        // 推送数据
        var res = x5on.getArr(this.data.picks, index)
        this.triggerEvent('pickChange', res)
      })
    }
  }
})
