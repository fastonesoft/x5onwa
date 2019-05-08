// coms/comList.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    obj: Object,
    mes: Object,
    title: String,
    notitle: Boolean,
    notitletext: Boolean,
  },

  observers: {
    'obj, mes': function (obj, mes) {
      var list = x5on.objMessage(obj, mes)
      this.setData({ list })
    }
  },

})
