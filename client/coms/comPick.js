// Com/comPick.js
var x5on = require('../pages/x5on.js')

Component({

  options: {
    styleIsolation: 'apply-shared'
  },

  properties: {
    name: String,
    title: String,
    notitle: Boolean,
    label: String,
    url: String,
    picks: Array,
    rangeKey: String,
    selectKey: String,
    valueKey: String,
  },

  lifetimes: {
    ready() {
      var that = this
      that.data.url && x5on.http(that.data.url)
      .then(picks=>{
        that.setData({ picks })
      })
    },
  },

  observers: {
    'picks': function (picks) {
      this.setData({ selectIndex: -1 })
    }
  },

  methods: {
    pickChange: function (e) {
      var that = this
      x5on.setPick(e, selectIndex => {
        that.setData({ selectIndex })
        //
        var name = that.data.name
        if (name) {
          var picked = x5on.getArr(that.data.picks, selectIndex)
          var value = picked[that.data.valueKey]
          that.triggerEvent('pickChange', { [name]: value })
        } else {
          x5on.showError('控件没有指定名称')
        }
      })
    }
  }
})
