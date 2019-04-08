// coms/comMember.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    members: Array,
    userName: String,
    nickName: String,
  },

  methods: {
    memberRemove: function (e) {
      var uid = e.currentTarget.dataset.uid
      var removed = x5on.getArrex(this.data.members, 'uid', uid)
      var members = x5on.delValue(this.data.members, 'uid', uid)
      this.setData({ members })
      this.triggerEvent('memberRemove', { removed, members })
    }
  }
})
