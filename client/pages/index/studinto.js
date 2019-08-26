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
    x5on.http(x5on.url.studinto)
      .then(steps => {
        that.setData({ steps })
      })
      .catch(error => {
        x5on.showError(error)
      })
  },

  pickChange: function (e) {
		var that = this
		that.setData(e.detail)
		x5on.http(x5on.url.studintocount, e.detail)
		.then(counts => {
      let { cls } = counts
      delete counts.cls
			that.setData({ counts, cls, cls_id: null })
		})
		.catch(error => {
			x5on.showError(error)
		})
	},

  clsChange: function (e) {
		var that = this
		that.setData(e.detail)
  },
  
  buttonClick: function(e) {
    var that = this
    let { steps_id, cls_id } = that.data
		x5on.http(x5on.url.studintoenter, { steps_id, cls_id })
		.then(counts => {
			that.setData({ counts })
		})
		.catch(error => {
			x5on.showError(error)
		})
  },

  findSubmit: function(e) {
    var that = this
    let { steps_id } = that.data
    Object.assign(e.detail, { steps_id })

    x5on.http(x5on.url.studintoquery, e.detail)
		.then(notintos => {
			that.setData({ notintos })
		})
		.catch(error => {
			x5on.showError(error)
		})
  },

  checkSubmit: function(e) {
    var that = this
    let { steps_id, cls_id } = that.data
    let form = Object.assign({ steps_id, cls_id }, e.detail)

    x5on.http(x5on.url.studintoout, form)
		.then(number => {
      x5on.updateSuccess(number)
			// 清除选中
			let { notintos } = that.data
      notintos = x5on.delArrs(notintos, 'uid', e.detail.uids)
      
			that.setData({ notintos })
		})
		.catch(error => {
			x5on.showError(error)
		})
  },

})