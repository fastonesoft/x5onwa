/**
 * 表单验证
 * 
 * @param {Object} rules 验证字段的规则
 * @param {Object} messages 验证字段的提示信息
 * 
 */
class x5onValid {
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
   * 初始化默认提示信息
   */
  __initDefaults() {
    this.defaults = {
      messages: {
        required: '这是必填字段。',
        email: '请输入有效的电子邮件地址。',
        tel: '请输入11位的手机号码。',
        url: '请输入有效的网址。',
        date: '请输入有效的日期。',
        dateISO: '请输入有效的日期（ISO），例如：2009-06-23，1998/01/22。',
        number: '请输入有效的数字。',
        digits: '只能输入数字。',
        idcard: '请输入18位的有效身份证。',
        equalTo: this.formatTpl('输入值必须和 {0} 相同。'),
        contains: this.formatTpl('输入值必须包含 {0}。'),
        minlength: this.formatTpl('最少要输入 {0} 个字符。'),
        maxlength: this.formatTpl('最多可以输入 {0} 个字符。'),
        rangelength: this.formatTpl('请输入长度在 {0} 到 {1} 之间的字符。'),
        min: this.formatTpl('请输入不小于 {0} 的数值。'),
        max: this.formatTpl('请输入不大于 {0} 的数值。'),
        range: this.formatTpl('请输入范围在 {0} 到 {1} 之间的数值。'),
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
       * 验证电子邮箱格式
       */
      email(value) {
        return that.optional(value) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(value)
      },
      /**
       * 验证手机格式
       */
      tel(value) {
        return that.optional(value) || /^1[34578]\d{9}$/.test(value)
      },
      /**
       * 验证URL格式
       */
      url(value) {
        return that.optional(value) || /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})).?)(?::\d{2,5})?(?:[/?#]\S*)?$/i.test(value)
      },
      /**
       * 验证日期格式
       */
      date(value) {
        return that.optional(value) || !/Invalid|NaN/.test(new Date(value).toString())
      },
      /**
       * 验证ISO类型的日期格式
       */
      dateISO(value) {
        return that.optional(value) || /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/.test(value)
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
       * 验证身份证号码
       */
      idcard(value) {
        return that.optional(value) || that.idcard(value)
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
   * 判断身份证号是否正确
   */
  idcard(value) {
    let valid = /^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/.test(value)
    if (valid) {
      // 格式检测
      $idc_birth = substr($idc, 6, 8);
      $idc_date = strtotime($idc_birth);
      if (!$idc_date) {
        $error = true;
        $message = '身份证出生日期格式错误';
        return compact('error', 'message');
      }
      // 日期检测
      $year = (int) substr($idc_birth, 0, 4);
      $month = (int) substr($idc_birth, 4, 2);
      $day = (int) substr($idc_birth, 6, 2);
      if (!checkdate($month, $day, $year)) {
        $error = true;
        $message = '身份证出生日期验证出错';
        return compact('error', 'message');
      }
      // 年龄检测
      $current_year = (int) date('Y');
      if ($more_than) {
        if ($current_year - $year < $more_than) {
          $error = true;
          $message = '年龄不符要求';
          return compact('error', 'message');
        }
      }
      if ($less_than) {
        if ($current_year - $year > $less_than) {
          $error = true;
          $message = '岁数已超标';
          return compact('error', 'message');
        }
      }

      // 验证检测
      $idcard_base = substr($idc, 0, 17);
      $verify_code = substr($idc, 17, 1);
      $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
      $verify_code_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
      $total = 0;
      for ($i = 0; $i < 17; $i++) {
        $total += substr($idcard_base, $i, 1) * $factor[$i];
      }
      $mod = $total % 11;
      if ($verify_code != $verify_code_list[$mod]) {
        $error = true;
        $message = '身份证号校验出错';
        return compact('error', 'message');
      }
    }
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
    let message = this.customMessage(param, rule) || this.defaults.messages[rule.method]
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

    // 缓存字段对应的值
    const value = data[param] !== null && data[param] !== undefined ? data[param] : ''

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

  /**
   * 设置字段的默认验证值
   * @param {String} param 字段名
   */
  setView(param) {
    this.form[param] = {
      $name: param,
      $valid: true,
      $invalid: false,
      $error: {},
      $success: {},
      $viewValue: ``,
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
    params.$valid = result
    params.$invalid = !result
    params.$error[method] = !result
    params.$success[method] = result
    params.$viewValue = value
  }

  /**
   * 验证所有字段的规则，返回验证是否通过
   * @param {Object} data 需要验证数据对象
   */
  checkForm(data) {
    this.__initData()

    for (let param in this.rules) {
      this.setView(param)
      this.checkParam(param, this.rules[param], data)
    }

    return this.valid()
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

export default x5onValid