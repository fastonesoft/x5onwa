// coms/comRowPick.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    name: String,
    url: String,
    data: Object,
    picks: Array,
    rangeKey: String,
    valueKey: String,
    selectKey: String,
  },

  lifetimes: {
    ready() {
      var that = this
      that.data.url && x5on.http(that.data.url, data)
      .then(picks=>{
        that.setData({ picks })
      })
    },
  },

  ready() {
    var that = this
    that.data.url && x5on.http(that.data.url, data)
    .then(picks=>{
      that.setData({ picks })
    })
  },

  methods: {
    rowpickChange: function (e) {
      var that = this
      x5on.setPick(e, selectIndex => {
        that.setData({ selectIndex })
        //
        var name = that.data.name
        if (name) {
          var picked = x5on.getArr(that.data.picks, selectIndex)
          var value = picked[that.data.valueKey]
          that.triggerEvent('rowpickChange', { [name]: value })
        } else {
          x5on.showError(that, '控件没有指定名称')
        }
      })
    }
  }
})
