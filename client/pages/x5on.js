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
  // 登录检测
  user: `${host}/weapp/user`,
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
  tchsch: `${host}/weapp/tchreg/usersch`,
  tchschreg: `${host}/weapp/tchreg/usereg`,

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



  // 错误测试地址
  test: `${host}/weapp/youtu`,
  imageurl: `${host}/weapp/data`,
};

var doData = function (that, data) {
  for (var i in data) {
    that.setData({ [i]: data[i] })
  }
};

// 获取索引值
var doGetIndex = function (arrs, id) {
  for (var i=0; i<arrs.length; i++) {
    var arr = arr[i]
    if (arr.id === id) return i
  }
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
    arr.checked ? res.push(arr) : void(0)
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

var doCheck = function (options) {
  const session = qcloud.Session.get()
  if (session) {
    // 查看是否授权
    wx.getSetting({
      success: function (res) {
        if (res.authSetting['scope.userInfo']) {
          // 检查登录是否过期
          wx.checkSession({
            success: function () {
              // 执行回调，返回用户信息
              if (typeof options.success === 'function') options.success(session.userinfo);
            },
            fail: function () {
              if (typeof options.fail === 'function') options.fail();
              if (options.dontshow) return
              util.showModel('登录过期', '请转到“登录”页面登录');
            },
          });
        } else {
          if (typeof options.fail === 'function') options.fail();
          if (options.dontshow) return
          util.showModel('授权失败', '请转到“登录”页面授权');
        }
      }
    });
  } else {
    if (typeof options.fail === 'function') options.fail();
    if (options.dontshow) return
    util.showModel('缓存过期', '请转到“登录”页面登录');
  }
};

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
    login: false,
    success: function (result) {
      wx.hideToast()
      // 检测code是否为0，
      var data = result.data
      if ( data.code === 0 ) {
        // 为0，表示请求成功
        if (typeof options.success === 'function') options.success(data)
        return
      } 
      if ( data.code === 1 ) {
        // 不为0给出错误提示
        if (typeof options.fail === 'function') options.fail()
        if (options.dontshow) return
        // 用页面错误提示
        if (options.that) {
          doShowError(options.that, data.data)
        } else {
          util.showModel('加载失败', data.data);
        }
        return
      }
      util.showModel('加载出错', result);
    },
    fail: function (error) {
      wx.hideToast()
      if (typeof options.fail === 'function') options.fail()
      if (options.dontshow) return
      util.showModel('请求失败', '请确认登录是否过期，网络是否畅通');
    }
  })
};

var doRequestEx = function (options) {
  util.showBusy('正在查询...')
  qcloud.request({
    url: options.url,
    success: function (result) {
      wx.hideToast()
      var res = result.data
      res.code === 0 && typeof options.success === 'function' && options.success(res.data)
      res.code === 1 && typeof options.fail === 'function' && options.fail(res.data)
      if (options.donshow) return

      res.code === 1 && util.showModel('查询出错', res.data)
    },
    fail: function (error) {
      wx.hideToast()
      options.donshow ? void(0) : util.showModel('请求失败', '请确认登录是否过期，网络是否畅通')
    }
  })
};

/**
 * 数据提交
 * @param {String}   请求地址
 * @param {Object}   JSON序列
 * @param {Function} 成功回调
 * @param {Function} 失败回调
 */
var doPostFormEx = function (options) {
  util.showBusy('正在请求...')
  qcloud.request({
    url: options.url,
    data: options.data,
    method: 'POST',
    header: { 'content-type': 'application/x-www-form-urlencoded' },
    login: false,
    success: function (result) {
      wx.hideToast()
      var res = result.data
      res.code === 0 && typeof options.success === 'function' && options.success(res.data)
      res.code === 1 && typeof options.fail === 'function' && options.fail(res.data)
      if (options.donshow) return

      res.code === 1 && util.showModel('请求出错', res.data)
    },
    fail: function (error) {
      wx.hideToast()
      options.donshow ? void(0) : util.showModel('请求失败', error.message)
    }
  })
};

var doRequestImage = function (options) {
  qcloud.request({
    url: options.url,
    login: false,
    success: function (result) {
      var data = result.data
      if (typeof options.success === 'function') options.success(data)
    },
    fail: function (error) {
      if (typeof options.fail === 'function') options.fail(error)
      util.showModel('请求失败', '确认网络是否畅通');
    }
  })
};

var doLogin = function (options) {
  util.showBusy('正在登录...')
  const session = qcloud.Session.get()
  if (session) {
    qcloud.loginWithCode({
      success: res => {
        wx.hideToast()
        typeof options.success === 'function' && options.success(res);
      },
      fail: err => {
        wx.hideToast()
        typeof options.fail === 'function' && options.fail(err);
        util.showModel('登录错误', err.errMsg)
      }
    })
  } else {
    qcloud.login({
      success: res => {
        wx.hideToast()
        typeof options.success === 'function' && options.success(res);
      },
      fail: () => {
        wx.hideToast()
        typeof options.fail === 'function' && options.fail();
        util.showModel('登录错误', '拒绝授权，获取微信用户信息失败')
      }
    })
  }
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
  login: doLogin,
  check: doCheck,
  getIndex: doGetIndex,
  getRadio: doGetRadio,
  getCheckbox: doGetCheckbox,
  setRadio: doSetRadio,
  setCheckbox: doSetCheckbox,
  request: doRequest,
  requestEx: doRequestEx,
  loadimage: doRequestImage,
  postForm: doPostFormEx,
  postFormEx: doPostFormEx,
  showError: doShowError,
  showSuccess: doSuccess,
}
