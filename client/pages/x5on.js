var qcloud = require('../vendor/wafer2-client-sdk/index')
var config = require('../config')
var util = require('../utils/util.js')
var session = require('../vendor/wafer2-client-sdk/lib/session.js')
var x5va = require('./x5valid.js')

/**
 * 请求列表
 * @param {String} 服务地址列表
 */
var host = config.service.host;
var doUrl = {
  host,

  // 登录地址
  login: `${host}/weapp/login`,

  // 用户注册无检测
  user: `${host}/weapp/user`,
  userreg: `${host}/weapp/user/reg`,

  // 用户设置有检测
  userset: `${host}/weapp/userset`,
  usersetrole: `${host}/weapp/userset/role`,
  usersetupdate: `${host}/weapp/userset/update`,
  usersetchange: `${host}/weapp/userset/change`,

  // 用户孩子
  userchilds: `${host}/weapp/userchilds`,
  userchildsreg: `${host}/weapp/userchilds/reg`,
  userchildsrelation: `${host}/weapp/userchilds/relation`,
  userchildstudent: `${host}/weapp/userchilds/student`,

  // 用户重置
  usereset: `${host}/weapp/usereset`,
  useresetupdate: `${host}/weapp/usereset/update`,

  // 教师注册
  usersch: `${host}/weapp/usersch`,
  userschuser: `${host}/weapp/usersch/user`,
  userschreg: `${host}/weapp/usersch/reg`,
  userschdel: `${host}/weapp/usersch/del`,
  userschmember: `${host}/weapp/usersch/member`,
  userschmemfind: `${host}/weapp/usersch/memfind`,

  // 教师权限分配
  userdist: `${host}/weapp/userdist`,
  userdistuser: `${host}/weapp/userdist/user`,
  userdistgroup: `${host}/weapp/userdist/group`,
  userdistadd: `${host}/weapp/userdist/add`,
  userdistdel: `${host}/weapp/userdist/del`,
  userdistmember: `${host}/weapp/userdist/member`,
  userdistmemfind: `${host}/weapp/userdist/memfind`,
  // 教师权限预览
  userview: `${host}/weapp/userview`,
  userviewupdate: `${host}/weapp/userview/update`,

  // 地区分配
  areadist: `${host}/weapp/areadist`,
  areadistadd: `${host}/weapp/areadist/add`,
  areadistuser: `${host}/weapp/areadist/user`,
  areadistdist: `${host}/weapp/areadist/dist`,
  areadistdel: `${host}/weapp/areadist/del`,
  areadistmemfind: `${host}/weapp/areadist/memfind`,

  // 集团分配
  schsdist: `${host}/weapp/schsdist`,
  schsdistadd: `${host}/weapp/schsdist/add`,
  schsdistuser: `${host}/weapp/schsdist/user`,
  schsdistdist: `${host}/weapp/schsdist/dist`,
  schsdistschs: `${host}/weapp/schsdist/schs`,
  schsdistdel: `${host}/weapp/schsdist/del`,
  schsdistmemfind: `${host}/weapp/schsdist/memfind`,

  // 学校注册
  schdist: `${host}/weapp/schdist`,
  schdistadd: `${host}/weapp/schdist/add`,
  schdistedutype: `${host}/weapp/schdist/edutype`,
  schdistuser: `${host}/weapp/schdist/user`,
  schdistdist: `${host}/weapp/schdist/dist`,
  schdistsch: `${host}/weapp/schdist/sch`,
  schdistdel: `${host}/weapp/schdist/del`,

  // 报名
  regstud: `${host}/weapp/studreg`,
  regstudstep: `${host}/weapp/studreg/step`,
  regstudreg: `${host}/weapp/studreg/reg`,
  regstudcheck: `${host}/weapp/studreg/check`,
  regstudcancel: `${host}/weapp/studreg/cancel`,
  regstudstudenroll: `${host}/weapp/studreg/studenroll`,

  // 班级分管
  mydivi: `${host}/weapp/mydivi`,
  mydiviclsdiv: `${host}/weapp/mydivi/clsdiv`,
  mydiviteachs: `${host}/weapp/mydivi/teachs`,
  mydividist: `${host}/weapp/mydivi/dist`,
  mydiviremove: `${host}/weapp/mydivi/remove`,

  // 权限设置
  roleset: `${host}/weapp/roleset`,
  rolesetupdate: `${host}/weapp/roleset/update`,

  // 分组权限
  rolegroup: `${host}/weapp/rolegroup`,
  rolegrouprole: `${host}/weapp/rolegroup/role`,
  rolegroupupdate: `${host}/weapp/rolegroup/update`,




  // 分类设置
  typeset: `${host}/weapp/typeset`,
  typesetadd: `${host}/weapp/typeset/add`,
  typesetdel: `${host}/weapp/typeset/del`,
  // 学科设置
  subset: `${host}/weapp/subset`,
  subsetadd: `${host}/weapp/subset/add`,
  subsetdel: `${host}/weapp/subset/del`,
  // 学校年度
  schyear: `${host}/weapp/schyear`,
  schyearadd: `${host}/weapp/schyear/add`,
  schyeardel: `${host}/weapp/schyear/del`,
  // 学校分级
  schstep: `${host}/weapp/schstep`,
  schstepadd: `${host}/weapp/schstep/add`,
  schstepdel: `${host}/weapp/schstep/del`,
  schstepedit: `${host}/weapp/schstep/edit`,
  schstepyear: `${host}/weapp/schstep/year`,







  // 审核
  studexam: `${host}/weapp/studexam`,
  studexampass: `${host}/weapp/studexam/pass`,
  studexamcancel: `${host}/weapp/studexam/cancel`,
  studconfirm: `${host}/weapp/studconfirm`,
  studconfirmpass: `${host}/weapp/studconfirm/pass`,
  studconfirmcancel: `${host}/weapp/studconfirm/cancel`,



  // 同班设置
  mysameset: `${host}/weapp/mysameset`,
  mysamesetclass: `${host}/weapp/mysameset/classes`,
  mysamesetstudent: `${host}/weapp/mysameset/students`,
  mysamesetstudentupdate: `${host}/weapp/mysameset/update`,

  // 班号变更
  myrename: `${host}/weapp/myrename`,
  myrenameclass: `${host}/weapp/myrename/classes`,
  myrenameupdate: `${host}/weapp/myrename/update`,

  // 分班微调
  mytuning: `${host}/weapp/mytuning`,
  mytuningclass: `${host}/weapp/mytuning/classes`,
  mytuningstudmoves: `${host}/weapp/mytuning/studmoves`,
  mytuningstudchanges: `${host}/weapp/mytuning/studchanges`,
  mytuningexchange: `${host}/weapp/mytuning/exchange`,
  mytuninglocal: `${host}/weapp/mytuning/local`,



  // 分班调整
  myadjust: `${host}/weapp/myadjust`,
  myadjustclass: `${host}/weapp/myadjust/classes`,
  myadjuststudent: `${host}/weapp/myadjust/student`,
  myadjuststudmove: `${host}/weapp/myadjust/studmove`,
  myadjuststudremove: `${host}/weapp/myadjust/studremove`,
  // 识别调动学生，并返回交换学生
  myadjuststudscanmove: `${host}/weapp/myadjust/scanmove`,
  // 扫二维码调动
  myadjuststudexchange: `${host}/weapp/myadjust/studexchange`,
  // 自主调动
  myadjuststudexchangeself: `${host}/weapp/myadjust/studexchangeself`,
  // 添加交换学生记录
  myadjustaddexchange: `${host}/weapp/myadjust/addexchange`,
  // 显示查询交换学生信息
  myadjustqueryexchange: `${host}/weapp/myadjust/queryexchange`,
  // 交换学生列表
  myadjustexchangelist: `${host}/weapp/myadjust/exchangelist`,
  myadjustremoveliststud: `${host}/weapp/myadjust/removeliststud`,

  myadjuststudlocal: `${host}/weapp/myadjust/studlocal`,
  myadjustclassmove: `${host}/weapp/myadjust/classmove`,
  myadjustclassmoved: `${host}/weapp/myadjust/classmoved`,
  myadjustclassmoving: `${host}/weapp/myadjust/classmoving`,
  myadjustmovingqrcode: `${host}/weapp/myadjust/movingqrcode`,

  // 调动设置
  mydiviset: `${host}/weapp/mydiviset`,
  mydivisetdata: `${host}/weapp/mydiviset/data`,
  mydivisetupdate: `${host}/weapp/mydiviset/update`,

  // 学生学籍
  gradestud: `${host}/weapp/gradestud`,
  gradestudgrade: `${host}/weapp/gradestud/grade`,
  gradestudclass: `${host}/weapp/gradestud/classes`,
  gradestudcls: `${host}/weapp/gradestud/studcls`,
  gradestuduid: `${host}/weapp/gradestud/uid`,
  gradestudquery: `${host}/weapp/gradestud/query`,
  gradestudadd: `${host}/weapp/gradestud/add`,
  gradestudtype: `${host}/weapp/gradestud/type`,
  gradestudstatus: `${host}/weapp/gradestud/status`,
  gradestudmove: `${host}/weapp/gradestud/move`,
  gradestudmodi: `${host}/weapp/gradestud/modi`,
  gradestudauth: `${host}/weapp/gradestud/auth`,
  gradestudcome: `${host}/weapp/gradestud/come`,
  gradestudrepet: `${host}/weapp/gradestud/repet`,
  gradestudread: `${host}/weapp/gradestud/read`,
  gradestuddown: `${host}/weapp/gradestud/down`,
  gradestudtask: `${host}/weapp/gradestud/task`,
  gradestudgradesdown: `${host}/weapp/gradestud/gradesdown`,
  gradestudreturns: `${host}/weapp/gradestud/returns`,
  gradestudback: `${host}/weapp/gradestud/back`,
  gradestudtemp: `${host}/weapp/gradestud/temp`,


  // 错误测试地址
  test: `${host}/weapp/youtu`,
  imageurl: `${host}/weapp/data`,
};

// 数据常量
var doData = {
  status_normal: 1,
  status_return: 2,
  status_come: 3,
  status_read: 4,
  status_repetition: 5,
  status_down: 21,
  status_out: 22,
  status_leave: 23,
  status_temp: 99,
}

// 数据对象添加
var doAdd = function (arrs, arr, sort_field) {
  arrs.push(arr)
  return doSort(arrs, sort_field)
}
// 数据对象排序
var doSort = function (arrs, sort_field) {
  arrs.sort(function (a, b) {
    if (a[sort_field]<b[sort_field]) {
      return -1
    } else {
      return 1
    }
  })
  return arrs
}

// 根据编号获取索引值
var doGetIndex = function (arrs, id_value) {
  return doGetIndexe(arrs, 'id', id_value)
}
var doGetIndexe = function (arrs, obj_name, obj_value) {
  for (var i = 0; i < arrs.length; i++) {
    var arr = arrs[i]
    if (arr[obj_name] === obj_value) return i
  }
}
// 根据索引获取编号
var doGetId = function (arrs, index) {
  return doGetValue(arrs, index, 'id')
}
var doGetUid = function (arrs, index) {
  return doGetValue(arrs, index, 'uid')
}
var doGetValue = function (arrs, index, obj_name) {
  return arrs.length > index ? arrs[index][obj_name] : null
}
var doGetArr = function (arrs, index) {
  return arrs.length > index ? arrs[index] : null
}
var doGetArrex = function (arrs, obj_name, obj_value) {
  for (var i = 0; i < arrs.length; i++) {
    var arr = arrs[i]
    if (arr[obj_name] === obj_value) return arr
  }
  return null
}
// 删除数组元素
var doDelArr = function (arrs, obj_name, obj_value) {
  var index = doGetIndexe(arrs, obj_name, obj_value)
  arrs.splice(index, 1)
  return arrs;
}
// 变更数组索引obj_value的对象，sets字段的值
var doSetArr = function (arrs, obj_name, obj_value, obj_sets) {
  var index = doGetIndexe(arrs, obj_name, obj_value)
  for (var key in obj_sets) {
    arrs[index].hasOwnProperty(key) && (arrs[index][key] = obj_sets[key])
  }
  return arrs
}

// 数组单项选择
var doGetRadio = function (arrs, success, fail) {
  doGetRadioex(arrs, 'checked', success, fail)
}

// 数组单项选择
var doGetRadioex = function (arrs, checked_obj_name, success, fail) {
  var find = null
  for (let arr of arrs) {
    if (arr[checked_obj_name]) {
      find = arr;
      break
    }
  }
  find && typeof success === 'function' && success(find);
  !find && typeof fail === 'function' && fail()
}

// 数组多项选择
var doGetCheckbox = function (arrs, success, fail) {
  doGetCheckboxex(arrs, 'checked', success, fail)
}
var doGetCheckboxex = function (arrs, obj_name, success, fail) {
  var res = []
  for (let arr of arrs) {
    arr[obj_name] ? res.push(arr) : void(0)
  }
  res.length > 0 && typeof success === 'function' && success(res)
  res.length == 0 && typeof fail === 'function' && fail()
}

// pick成功后返回相应的值
var doSetPick = function (e, success) {
  var value = e.detail.value
  value > -1 && typeof success === 'function' && success(value)
}

// 数组单项设置
var doSetRadio = function (arrs, e_detail_value, success) {
  for (let arr of arrs) {
    arr.checked = arr.uid === e_detail_value
  }
  typeof success === 'function' && success(arrs)
}

var doSetRadioex = function (arrs, e_detail_value, checked_obj_name, success) {
  for (let arr of arrs) {
    arr[checked_obj_name] = arr.uid === e_detail_value
  }
  typeof success === 'function' && success(arrs)
}

// 数组多项设置
var doSetCheckbox = function (arrs, e_detail_value_uids, success) {
  doSetCheckboxex(arrs, e_detail_value_uids, 'checked', success)
}
var doSetCheckboxex = function (arrs, e_detail_value_uids, checked_obj_name, success) {
  for (let arr of arrs) {
    var checked = false
    for (let uid of e_detail_value_uids) {
      if (arr.uid === uid) {
        checked = true; break
      }
    }
    arr[checked_obj_name] = checked
  }
  typeof success === 'function' && success(arrs)
}

var doMessage = function (fields) {
  var res = {}
  for (let field of fields) {
    if (field.mode === 1 || field.mode === 3) {
      var value = {}
      value.required = field.label
      res[field.name] = value
    }
  }
  return res
}

/**
 * 关于错误代码
 * -1    ：   系统级出错代码，与登录有关，由系统检测
 *  0    ：   数据请求成功
 *  1    ：   应用级出错代码，逻辑错误代码
 *  X    ：   ...
 */
var doRequest = function (options) {
  util.showBusy('正在查询...')
  qcloud.request({
    url: options.url,
    success(result) {
      wx.hideToast()
      var res = result.data
      res.code === 0 && typeof options.success === 'function' && options.success(res.data)
      res.code === 1 && typeof options.fail === 'function' && options.fail(res.data)
      if (options.donshow) return

      res.code === 1 && util.showModel('查询出错', res.data)
    },
    fail(error) {
      // error为文字提示
      wx.hideToast()
      typeof options.fail === 'function' && options.fail(error)
      options.donshow ? void(0) : util.showModel('查询失败', error)
    }
  })
};

var poPost = function (url, data, donshow) {
  return new Promise((reject, resolve) => {
    util.showBusy('正在请求...')
    qcloud.request({
      url: url,
      data: data,
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success(result) {
        wx.hideToast()
        var res = result.data
        res.code === 0 && reject(res.data)
        res.code === 1 && resolve(res.data)
        if (donshow) return
        res.code === 1 && util.showModel('请求出错', res.data)
      },
      fail(error) {
        wx.hideToast()
        resolve(error)
        if (donshow) return
        util.showModel('请求失败', error)
      }
    })
  })
}

var doPost = function (options) {
  util.showBusy('正在请求...')
  qcloud.request({
    url: options.url,
    data: options.data,
    method: 'POST',
    header: {
      'content-type': 'application/x-www-form-urlencoded'
    },
    success(result) {
      wx.hideToast()
      var res = result.data
      res.code === 0 && typeof options.success === 'function' && options.success(res.data)
      res.code === 1 && typeof options.fail === 'function' && options.fail(res.data)
      if (options.donshow) return

      res.code === 1 && util.showModel('请求出错', res.data)
    },
    fail(error) {
      wx.hideToast()
      typeof options.fail === 'function' && options.fail(error)
      options.donshow ? void(0) : util.showModel('请求失败', error)
    }
  })
};

// 权限检测
var doAuth = function (authString, success, fail) {
  wx.getSetting({
    success(res) {
      var auth = !!res.authSetting[authString];
      !auth && typeof fail === 'function' && fail();
      auth && typeof success === 'function' && success()
    }
  })
}

// 授权登录检测
var doCheck = function (options) {
  // 查看是否授权
  doAuth('scope.userInfo', () => {
    // 检测是否过期
    wx.checkSession({
      success() {
        typeof options.success === 'function' && options.success()
      },
      fail(error) {
        util.showBusy('正在登录...')
        // 过期，自动登录
        qcloud.loginWithCode({
          success(res) {
            wx.hideToast()
            typeof options.success === 'function' && options.success()
          },
          fail(err) {
            wx.hideToast()
            typeof options.fail === 'function' && options.fail()
          }
        })
      },
    });
  }, () => {
    typeof options.fail === 'function' && options.fail()
  })
};


var doLogin = function (options) {
  util.showBusy('正在登录...')
  qcloud.login({
    auth: options.auth,
    success(res) {
      wx.hideToast()
      typeof options.success === 'function' && options.success(res)
    },
    fail(err) {
      wx.hideToast()
      typeof options.fail === 'function' && options.fail()
      util.showModel('登录错误', '状态异常，请稍后重试')
    }
  })
};

var poLogin = function (e_detail, donshow) {
  return new Promise((resolve, reject) => {
    !donshow && util.showBusy('正在登录...')
    qcloud.login({
      auth: e_detail,
      success(res) {
        !donshow && wx.hideToast()
        resolve(res)
      },
      fail(err) {
        !donshow && wx.hideToast()
        reject(err)
      }
    })
  })
}
var poRequest = function (url, donshow) {
  return new Promise((resolve, reject) => {
    util.showBusy('正在查询...')
    qcloud.request({
      url: url,
      success(result) {
        wx.hideToast()
        var res = result.data
        if (res.code === 0) {
          resolve(res.data)
        } else {
          var error = res.data ? res.data : '请确认查询地址是否有误'
          reject(error)
          if (donshow) return
          util.showModel('查询出错', error)
        }
      },
      fail(error) {
        wx.hideToast()
        reject(error)
        if (donshow) return
        error && util.showModel('查询失败', error)
      }
    })
  })
}
var poPost = function (url, data, donshow) {
  return new Promise((resolve, reject) => {
    util.showBusy('正在提交...')
    qcloud.request({
      url: url,
      data: data,
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success(result) {
        wx.hideToast()
        var res = result.data
        if (res.code === 0) {
          resolve(res.data)
        } else {
          var error = res.data ? res.data : '请确认提交地址是否有误'
          reject(error)
          if (donshow) return
          util.showModel('提交出错', error)
        }
      },
      fail(error) {
        wx.hideToast()
        reject(error)
        if (donshow) return
        error && util.showModel('提交失败', error)
      }
    })
  })
}

/**
 * 错误显示
 */
var doShowError = function (that, message) {
  // 有错显示
  that.setData({
    errorShow: true,
    errorMessage: message
  })
  setTimeout(function () {
    that.setData({
      errorShow: false,
      errorMessage: '错误提示'
    });
  }, 3000);
};

/**
 * 成功提示
 */
var doSuccess = function (message) {
  util.showSuccess(message);
};

var doPrevPage = function (success) {
  var pages = getCurrentPages();
  var prevPage = pages[pages.length - 2];
  success(prevPage)
}

// 对外接口
module.exports = {
  url: doUrl,
  data: doData,

  auth: doAuth,
  login: doLogin,
  check: doCheck,
  request: doRequest,
  post: doPost,
  showError: doShowError,
  showSuccess: doSuccess,

  plogin: poLogin,
  prequest: poRequest,
  ppost: poPost,

  add: doAdd,
  sort: doSort,

  getId: doGetId,
  getUid: doGetUid,
  getValue: doGetValue,
  getArr: doGetArr,
  getArrex: doGetArrex,
  getIndex: doGetIndex,
  getRadio: doGetRadio,
  getRadioex: doGetRadioex,
  getCheckbox: doGetCheckbox,
  getCheckboxex: doGetCheckboxex,
  setRadio: doSetRadio,
  setRadioex: doSetRadioex,
  setCheckbox: doSetCheckbox,
  setCheckboxex: doSetCheckboxex,
  setPick: doSetPick,
  setArr: doSetArr,
  delArr: doDelArr,

  message: doMessage,
  checkForm: x5va.checkForm,
  prevPage: doPrevPage,
}