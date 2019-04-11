// pages/index/typeset.js
var x5on = require('../x5on.js')

Page({

  data: {
    typeseturl: x5on.url.typeset,
  },

  onLoad: function (e) {
    var that = this
    // x5on.request({
    //   url: x5on.url.typeset,
    //   success(schos_typesets) {
    //     that.setData(schos_typesets)
    //   }
    // })

    var fields = [{
      mode: 0,
      name: 'name',
      label: '学生姓名',
      type: 'text',
      maxlength: '4',
    }, {
      mode: 0,
      name: 'year',
      label: '学制年度',
      type: 'number',
      maxlength: '4',
    }]
    var rules = {
      name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      },
      year: {
        required: true,
        digits: true,
        rangelength: [2, 4],
      }
    }
    var messages = {
      name: {
        required: '学生姓名'
      },
      year: {
        required: '学制年度'
      }
    }

    that.setData({ fields, rules, messages })

  },


  memberRemove: function (e) {
    var types = []
    types.push(e.detail.removed)
    this.setData({ types })
  },

  member1Remove: function (e) {
    console.log(111)
  },

  findSubmit: function (e) {
    console.log(e)
  },

  formSubmit: function (e) {
    console.log(e)

  },


  typesetRemove: function (e) {
    var that = this
    x5on.request({
      url: x5on.url.typesetdel,
      success(typesets) {
        that.setData({ typesets })
      }
    })
  },

  returnClick: function (e) {
		wx.navigateBack()
  },
  
  
  
  
  
  
  
  
  
  
  

})