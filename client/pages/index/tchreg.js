// pages/index/tchreg.js
var x5on = require('../x5on.js')
import x5va from '../x5va.js'

Page({

  data: {
    radios: [],
    pickers: [],
    sch_id: '',
    pIndex: 0,
    rIndex: 0
  },

  onLoad: function () {
    this.x5va = new x5va({
      name: {
        required: true,
        chinese: true,
        rangelength: [2, 4],
      }
    })
    var that = this
    x5on.check({
      showError: true,
      success: () => x5on.request({
        url: x5on.url.tchsch,
        success: function (result) {
          var data = result.data
          var sch_id = data.length > 0 ? data[0].sch_id : ''
          that.setData({ pickers: data, sch_id: sch_id })          
        }
      })
    })
  },

  findSubmit: function (e) {
    var that = this
    // 检测输入
    that.x5va.checkForm(e, function () {
      x5on.postFormEx({
        url: x5on.url.tchreg,
        data: e.detail.value,
        success: (result) => {
          var radios = result.data
          radios.length === 0 ? x5on.showError(that, '没有找到你说的老师！') : that.setData({ radios })
        }
      })
    }, function (error) {
      x5on.showError(that, '教师姓名：' + error)
    })
  },

  radioChange: function (e) {
    var index = 0
    var radios = this.data.radios
    for (var i = 0; i < radios.length; ++i) {
      radios[i].checked = radios[i].id == e.detail.value
      index = radios[i].checked ? i : index
    }
    this.setData({ radios: radios, rIndex: index })
  },

  pickerChange: function (e) {
    var index = e.detail.value
    var sch_id = this.data.pickers[index].sch_id
    this.setData({ pIndex: index, sch_id: sch_id })
  },

  updateSubmit: function (e) {
    var that = this
    var data = e.detail.value
    if (data.user_id && data.sch_id) {
      // 提交
      x5on.postFormEx({
        url: x5on.url.tchschreg,
        data: e.detail.value,
        success: (result) => {
          // 数据提交成功，清除已添加的教师
          var radios = this.data.radios
          radios.splice(this.data.rIndex, 1)
          that.setData({ radios })
        }
      })
    } else {
      x5on.showError(that, '教师姓名、注册学校不得为空！')
    }
  }

})