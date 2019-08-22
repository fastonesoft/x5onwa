// coms/formFind.js
var x5on = require('../pages/x5on.js')

Component({

  options: {
    styleIsolation: 'apply-shared'
  },

  properties: {
    title: String,
    notitle: Boolean,
    label: String,
    name: String,
  },

  methods: {
    findSubmit: function (e) {
      var that = this
      var name = that.data.name ? that.data.name : 'name'

      var rules = {
        [name]: {
          required: true,
          chinese: true,
          rangelength: [1, 3],
        }
      }
      var messages = {
        [name]: {
          required: that.data.label
        }
      }

      x5on.checkForm(e.detail.value, rules, messages, form => {
        that.triggerEvent('findSubmit', form)
      }, message => {
        x5on.showError(message)
      })
    },
  }
})
