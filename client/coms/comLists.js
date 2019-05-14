// coms/comLists.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    lists: Object,
    mes: Object,
    title: String,
    notitle: Boolean,
    ok: String,
    del: String,
    ref: String,
    canOk: String,
    canDel: String,
    canRef: String,
    selectKey: String,
    tips: String,
  },

  methods: {
    okClick: function(e) {
      this.triggerEvent('okClick', e.currentTarget.dataset)
    },

    delClick: function(e) {
      this.triggerEvent('delClick', e.currentTarget.dataset)
    },

    refClick: function(e) {
      console.log('-------------1---')
      this.triggerEvent('refClick', e.currentTarget.dataset)
    },
  }

})
