// pages/index/tchreg.js
var x5on = require('../x5on.js')
import x5form from '../x5va.js'

Page({

  onLoad: function () {
    var that = this
    x5on.requestEx({
      url: x5on.url.tchregusersch,
      success: schools => {
        that.setData({ schools })
      }
    })
  },

  findSubmit: function (e) {
    var that = this
    var form = new x5form({
      name: {
        required: true,
        chinese: true,
        rangelength: [1, 3],
      }
    }, {
        name: {
          required: '教师姓名',
        }
      })
    form.checkForm(e, forms => {
      x5on.postFormEx({
        url: x5on.url.tchreg,
        data: forms,
        success: radios => {
          radios.length === 0 ? x5on.showError(that, '没有找到你说的老师！') : that.setData({ radios })
        }
      })
    }, error => {
      x5on.showError(that, error)
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

  schoolChange: function (e) {
    var index = e.detail.value
    var sch_id = this.data.schools[index].sch_id
    this.setData({ schIndex: index, sch_id: sch_id })
  },

  updateSubmit: function (e) {
    var that = this
    var form = new x5form({
      user_id: {
        required: true,
      },
      sch_index: {
        required: true,
      }
    }, {
        user_id: {
          required: '教师选择',
        },
        sch_index: {
          required: '注册学校',
        }
      })
    form.checkForm(e, forms => {
      forms.sch_id = x5on.getId(that.data.schools, forms.sch_index)
      x5on.postFormEx({
        url: x5on.url.tchreguserreg,
        data: forms,
        success: radios => {
          // 数据提交成功，清除已添加的教师
          var radios = this.data.radios
          radios.splice(this.data.rIndex, 1)
          that.setData({ radios })
        }
      })
    }, error => {
      x5on.showError(that, error)
    })
  }

})