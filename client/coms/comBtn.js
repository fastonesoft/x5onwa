// coms/comBtn.js
Component({

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
