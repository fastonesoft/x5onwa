// coms/comMember.js
// 单个选择显示


var x5on = require('../pages/x5on.js')

Component({

  properties: {
    membs: Array,
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
      .then(membs=>{
        that.setData({ membs })
      })
    },
  },

  ready() {
    var that = this
    that.data.url && x5on.http(that.data.url)
    .then(membs=>{
      that.setData({ membs })
    })
  },

  methods: {
    removeClick: function (e) {
      var uid = e.currentTarget.dataset.uid
      var membs = x5on.delArr(this.data.membs, 'uid', uid)
      this.setData({ membs })
      this.triggerEvent('removeClick', { uid })
    },

    editClick: function (e) {
      var uid = e.currentTarget.dataset.uid
      var memb = x5on.getArrex(this.data.membs, 'uid', uid)
      this.triggerEvent('editClick', memb)
    }
  }
})
