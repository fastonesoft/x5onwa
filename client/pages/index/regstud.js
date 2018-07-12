// pages/index/regstud.js
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var x5on = require('../x5on.js')

Page({

  data: {
  
  },

  onLoad: function (options) {
    var that = this

    x5on.loadimage({
      url: x5on.url.regstudqrcode,
      success: function (result) {
        var imageurl = 'data:image/png;base64,' + result
        that.setData({ imageurl })
      }
    })

    x5on.check({
      success: () => {
        // 是否报名
        const session = qcloud.Session.get()
        var userinfor = session ? session.userinfo : null
        var user_id = userinfor ? userinfor.unionId : '0'
        x5on.request({
          url: x5on.url.regstudcheck,
          success: function (result) {
            var data = result.data
            var not_reg = ! data.reged
            var sch_reged = data.reged
            var not_added = ! data.infor_added
            var infor_added = data.infor_added 
            var sch_id = data.reged && data.data.sch_id
            var sch_name = data.reged && data.data.sch_name
            var child_id = data.reged && data.data.child_id
            var child_name = data.reged && data.data.child_name
            var infors = data.reged && data.forms
            var user_forms = data.reged && data.infor_added && data.user_forms
            var form_name = data.reged && data.infor_added && data.form_name
            that.setData({ not_reg, sch_reged, not_added, infor_added, sch_id, sch_name, child_id, child_name, infors, user_forms, form_name })
          }
        })
        // 学校
        x5on.request({
          url: x5on.url.regstudschools,
          success: function (result) {
            var data = result.data
            that.setData({ schools: data })
          }
        })
        // 孩子
        x5on.request({
          url: x5on.url.parentchilds,
          success: function (result) {
            var data = result.data
            that.setData({ childs: data })
          }
        })
      }
    })
  },

  checkInput: function (e) {
    x5on.checkInputEx(e, this)
  },

  schoolChange: function (e) {
    var schIndex = e.detail.value
    if (schIndex == -1) return

    var sch_id = this.data.schools[schIndex].id
    var sch_name = this.data.schools[schIndex].name
    var edu_type_id = this.data.schools[schIndex].edu_type_id
    this.setData({ schIndex, sch_id, sch_name, edu_type_id })
  },

  childChange: function (e) {
    var childIndex = e.detail.value
    if (childIndex == -1) return

    var child_id = this.data.childs[childIndex].child_id
    var child_name = this.data.childs[childIndex].child_name
    this.setData({ childIndex, child_id, child_name })
  },

  inforChange: function (e) {
    var that = this
    var inforIndex = e.detail.value
    if (inforIndex == -1) return

    var form_show = true
    var form_id = that.data.infors[inforIndex].id
    var form_name = that.data.infors[inforIndex].name    
    this.setData({ form_show, inforIndex, form_id, form_name })
    x5on.check({
      success: () => {
        x5on.postFormEx({
          data: {form_id},
          url: x5on.url.schoolformkey,
          success: function (result) {            
            var data = result.data
            console.log(data)
            that.setData({ items: data })
          }
        })
      }
    })
  },

  regstudSubmit: function (e) {
    var that = this
    if (e.detail.value.sch_id && e.detail.value.child_id && e.detail.value.edu_type_id) {
      x5on.check({
        success: () => {
          x5on.postFormEx({
            data: e.detail.value,
            url: x5on.url.regstudreg,
            success: function (result) {
              var not_reg = false
              var sch_reged = true
              var infors = result.data
              that.setData({ not_reg, sch_reged, infors })
            }
          })
        }
      })
    } else {
      x5on.showError(this, '报名学校、报名学生不得为空')
    }
  },

  cancelSubmit: function (e) {
    var that = this
    x5on.check({
      success: () => {
        x5on.postFormEx({
          data: e.detail.value,
          url: x5on.url.regstudcancel,
          success: function (result) {
            var not_reg = true
            var sch_reged = false
            var form_show = false
            var sch_id = ''
            var child_id = ''
            var schIndex = -1
            var childIndex = -1
            that.setData({ not_reg, sch_reged, form_show, sch_id, child_id, schIndex, childIndex })
          }
        })
      }
    })
  },

  // 动态创建的picker脚本（只能创一个）
  dynamChange: function (e) {
    var dynamIndex = e.detail.value
    if (dynamIndex == -1) return

    var uid = e.currentTarget.dataset.uid
    var items = this.data.items
    for (var i=0; i<items.length; i++) {
      if (items[i].uid === uid) {
        items[i].error = false
        items[i].value = dynamIndex
      }
    }
    this.setData({ items })
  },

  uploadSubmit: function (e) {
    var that = this
    console.log(e)
    x5on.checkFormEx(this, function () {
      x5on.postFormEx({
        data: e.detail.value,
        url: x5on.url.schoolformvalueupdate,
        success: function (result) {
          var infor_added = true
          var not_added = false
          var form_show = false
          var user_forms = result.data
          that.setData({ form_show, infor_added, not_added, user_forms })
          //
        }
      })
    })
  },

})