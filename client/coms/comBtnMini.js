// coms/comBtnMini.js
Component({

  options: {
    styleIsolation: 'apply-shared'
  },

  properties: {
    uid: Object,
    canShow: Boolean,
    canDefault: Boolean,
    canPrimary: Boolean,
    canWarn: Boolean,
    default: String,
    primary: String,
    warn: String,
  },

  methods: {
    defaultClick: function(e) {
      this.triggerEvent('defaultClick', e.currentTarget.dataset)
    },

    primaryClick: function(e) {
      this.triggerEvent('primaryClick', e.currentTarget.dataset)
    },

    warnClick: function(e) {
      this.triggerEvent('warnClick', e.currentTarget.dataset)
    },
  }
})
