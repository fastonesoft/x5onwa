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
   * 组件的初始数据
   */
  data: {

  },

  /**
   * 组件的方法列表
   */
  methods: {
    pickChange: function (e) {
      var that = this
      x5on.setPick(e, pickIndex => {
        that.setData({ pickIndex })
      })
    }
  }
})
