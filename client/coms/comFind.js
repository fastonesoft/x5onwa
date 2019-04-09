// coms/comFind.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    title: String,
    label: String,
  },

  methods: {
    findSubmit: function (e) {
      var that = this
      var rules = {
        name: {
          required: true,
          chinese: true,
          rangelength: [1, 3],
        }
      }
      var messages = {
        name: {
          required: this.data.label
        }
      }
      x5on.checkForm(e.detail.value, rules, messages, form => {
        this.triggerEvent('findSubmit', { form })
      }, message => {
        x5on.showError(that, message)
      })
    },
  }
})
