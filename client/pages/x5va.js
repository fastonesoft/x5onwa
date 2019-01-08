/**
 * 表单验证
 * 
 * @param {Object} rules 验证字段的规则
 * @param {Object} messages 验证字段的提示信息
 * 
 */
class x5va {
  constructor(rules = {}, messages = {}) {
    Object.assign(this, {
      data: {},
      rules,
      messages,
    })
    this.__init()
  }

  /**
   * __init
   */
  __init() {
    this.__initMethods()
    this.__initDefaults()
    this.__initData()
  }

  /**
   * 初始化数据
   */
  __initData() {
    this.form = {}
    this.errorList = []
  }

  /**
   * 初始化错误
   */
  __initError() {
    this.errorList = []
  }

  /**
   * 初始化默认提示信息
   */
  __initDefaults() {
    this.defaults = {
      messages: {
        required: '不得为空',
        tel: '请输入11位的手机号码',
        date: '请输入有效的日期，例如：2005-08-15',
        number: '请输入有效的数字',
        digits: '请输入有效的非负整数',
        chinese: '请输入有效的中文字符',
        idcard: '请输入18位的有效身份证',
        idcardrange: this.formatTpl('年龄不在 {0} 到 {1} 之间'),
        equalTo: this.formatTpl('输入值必须和 {0} 相同'),
        contains: this.formatTpl('输入值必须包含 {0}'),
        minlength: this.formatTpl('最少输入 {0} 个字符'),
        maxlength: this.formatTpl('最多输入 {0} 个字符'),
        rangelength: this.formatTpl('字段长度在 {0} 到 {1} 之间的字符'),
        min: this.formatTpl('请输入不小于 {0} 的数值'),
        max: this.formatTpl('请输入不大于 {0} 的数值'),
        range: this.formatTpl('请输入范围在 {0} 到 {1} 之间的数值'),
        custom: '请输入满足条件的有效数据',
      }
    }
  }

  /**
   * 初始化默认验证方法
   */
  __initMethods() {
    const that = this
    that.methods = {
      /**
       * 验证必填元素
       */
      required(value, param) {
        if (!that.depend(param)) {
          return 'dependency-mismatch'
        } else if (typeof value === 'number') {
          value = value.toString()
        } else if (typeof value === 'boolean') {
          return !0
        }
        return value.length > 0
      },
      /**
       * 验证手机格式
       */
      tel(value) {
        return that.optional(value) || /^1[34578]\d{9}$/.test(value)
      },
      /**
       * 验证ISO类型的日期格式
       */
      date(value) {
        return that.optional(value) || that.date(value)
      },
      /**
       * 验证十进制数字
       */
      number(value) {
        return that.optional(value) || /^(?:-?\d+|-?\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test(value)
      },
      /**
       * 验证整数
       */
      digits(value) {
        return that.optional(value) || /^\d+$/.test(value)
      },
      /**
       * 验证中文
       */
      chinese(value) {
        return that.optional(value) || /^[\u4e00-\u9fa5]+$/.test(value)
      },
      /**
       * 验证身份证号码
       */
      idcard(value) {
        return that.optional(value) || that.idcard(value)
      },
      /**
       * 验证身份证号码
       */
      idcardrange(value, param) {
        return that.optional(value) || that.idcardrange(value, param[0], param[1])
      },
      /**
       * 验证两个输入框的内容是否相同
       */
      equalTo(value, param) {
        return that.optional(value) || value === that.data[param]
      },
      /**
       * 验证是否包含某个值
       */
      contains(value, param) {
        return that.optional(value) || value.indexOf(param) >= 0
      },
      /**
       * 验证最小长度
       */
      minlength(value, param) {
        return that.optional(value) || value.length >= param
      },
      /**
       * 验证最大长度
       */
      maxlength(value, param) {
        return that.optional(value) || value.length <= param
      },
      /**
       * 验证一个长度范围[min, max]
       */
      rangelength(value, param) {
        return that.optional(value) || (value.length >= param[0] && value.length <= param[1])
      },
      /**
       * 验证最小值
       */
      min(value, param) {
        return that.optional(value) || value >= param
      },
      /**
       * 验证最大值
       */
      max(value, param) {
        return that.optional(value) || value <= param
      },
      /**
       * 验证一个值范围[min, max]
       */
      range(value, param) {
        return that.optional(value) || (value >= param[0] && value <= param[1])
      },
      /**
       * 自定义正则验证
       */
      custom(value, param) {
        return that.optional(value) || that.custom(value, param)
      }
    }
  }

  /**
   * 添加自定义验证方法
   * @param {String} name 方法名
   * @param {Function} method 函数体，接收两个参数(value, param)，value表示元素的值，param表示参数
   * @param {String} message 提示信息
   */
  addMethod(name, method, message) {
    this.methods[name] = method
    this.defaults.messages[name] = message !== undefined ? message : this.defaults.messages[name]
  }

  /**
   * 判断验证方法是否存在
   */
  isValidMethod(value) {
    let methods = []
    for (let method in this.methods) {
      if (method && typeof this.methods[method] === 'function') {
        methods.push(method)
      }
    }
    return methods.indexOf(value) !== -1
  }

  /**
   * 格式化提示信息模板
   */
  formatTpl(source, params) {
    const that = this
    if (arguments.length === 1) {
      return function () {
        let args = Array.from(arguments)
        args.unshift(source)
        return that.formatTpl.apply(this, args)
      }
    }
    if (params === undefined) {
      return source
    }
    if (arguments.length > 2 && params.constructor !== Array) {
      params = Array.from(arguments).slice(1)
    }
    if (params.constructor !== Array) {
      params = [params]
    }
    params.forEach(function (n, i) {
      source = source.replace(new RegExp("\\{" + i + "\\}", "g"), function () {
        return n
      })
    })
    return source
  }

  /**
   * 判断规则依赖是否存在
   */
  depend(param) {
    switch (typeof param) {
      case 'boolean':
        param = param
        break
      case 'string':
        param = !!param.length
        break
      case 'function':
        param = param()
      default:
        param = !0
    }
    return param
  }

  /**
   * 判断输入值是否为空
   */
  optional(value) {
    return !this.methods.required(value) && 'dependency-mismatch'
  }
  /**
   * 判断日期是否合法20050815
   */
  datechecked(value) {
    let passed = /^\d{8}$/.test(value)
    if (!passed) return false
    // 日期格式
    var y = value.substr(0, 4)
    var m = value.substr(4, 2)
    var d = value.substr(6, 2)
    // 日期检测
    var big = ['01', '03', '05', '07', '08', '10', '12']
    var small = ['04', '06', '09', '11']
    var two = ['02']
    // 月份判断
    if (big.indexOf(m) === -1 && small.indexOf(m) === -1 && two.indexOf(m) === -1) return false
    // 天数判断
    if (big.indexOf(m) > -1 && d > 31) return false
    if (small.indexOf(m) > -1 && d > 30) return false
    // 闰年二月
    if (y % 400 == 0 || y % 4 == 0 && y % 100 != 0) {
      if (two.indexOf(m) > -1 && d > 29) return false
    } else {
      if (two.indexOf(m) > -1 && d > 28) return false
    }
    return true
  }
  /**
   * 日期检测2005-08-15
   */
  date(value) {
    // 日期格式
    let passed = /^\d{4}[\-](0[1-9]|1[012])[\-](0[1-9]|[12][0-9]|3[01])$/.test(value)
    if (!passed) return false
    // 日期判断
    let dat = value.replace(/\-/g, '')

    return this.datechecked(dat)
  }
  /**
   * 判断身份证号是否正确
   */
  idcard(value) {
    // 18位身份证格式
    let passed = /^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/.test(value)
    if (!passed) return false
    // 日期判断
    let dat = value.substr(6, 8)
    if (!this.datechecked(dat)) return false
    // 验证检测
    var verify = value.substr(17, 1)
    var idchar = value.split('')
    var factor = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2]
    var verify_list = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2']
    var total = 0;
    for (var i = 0; i < 17; i++) {
      total += idchar[i] * factor[i];
    }
    var mod = total % 11;
    if (verify !== verify_list[mod]) return false
    // 结果
    return true
  }

  idcardrange(value, min, max) {
    var pass = this.idcard(value)
    if (!pass) return false
    // 日期格式
    var y = value.substr(6, 4)
    var m = value.substr(10, 2)
    var d = value.substr(12, 2)
    // 年龄
    var now = new Date();
    var now_year = now.getFullYear()
    // 出界
    if (now_year - y < min || now_year - y > max) return false
    // 结果
    return true
  }

  custom(value, param) {
    let patt = new RegExp(param, 'g')
    return patt.test(value)
  }

  /**
   * 获取自定义字段的提示信息
   * @param {String} param 字段名
   * @param {Object} rule 规则
   */
  customMessage(param, rule) {
    const params = this.messages[param]
    const isObject = typeof params === 'object'
    if (params && isObject) return params[rule.method]
  }

  /**
   * 获取某个指定字段的提示信息
   * @param {String} param 字段名
   * @param {Object} rule 规则
   */
  defaultMessage(param, rule) {
    var rulename = rule.method
    var message;
    if (rulename === 'required') {
      message = this.customMessage(param, rule) ? this.customMessage(param, rule) + this.defaults.messages[rule.method] : this.defaults.messages[rule.method]
    } else {
      message = this.customMessage(param, rule) || this.defaults.messages[rule.method]
    }

    let type = typeof message

    if (type === 'undefined') {
      message = `Warning: No message defined for ${rule.method}.`
    } else if (type === 'function') {
      message = message.call(this, rule.parameters)
    }

    return message
  }

  /**
   * 缓存错误信息
   * @param {String} param 字段名
   * @param {Object} rule 规则
   * @param {String} value 元素的值
   */
  formatTplAndAdd(param, rule, value) {
    let msg = this.defaultMessage(param, rule)
    // 存在，则，退出
    let exist = false
    this.errorList.forEach(function (item) {
      if (item.param === param) exist = true
    })
    if (exist) return
    this.errorList.push({
      param: param,
      msg: msg,
      value: value,
    })
  }

  /**
   * 验证某个指定字段的规则
   * @param {String} param 字段名
   * @param {Object} rules 规则
   * @param {Object} data 需要验证的数据对象
   */
  checkParam(param, rules, data) {
    // 缓存数据对象
    this.data = data
    console.log(data)
    // 缓存字段对应的值
    // 表单值
    const values = data.detail.value
    const value = values[param] !== null && values[param] !== undefined ? values[param] : ''
    // 遍历某个指定字段的所有规则，依次验证规则，否则缓存错误信息
    for (let method in rules) {
      // 判断验证方法是否存在
      if (this.isValidMethod(method)) {
        // 缓存规则的属性及值
        const rule = {
          method: method,
          parameters: rules[method]
        }
        // 调用验证方法
        const result = this.methods[method](value, rule.parameters)
        // 若result返回值为dependency-mismatch，则说明该字段的值为空或非必填字段
        if (result === 'dependency-mismatch') {
          continue
        }
        this.setValue(param, method, result, value)
        // 判断是否通过验证，否则缓存错误信息，跳出循环
        if (!result) {
          this.formatTplAndAdd(param, rule, value)
          break
        }
      }
    }
  }

  checkInputParam(param, rules, value) {
    let result = true
    for (let method in rules) {
      if (this.isValidMethod(method)) {
        const rule = {
          method: method,
          parameters: rules[method]
        }
        const res = this.methods[method](value, rule.parameters)
        result = result && res
        if (res === 'dependency-mismatch') {
          continue
        }
        this.setValue(param, method, result, value)
        if (!res) {
          this.formatTplAndAdd(param, rule, value)
          break
        }
      }
    }
    return result
  }

  /**
   * 设置字段的默认验证值
   * @param {String} param 字段名
   */
  setView(param) {
    this.form[param] = {
      name: param,
      valid: true,
      invalid: false,
      error: {},
      success: {},
      viewValue: ``,
    }
  }

  /**
   * 设置字段的验证值
   * @param {String} param 字段名
   * @param {String} method 字段的方法
   * @param {Boolean} result 是否通过验证
   * @param {String} value 字段的值
   */
  setValue(param, method, result, value) {
    const params = this.form[param]
    params.valid = result
    params.invalid = !result
    params.error[method] = !result
    params.success[method] = result
    params.viewValue = value
  }

  /**
   * 验证所有字段的规则，返回验证是否通过
   * @param {Object} data 需要验证数据对象
   */
  checkForm(data, success, fail, complete) {
    this.__initData()
    for (let param in this.rules) {
      this.setView(param)
      this.checkParam(param, this.rules[param], data)
    }
    let passed = this.valid()
    // 成功，执行
    if (passed) {
      if (typeof success === 'function') success(this.form)
    }
    else {
      let error = this.errorList[0]
      if (typeof fail === 'function') fail(error.msg)
    }
  }

  /**
   * 验证失去焦点时的动作
   * @param {Object} data 焦点控件 e
   * 控件要提供 data-name 参数，值 为控件的 name
   */
  checkInput(data, fail, complete) {
    this.__initError()
    let name = data.currentTarget.dataset.name
    let value = data.detail.value
    // 验证
    this.setView(name)
    let passed = this.checkInputParam(name, this.rules[name], value)
    // 失败，给出错误信息
    if (!passed) {
      let error = this.errorList[0]
      if (typeof fail === 'function') fail(error.msg)
    }
    // 不管成功与否，都向外提供表单验证结果
    if (typeof complete === 'function') complete(this.form)
  }

  /**
   * 返回验证是否通过
   */
  valid() {
    return this.size() === 0
  }

  /**
   * 返回错误信息的个数
   */
  size() {
    return this.errorList.length
  }

  /**
   * 返回所有错误信息
   */
  validationErrors() {
    return this.errorList
  }
}

export default x5va