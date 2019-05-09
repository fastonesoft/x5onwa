// coms/comLists.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    lists: Object,
    mes: Object,
    title: String,
    notitle: Boolean,
    detail: Boolean,
    selectKey: String,
    tips: String,
  },

  methods: {
    detailClick: function(e) {
      this.triggerEvent('detailClick', e.currentTarget.dataset)
    }
  }

})
