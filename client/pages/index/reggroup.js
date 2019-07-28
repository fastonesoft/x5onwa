// pages/index/reggroup.js
var x5on = require('../x5on.js')

Page({

  data: {
    groups: [
      {id: 'A', name: 'A组'},
      {id: 'B', name: 'B组'},
      {id: 'C', name: 'C组'},
      {id: 'D', name: 'D组'},
      {id: 'E', name: 'E组'},
      {id: 'F', name: 'F组'},
      {id: 'G', name: 'G组'},
      {id: 'H', name: 'H组'},
      {id: 'J', name: 'J组'},
      {id: 'K', name: 'K组'},
      {id: 'M', name: 'M组'},
      {id: 'N', name: 'N组'},
    ]
  },

  onLoad: function(e) {
    var that = this
    var mes = {
      child_name: { label: '报名学生', type: 0 },
      group_num: { label: '分组编号', type: 0 },
    }
    that.setData({ mes })
    
		x5on.http(x5on.url.reggroup)
		.then(steps=>{
			that.setData({ steps })
		})
		.catch(error=>{
			x5on.showError(error)
		})
  },

  pickChange: function(e) {
    this.setData(e.detail)
  },

  findSubmit: function(e) {
    var that = this
    var { steps_id } = that.data
    e.detail.steps_id = steps_id
    // 清除
    that.setData({ regstuds: [], regstud: null, studgroup: null })

    x5on.http(x5on.url.reggroupstud, e.detail)
    .then(regstuds=>{
      that.setData({ regstuds })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  },

  studChange: function(e) {
    this.setData({ regstud: e.detail, studgroup: null })
  },

  groupClick: function(e) {
    var that = this
    var { steps_id, group_name, regstud } = that.data
    var { uid, group_num } = regstud

    // 非空
    group_num && x5on.confirm('分组提示', '分组编号已存在，确认重新分组吗？', ()=>{
      // 确认，提交
      x5on.http(x5on.url.reggroupgroup, { steps_id, group_name, stud_reg_uid: uid })
      .then(studgroup=>{
        // 清除当前设置记录、删除数组记录、显示设置结果
        var regstuds = x5on.delArr(that.data.regstuds, 'uid', uid)
        that.setData({ regstud: null, regstuds, studgroup })
      })
      .catch(error=>{
        x5on.showError(error)
      })
    })

    // 空值
    !group_num && x5on.http(x5on.url.reggroupgroup, { steps_id, group_name, stud_reg_uid: uid })
    .then(studgroup=>{
      // 清除当前设置记录、删除数组记录、显示设置结果
      var regstuds = x5on.delArr(that.data.regstuds, 'uid', uid)
      that.setData({ regstud: null, regstuds, studgroup })
    })
    .catch(error=>{
      x5on.showError(error)
    })
  }

})