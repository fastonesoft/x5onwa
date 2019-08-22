// coms/comMembs.js
var x5on = require('../pages/x5on.js')

Component({

  options: {
    styleIsolation: 'apply-shared'
  },

  properties: {
    membs: Array,
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
      .then(membs=>{
        that.setData({ membs })
      })
    },
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
      var mema = x5on.getArrex(this.data.membs, 'uid', uid)
      this.triggerEvent('editClick', mema)
    },

    removeClick: function (e) {
      var uid = e.currentTarget.dataset.uid
      var membs = x5on.delArr(this.data.membs, 'uid', uid)
      this.setData({ membs })
      this.triggerEvent('removeClick', { uid })
    },
  }
})
