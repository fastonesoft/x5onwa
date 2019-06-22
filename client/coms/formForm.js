// coms/formForm.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    title: String,
    notitle: Boolean,
    fields: Array,
    rules: Object,
    mini: Boolean,
    submitName: String,
  },

  data: {
    pickForm: {}
  },

  methods: {
    
    subpickChange: function (e) {
      var pickForm = this.data.pickForm
      Object.assign(pickForm, e.detail)
      this.setData({ pickForm })
    },
    
    formSubmit: function (e) {
      var that = this
      // 获取picks控件初值列表
      var oldform = x5on.formPickDefault(that.data.fields)
      Object.assign(oldform, e.detail.value, that.data.pickForm)
      var messages = x5on.message(that.data.fields)
      x5on.checkForm(oldform, that.data.rules, messages, form => {
        that.triggerEvent('formSubmit', form)
      }, mes => {
        x5on.showErrorLocal(this, mes)
      })
    },

  }
})