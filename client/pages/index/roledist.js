// pages/index/roledist.js
var x5on = require('../x5on.js')

Page({
  data: {
    errorShow: false,
    errorMessage: '错误提示',
    errorArray: [1],

    picker: [],
    pIndex: -1,
    radios: [],
    rIndex: 0,
    group_id: '',
    teachs: [],
  },

  onLoad: function () {
    var that = this
    x5on.check({
      showError: true,
      success: () => x5on.request({
        url: x5on.url.roledistgroup,
        success: function (result) {
          console.log(result)
          that.setData({ pickers: result.data })
        }
      })
    })
  },

  checkInput: function (e) {
    x5on.checkInput(e, this)
  },

  findSubmit: function (e) {
    var that = this;
    // 检测登录
    x5on.check({
      showError: true,
      success: () => x5on.checkForm(that, 0, 0, function () {
        x5on.postFormEx({
          url: x5on.url.roledist,
          data: e.detail.value,
          success: (result) => {
            var data = result.data
            data.length === 0 ? x5on.showError(that, '没有找到你说的老师！') : that.setData({ radios: result.data })
          }
        })
      })
    });
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
    var that = this
    var index = e.detail.value
    var group_id = this.data.pickers[index].id
    that.setData({ pIndex: index, group_id: group_id });
    // 刷新数据
    x5on.postFormEx({
      url: x5on.url.roledistgroupuser,
      data: {group_id},
      success: (res) => {
        that.setData({ teachs: res.data })
      }
    })
  },

  roledistUpdate: function (e) {
    var that = this
    var value = e.detail.value
    if (value.user_id && value.group_id) {
      x5on.postFormEx({
        url: x5on.url.roledistupdate,
        data: value,
        success: (res) => {
          x5on.showSuccess('添加' + res.data.num + '个教师')
          if (res.data && res.data.num === 1) {
            // 添加成功，刷新数据
            var radios = that.data.radios
            radios.splice(that.data.rIndex, 1)
            that.setData({ radios: radios, teachs: res.data.data })
          }
        }
      })
    } else {
      x5on.showError(this, '教师选择、权限分组不得为空！')
    }    
  },

  roledistRemove: function (e) {
    var that = this
    var uid = e.currentTarget.dataset.uid
    var index = e.currentTarget.dataset.index
    x5on.postFormEx({
      url: x5on.url.roledistdeleteuser,
      data: {uid},
      success: (res) => {
        x5on.showSuccess('删除' + res.data + '个教师')
        if (res.data && res.data === 1) {
          // 添加成功，刷新数据
          var teachs = that.data.teachs
          teachs.splice(index, 1)
          that.setData({ teachs: teachs })
        }
      }
    })
  },
})