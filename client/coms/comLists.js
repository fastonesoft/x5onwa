// coms/comLists.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    lists: Object,
    mes: Object,
    title: String,
    notitle: Boolean,
    ok: String,
    detail: String,
    delete: String,
    canDelete: String,
    selectKey: String,
    tips: String,
  },

  methods: {
    detailClick: function(e) {
      this.triggerEvent('detailClick', e.currentTarget.dataset)
    },

    deleteClick: function(e) {
      this.triggerEvent('deleteClick', e.currentTarget.dataset)
    }
  }

})
