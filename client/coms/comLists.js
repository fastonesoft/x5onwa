// coms/comLists.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    lists: Object,
    mes: Object,
    title: String,
    notitle: Boolean,
  },

  observers: {
    'lists, mes': function (lists, mes) {
      var lists = x5on.objMessage(obj, mes)
      this.setData({ lists })
    }
  },

})
