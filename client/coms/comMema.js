// coms/comMema.js

var x5on = require('../pages/x5on.js')

Component({

  properties: {
    memas: Array,
    url: String,
    title: String,
    notitle: Boolean,
    key: String,
    split: String,
    memo: String,
    selected: String,
    remove: Boolean,
  },

  lifetimes: {
    ready() {
      var that = this
      that.data.url && x5on.http(that.data.url)
      .then(memas=>{
        that.setData({ memas })
      })
    },
  },

  ready() {
    var that = this
    that.data.url && x5on.http(that.data.url)
    .then(memas=>{
      that.setData({ memas })
    })
  },

  observers: {
    'selected': function (selected) {
      var selects = selected.split(',')
      this.setData({ selects })
    }
  },

  methods: {
    editClick: function (e) {
      var uid = e.currentTarget.dataset.uid
      var mema = x5on.getArrex(this.data.memas, 'uid', uid)
      this.triggerEvent('editClick', mema)
    },

    removeClick: function (e) {
      var uid = e.currentTarget.dataset.uid
      var memas = x5on.delArr(this.data.memas, 'uid', uid)
      this.setData({ memas })
      this.triggerEvent('removeClick', { uid })
    },
  }
})
