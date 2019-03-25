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

  // 权限设置
  roleset: `${host}/weapp/roleset`,
  rolesetupdate: `${host}/weapp/roleset/update`,

  // 分组权限
  rolegroup: `${host}/weapp/rolegroup`,
  rolegrouprole: `${host}/weapp/rolegroup/role`,
  rolegroupupdate: `${host}/weapp/rolegroup/update`,

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
  usertch: `${host}/weapp/usertch`,
  usertchuser: `${host}/weapp/usertch/user`,
  usertchgroup: `${host}/weapp/usertch/group`,
  usertchadd: `${host}/weapp/usertch/add`,
  usertchdel: `${host}/weapp/usertch/del`,
  usertchmember: `${host}/weapp/usertch/member`,
  usertchmemfind: `${host}/weapp/usertch/memfind`,

  // 教师权限分配
  userdist: `${host}/weapp/userdist`,
  userdistuser: `${host}/weapp/userdist/user`,
  userdistgroup: `${host}/weapp/userdist/group`,
  userdistadd: `${host}/weapp/userdist/add`,
  userdistdel: `${host}/weapp/userdist/del`,
  userdistmember: `${host}/weapp/userdist/member`,
  userdistmemfind: `${host}/weapp/userdist/memfind`,

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
  schdistmemfind: `${host}/weapp/schdist/memfind`,

  // 报名
  regstud: `${host}/weapp/studreg`,
  regstudstep: `${host}/weapp/studreg/step`,
  regstudreg: `${host}/weapp/studreg/reg`,
  regstudcheck: `${host}/weapp/studreg/check`,
  regstudcancel: `${host}/weapp/studreg/cancel`,
  regstudstudenroll: `${host}/weapp/studreg/studenroll`,







  // 审核
  studexam: `${host}/weapp/studexam`,
  studexampass: `${host}/weapp/studexam/pass`,
  studexamcancel: `${host}/weapp/studexam/cancel`,
  studconfirm: `${host}/weapp/studconfirm`,
  studconfirmpass: `${host}/weapp/studconfirm/pass`,
  studconfirmcancel: `${host}/weapp/studconfirm/cancel`,

  // 学校表格
  schoolformkey: `${host}/weapp/schoolformkey`,
  schoolformvalueupdate: `${host}/weapp/schoolformvalue/update`,


  // 编码地址
  schcode: `${host}/weapp/schcode`,

  // 表单
  appform: `${host}/weapp/appform`,
  appformkey: `${host}/weapp/appformkey`,
  appformkeyupdate: `${host}/weapp/appformkey/update`,



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


  // 班级分管
  mydivision: `${host}/weapp/mydivision`,
  mydivisionclass: `${host}/weapp/mydivision/classes`,
  mydivisionteachs: `${host}/weapp/mydivision/teachs`,
  mydivisionupdate: `${host}/weapp/mydivision/update`,
  mydivisionedclass: `${host}/weapp/mydivision/classed`,
  mydivisionedremove: `${host}/weapp/mydivision/remove`,

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
  mydivisionset: `${host}/weapp/mydivisionset`,
  mydivisionsetdata: `${host}/weapp/mydivisionset/data`,
  mydivisionsetupdate: `${host}/weapp/mydivisionset/update`,

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
// 删除数组元素
var doDelValue = function (arrs, obj_name, obj_value) {
  var index = doGetIndexe(arrs, obj_name, obj_value)
  arrs.splice(index, 1)
  return arrs;
}
// 变更数组索引obj_value的对象，sets字段的值
var doSetValues = function (arrs, obj_name, obj_value, obj_sets) {
  var index = doGetIndexe(arrs, obj_name, obj_value)
  for (var key in obj_sets) {
    arrs[index].hasOwnProperty(key) && (arrs[index][key] = obj_sets[key])
  }
  return arrs
}

// 数组单项选择
var doGetRadio = function (arrs, success, fail) {
  var find = null
  for (let arr of arrs) {
    if (arr.checked) {
      find = arr;
      break
    }
  }
  find && typeof success === 'function' && success(find)
  !find && typeof fail === 'function' && fail()
}

// 数组多项选择
var doGetCheckbox = function (arrs, success, fail) {
  var res = []
  for (let arr of arrs) {
    arr.checked ? res.push(arr) : void (0)
  }
  res.length > 0 ? typeof success === 'function' && success(res) : typeof fail === 'function' && fail()
}

// 数组单项设置
var doSetRadio = function (arrs, e_detail_value, success) {
  for (let arr of arrs) {
    arr.checked = arr.uid === e_detail_value
  }
  typeof success === 'function' && success(arrs)
}

// 数组多项设置
var doSetCheckbox = function (arrs, uids, success) {
  for (let arr of arrs) {
    var checked = false
    for (let uid of uids) {
      if (arr.uid === uid) {
        checked = true;
        break
      }
    }
    arr.checked = checked
  }
  typeof success === 'function' && success(arrs)
}

// pick成功后返回相应的值
var doSetPick = function (e, success) {
  var value = e.detail.value
  value > -1 && typeof success === 'function' && success(value)
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
      options.donshow ? void (0) : util.showModel('查询失败', error)
    }
  })
};

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
      options.donshow ? void (0) : util.showModel('请求失败', error)
    }
  })
};

// 权限检测
var doAuth = function (authString, success, fail) {
  wx.getSetting({
    success(res) {
      var auth = !!res.authSetting[authString]
      !auth && typeof fail === 'function' && fail()
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

// 对外接口
module.exports = {
  url: doUrl,
  data: doData,
  auth: doAuth,
  login: doLogin,
  check: doCheck,

  getId: doGetId,
  getUid: doGetUid,
  getValue: doGetValue,
  getIndex: doGetIndex,
  getRadio: doGetRadio,
  getCheckbox: doGetCheckbox,
  setRadio: doSetRadio,
  setCheckbox: doSetCheckbox,
  setPick: doSetPick,

  delValue: doDelValue,
  setValues: doSetValues,

  request: doRequest,
  post: doPost,
  showError: doShowError,
  showSuccess: doSuccess,

  checkForm: x5va.checkForm,
}