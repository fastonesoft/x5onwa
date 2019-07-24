// coms/comBtn.js
Component({

  options: {
    styleIsolation: 'apply-shared'
  },

  properties: {
    type: String,
    title: String,
    canShow: Boolean,
  },

  methods: {
    buttonClick: function(e) {
      this.triggerEvent('buttonClick', {})
    }
  }
})
