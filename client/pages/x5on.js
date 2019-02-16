var qcloud = require('../vendor/wafer2-client-sdk/index')
var config = require('../config')
var util = require('../utils/util.js')
var session = require('../vendor/wafer2-client-sdk/lib/session.js')

/**
 * 请求列表
 * @param {String} 服务地址列表
 */
var host = config.service.host;
var doUrl = {
  host,

  // 登录地址
  login: `${host}/weapp/login`,
  // 权限地址
  role: `${host}/weapp/role`,

  // 编码地址
  schcode: `${host}/weapp/schcode`,

  // 表单
  appform: `${host}/weapp/appform`,
  appformkey: `${host}/weapp/appformkey`,
  appformkeyupdate: `${host}/weapp/appformkey/update`,

  // 教师注册
  tchreg: `${host}/weapp/tchreg`,
  tchregusersch: `${host}/weapp/tchreg/usersch`,
  tchreguserreg: `${host}/weapp/tchreg/usereg`,

  // 权限设置
  roleset: `${host}/weapp/roleset`,
  rolesetupdate: `${host}/weapp/roleset/update`,

  // 权限分组
  rolegroup: `${host}/weapp/rolegroup`,
  rolegrouprole: `${host}/weapp/rolegroup/role`,
  rolegroupupdate: `${host}/weapp/rolegroup/update`,

  // 权限分配
  roledist: `${host}/weapp/roledist`,
  roledistgroup: `${host}/weapp/roledist/group`,
  roledistupdate: `${host}/weapp/roledist/update`,
  roledistgroupuser: `${host}/weapp/roledist/groupuser`,
  roledistdeleteuser: `${host}/weapp/roledist/deleteuser`,

  // 用户检测
  user: `${host}/weapp/user`,
  userreg: `${host}/weapp/user/reg`,
  // 用户设置
  userset: `${host}/weapp/userset`,
  usersetupdate: `${host}/weapp/userset/update`,

  // 用户孩子
  userchild: `${host}/weapp/userchild`,
  userchildupdate: `${host}/weapp/child/update`,

  // 称谓
  relation: `${host}/weapp/relation`,
  // 亲子关系
  parentchilds: `${host}/weapp/parentchilds`,

  // 报名
  regstudreg: `${host}/weapp/studreg/regstud`,
  regstudcheck: `${host}/weapp/studreg/regcheck`,
  regstudcancel: `${host}/weapp/studreg/regcancel`,

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
var doGetIndex = function (arrs, id) {
  for (var i = 0; i < arrs.length; i++) {
    var arr = arrs[i]
    if (arr.id === id) return i
  }
}

// 根据索引获取编号
var doGetId = function (arrs, index) {
  return arrs.length > index ? arrs[index].id : null
}

// 数组单项选择
var doGetRadio = function (arrs, success, fail) {
  var find = null
  for (let arr of arrs) {
    if (arr.checked) {
      find = arr; break
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
var doSetRadio = function (arrs, uid, success) {
  for (let arr of arrs) {
    arr.checked = arr.uid === uid
  }
  typeof success === 'function' && success(arrs)
}

// 数组多项设置
var doSetCheckbox = function (arrs, uids, success) {
  for (let arr of arrs) {
    var checked = false
    for (let uid of uids) {
      if (arr.uid === uid) { checked = true; break }
    }
    arr.checked = checked
  }
  typeof success === 'function' && success(arrs)
}

var doPickChange = function (pick, success) {
  var value = pick.detail.value
  value > -1 && typeof success === 'function' && success(value)
}

/**
 * 关于错误代码
 * -1    ：   系统级出错代码，与登录有关，由系统检测
 *  0    ：   数据请求成功
 *  1    ：   应用级出错代码，逻辑错误代码
 *  X    ：   ...
 */
var doRequestEx = function (options) {
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
      wx.hideToast()
      typeof options.fail === 'function' && options.fail(error)
      options.donshow ? void (0) : util.showModel('请求失败', error)
    }
  })
};

var doPostFormEx = function (options) {
  util.showBusy('正在请求...')
  qcloud.request({
    url: options.url,
    data: options.data,
    method: 'POST',
    header: { 'content-type': 'application/x-www-form-urlencoded' },
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

var doRequestImage = function (options) {
  qcloud.request({
    url: options.url,
    login: false,
    success(result) {
      var data = result.data
      if (typeof options.success === 'function') options.success(data)
    },
    fail(error) {
      if (typeof options.fail === 'function') options.fail(error)
      util.showModel('请求失败', '确认网络是否畅通');
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
  getIndex: doGetIndex,
  getRadio: doGetRadio,
  getCheckbox: doGetCheckbox,
  setRadio: doSetRadio,
  setCheckbox: doSetCheckbox,
  pickChange: doPickChange,
  request: doRequestEx,
  requestEx: doRequestEx,

  loadimage: doRequestImage,
  postForm: doPostFormEx,
  postFormEx: doPostFormEx,
  showError: doShowError,
  showSuccess: doSuccess,
}
