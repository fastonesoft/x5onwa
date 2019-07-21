// coms/comList.js
var x5on = require('../pages/x5on.js')

Component({

  options: {
    styleIsolation: 'apply-shared'
  },

  properties: {
    obj: Object,
    mes: Object,
    title: String,
    notitle: Boolean,
  },

  observers: {
    'obj, mes': function (obj, mes) {
      var list = x5on.objMessage(obj, mes)
      this.setData({ list })
    }
  },

})
