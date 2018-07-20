
/*这句只能在测试阶段使用，运行阶段删除*/
DROP DATABASE IF EXISTS cAuth;
CREATE DATABASE IF NOT EXISTS cAuth DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
USE cAuth;

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

/*系统表*/
CREATE TABLE cAppinfo (
  appid CHAR(36) DEFAULT NULL,
  secret CHAR(64) DEFAULT NULL,
  ip CHAR(20) DEFAULT NULL,
  login_duration INT(11) DEFAULT NULL,
  qcloud_appid CHAR(64) DEFAULT NULL,
  session_duration INT(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='应用基本信息';

CREATE TABLE cSessionInfo (
  open_id VARCHAR(100) NOT NULL,
  uuid VARCHAR(100) NOT NULL,
  skey VARCHAR(100) NOT NULL,
  create_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  last_visit_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  session_key VARCHAR(100) NOT NULL,
  user_info VARCHAR(2048) NOT NULL,
  PRIMARY KEY (open_id),
  KEY open_id (open_id) USING BTREE,
  KEY skey (skey) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='会话管理用户信息';

/*自定义*/
CREATE TABLE xonSys (
  id VARCHAR(20) NOT NULL,
  uid VARCHAR(32) NOT NULL,
  value VARCHAR(32) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='设置';

INSERT INTO xonSys VALUES ('myinfor', 'ba2a4a2108ef2ba65076bc825cae7e99', 'wxdca8673d324d4384');

CREATE TABLE xonType (
	id INT(11) NOT NULL,
	uid VARCHAR(36) NOT NULL,
	name VARCHAR(20) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE KEY uid (uid),
	UNIQUE KEY name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='权限分类';

INSERT INTO xonType VALUES (1, replace(uuid(), '-', ''), '报名');
INSERT INTO xonType VALUES (2, replace(uuid(), '-', ''), '学籍');
INSERT INTO xonType VALUES (3, replace(uuid(), '-', ''), '考试');
INSERT INTO xonType VALUES (9, replace(uuid(), '-', ''), '设置');

CREATE TABLE xonRole (
	id INT(11) NOT NULL,
	uid VARCHAR(36) NOT NULL,
	name VARCHAR(20) NOT NULL,
	title VARCHAR(20) NOT NULL,
	can_show BOOLEAN NOT NULL,  /*没有权限时，是否可以显示*/
	type_id INT(11) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE KEY uid (uid),
	UNIQUE KEY name (name),
	FOREIGN KEY (type_id) REFERENCES xonType(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='权限列表';

INSERT INTO xonRole VALUES (1, replace(uuid(), '-', ''), 'userset', '用户设置', 1, 1);
INSERT INTO xonRole VALUES (2, replace(uuid(), '-', ''), 'userchilds', '我的孩子', 1, 1);
INSERT INTO xonRole VALUES (3, replace(uuid(), '-', ''), 'regstud', '新生报名', 1, 1);
INSERT INTO xonRole VALUES (4, replace(uuid(), '-', ''), 'regexam', '报名审核', 0, 1);
INSERT INTO xonRole VALUES (5, replace(uuid(), '-', ''), 'regconfirm', '确认审核', 0, 1);

INSERT INTO xonRole VALUES (21, replace(uuid(), '-', ''), 'student', '学生信息', 0, 2);
INSERT INTO xonRole VALUES (22, replace(uuid(), '-', ''), 'students', '学生名册', 0, 2);

INSERT INTO xonRole VALUES (81, replace(uuid(), '-', ''), 'schcode', '编码设置', 0, 9);
INSERT INTO xonRole VALUES (82, replace(uuid(), '-', ''), 'tchreg', '教师注册', 0, 9);
INSERT INTO xonRole VALUES (83, replace(uuid(), '-', ''), 'usereset', '用户重置', 0, 9);

INSERT INTO xonRole VALUES (91, replace(uuid(), '-', ''), 'roleset', '权限设置', 0, 9);
INSERT INTO xonRole VALUES (92, replace(uuid(), '-', ''), 'rolegroup', '权限分组', 0, 9);
INSERT INTO xonRole VALUES (93, replace(uuid(), '-', ''), 'roledist', '权限分配', 0, 9);

CREATE TABLE xonGroup (
	id INT(11) NOT NULL,
	uid VARCHAR(36) NOT NULL,
	name VARCHAR(20) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE KEY uid (uid),
	UNIQUE KEY name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='分组列表';

INSERT INTO xonGroup VALUES (1, replace(uuid(), '-', ''), '临时用户');
INSERT INTO xonGroup VALUES (2, replace(uuid(), '-', ''), '学生家长');
INSERT INTO xonGroup VALUES (3, replace(uuid(), '-', ''), '科任老师');
INSERT INTO xonGroup VALUES (4, replace(uuid(), '-', ''), '班级主管');
INSERT INTO xonGroup VALUES (5, replace(uuid(), '-', ''), '学科主管');
INSERT INTO xonGroup VALUES (6, replace(uuid(), '-', ''), '年级主管');
INSERT INTO xonGroup VALUES (7, replace(uuid(), '-', ''), '学校管理');
INSERT INTO xonGroup VALUES (8, replace(uuid(), '-', ''), '集团管理');
INSERT INTO xonGroup VALUES (9, replace(uuid(), '-', ''), '流量控制');
INSERT INTO xonGroup VALUES (99, replace(uuid(), '-', ''), '系统管理');

CREATE TABLE xonGroupRole (
	group_id INT(11) NOT NULL,
	role_id INT(11) NOT NULL,
	uid VARCHAR(36) NOT NULL,
	PRIMARY KEY (group_id, role_id),
	UNIQUE KEY uid (uid),
	FOREIGN KEY (group_id) REFERENCES xonGroup(id),
	FOREIGN KEY (role_id) REFERENCES xonRole(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='分组权限';

/**
  临时用户组权限
  新生报名
 */
INSERT INTO xonGroupRole VALUES (1, 1, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (1, 2, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (2, 1, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (2, 2, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (2, 3, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (2, 21, replace(uuid(), '-', ''));
/**
  管理员组权限
 */
INSERT INTO xonGroupRole VALUES (99, 1, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (99, 2, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (99, 3, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (99, 4, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (99, 5, replace(uuid(), '-', ''));

INSERT INTO xonGroupRole VALUES (99, 21, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (99, 22, replace(uuid(), '-', ''));

INSERT INTO xonGroupRole VALUES (99, 81, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (99, 82, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (99, 83, replace(uuid(), '-', ''));

INSERT INTO xonGroupRole VALUES (99, 91, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (99, 92, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (99, 93, replace(uuid(), '-', ''));


CREATE TABLE xonUser (
  id VARCHAR(36) NOT NULL,  /*unionid*/
  uid VARCHAR(36) NOT NULL,
  nick_name VARCHAR(36) NOT NULL,
  name VARCHAR(36) NOT NULL,
  fixed BOOLEAN NOT NULL DEFAULT 0,
  create_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  last_visit_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户列表';

CREATE TABLE xonUserKey (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(20) NOT NULL,
  title VARCHAR(20) NOT NULL,
  input_type VARCHAR(20) NOT NULL,
  place_holder VARCHAR(20) NOT NULL,
  max_length INT(11) NOT NULL DEFAULT 200,
  regex_php VARCHAR(200) NOT NULL,   /* 数据正则 */
  regex_js VARCHAR(200) NOT NULL,
  message VARCHAR(20) NOT NULL,
  required BOOLEAN NOT NULL,  /* 是否必填 */
  check_unique BOOLEAN NOT NULL,  /* 唯一检测 */
  fixed BOOLEAN NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户自定义字段';

INSERT INTO xonUserKey VALUES (1, replace(uuid(), '-', ''), 'name', '我的名字', 'text', '请输入您的姓名', '4', '/^[\\x{4e00}-\\x{9fa5}]{2,4}$/u', '^[\\u4e00-\\u9fa5]{2,4}$', '输入2-4个汉字', 1, 0, 0);
INSERT INTO xonUserKey VALUES (2, replace(uuid(), '-', ''), 'mobil', '手机号码', 'number', '请输入您的手机号', '11', '/^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[6-9])\\d{8}$/', '^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[6-9])\\d{8}$', '手机号码有误！', 1, 1, 0);
INSERT INTO xonUserKey VALUES (3, replace(uuid(), '-', ''), 'idc', '身份证号', 'idcard', '请输入您的身份证号', '18', '/^\\d{17}[0-9X]$/', '^\\d{17}[0-9X]$', '身份证号有误！', 1, 1, 0);

CREATE TABLE xonUserKeyValue (
  uid VARCHAR(36) NOT NULL,
  user_id VARCHAR(36) NOT NULL,
  key_id INT(11) NOT NULL,
  value VARCHAR(200),
  PRIMARY KEY (user_id, key_id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (user_id) REFERENCES xonUser(id),
  FOREIGN KEY (key_id) REFERENCES xonUserKey(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户自定义值';

CREATE TABLE xonUserSet (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(20) NOT NULL,
  title VARCHAR(20) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY name (name),
  UNIQUE KEY title (title)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户记录表';

INSERT INTO xonUserSet VALUES (1, replace(uuid(), '-', ''), 'user-set-myself', '个人信息设置');

CREATE TABLE xonUserSetData (
  uid VARCHAR(36) NOT NULL,
  user_id VARCHAR(36) NOT NULL,
  userset_id INT(11) NOT NULL,
  checked BOOLEAN NOT NULL DEFAULT 0,
  PRIMARY KEY (user_id, userset_id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (user_id) REFERENCES xonUser(id),
  FOREIGN KEY (userset_id) REFERENCES xonUserSet(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户记录值表';

CREATE TABLE xonUserGroup (
  user_id VARCHAR(36) NOT NULL,
  group_id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  PRIMARY KEY (user_id, group_id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (user_id) REFERENCES xonUser(id),
  FOREIGN KEY (group_id) REFERENCES xonGroup(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='分组用户';

CREATE TABLE xonEduType (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(20) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学制类型';

INSERT INTO xonEduType VALUES (1, replace(uuid(), '-', ''), '小学');
INSERT INTO xonEduType VALUES (2, replace(uuid(), '-', ''), '初中');
INSERT INTO xonEduType VALUES (3, replace(uuid(), '-', ''), '高中');

CREATE TABLE xonEdu (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(20) NOT NULL,
  edu_type_id INT(11) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY name (name),
  FOREIGN KEY (edu_type_id) REFERENCES xonEduType(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学制编排';

INSERT INTO xonEdu VALUES (1, replace(uuid(), '-', ''), '一年级', 1);
INSERT INTO xonEdu VALUES (2, replace(uuid(), '-', ''), '二年级', 1);
INSERT INTO xonEdu VALUES (3, replace(uuid(), '-', ''), '三年级', 1);
INSERT INTO xonEdu VALUES (4, replace(uuid(), '-', ''), '四年级', 1);
INSERT INTO xonEdu VALUES (5, replace(uuid(), '-', ''), '五年级', 1);
INSERT INTO xonEdu VALUES (6, replace(uuid(), '-', ''), '六年级', 1);
INSERT INTO xonEdu VALUES (7, replace(uuid(), '-', ''), '七年级', 2);
INSERT INTO xonEdu VALUES (8, replace(uuid(), '-', ''), '八年级', 2);
INSERT INTO xonEdu VALUES (9, replace(uuid(), '-', ''), '九年级', 2);
INSERT INTO xonEdu VALUES (10, replace(uuid(), '-', ''), '高一年级', 3);
INSERT INTO xonEdu VALUES (11, replace(uuid(), '-', ''), '高二年级', 3);
INSERT INTO xonEdu VALUES (12, replace(uuid(), '-', ''), '高三年级', 3);

CREATE TABLE xonArea (
  id VARCHAR(6) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(20) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='地区列表';

INSERT INTO xonArea VALUES ('321204', replace(uuid(), '-', ''), '泰州市姜堰区');


CREATE TABLE xonSchool (
  id VARCHAR(10) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  code VARCHAR(5) NOT NULL,
  name VARCHAR(20) NOT NULL,
  full_name VARCHAR(100) NOT NULL,
  edu_type_id INT(11) NOT NULL,
  area_id VARCHAR(6) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY name (name),
  UNIQUE KEY full_name (full_name),
  FOREIGN KEY (edu_type_id) REFERENCES xonEduType(id),
  FOREIGN KEY (area_id) REFERENCES xonArea(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学校列表';

INSERT INTO xonSchool VALUES ('32120402', replace(uuid(), '-', ''), '02', '实验初中', '泰州市姜堰区实验初级中学', 2, '321204');
INSERT INTO xonSchool VALUES ('32120401', replace(uuid(), '-', ''), '01', '励才实验', '泰州市姜堰区励才实验学校', 2, '321204');

/**
  学校用户 -> 老师
 */
CREATE TABLE xonSchoolTeach (
  uid VARCHAR(36) NOT NULL,
  user_id VARCHAR(36) NOT NULL,
  sch_id VARCHAR(10) NOT NULL,
  /* 可以扩展属性 */
  PRIMARY KEY (uid),
  UNIQUE KEY user_id (user_id),
  FOREIGN KEY (user_id) REFERENCES xonUser(id),
  FOREIGN KEY (sch_id) REFERENCES xonSchool(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户注册的学校';



/**
  自定义表单
 */
CREATE TABLE xonApp (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(20) NOT NULL,
  title VARCHAR(20) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='应用名称';

INSERT INTO xonApp VALUES (1, replace(uuid(), '-', ''), 'schcode', '编码设置');
INSERT INTO xonApp VALUES (2, replace(uuid(), '-', ''), 'regstud', '新生报名');

CREATE TABLE xonAppForm (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(20) NOT NULL,
  app_id INT(11) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (app_id) REFERENCES xonApp(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='系统表单名称';

INSERT INTO xonAppForm VALUES (1, replace(uuid(), '-', ''), '分段编码', 1);
INSERT INTO xonAppForm VALUES (2, replace(uuid(), '-', ''), '流水号编码', 1);

CREATE TABLE xonAppFormKey (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(20) NOT NULL,
  title VARCHAR(20) NOT NULL,
  view_type VARCHAR(20) NOT NULL,
  input_type VARCHAR(20) NOT NULL,
  place_holder VARCHAR(20) NOT NULL,
  max_length INT(11) NOT NULL DEFAULT 200,
  regex_php VARCHAR(200) NOT NULL,   /* 数据正则 */
  regex_js VARCHAR(200) NOT NULL,
  message VARCHAR(20) NOT NULL,
  required BOOLEAN NOT NULL,  /* 是否必填 */
  check_unique BOOLEAN NOT NULL,  /* 唯一检测 */
  fixed BOOLEAN NOT NULL,
  form_id INT(11) NOT NULL,
  default_value VARCHAR(200),  /* 缺省值 */
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY form_name (form_id, name),
  FOREIGN KEY (form_id) REFERENCES xonAppForm(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='表单字段';

INSERT INTO xonAppFormKey VALUES (1, replace(uuid(), '-', ''), 'howMany', '编码总数', 'input', 'number', '生成多少号码', 4, '/^\\d{4}$/u', '^\\d{4}$', '输入4位数字', 1, 0, 0, 1, 2000);
INSERT INTO xonAppFormKey VALUES (2, replace(uuid(), '-', ''), 'paraTotal', '分段总数', 'input', 'number', '分段号码总数', 2, '/^\\d{2}$/u', '^\\d{2}$', '输入2位数字', 1, 0, 0, 1, 36);
INSERT INTO xonAppFormKey VALUES (3, replace(uuid(), '-', ''), 'paraBit', '段号位数', 'input', 'number', '每段编号位数', 1, '/^\\d{1}$/u', '^\\d{1}$', '输入1位数字', 1, 0, 0, 1, 2);
INSERT INTO xonAppFormKey VALUES (4, replace(uuid(), '-', ''), 'paraOrd', '序号位数', 'input', 'number', '段内序号位数', 1, '/^\\d{1}$/u', '^\\d{1}$', '输入1位数字', 1, 0, 0, 1, 2);
INSERT INTO xonAppFormKey VALUES (5, replace(uuid(), '-', ''), 'paraPrev', '编码前缀', 'input', 'number', '区分生成号码', 20, '/^[A-Z0-9]{4,20}$/u', '^[A-Z0-9]{4,20}$', '4-20位大写字符标识', 1, 0, 0, 1, 2018);
INSERT INTO xonAppFormKey VALUES (6, replace(uuid(), '-', ''), 'paraSys', '学校前缀', 'check', 'number', '添加学校前缀', 1, '/^\\d$/u', '^\\d$', '是、否', 0, 0, 0, 1, 1);
INSERT INTO xonAppFormKey VALUES (7, replace(uuid(), '-', ''), 'howMany', '编码总数', 'input', 'number', '生成多少号码', 4, '/^\\d{4}$/u', '^\\d{4}$', '输入4位数字', 1, 0, 0, 2, 2000);
INSERT INTO xonAppFormKey VALUES (8, replace(uuid(), '-', ''), 'orderBit', '编码位数', 'input', 'number', '流水号码位数', 1, '/^\\d{1}$/u', '^\\d{1}$', '输入1位数字', 1, 0, 0, 2, 4);
INSERT INTO xonAppFormKey VALUES (9, replace(uuid(), '-', ''), 'orderPrev', '编码前缀', 'input', 'number', '区分生成号码', 20, '/^[A-Z0-9]{4,20}$/u', '^[A-Z0-9]{4,20}$', '4-20位大写字符标识', 1, 0, 0, 2, 2018);
INSERT INTO xonAppFormKey VALUES (10, replace(uuid(), '-', ''), 'orderSys', '学校前缀', 'check', 'number', '添加学校前缀', 1, '/^\\d$/u', '^\\d$', '是、否', 0, 0, 0, 2, 1);

/**
  单一表单值数据
 */
CREATE TABLE xonAppFormValue (
  uid VARCHAR(36) NOT NULL,
  sch_id VARCHAR(20) NOT NULL,
  form_id INT(11) NOT NULL,
  key_id INT(11) NOT NULL,
  value VARCHAR(200),
  PRIMARY KEY (sch_id, form_id, key_id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (sch_id) REFERENCES xonSchool(id),
  FOREIGN KEY (form_id) REFERENCES xonAppForm(id),
  FOREIGN KEY (key_id) REFERENCES xonAppFormKey(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='单一表单值';

CREATE TABLE xonAppFormSet (
  uid VARCHAR(36) NOT NULL,
  sch_id VARCHAR(20) NOT NULL,
  form_id INT(11) NOT NULL,
  set_name VARCHAR(20) NOT NULL,
  checked BOOLEAN NOT NULL,
  PRIMARY KEY (sch_id, set_name),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (sch_id) REFERENCES xonSchool(id),
  FOREIGN KEY (form_id) REFERENCES xonAppForm(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='表单设置';

/**
  学校数据表
 */
CREATE TABLE xonSchoolForm (
  id VARCHAR(32) NOT NULL,  /* sch_id + code(4) */
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(20) NOT NULL,
  code INT(11) NOT NULL,
  app_id INT(11) NOT NULL,
  sch_id VARCHAR(20) NOT NULL,
  year_id INT(11) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY sch_code (sch_id, code),
  FOREIGN KEY (app_id) REFERENCES xonApp(id),
  FOREIGN KEY (sch_id) REFERENCES xonSchool(id),
  FOREIGN KEY (year_id) REFERENCES xonYear(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学校表单名称';

INSERT INTO xonSchoolForm VALUES ('3212040220180001', replace(uuid(), '-', ''), '招生统计表（有房）', 1, 2, '32120402', 2018);
INSERT INTO xonSchoolForm VALUES ('3212040220180002', replace(uuid(), '-', ''), '监护人统计（无房）', 2, 2, '32120402', 2018);
INSERT INTO xonSchoolForm VALUES ('3212040220180003', replace(uuid(), '-', ''), '领录取通知书', 3, 2, '32120402', 2018);


CREATE TABLE xonSchoolFormKey (
  id VARCHAR(36) NOT NULL,  /* form_id + code(2) */
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(20) NOT NULL,
  title VARCHAR(20) NOT NULL,
  view_type VARCHAR(20) NOT NULL,
  input_type VARCHAR(20) NOT NULL,
  place_holder VARCHAR(20) NOT NULL,
  max_length INT(11) NOT NULL DEFAULT 200,
  regex_php VARCHAR(200) NOT NULL,   /* 数据正则 */
  regex_js VARCHAR(200) NOT NULL,
  message VARCHAR(20) NOT NULL,
  required BOOLEAN NOT NULL,  /* 是否必填 */
  check_unique BOOLEAN NOT NULL,  /* 唯一检测 */
  fixed BOOLEAN NOT NULL,
  code INT(11) NOT NULL,
  form_id VARCHAR(32) NOT NULL,
  default_value VARCHAR(200) DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY form_code (form_id, code),
  UNIQUE KEY form_name (form_id, name),
  FOREIGN KEY (form_id) REFERENCES xonSchoolForm(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学校表单字段';

INSERT INTO xonSchoolFormKey VALUES ('321204022018000101', replace(uuid(), '-', ''), 'owner', '产权人姓名', 'input', 'text', '输入产权人姓名', 4, '/^[\\x{4e00}-\\x{9fa5}]{2,4}$/u', '^[\\u4e00-\\u9fa5]{2,4}$', '输入2-4个汉字', 1, 0, 0, 1, '3212040220180001', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000102', replace(uuid(), '-', ''), 'no', '产权证编号', 'input', 'number', '输入产权证号码', 20, '/^\\d+$/u', '^\\d+$', '产权证号码有误', 1, 0, 0, 2, '3212040220180001', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000103', replace(uuid(), '-', ''), 'idc', '产权人身份证', 'input', 'idcard', '输入产权人身份证号', 18, '/^\\d{17}[0-9X]$/u', '^\\d{17}[0-9X]$', '身份证号码有误', 1, 0, 0, 3, '3212040220180001', null);

INSERT INTO xonSchoolFormKey VALUES ('321204022018000201', replace(uuid(), '-', ''), 'idc', '产权人身份证', 'input', 'idcard', '输入产权人身份证号', 18, '/^\\d{17}[0-9X]$/u', '^\\d{17}[0-9X]$', '身份证号码有误', 1, 0, 0, 1, '3212040220180002', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000202', replace(uuid(), '-', ''), 'htype', '产权证分类', 'picker', 'text', '产权证分类', 0, '/^\\d$/u', '^\\d$', '', 0, 0, 0, 2, '3212040220180002', '房产证#不动产证#集体土地使用证#契税发票');
INSERT INTO xonSchoolFormKey VALUES ('321204022018000203', replace(uuid(), '-', ''), 'hhtype', '产权证分类', 'picker', 'text', '产权证分类', 0, '/^\\d$/u', '^\\d$', '', 0, 0, 0, 3, '3212040220180002', '房产证#不动产证#集体土地使用证#契税发票');

INSERT INTO xonSchoolFormKey VALUES ('321204022018000301', replace(uuid(), '-', ''), 'name', '配偶姓名', 'input', 'text', '输入配偶姓名', 4, '/^[\\x{4e00}-\\x{9fa5}]{2,4}$/u', '^[\\u4e00-\\u9fa5]{2,4}$', '输入2-4个汉字', 1, 0, 0, 1, '3212040220180003', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000302', replace(uuid(), '-', ''), 'mobil', '手机号码', 'input', 'number', '输入配偶手机号码', 11, '/^\\d{11}$/u', '^\\d{11}$', '输入11位手机号码', 1, 0, 0, 2, '3212040220180003', null);


CREATE TABLE xonSchoolFormValue (
  uid VARCHAR(36) NOT NULL,
  user_id VARCHAR(36) NOT NULL,
  form_id VARCHAR(32) NOT NULL,
  key_id VARCHAR(36) NOT NULL,
  value VARCHAR(200),
  PRIMARY KEY (user_id, form_id, key_id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (user_id) REFERENCES xonUser(id),
  FOREIGN KEY (form_id) REFERENCES xonSchoolForm(id),
  FOREIGN KEY (key_id) REFERENCES xonSchoolFormKey(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='多一表单值';


CREATE TABLE xonSchoolFormSet (
  uid VARCHAR(36) NOT NULL,
  user_id VARCHAR(36) NOT NULL,
  form_id VARCHAR (32) NOT NULL,
  app_id INT(11) NOT NULL,
  checked BOOLEAN NOT NULL,
  PRIMARY KEY (user_id, form_id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (user_id) REFERENCES xonUser(id),
  FOREIGN KEY (form_id) REFERENCES xonSchoolForm(id),
  FOREIGN KEY (app_id) REFERENCES xonApp(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户表单设置';


CREATE TABLE xonSchoolCode (
  id VARCHAR(20) NOT NULL,  /* id = sch_id + code */
  uid VARCHAR(36) NOT NULL,
  sch_id VARCHAR(10) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (sch_id) REFERENCES xonSchool(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='自定义编号数据';

/**
  学生报名表
  同种类型学校，只能报一所
 */
CREATE TABLE xonStudReg (
  uid VARCHAR(36) NOT NULL,
  child_id VARCHAR(20) NOT NULL,
  sch_id VARCHAR(10) NOT NULL,
  user_id VARCHAR(36) NOT NULL,
  edu_type_id INT(11) NOT NULL,
  exam_user_id VARCHAR(36),
  rexam_user_id VARCHAR(36),
  PRIMARY KEY (child_id, edu_type_id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (child_id) REFERENCES xonChild(id),
  FOREIGN KEY (sch_id) REFERENCES xonSchool(id),
  FOREIGN KEY (user_id) REFERENCES xonUser(id),
  FOREIGN KEY (edu_type_id) REFERENCES xonEduType(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学生注册';

CREATE TABLE xonStudent (
  id VARCHAR(20) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  child_id VARCHAR(20) NOT NULL,
  year_id INT(11) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (child_id) REFERENCES xonChild(id),
  FOREIGN KEY (year_id) REFERENCES xonYear(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='录取学生';

/**
  学生与学校（学校、年度、级、年级、班级）关系表
  存在外键引用的，尽量使用数值型作主键
 */
/** 年度 **/
CREATE TABLE xonYear (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  current_year BOOLEAN NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='年度';

INSERT INTO xonYear VALUES (2004, replace(uuid(), '-', ''), 0);
INSERT INTO xonYear VALUES (2005, replace(uuid(), '-', ''), 0);
INSERT INTO xonYear VALUES (2006, replace(uuid(), '-', ''), 0);
INSERT INTO xonYear VALUES (2007, replace(uuid(), '-', ''), 0);
INSERT INTO xonYear VALUES (2008, replace(uuid(), '-', ''), 0);
INSERT INTO xonYear VALUES (2009, replace(uuid(), '-', ''), 0);
INSERT INTO xonYear VALUES (2010, replace(uuid(), '-', ''), 0);
INSERT INTO xonYear VALUES (2011, replace(uuid(), '-', ''), 0);
INSERT INTO xonYear VALUES (2012, replace(uuid(), '-', ''), 0);
INSERT INTO xonYear VALUES (2013, replace(uuid(), '-', ''), 0);
INSERT INTO xonYear VALUES (2014, replace(uuid(), '-', ''), 0);
INSERT INTO xonYear VALUES (2015, replace(uuid(), '-', ''), 0);
INSERT INTO xonYear VALUES (2016, replace(uuid(), '-', ''), 0);
INSERT INTO xonYear VALUES (2017, replace(uuid(), '-', ''), 0);
INSERT INTO xonYear VALUES (2018, replace(uuid(), '-', ''), 1);

/**
  分级编号 定义规则：
  同年进，同年出，不需要分级
  同年进，异年出，分级定义
  比如，完中：一年级，七年级，这种类型学校的分级，就必须要分
 */
CREATE TABLE xonStep (
  id VARCHAR(16) NOT NULL,  /*学校10+分级序号6（2018、201801）*/
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(20) NOT NULL,
  sch_id VARCHAR(10) NOT NULL,
  graduated BOOLEAN NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (sch_id) REFERENCES xonSchool(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='分级';

/** 年级 **/
CREATE TABLE xonGrade (
  id VARCHAR(18) NOT NULL,  /*分级编号16+学制编号2  (CONCAT(step_id, edu_id))*/
  uid VARCHAR(36) NOT NULL,
  step_id VARCHAR(16) NOT NULL,
  year_id INT(11) NOT NULL,
  edu_id INT(11) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (step_id) REFERENCES xonStep(id),
  FOREIGN KEY (year_id) REFERENCES xonYear(id),
  FOREIGN KEY (edu_id) REFERENCES xonEdu(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='年级';

/** 班级 **/
CREATE TABLE xonClass (
  id VARCHAR(20) NOT NULL,  /*年级编号18+班级序号2 */
  uid VARCHAR(36) NOT NULL,
  grade_id VARCHAR(18) NOT NULL,
  num VARCHAR(2) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (grade_id) REFERENCES xonGrade(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='班级';

/** 年级对应分组名称，分类统计用 **/
CREATE TABLE xonGradeGroup (
  id VARCHAR(20) NOT NULL,  /*年级编号18 + 分组序号2(CONCAT(grade_id, num))*/
  uid VARCHAR(36) NOT NULL,
  grade_id VARCHAR(18) NOT NULL,
  num VARCHAR(2) NOT NULL,  /* 分组序号 */
  name VARCHAR(20) NOT NULL,  /* 分组名称：智慧班、普通班 */
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (grade_id) REFERENCES xonGrade(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='年级对应分组';

/** 分组对应班级，分类统计用 **/
CREATE TABLE xonClassGroup (
  uid VARCHAR(36) NOT NULL,
  grade_group_id VARCHAR(20) NOT NULL,
  cls_id VARCHAR(20) NOT NULL,
  PRIMARY KEY (uid),
  FOREIGN KEY (cls_id) REFERENCES xonClass(id),
  FOREIGN KEY (grade_group_id) REFERENCES xonGradeGroup(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='分组对应班级';

/** 年级教师 **/
CREATE TABLE xonGradeUser (
  uid VARCHAR(36) NOT NULL,
  grade_id VARCHAR(18) NOT NULL,
  user_id VARCHAR(36) NOT NULL,
  PRIMARY KEY (uid),
  FOREIGN KEY (grade_id) REFERENCES xonGrade(id),
  FOREIGN KEY (user_id) REFERENCES xonUser(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='年级教师';

/** 班级教师 **/
CREATE TABLE xonClassUser (
  uid VARCHAR(36) NOT NULL,
  cls_id VARCHAR(18) NOT NULL,
  sub_id INT(11) NOT NULL,
  user_id VARCHAR(36) NOT NULL,
  is_master BOOLEAN NOT NULL,
  PRIMARY KEY (cls_id, sub_id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (sub_id) REFERENCES xonSub(id),
  FOREIGN KEY (user_id) REFERENCES xonUser(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='班级教师';

/** 学科设置 **/
CREATE TABLE xonSub (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(10) NOT NULL,
  name_short VARCHAR(1) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY name (name),
  UNIQUE KEY name_short (name_short)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学科设置';

INSERT INTO xonSub VALUES (1, replace(uuid(), '-', ''), '语文', '语');
INSERT INTO xonSub VALUES (2, replace(uuid(), '-', ''), '数学', '数');
INSERT INTO xonSub VALUES (3, replace(uuid(), '-', ''), '英语', '英');
INSERT INTO xonSub VALUES (4, replace(uuid(), '-', ''), '物理', '物');
INSERT INTO xonSub VALUES (5, replace(uuid(), '-', ''), '化学', '化');
INSERT INTO xonSub VALUES (6, replace(uuid(), '-', ''), '政治', '政');
INSERT INTO xonSub VALUES (7, replace(uuid(), '-', ''), '历史', '历');
INSERT INTO xonSub VALUES (8, replace(uuid(), '-', ''), '地理', '地');
INSERT INTO xonSub VALUES (9, replace(uuid(), '-', ''), '生物', '生');
INSERT INTO xonSub VALUES (10, replace(uuid(), '-', ''), '音乐', '音');
INSERT INTO xonSub VALUES (11, replace(uuid(), '-', ''), '美术', '美');
INSERT INTO xonSub VALUES (12, replace(uuid(), '-', ''), '体育', '体');
INSERT INTO xonSub VALUES (13, replace(uuid(), '-', ''), '信息', '信');
INSERT INTO xonSub VALUES (14, replace(uuid(), '-', ''), '听力', '听');
INSERT INTO xonSub VALUES (15, replace(uuid(), '-', ''), '口语', '口');




/** 学籍状态 **/
CREATE TABLE xonStudType (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(10) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学籍状态';

INSERT INTO xonStudType VALUES (1, replace(uuid(), '-', ''), '应届生');
INSERT INTO xonStudType VALUES (2, replace(uuid(), '-', ''), '往届生');

/** 学生来源 **/
CREATE TABLE xonStudCome (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(10) NOT NULL,
  name_display BOOLEAN NOT NULL,
  stud_type_id INT(11) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (stud_type_id) REFERENCES xonStudType(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学生来源';

INSERT INTO xonStudCome VALUES (1, replace(uuid(), '-', ''), '正常', 0, 1);
INSERT INTO xonStudCome VALUES (2, replace(uuid(), '-', ''), '休复', 1, 1);
INSERT INTO xonStudCome VALUES (3, replace(uuid(), '-', ''), '转入', 1, 1);
INSERT INTO xonStudCome VALUES (4, replace(uuid(), '-', ''), '跨省', 1, 1);
INSERT INTO xonStudCome VALUES (5, replace(uuid(), '-', ''), '借读', 1, 1);
INSERT INTO xonStudCome VALUES (6, replace(uuid(), '-', ''), '重读', 1, 2);

/** 学籍变更信息 **/
CREATE TABLE xonStudOut (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(10) NOT NULL,
  can_return BOOLEAN NOT NULL,  /* 可以直接回原年级 */
  down_return BOOLEAN NOT NULL,  /* 降级回校 */
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学籍变更信息';

INSERT INTO xonStudOut VALUES (1, replace(uuid(), '-', ''), '休学', 0, 1);
INSERT INTO xonStudOut VALUES (2, replace(uuid(), '-', ''), '转出', 0, 0);
INSERT INTO xonStudOut VALUES (3, replace(uuid(), '-', ''), '死亡', 0, 0);
INSERT INTO xonStudOut VALUES (11, replace(uuid(), '-', ''), '外借', 1, 0);
INSERT INTO xonStudOut VALUES (12, replace(uuid(), '-', ''), '流生', 1, 0);
INSERT INTO xonStudOut VALUES (99, replace(uuid(), '-', ''), '临时', 1, 0);

/** 年级学生，报名审核的时候根据家长登记的学生信息，满足条件添加 **/
CREATE TABLE xonGradeStud (
  id VARCHAR(22) NOT NULL,  /* 年级编号grade_id + 重编的序号4 */
  uid VARCHAR(36) NOT NULL,
  grade_id VARCHAR(18) NOT NULL,
  cls_id VARCHAR(20) NOT NULL,
  stud_id VARCHAR(20) NOT NULL,
  stud_type_id INT(11) NOT NULL,  /* 学籍状态：应届生、往届生 */
  stud_come_id INT(11) NOT NULL,  /* 学籍办理信息 */
  in_sch BOOLEAN NOT NULL,
  auth_stud BOOLEAN NOT NULL,  /* 是否指标生 */
  same_group VARCHAR(36),  /* 同组标志 */
  stud_code VARCHAR(36),  /* 学籍号，应届生有，往届生无 */
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (grade_id) REFERENCES xonGrade(id),
  FOREIGN KEY (cls_id) REFERENCES xonClass(id),
  FOREIGN KEY (stud_id) REFERENCES xonStudent(id),
  FOREIGN KEY (stud_type_id) REFERENCES xonStudType(id),
  FOREIGN KEY (stud_come_id) REFERENCES xonStudCome(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='年级学生';

/** 年级学生变更 **/
CREATE TABLE xonGradeStudOut (
  uid VARCHAR(36) NOT NULL,
  grade_stud_id VARCHAR(22) NOT NULL,
  stud_out_id INT(11) NOT NULL,
  begin_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,  /* 手续开启时间 */
  end_time INT(11) NOT NULL DEFAULT 0,  /* 多长时间到期提醒 */
  done BOOLEAN NOT NULL DEFAULT 0,
  memo VARCHAR(36) DEFAULT NULL,
  PRIMARY KEY (uid),
  FOREIGN KEY (grade_stud_id) REFERENCES xonGradeStud(id),
  FOREIGN KEY (stud_out_id) REFERENCES xonStudOut(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='年级学生变更';





/**
  学生、家长相关表格
 */
CREATE TABLE xonChild (
  id VARCHAR(20) NOT NULL,  /* 用身份证号 - 不可变更 */
  uid VARCHAR(36) NOT NULL,
  idc VARCHAR(20) NOT NULL,
  name VARCHAR(20) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY idc (idc)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='孩子表';

CREATE TABLE xonRelation (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(20) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='关系表';

INSERT INTO xonRelation VALUES (1, replace(uuid(), '-', ''), '爸爸');
INSERT INTO xonRelation VALUES (2, replace(uuid(), '-', ''), '妈妈');
INSERT INTO xonRelation VALUES (3, replace(uuid(), '-', ''), '亲戚');
INSERT INTO xonRelation VALUES (4, replace(uuid(), '-', ''), '朋友');

CREATE TABLE xonParentChilds (
  uid VARCHAR(36) NOT NULL,
  user_id VARCHAR(36) NOT NULL,
  child_id VARCHAR(20) NOT NULL,
  relation_id INT(11) NOT NULL,
  pay_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  pay_day INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (uid),
  UNIQUE KEY user_child (user_id, child_id),
  UNIQUE KEY child_relation (child_id, relation_id),
  FOREIGN KEY (user_id) REFERENCES xonUser(id),
  FOREIGN KEY (child_id) REFERENCES xonChild(id),
  FOREIGN KEY (relation_id) REFERENCES xonRelation(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='家长孩子';

/**
  可变属性记录表 - 定制表格
 */
CREATE TABLE xonParentCustom (
  id VARCHAR(15) NOT NULL,  /* 学校编号 + 4位流水号 => sch_id + code */
  uid VARCHAR(36) NOT NULL,
  code VARCHAR(5) NOT NULL,
  name VARCHAR(20) NOT NULL,  /* 定制表格分类名称 */
  type_id INT(11) NOT NULL,
  sch_id VARCHAR(10) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (type_id) REFERENCES xonType(id),
  FOREIGN KEY (sch_id) REFERENCES xonSchool(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='定制表格名称';

INSERT INTO xonParentCustom VALUES ('321204020001', replace(uuid(), '-', ''), '0001', '报名信息', 1, '32120402');

/**
  可变属性记录表 - 定制字段
 */
CREATE TABLE xonParentCustProp (
  id VARCHAR(20) NOT NULL,  /* 定制表格编号 + 流水号 => custom_id + code */
  uid VARCHAR(36) NOT NULL,
  code VARCHAR(2) NOT NULL,
  name VARCHAR(20) NOT NULL,
  data_required BOOLEAN NOT NULL,  /* 是否必填 */
  data_regex VARCHAR(200) NOT NULL,   /* 数据正则 */
  custom_id VARCHAR(15) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (custom_id) REFERENCES xonParentCustom(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='定制表格字段';

INSERT INTO xonParentCustProp VALUES ('32120402000101', replace(uuid(), '-', ''), '01', '身份证号', 1, '', '321204020001');


/**
  可变属性记录表 - 定制表格数据
 */
CREATE TABLE xonParentCustValue (
  uid VARCHAR(36) NOT NULL,
  prop_id VARCHAR(20) NOT NULL,
  user_id VARCHAR(36) NOT NULL,
  value VARCHAR(200) NOT NULL,
  PRIMARY KEY (uid),
  FOREIGN KEY (prop_id) REFERENCES xonParentCustProp(id),
  FOREIGN KEY (user_id) REFERENCES xonUser(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='定制表格数据';

INSERT INTO xonParentCustValue VALUES (replace(uuid(), '-', ''), '32120402000101', 'o47ZhvzWPWSNS26vG_45Fuz5JMZk', '32102819790209301X');







/**
  临时错误存放，调试用
 */
CREATE TABLE xonError (
  id INT(11) NOT NULL AUTO_INCREMENT,
  message VARCHAR(2048),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='错误输出检测';

/*分级数据*/
INSERT INTO xonStep VALUES ('321204022004', replace(uuid(), '-', ''), '2004级', '32120402', 1);
INSERT INTO xonStep VALUES ('321204022005', replace(uuid(), '-', ''), '2005级', '32120402', 1);
INSERT INTO xonStep VALUES ('321204022006', replace(uuid(), '-', ''), '2006级', '32120402', 1);
INSERT INTO xonStep VALUES ('321204022007', replace(uuid(), '-', ''), '2007级', '32120402', 1);
INSERT INTO xonStep VALUES ('321204022008', replace(uuid(), '-', ''), '2008级', '32120402', 1);
INSERT INTO xonStep VALUES ('321204022009', replace(uuid(), '-', ''), '2009级', '32120402', 1);
INSERT INTO xonStep VALUES ('321204022010', replace(uuid(), '-', ''), '2010级', '32120402', 1);
INSERT INTO xonStep VALUES ('321204022011', replace(uuid(), '-', ''), '2011级', '32120402', 1);
INSERT INTO xonStep VALUES ('321204022012', replace(uuid(), '-', ''), '2012级', '32120402', 1);
INSERT INTO xonStep VALUES ('321204022013', replace(uuid(), '-', ''), '2013级', '32120402', 1);
INSERT INTO xonStep VALUES ('321204022014', replace(uuid(), '-', ''), '2014级', '32120402', 1);
INSERT INTO xonStep VALUES ('321204022015', replace(uuid(), '-', ''), '2015级', '32120402', 0);
INSERT INTO xonStep VALUES ('321204022016', replace(uuid(), '-', ''), '2016级', '32120402', 0);
INSERT INTO xonStep VALUES ('321204022017', replace(uuid(), '-', ''), '2017级', '32120402', 0);
INSERT INTO xonStep VALUES ('321204022018', replace(uuid(), '-', ''), '2018级', '32120402', 0);

/*年级数据*/
INSERT INTO xonGrade VALUES ('32120402200409', replace(uuid(), '-', ''), '321204022004', 2006, 9);
INSERT INTO xonGrade VALUES ('32120402200508', replace(uuid(), '-', ''), '321204022005', 2006, 8);
INSERT INTO xonGrade VALUES ('32120402200509', replace(uuid(), '-', ''), '321204022005', 2007, 9);
INSERT INTO xonGrade VALUES ('32120402200607', replace(uuid(), '-', ''), '321204022006', 2006, 7);
INSERT INTO xonGrade VALUES ('32120402200608', replace(uuid(), '-', ''), '321204022006', 2007, 8);
INSERT INTO xonGrade VALUES ('32120402200609', replace(uuid(), '-', ''), '321204022006', 2008, 9);
INSERT INTO xonGrade VALUES ('32120402200707', replace(uuid(), '-', ''), '321204022007', 2007, 7);
INSERT INTO xonGrade VALUES ('32120402200708', replace(uuid(), '-', ''), '321204022007', 2008, 8);
INSERT INTO xonGrade VALUES ('32120402200709', replace(uuid(), '-', ''), '321204022007', 2009, 9);
INSERT INTO xonGrade VALUES ('32120402200807', replace(uuid(), '-', ''), '321204022008', 2008, 7);
INSERT INTO xonGrade VALUES ('32120402200808', replace(uuid(), '-', ''), '321204022008', 2009, 8);
INSERT INTO xonGrade VALUES ('32120402200809', replace(uuid(), '-', ''), '321204022008', 2010, 9);
INSERT INTO xonGrade VALUES ('32120402200907', replace(uuid(), '-', ''), '321204022009', 2009, 7);
INSERT INTO xonGrade VALUES ('32120402200908', replace(uuid(), '-', ''), '321204022009', 2010, 8);
INSERT INTO xonGrade VALUES ('32120402200909', replace(uuid(), '-', ''), '321204022009', 2011, 9);
INSERT INTO xonGrade VALUES ('32120402201007', replace(uuid(), '-', ''), '321204022010', 2010, 7);
INSERT INTO xonGrade VALUES ('32120402201008', replace(uuid(), '-', ''), '321204022010', 2011, 8);
INSERT INTO xonGrade VALUES ('32120402201009', replace(uuid(), '-', ''), '321204022010', 2012, 9);
INSERT INTO xonGrade VALUES ('32120402201107', replace(uuid(), '-', ''), '321204022011', 2011, 7);
INSERT INTO xonGrade VALUES ('32120402201108', replace(uuid(), '-', ''), '321204022011', 2012, 8);
INSERT INTO xonGrade VALUES ('32120402201109', replace(uuid(), '-', ''), '321204022011', 2013, 9);
INSERT INTO xonGrade VALUES ('32120402201207', replace(uuid(), '-', ''), '321204022012', 2012, 7);
INSERT INTO xonGrade VALUES ('32120402201208', replace(uuid(), '-', ''), '321204022012', 2013, 8);
INSERT INTO xonGrade VALUES ('32120402201209', replace(uuid(), '-', ''), '321204022012', 2014, 9);
INSERT INTO xonGrade VALUES ('32120402201307', replace(uuid(), '-', ''), '321204022013', 2013, 7);
INSERT INTO xonGrade VALUES ('32120402201308', replace(uuid(), '-', ''), '321204022013', 2014, 8);
INSERT INTO xonGrade VALUES ('32120402201309', replace(uuid(), '-', ''), '321204022013', 2015, 9);
INSERT INTO xonGrade VALUES ('32120402201407', replace(uuid(), '-', ''), '321204022014', 2014, 7);
INSERT INTO xonGrade VALUES ('32120402201408', replace(uuid(), '-', ''), '321204022014', 2015, 8);
INSERT INTO xonGrade VALUES ('32120402201409', replace(uuid(), '-', ''), '321204022014', 2016, 9);
INSERT INTO xonGrade VALUES ('32120402201507', replace(uuid(), '-', ''), '321204022015', 2015, 7);
INSERT INTO xonGrade VALUES ('32120402201508', replace(uuid(), '-', ''), '321204022015', 2016, 8);
INSERT INTO xonGrade VALUES ('32120402201509', replace(uuid(), '-', ''), '321204022015', 2017, 9);
INSERT INTO xonGrade VALUES ('32120402201607', replace(uuid(), '-', ''), '321204022016', 2016, 7);
INSERT INTO xonGrade VALUES ('32120402201608', replace(uuid(), '-', ''), '321204022016', 2017, 8);
INSERT INTO xonGrade VALUES ('32120402201707', replace(uuid(), '-', ''), '321204022017', 2017, 7);


CREATE TABLE xonToken (
  id VARCHAR(20) NOT NULL,
  access_token VARCHAR(1024) NOT NULL,
  expires_in INT(11) NOT NULL,
  create_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='请求参数';

/**
  视图：非管理用户查询
 */
CREATE VIEW xovUser
AS
  SELECT *
  FROM xonUser a WHERE a.id NOT IN (
    SELECT user_id
    FROM xonUserGroup
    WHERE user_id = a.id AND group_id = 99
  );

/**
  视图：用户权限
 */
CREATE VIEW xovUserRole
AS
  SELECT a.*, b.name as role_name, title
  FROM (
    SELECT DISTINCT user_id, role_id
    FROM xonUserGroup c INNER JOIN xonGroupRole d ON c.group_id = d.group_id
  ) a LEFT JOIN xonRole b on a.role_id = b.id;


/**
  视图：不是教师的用户
 */
CREATE VIEW xovUserNotTeach
AS
  SELECT id, nick_name, name, 0 as checked
  FROM xonUser a
  WHERE a.id NOT IN (
    SELECT user_id FROM xonSchoolTeach
  );

/**
  视图：查询学校老师
 */
CREATE VIEW xovSchoolTeach
AS
  SELECT user_id, C.name as user_name, nick_name, sch_id, B.name as sch_name
  FROM xonSchoolTeach A
  LEFT JOIN xonSchool B ON A.sch_id = B.id
  LEFT JOIN xonUser C ON A.user_id = C.id;

/**
  视图：查询组用户信息
 */
CREATE VIEW xovUserGroup
AS
  SELECT a.*, b.name as user_name, nick_name
  FROM xonUserGroup a LEFT JOIN xonUser b ON a.user_id = b.id;

/**
  视图：查询我的孩子
 */
 CREATE VIEW xovParentChilds
 AS
  SELECT a.*, c.idc, c.name as child_name, d.name as relation_name
  FROM xonParentChilds a
  LEFT JOIN xonChild c on a.child_id = c.id
  LEFT JOIN xonRelation d on a.relation_id = d.id;

CREATE VIEW xovStudReg
AS
  SELECT a.*, S.name as sch_name, C2.name as child_name
  FROM xonStudReg a
  LEFT JOIN xonSchool S on a.sch_id = S.id
  LEFT JOIN xonChild C2 on a.child_id = C2.id;

CREATE VIEW xovSchoolForm
AS
  SELECT a.*, xA.name as app_name, Year2.current_year
  FROM xonSchoolForm a
  LEFT JOIN xonApp xA on a.app_id = xA.id
  LEFT JOIN xonYear Year2 on a.year_id = Year2.id;

/*外键约束开启*/
SET FOREIGN_KEY_CHECKS = 1;
