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

  // 错误测试地址
  test: `${host}/weapp/data`
};

var doCheck = function (options) {
  qcloud.request({
    url: doUrl.user,
    login: true,
    success: function (result) {
      // 请求成功
      if (typeof options.success === 'function') options.success(result.data)
    },
    fail: function (error) {
      if (typeof options.fail === 'function') options.fail()
      util.showModel('请求失败', error.message);
    }
  })
};

var doRequest = function (options) {
  qcloud.request({
    url: options.url,
    login: false,
    success: function (result) {
      // 请求成功
      if (typeof options.success === 'function') options.success(result.data)
    },
    fail: function (error) {
      if (typeof options.fail === 'function') options.fail()
      util.showModel('请求失败', error.message);
    }
  })
};

var doLogin = function (options) {
  util.showBusy('正在登录')
  const session = qcloud.Session.get()
  if (session) {
    qcloud.loginWithCode({
      success: res => {
        if (typeof options.success === 'function') options.success();
      },
      fail: err => {
        if (typeof options.fail === 'function') options.fail();
        util.showModel('登录错误', err.message)
      }
    })
  } else {
    qcloud.login({
      success: res => {
        if (typeof options.success === 'function') options.success();
      },
      fail: err => {
        if (typeof options.fail === 'function') options.fail();
        util.showModel('登录错误', err.message)
      }
    })
  }
};



/**
 * 数据查询（还有些问题）
 * @param {Object} options 登录配置
 * @param {string} options.url 请求地址
 * @param {string} options.error 错误提示
 * @param {Function} options.success(result) 登录成功后的回调函数
 */
var doRequestEx = function (options) {
  // 提取session-skey
  var sessionkey = session.get();
  var skey = sessionkey ? sessionkey.skey : null;
  if ( ! skey ) {
    if (typeof options.fail === 'function') options.fail()    
    if (options.showError) util.showModel('数据查询', '请求数据出错，检查是否登录过期！')
    // 退出
    return
  }
  wx.request({
    url: options.url,
    header: { 'x-wx-skey': skey },
    success: function (res) {
      // 错误检测
      var data = res.data;
      if (data && data.code === -1) {
        if (typeof options.fail === 'function') options.fail()        
        if (options.showError) util.showModel('数据查询', data.data)
        // 退出
        return
      }
      // 没错误
      if (typeof options.success === 'function') options.success(data)
    },
    fail: function (error) {
      if (typeof options.fail === 'function') options.fail()
      var message = options.error || error.message
      if (options.showError) util.showModel('数据查询', message)      
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
var doPostForm = function (options) {
  // 提取session-skey
  var sessionkey = session.get();
  var skey = sessionkey ? sessionkey.skey : null;
  if ( ! skey ) {
    if (typeof options.fail === 'function') options.fail()
    util.showModel('数据提交', '请求数据出错，检查是否登录过期！')
    // 退出
    return
  }
  wx.request({
    url: options.url,
    data: options.data,
    method: 'POST',
    header: {
      'content-type': 'application/x-www-form-urlencoded',
      'x-wx-skey': skey
    },
    success: function (res) {
      // 错误检测
      var data = res.data;
      if (data && data.code === -1) {
        if (typeof options.fail === 'function') options.fail()
        util.showModel('数据提交', data.data)
        // 退出
        return
      }
      // 没错误
      if (typeof options.success === 'function') options.success(data)
    },
    fail: function (error) {
      if (typeof options.fail === 'function') options.fail()
      var message = options.error || error.message
      util.showModel('数据提交', message)
    }
  })  
};

// 对外接口
module.exports = {
  url: doUrl,
  login: doLogin,
  check: doCheck,
  request: doRequest,
  checkInput: doCheckInput,
  checkInputEx: doCheckInputEx,
  checkForm: doCheckForm,
  checkFormEx: doCheckFormEx,
  postForm: doPostForm,
  showError: doShowError,
  showSuccess: doSuccess,
}
