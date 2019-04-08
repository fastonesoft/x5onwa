// Com/comPick.js
var x5on = require('../pages/x5on.js')

Component({
  /**
   * 组件的属性列表
   */
  properties: {
    pickTitle: String,
    pickLabel: String,
    picks: Array,
    pickKey: String,
    pickValue: String,
    pickIndex: Number,
  },

  /**
   * 组件的方法列表
   */
  methods: {
    pickChange: function (e) {
      var that = this
      x5on.setPick(e, pickIndex => {
        that.setData({ pickIndex })
        // 推送数据
        var pickData = x5on.getArr(this.data.picks, pickIndex)
        this.triggerEvent('pickChange', pickData)
      })
    }
  }
})
