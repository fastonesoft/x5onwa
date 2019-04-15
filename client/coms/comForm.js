// coms/comForm.js
var x5on = require('../pages/x5on.js')

Component({

  properties: {
    title: String,
    fields: Array,
    rules: Object,
    messages: Object,
    mini: Boolean,
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

    pickChange: function (e) {
      console.log(e)
    }
  }
})


// var fields = [{
//   mode: 0,
//   label: '文字测试',
//   value: false,
//   bool: true,
// }, {
//   mode: 1,
//   name: 'name',
//   label: '学生姓名',
//   type: 'text',
//   maxlength: '4',
//   value: '你是谁？'
// }, {
//   mode: 2,
//   name: 'year',
//   label: '学制年度',
//   value: true,
// }]
// var rules = {
//   name: {
//     required: true,
//     chinese: true,
//     rangelength: [2, 4],
//   },
//   year: {
//     required: true,
//   }
// }
// var messages = {
//   name: {
//     required: '学生姓名'
//   },
//   year: {
//     required: '学制年度'
//   }
// }

// that.setData({
//   fields,
//   rules,
//   messages
// })
// })
