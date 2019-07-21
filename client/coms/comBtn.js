// coms/comBtn.js
Component({

  options: {
    styleIsolation: 'apply-shared'
  },

  properties: {
    title: String,
    canShow: Boolean,
  },

  methods: {
    buttonClick: function(e) {
      this.triggerEvent('buttonClick', {})
    }
  }
})
