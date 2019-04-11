// coms/comForm.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    title: String,
    fields: Array,
    rules: Object,
    messages: Object,
  },

  methods: {
    formSubmit: function (e) {
      var that = this
      x5on.checkForm(e.detail.value, that.data.rules, that.data.messages, form => {
        that.triggerEvent('formSubmit', { form })
      }, mes => {
        x5on.showError(that, mes)
      })
    },
  }
})
