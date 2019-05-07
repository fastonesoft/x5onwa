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

  methods: {
    gotoClick: function (e) {
      var uid = e.currentTarget.dataset.uid
      var mema = x5on.getArrex(this.data.memas, 'uid', uid)
      this.triggerEvent('gotoClick', mema)
    }
  }
})
