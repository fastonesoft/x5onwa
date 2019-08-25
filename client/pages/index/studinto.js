// pages/index/studinto.js
var x5on = require('../x5on.js')

Page({

  onLoad: function (options) {
    var that = this
    var mes = {
      total: { label: '总人数', type: 0 },
      female: { label: '：女生', type: 0 },
      male: { label: '：男生', type: 0 },
    }
    that.setData({ mes })
    //
		x5on.http(x5on.url.regquery)
		.then(steps_auths=>{
			that.setData(steps_auths)
		})
		.catch(error=>{
			x5on.showError(error)
		})

  },

})