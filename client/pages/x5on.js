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

  // 班级分管
  mydivision: `${host}/weapp/mydivision`,
  mydivisionclass: `${host}/weapp/mydivision/classes`,



  // 错误测试地址
  test: `${host}/weapp/data`,
  imageurl: `${host}/weapp/data`,
};

var doData = function (that, data) {
  for (var i in data) {
    that.setData({ [i]: data[i] })
  }
};

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
        if (typeof options.success === 'function') options.success(res);
      },
      fail: err => {
        wx.hideToast()
        if (typeof options.fail === 'function') options.fail(err);
        util.showModel('登录错误', err.message)
      }
    })
  } else {
    qcloud.login({
      success: res => {
        wx.hideToast()
        if (typeof options.success === 'function') options.success(res);
      },
      fail: err => {
        wx.hideToast()
        if (typeof options.fail === 'function') options.fail(err);
        util.showModel('登录错误', err.message)
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

/**
 * 输入检测
 * 页面数据准备：
 *   errorShow: false
 *   errorMessage: '错误提示'
 *   errorArray: [0, 0, 0, 0, 0, 0, 0, 0]，根据检测控件个数来定大小
 * @param {Object} 事件参数
 * @param {Object} 页面对象
 */
var doCheckInput = function (event, that) {
  var reg = event.currentTarget.dataset.reg
  var index = event.currentTarget.dataset.index
  var message = event.currentTarget.dataset.message

  var value = event.detail.value
  var patt = new RegExp(reg, 'g')

  var item = 'errorArray[' + index + ']'
  var error = !patt.test(value)
  that.setData({
    [item]: error
  })
  // 无错退出
  if (!error) return
  // 出错提示
  doShowError(that, message)
};

/**
 * 输入检测
 */
var doCheckInputEx = function (event, that) {
  var uid = event.currentTarget.dataset.uid
  var keys = that.data.items
  for (var i=0; i<keys.length; i++) {
    var key = keys[i]
    if (key.uid === uid) {
      // 检测
      var value = event.detail.value
      var patt = new RegExp(key.regex_js)
      key.value = value
      key.error = key.required && !patt.test(value)
      // 更新
      keys[i] = key
      that.setData({ items: keys });
      // 出错
      if (key.error) doShowError(that, key.message)
      break
    }
  }
};

/**
 * 数组方式数据检测
 */
var doCheckInputReg = function (options) {
  var uid = options.event.currentTarget.dataset.uid
  var value = options.event.detail.value
  var patt = new RegExp(options.reg)

  var data = options.data
  data.forEach(function (item) {
    if (item.uid === uid) {
      item.value = value
      item.error = !patt.test(value)
      if (item.error) doShowError(options.that, options.message)
    }
  })
  if (typeof options.success === 'function') options.success(data)
}

var doCheckFormReg = function (that, message, success) {
  var items = that.data.items;
  for (var i = 0; i < items.length; i++) {
    if (items[i].error) {
      doShowError(that, message)
      return
    }
  }
  // 成功回调
  if (typeof success === 'function') success()
}


/**
 * 表单提交
 * 页面数据准备：
 *   errorArray
 * @param {Int} 检测起始位
 * @param {Int} 检测结束位
 */
var doCheckForm = function (that, begin, end, success) {
  var error = false
  for (var i=begin; i<=end; i++) {
    if (that.data.errorArray[i]) {
      error = true
      break;
    }
  }
  if (error) {
    // 出错提示
    doShowError(that, '表单数据有误，请检查')
    return
  }
  // 成功回调
  if (typeof success === 'function') success()
};

/**
 * 表单提交
 */
var doCheckFormEx = function (that, success) {
  var items = that.data.items;
  for (var i=0; i<items.length; i++) {
    if (items[i].error) {
      doShowError(that, items[i].message)
      return
    }
  }
  // 成功回调
  if (typeof success === 'function') success()
};

/**
 * 数据提交
 * @param {String}   请求地址
 * @param {Object}   JSON序列
 * @param {Function} 成功回调
 * @param {Function} 失败回调
 */
var doPostFormEx = function (options) {
  qcloud.request({
    url: options.url,
    data: options.data,
    method: 'POST',
    header: { 'content-type': 'application/x-www-form-urlencoded' },
    login: false,
    success: function (result) {
      // 检测code是否为0，
      var data = result.data
      if (data.code === 0) {
        // 为0，表示请求成功
        if (typeof options.success === 'function') options.success(data)
        return
      } 
      if (data.code === 1) {
        // 不为0给出错误提示
        if (typeof options.fail === 'function') options.fail()
        // 用页面错误提示
        if (options.that) {
          doShowError(options.that, data.data)
        } else {
          util.showModel('请求失败', data.data);
        }
        return
      }
      util.showModel('请求出错', result);
    },
    fail: function (error) {
      if (typeof options.fail === 'function') options.fail()
      util.showModel('请求失败', error.message);
    }
  })
};


// 对外接口
module.exports = {
  url: doUrl,
  data: doData,
  login: doLogin,
  check: doCheck,
  request: doRequest,
  loadimage: doRequestImage,
  checkInput: doCheckInput,
  checkInputEx: doCheckInputEx,
  checkInputReg: doCheckInputReg,
  checkForm: doCheckForm,
  checkFormEx: doCheckFormEx,
  checkFormReg: doCheckFormReg,
  postForm: doPostFormEx,
  postFormEx: doPostFormEx,
  showError: doShowError,
  showSuccess: doSuccess,
}
