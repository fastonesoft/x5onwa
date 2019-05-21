// coms/comSubPick.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    name: String,
    label: String,
    url_q: String,
    data_q: Object,
    picks: Array,
    value: String,
    rangeKey: String,
    valueKey: String,
    selectKey: String,
  },

  lifetimes: {
    ready() {
      var that = this
      that.data.url_q && x5on.http(that.data.url_q, that.data.data_q)
      .then(picks=>{
        that.setData({ picks })
      })
    },
  },

  ready() {
    var that = this
    that.data.url_q && x5on.http(that.data.url_q, that.data.data_q)
    .then(picks=>{
      that.setData({ picks })
    })
  },

  observers: {
    'picks, value': function (picks, value) {
      var selectIndex = x5on.getIndexe(picks, this.data.valueKey, value)
      this.setData({ selectIndex })
    }
  },

  methods: {
    subpickChange: function (e) {
      var that = this
      x5on.setPick(e, selectIndex => {
        that.setData({ selectIndex })
        //
        var name = that.data.name
        var value = that.data.valueKey
        var range = that.data.rangeKey
        var select = that.data.selectKey
        if (name && value && range && select) {
          var picked = x5on.getArr(that.data.picks, selectIndex)
          var value = picked[value]
          that.triggerEvent('subpickChange', { [name]: value })
        } else {
          x5on.showError('没有指定控件名称、列表字段、选择字段、输出字段')
        }
      })
    }
  }
})
