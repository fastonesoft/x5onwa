// coms/comMember.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    membs: Array,
    title: String,
    key: String,
    memo: String,
    url: String,
  },

  lifetimes: {
    ready() {
      var that = this
      that.data.url && x5on.request({
        url: that.data.url,
        success(membs) {
          that.setData({ membs })
        }
      })
    },
  },

  ready() {
    var that = this
    that.data.url && x5on.request({
      url: that.data.url,
      success(membs) {
        that.setData({ membs })
      }
    })
  },

  methods: {
    removeClick: function (e) {
      var uid = e.currentTarget.dataset.uid
      var removed = x5on.getArrex(this.data.membs, 'uid', uid)
      var membs = x5on.delArr(this.data.membs, 'uid', uid)
      this.setData({ membs })
      this.triggerEvent('removeClick', { removed, membs })
    },

    editClick: function (e) {
      var uid = e.currentTarget.dataset.uid
      var memb = x5on.getArrex(this.data.membs, 'uid', uid)
      this.triggerEvent('editClick', memb)
    }
  }
})
