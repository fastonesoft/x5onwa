
/*这句只能在测试阶段使用，运行阶段删除*/
DROP DATABASE IF EXISTS cAuth2;
CREATE DATABASE IF NOT EXISTS cAuth2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
USE cAuth2;

SET NAMES utf8mb4;
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
INSERT INTO xonType VALUES (4, replace(uuid(), '-', ''), '分班');
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
INSERT INTO xonRole VALUES (3, replace(uuid(), '-', ''), 'regstud', '新生注册', 1, 1);
INSERT INTO xonRole VALUES (4, replace(uuid(), '-', ''), 'regexam', '报名审核', 0, 1);
INSERT INTO xonRole VALUES (5, replace(uuid(), '-', ''), 'regconfirm', '确认审核', 0, 1);

INSERT INTO xonRole VALUES (21, replace(uuid(), '-', ''), 'student', '学生信息', 0, 2);
INSERT INTO xonRole VALUES (22, replace(uuid(), '-', ''), 'students', '学生名册', 0, 2);


INSERT INTO xonRole VALUES (41, replace(uuid(), '-', ''), 'mystud', '我的学生', 0, 4);
INSERT INTO xonRole VALUES (42, replace(uuid(), '-', ''), 'myclass', '我的班级', 0, 4);
INSERT INTO xonRole VALUES (43, replace(uuid(), '-', ''), 'myadjust', '分班调整', 0, 4);
INSERT INTO xonRole VALUES (44, replace(uuid(), '-', ''), 'myexchange', '交换名单', 0, 4);
INSERT INTO xonRole VALUES (45, replace(uuid(), '-', ''), 'mydivision', '班级分管', 0, 4);
INSERT INTO xonRole VALUES (46, replace(uuid(), '-', ''), 'mytuning', '分班微调', 0, 4);
INSERT INTO xonRole VALUES (47, replace(uuid(), '-', ''), 'mysameset', '同班设置', 0, 4);
INSERT INTO xonRole VALUES (48, replace(uuid(), '-', ''), 'myrename', '班号变更', 0, 4);
INSERT INTO xonRole VALUES (49, replace(uuid(), '-', ''), 'mydivisionset', '调动设置', 0, 4);


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
INSERT INTO xonGroup VALUES (4, replace(uuid(), '-', ''), '班主任');
INSERT INTO xonGroup VALUES (50, replace(uuid(), '-', ''), '年管会');
INSERT INTO xonGroup VALUES (60, replace(uuid(), '-', ''), '教学处');
INSERT INTO xonGroup VALUES (70, replace(uuid(), '-', ''), '学校管理');
INSERT INTO xonGroup VALUES (80, replace(uuid(), '-', ''), '集团管理');
INSERT INTO xonGroup VALUES (90, replace(uuid(), '-', ''), '流量控制');
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

/**
  学科主管、年级主管
 */
INSERT INTO xonGroupRole VALUES (50, 1, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (50, 2, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (50, 3, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (50, 4, replace(uuid(), '-', ''));

INSERT INTO xonGroupRole VALUES (60, 1, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (60, 2, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (60, 3, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (60, 5, replace(uuid(), '-', ''));
/**
  学校管理员
 */
INSERT INTO xonGroupRole VALUES (70, 1, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (70, 2, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (70, 3, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (70, 4, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (70, 5, replace(uuid(), '-', ''));

INSERT INTO xonGroupRole VALUES (70, 43, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (70, 44, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (70, 45, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (70, 46, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (70, 47, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (70, 48, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (70, 49, replace(uuid(), '-', ''));

INSERT INTO xonGroupRole VALUES (70, 81, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (70, 82, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (70, 83, replace(uuid(), '-', ''));

INSERT INTO xonGroupRole VALUES (70, 93, replace(uuid(), '-', ''));

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

INSERT INTO xonGroupRole VALUES (99, 41, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (99, 42, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (99, 43, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (99, 44, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (99, 45, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (99, 46, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (99, 47, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (99, 48, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (99, 49, replace(uuid(), '-', ''));


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

create table xonEduTypeCondition (
  uid varchar(36) not null,
  edu_type_id int(11) not null,
  code int(11) not null,
  min int(11) not null,
  max int(11) not null,
  current boolean not null,
  primary key (edu_type_id, code),
  unique key uid (uid),
  foreign key (edu_type_id) references xonEduType(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学制类型条件';

INSERT INTO xonEduTypeCondition VALUES (replace(uuid(), '-', ''), 1, 1, 7, 13, 1);
INSERT INTO xonEduTypeCondition VALUES (replace(uuid(), '-', ''), 2, 1, 12, 16, 1);
INSERT INTO xonEduTypeCondition VALUES (replace(uuid(), '-', ''), 3, 1, 15, 18, 1);

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
  id VARCHAR(20) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  title VARCHAR(20) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='应用名称';

INSERT INTO xonApp VALUES ('schcode', replace(uuid(), '-', ''), '编码设置');
INSERT INTO xonApp VALUES ('regstud', replace(uuid(), '-', ''), '新生报名');

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

INSERT INTO xonSchoolForm VALUES ('3212040220180001', replace(uuid(), '-', ''), '信息采集表', 1, 2, '32120402', 2018);
INSERT INTO xonSchoolForm VALUES ('3212040220180002', replace(uuid(), '-', ''), '招生统计表（有房）', 2, 2, '32120402', 2018);
INSERT INTO xonSchoolForm VALUES ('3212040220180003', replace(uuid(), '-', ''), '监护人统计（无房）', 3, 2, '32120402', 2018);


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

INSERT INTO xonSchoolFormKey VALUES ('321204022018000101', replace(uuid(), '-', ''), 'name', '配偶姓名', 'input', 'text', '输入配偶姓名', 4, '/^[\\x{4e00}-\\x{9fa5}]{2,4}$/u', '^[\\u4e00-\\u9fa5]{2,4}$', '输入2-4个汉字', 1, 0, 0, 1, '3212040220180001', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000102', replace(uuid(), '-', ''), 'mobil', '手机号码', 'input', 'number', '输入配偶手机号码', 11, '/^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[6-9])\\d{8}$/u', '^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[6-9])\\d{8}$', '输入11位手机号码', 1, 0, 0, 2, '3212040220180001', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000103', replace(uuid(), '-', ''), 'address', '家庭住址', 'input', 'text', '输入家庭住址', 30, '/^[a-zA-Z0-9\-#\\x{4e00}-\\x{9fa5}]{8,}$/u', '^[a-zA-Z0-9\-#\\u4e00-\\u9fa5]{8,}$', '至少8个汉字', 1, 0, 0, 3, '3212040220180001', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000104', replace(uuid(), '-', ''), 'hhtype', '是否特长生', 'check', 'text', '是否择校生', 0, '/^\\d$/u', '^\\d$', '', 0, 0, 0, 4, '3212040220180001', 1);

INSERT INTO xonSchoolFormKey VALUES ('321204022018000201', replace(uuid(), '-', ''), 'owner', '产权人姓名', 'input', 'text', '输入产权人姓名', 4, '/^[\\x{4e00}-\\x{9fa5}]{2,4}$/u', '^[\\u4e00-\\u9fa5]{2,4}$', '输入2-4个汉字', 1, 0, 0, 1, '3212040220180002', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000202', replace(uuid(), '-', ''), 'idcard', '产权人身份证', 'input', 'idcard', '输入产权人身份证号', 18, '/^\\d{17}[0-9X]$/u', '^\\d{17}[0-9X]$', '身份证号码有误', 1, 0, 0, 2, '3212040220180002', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000203', replace(uuid(), '-', ''), 'htype', '产权证分类', 'picker', 'text', '产权证分类', 0, '/^\\d$/u', '^\\d$', '', 0, 0, 0, 3, '3212040220180002', '房产证#不动产证#集体土地使用证#契税发票');
INSERT INTO xonSchoolFormKey VALUES ('321204022018000204', replace(uuid(), '-', ''), 'no', '产权证编号', 'input', 'text', '输入产权证号码', 20, '/^\\d+$|^[\\x{4e00}-\\x{9fa5}]+$/u', '^\\d+$|^[\\u4e00-\\u9fa5]+$', '数字编号 或 汉字描述', 1, 0, 0, 4, '3212040220180002', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000205', replace(uuid(), '-', ''), 'name1', '父亲姓名', 'input', 'text', '输入父亲姓名', 20, '/^[\\x{4e00}-\\x{9fa5}]{2,4}$/u', '^[\\u4e00-\\u9fa5]{2,4}$', '输入2-4个汉字', 1, 0, 0, 5, '3212040220180002', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000206', replace(uuid(), '-', ''), 'mobil1', '父亲电话', 'input', 'number', '输入父亲手机号码', 11, '/^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[6-9])\\d{8}$/u', '^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[6-9])\\d{8}$', '输入11位数字号码', 1, 0, 0, 6, '3212040220180002', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000207', replace(uuid(), '-', ''), 'name2', '母亲姓名', 'input', 'text', '输入母亲姓名', 4, '/^[\\x{4e00}-\\x{9fa5}]{2,4}$/u', '^^[\\u4e00-\\u9fa5]{2,4}$', '输入2-4个汉字', 1, 0, 0, 7, '3212040220180002', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000208', replace(uuid(), '-', ''), 'mobil2', '母亲电话', 'input', 'number', '输入母亲手机号码', 11, '/^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[6-9])\\d{8}$/u', '^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[6-9])\\d{8}$', '输入11位数字号码', 1, 0, 0, 8, '3212040220180002', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000209', replace(uuid(), '-', ''), 'address', '家庭住址', 'input', 'text', '输入家庭住址', 30, '/^[a-zA-Z0-9\-#\\x{4e00}-\\x{9fa5}]{8,}$/u', '^[a-zA-Z0-9\-#\\u4e00-\\u9fa5]{8,}$', '至少8个汉字', 1, 0, 0, 9, '3212040220180002', null);


INSERT INTO xonSchoolFormKey VALUES ('321204022018000301', replace(uuid(), '-', ''), 'owner', '产权人姓名', 'input', 'text', '输入产权人姓名', 4, '/^[\\x{4e00}-\\x{9fa5}]{2,4}$/u', '^[\\u4e00-\\u9fa5]{2,4}$', '输入2-4个汉字', 1, 0, 0, 1, '3212040220180003', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000302', replace(uuid(), '-', ''), 'idcard', '产权人身份证', 'input', 'idcard', '输入产权人身份证号', 18, '/^\\d{17}[0-9X]$/u', '^\\d{17}[0-9X]$', '身份证号码有误', 1, 0, 0, 2, '3212040220180003', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000303', replace(uuid(), '-', ''), 'htype', '产权证分类', 'picker', 'text', '产权证分类', 0, '/^\\d$/u', '^\\d$', '', 0, 0, 0, 3, '3212040220180003', '房产证#不动产证#集体土地使用证#契税发票');
INSERT INTO xonSchoolFormKey VALUES ('321204022018000304', replace(uuid(), '-', ''), 'no', '产权证编号', 'input', 'text', '输入产权证号码', 20, '/^\\d+$|^[\\x{4e00}-\\x{9fa5}]+$/u', '^\\d+$|^[\\u4e00-\\u9fa5]+$', '数字编号 或 汉字描述', 1, 0, 0, 4, '3212040220180003', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000305', replace(uuid(), '-', ''), 'name1', '父亲姓名', 'input', 'text', '输入父亲姓名', 4, '/^[\\x{4e00}-\\x{9fa5}]{2,4}$/u', '^[\\u4e00-\\u9fa5]{2,4}$', '输入2-4个汉字', 1, 0, 0, 5, '3212040220180003', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000306', replace(uuid(), '-', ''), 'mobil1', '父亲电话', 'input', 'number', '输入父亲手机号码', 11, '/^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[6-9])\\d{8}$/u', '^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[6-9])\\d{8}$', '输入11位数字号码', 1, 0, 0, 6, '3212040220180003', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000307', replace(uuid(), '-', ''), 'idcard1', '父亲身份证号', 'input', 'idcard', '输入父亲身份证号', 18, '/^\\d{17}[0-9X]$/u', '^\\d{17}[0-9X]$', '身份证号码有误', 1, 0, 0, 7, '3212040220180003', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000308', replace(uuid(), '-', ''), 'name2', '母亲姓名', 'input', 'text', '输入母亲姓名', 4, '/^[\\x{4e00}-\\x{9fa5}]{2,4}$/u', '^^[\\u4e00-\\u9fa5]{2,4}$', '输入2-4个汉字', 1, 0, 0, 8, '3212040220180003', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000309', replace(uuid(), '-', ''), 'mobil2', '母亲电话', 'input', 'number', '输入母亲手机号码', 11, '/^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[6-9])\\d{8}$/u', '^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[6-9])\\d{8}$', '输入11位数字号码', 1, 0, 0, 9, '3212040220180003', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000310', replace(uuid(), '-', ''), 'idcard2', '母亲身份证号', 'input', 'idcard', '输入母亲身份证号', 18, '/^\\d{17}[0-9X]$/u', '^\\d{17}[0-9X]$', '身份证号码有误', 1, 0, 0, 10, '3212040220180003', null);
INSERT INTO xonSchoolFormKey VALUES ('321204022018000311', replace(uuid(), '-', ''), 'address', '家庭住址', 'input', 'text', '输入家庭住址', 20, '/^[a-zA-Z0-9\-#\\x{4e00}-\\x{9fa5}]{8,}$/u', '^[a-zA-Z0-9\-#\\u4e00-\\u9fa5]{8,}$', '至少8个汉字', 1, 0, 0, 11, '3212040220180003', null);



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
  confirm_user_id VARCHAR(36),
  PRIMARY KEY (child_id, edu_type_id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (child_id) REFERENCES xonChild(id),
  FOREIGN KEY (sch_id) REFERENCES xonSchool(id),
  FOREIGN KEY (user_id) REFERENCES xonUser(id),
  FOREIGN KEY (edu_type_id) REFERENCES xonEduType(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学生注册';

CREATE TABLE xonStudent (
  id VARCHAR(20) NOT NULL COMMENT '学生录取编号',
  uid VARCHAR(36) NOT NULL,
  child_id VARCHAR(20) NOT NULL,
  step_id VARCHAR(16) NOT NULL,
  come_year INT(11) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (child_id) REFERENCES xonChild(id),
  FOREIGN KEY (step_id) REFERENCES xonStep(id)
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

/**
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
 */

INSERT INTO xonYear VALUES (2016, replace(uuid(), '-', ''), 0);
INSERT INTO xonYear VALUES (2017, replace(uuid(), '-', ''), 0);
INSERT INTO xonYear VALUES (2018, replace(uuid(), '-', ''), 1);




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
  id VARCHAR(18) NOT NULL,  /* 分级编号16+学制编号2  step_id, edu_id */
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
  num INT(11) NOT NULL,
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

/**
  年级分管班级用户列表
 */
CREATE TABLE xonGradeDivision (
  uid VARCHAR(36) NOT NULL,
  grade_id VARCHAR(18) NOT NULL,
  cls_id VARCHAR(20) NOT NULL,
  user_id VARCHAR(36) NOT NULL,
  PRIMARY KEY (grade_id, cls_id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (grade_id) REFERENCES xonGrade(id),
  FOREIGN KEY (cls_id) REFERENCES xonClass(id),
  FOREIGN KEY (user_id) REFERENCES xonUser(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='年级班级分管用户';

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
INSERT INTO xonSub VALUES (99, replace(uuid(), '-', ''), '总分', '总');




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
  uid VARCHAR(36) NOT NULL,
  grade_id VARCHAR(18) NOT NULL,
  cls_id VARCHAR(20) NOT NULL,
  stud_id VARCHAR(20) NOT NULL,   /* 录取编号 */
  stud_come_id INT(11) NOT NULL,  /* 学籍办理信息 */
  auth_stud BOOLEAN NOT NULL,  /* 是否指标生 */
  in_sch BOOLEAN NOT NULL,
  same_group BOOLEAN NOT NULL DEFAULT 0,  /* 同组标志 */
  stud_code VARCHAR(36),  /* 学籍号，应届生有，往届生无 */
  PRIMARY KEY (grade_id, stud_id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (grade_id) REFERENCES xonGrade(id),
  FOREIGN KEY (cls_id) REFERENCES xonClass(id),
  FOREIGN KEY (stud_id) REFERENCES xonStudent(id),
  FOREIGN KEY (stud_come_id) REFERENCES xonStudCome(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='年级学生';



CREATE TABLE xonKaoType (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(20) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='考试分类';

INSERT INTO xonKaoType VALUES (1, replace(uuid(), '-', ''), '测试');
INSERT INTO xonKaoType VALUES (2, replace(uuid(), '-', ''), '月考');
INSERT INTO xonKaoType VALUES (3, replace(uuid(), '-', ''), '统考');
INSERT INTO xonKaoType VALUES (4, replace(uuid(), '-', ''), '调研');
INSERT INTO xonKaoType VALUES (5, replace(uuid(), '-', ''), '中考');
INSERT INTO xonKaoType VALUES (6, replace(uuid(), '-', ''), '高考');

CREATE TABLE xonTerm (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(20) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学期设置';

INSERT INTO xonTerm VALUES (1, replace(uuid(), '-', ''), '第一学期');
INSERT INTO xonTerm VALUES (2, replace(uuid(), '-', ''), '第二学期');

CREATE TABLE xonKao (
  id VARCHAR(20) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(20) NOT NULL,
  grade_id VARCHAR(18) NOT NULL,
  term_id INT(11) NOT NULL,
  type_id INT(11) NOT NULL,
  code INT(11) NOT NULL,
  summed BOOLEAN NOT NULL,
  to_division BOOLEAN NOT NULL,   /* 分班成绩依据，一个grade_id只能有一个 */
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (grade_id) REFERENCES xonGrade(id),
  FOREIGN KEY (term_id) REFERENCES xonTerm(id),
  FOREIGN KEY (type_id) REFERENCES xonKaoType(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='考试安排';

INSERT INTO xonKao VALUES ('3212040220160901', replace(uuid(), '-', ''), '分班', '32120402201609', 1, 1, 1, 0, 1);
INSERT INTO xonKao VALUES ('3212040220170801', replace(uuid(), '-', ''), '分班', '32120402201708', 1, 1, 1, 0, 1);
INSERT INTO xonKao VALUES ('3212040220180701', replace(uuid(), '-', ''), '分班', '32120402201807', 1, 1, 1, 0, 1);


CREATE TABLE xonKaoStud (
  id VARCHAR(28) NOT NULL,  /* kao_id + kao_room + kao_seat */
  uid VARCHAR(36) NOT NULL,
  kao_id VARCHAR(20) NOT NULL,
  stud_id VARCHAR(20) NOT NULL,
  kao_room VARCHAR(4) NOT NULL,
  kao_seat VARCHAR(4) NOT NULL,
  kao_num VARCHAR(20) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (kao_id) REFERENCES xonKao(id),
  FOREIGN KEY (stud_id) REFERENCES xonStudent(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='考试学生';



CREATE TABLE xonKaoSub (
  uid VARCHAR(36) NOT NULL,
  kao_id VARCHAR(20) NOT NULL,
  sub_id INT(11) NOT NULL,
  max_value INT(11) NOT NULL,
  PRIMARY KEY (kao_id, sub_id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (kao_id) REFERENCES xonKao(id),
  FOREIGN KEY (sub_id) REFERENCES xonSub(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='考试学科';

INSERT INTO xonKaoSub VALUES (replace(uuid(), '-', ''), '3212040220160901', 1, 150);
INSERT INTO xonKaoSub VALUES (replace(uuid(), '-', ''), '3212040220160901', 2, 150);
INSERT INTO xonKaoSub VALUES (replace(uuid(), '-', ''), '3212040220160901', 3, 150);
INSERT INTO xonKaoSub VALUES (replace(uuid(), '-', ''), '3212040220160901', 4, 100);

INSERT INTO xonKaoSub VALUES (replace(uuid(), '-', ''), '3212040220170801', 1, 150);
INSERT INTO xonKaoSub VALUES (replace(uuid(), '-', ''), '3212040220170801', 2, 150);
INSERT INTO xonKaoSub VALUES (replace(uuid(), '-', ''), '3212040220170801', 3, 150);

INSERT INTO xonKaoSub VALUES (replace(uuid(), '-', ''), '3212040220180701', 1, 150);
INSERT INTO xonKaoSub VALUES (replace(uuid(), '-', ''), '3212040220180701', 2, 150);
INSERT INTO xonKaoSub VALUES (replace(uuid(), '-', ''), '3212040220180701', 3, 150);


CREATE TABLE xonKaoScore (
  uid VARCHAR(36) NOT NULL,
  kao_stud_id VARCHAR(28) NOT NULL,
  sub_id INT(11) NOT NULL,
  value DECIMAL(10,1) NOT NULL,
  cls_order DECIMAL(10,1) NOT NULL DEFAULT 0.0,
  grd_order DECIMAL(10,1) NOT NULL DEFAULT 0.0,
  PRIMARY KEY (kao_stud_id, sub_id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (sub_id) REFERENCES xonSub(id),
  FOREIGN KEY (kao_stud_id) REFERENCES xonKaoStud(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='考试成绩';


CREATE TABLE xonStudMove (
  grade_stud_uid VARCHAR(36) NOT NULL,
  request_user_id VARCHAR(36) NOT NULL,
  request_cls_id VARCHAR(20) NOT NULL,
  exchange_grade_stud_uid VARCHAR(36) DEFAULT NULL,
  success BOOLEAN NOT NULL,
  PRIMARY KEY (grade_stud_uid),
  FOREIGN KEY (request_user_id) REFERENCES xonUser(id),
  FOREIGN KEY (request_cls_id) REFERENCES xonClass(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学生调动';

CREATE TABLE xonDivisionSet (
  grade_id VARCHAR(18) NOT NULL,
  section INT(11) not null,
  limit_num INT(11) NOT NULL,
  godown BOOLEAN NOT NULL,
  samesex BOOLEAN NOT NULL,
  finished BOOLEAN NOT NULL,
  PRIMARY KEY (grade_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='年级调动设置';

INSERT INTO xonDivisionSet VALUES ('32120402201609', 5, 1, 0, 1, 0);
INSERT INTO xonDivisionSet VALUES ('32120402201708', 5, 1, 0, 1, 0);
INSERT INTO xonDivisionSet VALUES ('32120402201807', 5, 1, 0, 1, 0);

INSERT INTO xonStep VALUES ('321204022016', replace(uuid(), '-', ''), '2016级', '32120402', 0);
INSERT INTO xonStep VALUES ('321204022017', replace(uuid(), '-', ''), '2017级', '32120402', 0);
INSERT INTO xonStep VALUES ('321204022018', replace(uuid(), '-', ''), '2018级', '32120402', 0);


INSERT INTO xonGrade VALUES ('32120402201607', replace(uuid(), '-', ''), '321204022016', 2016, 7);
INSERT INTO xonGrade VALUES ('32120402201608', replace(uuid(), '-', ''), '321204022016', 2017, 8);
INSERT INTO xonGrade VALUES ('32120402201609', replace(uuid(), '-', ''), '321204022016', 2018, 9);
INSERT INTO xonGrade VALUES ('32120402201707', replace(uuid(), '-', ''), '321204022017', 2017, 7);
INSERT INTO xonGrade VALUES ('32120402201708', replace(uuid(), '-', ''), '321204022017', 2018, 8);
INSERT INTO xonGrade VALUES ('32120402201807', replace(uuid(), '-', ''), '321204022018', 2018, 7);

/* 班级数据 */
INSERT INTO xonClass VALUES ('3212040220180701', replace(uuid(), '-', ''), '32120402201807', 1);
INSERT INTO xonClass VALUES ('3212040220180702', replace(uuid(), '-', ''), '32120402201807', 2);
INSERT INTO xonClass VALUES ('3212040220180703', replace(uuid(), '-', ''), '32120402201807', 3);
INSERT INTO xonClass VALUES ('3212040220180704', replace(uuid(), '-', ''), '32120402201807', 4);
INSERT INTO xonClass VALUES ('3212040220180705', replace(uuid(), '-', ''), '32120402201807', 5);
INSERT INTO xonClass VALUES ('3212040220180706', replace(uuid(), '-', ''), '32120402201807', 6);
INSERT INTO xonClass VALUES ('3212040220180707', replace(uuid(), '-', ''), '32120402201807', 7);
INSERT INTO xonClass VALUES ('3212040220180708', replace(uuid(), '-', ''), '32120402201807', 8);
INSERT INTO xonClass VALUES ('3212040220180709', replace(uuid(), '-', ''), '32120402201807', 9);
INSERT INTO xonClass VALUES ('3212040220180710', replace(uuid(), '-', ''), '32120402201807', 10);
INSERT INTO xonClass VALUES ('3212040220180711', replace(uuid(), '-', ''), '32120402201807', 11);
INSERT INTO xonClass VALUES ('3212040220180712', replace(uuid(), '-', ''), '32120402201807', 12);
INSERT INTO xonClass VALUES ('3212040220180713', replace(uuid(), '-', ''), '32120402201807', 13);
INSERT INTO xonClass VALUES ('3212040220180714', replace(uuid(), '-', ''), '32120402201807', 14);
INSERT INTO xonClass VALUES ('3212040220180715', replace(uuid(), '-', ''), '32120402201807', 15);
INSERT INTO xonClass VALUES ('3212040220180716', replace(uuid(), '-', ''), '32120402201807', 16);
INSERT INTO xonClass VALUES ('3212040220180717', replace(uuid(), '-', ''), '32120402201807', 17);
INSERT INTO xonClass VALUES ('3212040220180718', replace(uuid(), '-', ''), '32120402201807', 18);
INSERT INTO xonClass VALUES ('3212040220180719', replace(uuid(), '-', ''), '32120402201807', 19);
INSERT INTO xonClass VALUES ('3212040220180720', replace(uuid(), '-', ''), '32120402201807', 20);
INSERT INTO xonClass VALUES ('3212040220180721', replace(uuid(), '-', ''), '32120402201807', 21);
INSERT INTO xonClass VALUES ('3212040220180722', replace(uuid(), '-', ''), '32120402201807', 22);
INSERT INTO xonClass VALUES ('3212040220180723', replace(uuid(), '-', ''), '32120402201807', 23);
INSERT INTO xonClass VALUES ('3212040220180724', replace(uuid(), '-', ''), '32120402201807', 24);
INSERT INTO xonClass VALUES ('3212040220180725', replace(uuid(), '-', ''), '32120402201807', 25);
INSERT INTO xonClass VALUES ('3212040220180726', replace(uuid(), '-', ''), '32120402201807', 26);

INSERT INTO xonClass VALUES ('3212040220170801', replace(uuid(), '-', ''), '32120402201708', 1);
INSERT INTO xonClass VALUES ('3212040220170802', replace(uuid(), '-', ''), '32120402201708', 2);
INSERT INTO xonClass VALUES ('3212040220170803', replace(uuid(), '-', ''), '32120402201708', 3);
INSERT INTO xonClass VALUES ('3212040220170804', replace(uuid(), '-', ''), '32120402201708', 4);
INSERT INTO xonClass VALUES ('3212040220170805', replace(uuid(), '-', ''), '32120402201708', 5);
INSERT INTO xonClass VALUES ('3212040220170806', replace(uuid(), '-', ''), '32120402201708', 6);
INSERT INTO xonClass VALUES ('3212040220170807', replace(uuid(), '-', ''), '32120402201708', 7);
INSERT INTO xonClass VALUES ('3212040220170808', replace(uuid(), '-', ''), '32120402201708', 8);
INSERT INTO xonClass VALUES ('3212040220170809', replace(uuid(), '-', ''), '32120402201708', 9);
INSERT INTO xonClass VALUES ('3212040220170810', replace(uuid(), '-', ''), '32120402201708', 10);
INSERT INTO xonClass VALUES ('3212040220170811', replace(uuid(), '-', ''), '32120402201708', 11);
INSERT INTO xonClass VALUES ('3212040220170812', replace(uuid(), '-', ''), '32120402201708', 12);
INSERT INTO xonClass VALUES ('3212040220170813', replace(uuid(), '-', ''), '32120402201708', 13);
INSERT INTO xonClass VALUES ('3212040220170814', replace(uuid(), '-', ''), '32120402201708', 14);
INSERT INTO xonClass VALUES ('3212040220170815', replace(uuid(), '-', ''), '32120402201708', 15);
INSERT INTO xonClass VALUES ('3212040220170816', replace(uuid(), '-', ''), '32120402201708', 16);
INSERT INTO xonClass VALUES ('3212040220170817', replace(uuid(), '-', ''), '32120402201708', 17);
INSERT INTO xonClass VALUES ('3212040220170818', replace(uuid(), '-', ''), '32120402201708', 18);
INSERT INTO xonClass VALUES ('3212040220170819', replace(uuid(), '-', ''), '32120402201708', 19);
INSERT INTO xonClass VALUES ('3212040220170820', replace(uuid(), '-', ''), '32120402201708', 20);
INSERT INTO xonClass VALUES ('3212040220170821', replace(uuid(), '-', ''), '32120402201708', 21);
INSERT INTO xonClass VALUES ('3212040220170822', replace(uuid(), '-', ''), '32120402201708', 22);
INSERT INTO xonClass VALUES ('3212040220160901', replace(uuid(), '-', ''), '32120402201609', 1);
INSERT INTO xonClass VALUES ('3212040220160902', replace(uuid(), '-', ''), '32120402201609', 2);
INSERT INTO xonClass VALUES ('3212040220160903', replace(uuid(), '-', ''), '32120402201609', 3);
INSERT INTO xonClass VALUES ('3212040220160904', replace(uuid(), '-', ''), '32120402201609', 4);
INSERT INTO xonClass VALUES ('3212040220160905', replace(uuid(), '-', ''), '32120402201609', 5);
INSERT INTO xonClass VALUES ('3212040220160906', replace(uuid(), '-', ''), '32120402201609', 6);
INSERT INTO xonClass VALUES ('3212040220160907', replace(uuid(), '-', ''), '32120402201609', 7);
INSERT INTO xonClass VALUES ('3212040220160908', replace(uuid(), '-', ''), '32120402201609', 8);
INSERT INTO xonClass VALUES ('3212040220160909', replace(uuid(), '-', ''), '32120402201609', 9);
INSERT INTO xonClass VALUES ('3212040220160910', replace(uuid(), '-', ''), '32120402201609', 10);
INSERT INTO xonClass VALUES ('3212040220160911', replace(uuid(), '-', ''), '32120402201609', 11);
INSERT INTO xonClass VALUES ('3212040220160912', replace(uuid(), '-', ''), '32120402201609', 12);
INSERT INTO xonClass VALUES ('3212040220160913', replace(uuid(), '-', ''), '32120402201609', 13);
INSERT INTO xonClass VALUES ('3212040220160914', replace(uuid(), '-', ''), '32120402201609', 14);
INSERT INTO xonClass VALUES ('3212040220160915', replace(uuid(), '-', ''), '32120402201609', 15);
INSERT INTO xonClass VALUES ('3212040220160916', replace(uuid(), '-', ''), '32120402201609', 16);
INSERT INTO xonClass VALUES ('3212040220160917', replace(uuid(), '-', ''), '32120402201609', 17);
INSERT INTO xonClass VALUES ('3212040220160918', replace(uuid(), '-', ''), '32120402201609', 18);
INSERT INTO xonClass VALUES ('3212040220160919', replace(uuid(), '-', ''), '32120402201609', 19);
INSERT INTO xonClass VALUES ('3212040220160920', replace(uuid(), '-', ''), '32120402201609', 20);
INSERT INTO xonClass VALUES ('3212040220160921', replace(uuid(), '-', ''), '32120402201609', 21);
INSERT INTO xonClass VALUES ('3212040220160922', replace(uuid(), '-', ''), '32120402201609', 22);






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
  SELECT a.*, S.name as sch_name, C2.name as child_name, C2.idc as child_idc
  FROM xonStudReg a
  LEFT JOIN xonSchool S on a.sch_id = S.id
  LEFT JOIN xonChild C2 on a.child_id = C2.id;

CREATE VIEW xovSchoolForm
AS
  SELECT a.*, xA.name as app_name, Year2.current_year
  FROM xonSchoolForm a
  LEFT JOIN xonApp xA on a.app_id = xA.id
  LEFT JOIN xonYear Year2 on a.year_id = Year2.id;




/**
  当前年级
 */

CREATE VIEW xovGradeCurrent
AS
  SELECT A.*, E.name
  FROM xonGrade A
  INNER JOIN xonYear B ON A.year_id = B.id
  INNER JOIN xonEdu E ON A.edu_id = E.id
  WHERE B.current_year = 1;

/**
  班级列表
 */
CREATE VIEW xovClass
AS
  SELECT A.*, concat(B.name, '（', A.num, '）班') as cls_name, concat('条号：', right(A.id, 2)) as cls_order
  FROM xonClass A
  LEFT JOIN xovGradeCurrent B ON A.grade_id = B.id;

/**
  分班考试
 */
CREATE VIEW xovKaoDivision
AS
  SELECT *
  FROM xonKao
  WHERE to_division = 1;


/**
  未分管的班级列表
 */
CREATE VIEW xovClassNotDivision
AS
  SELECT A.*
  FROM xovClass A
  WHERE A.id NOT IN (
    SELECT cls_id FROM xonGradeDivision
  );

CREATE VIEW xovClassDivisioned
AS
  SELECT A.*, cls_order, cls_name, User2.name as user_name, nick_name
  FROM xonGradeDivision A
  LEFT JOIN xovClass C ON C.id = A.cls_id
  LEFT JOIN xonUser User2 on A.user_id = User2.id;


/**
  年级
 */

CREATE VIEW xovGrade
AS
  SELECT A.*, E.name
  FROM xonGrade A
  INNER JOIN xonYear B ON A.year_id = B.id
  INNER JOIN xonEdu E ON A.edu_id = E.id;

/**
  孩子性别
 */
CREATE VIEW xovChild
AS
  SELECT A.*, case
    when CHAR_LENGTH(idc) = 10 and SUBSTRING(idc, 2, 1) = '1' then '男'
    when CHAR_LENGTH(idc) = 10 and SUBSTRING(idc, 2, 1) = '2' then '女'
    when CHAR_LENGTH(idc) = 18 and CONVERT(SUBSTRING(idc, 17, 1), UNSIGNED INTEGER) % 2 = 1 then '男'
    when CHAR_LENGTH(idc) = 18 and CONVERT(SUBSTRING(idc, 17, 1), UNSIGNED INTEGER) % 2 = 0 then '女'
    else '男' end as child_sex
  FROM xonChild A;



/**
  学校学生
 */

CREATE VIEW xovStudent
AS
  SELECT A.*, C2.name as stud_name, C2.child_sex AS stud_sex, case
    when C2.child_sex = '男' then 1
    when C2.child_sex = '女' then 0
    end as stud_sex_num, S.name AS step_name, S2.name AS sch_name, sch_id, C2.idc as stud_idc
  FROM xonStudent A
  LEFT JOIN xovChild C2 ON A.child_id = C2.id
  LEFT JOIN xonStep S ON A.step_id = S.id
  LEFT JOIN xonSchool S2 ON S.sch_id = S2.id;




/**
  班级学生
 */

CREATE VIEW xovGradeStud
AS
  SELECT A.*, S.stud_idc, S.stud_name, S.stud_sex, S.stud_sex_num, step_name, sch_name, C.name AS come_name, C2.num as cls_num, C2.cls_name, C2.cls_order
  FROM xonGradeStud A
  LEFT JOIN xovStudent S ON A.stud_id = S.id
  LEFT JOIN xonStudCome C ON A.stud_come_id = C.id
  LEFT JOIN xovClass C2 ON A.cls_id = C2.id;


/**
  分班考试学生
 */

CREATE VIEW xovGradeDivisionStud
AS
  SELECT X.*, Y.sub_id, sub_name, sub_shortname, value, Y.id as kao_stud_id, kao_room, kao_seat, kao_num
  FROM
  (
    SELECT A.*
    FROM xovGradeStud A
    INNER JOIN xovGradeCurrent B ON A.grade_id = B.id
  ) X
  INNER JOIN (
    SELECT C.*, S.sub_id, B.name AS sub_name, B.name_short AS sub_shortname, S.value, to_division
    FROM xonKaoStud C
    INNER JOIN xonKaoScore S ON C.id = S.kao_stud_id
    INNER JOIN xonSub B ON S.sub_id = B.id
    INNER JOIN xovKaoDivision D ON C.kao_id = D.id
  ) Y
  ON X.stud_id = Y.stud_id;

/**
  分班考试学生，不在调动列表中
 */

CREATE VIEW xovGradeDivisionStudNotMoved
AS
  SELECT a.*
  FROM xovGradeDivisionStud a
  WHERE a.uid not in (
    select grade_stud_uid
    from xonStudMove
  );



/**
  分班考试学生，在调动列表中
 */

create view xovGradeDivisionStudExchanging
AS
  select a.*, b.request_user_id, b.request_cls_id, b.exchange_grade_stud_uid, success
  from xovGradeDivisionStud a
  INNER JOIN xonStudMove b ON a.uid = b.grade_stud_uid
  where success = 0 and exchange_grade_stud_uid is not null;


create view xovGradeDivisionStudMoving
AS
  select a.*, b.request_user_id, b.request_cls_id, success
  from xovGradeDivisionStud a
  INNER JOIN xonStudMove b ON a.uid = b.grade_stud_uid
  where success = 0 and exchange_grade_stud_uid is null;


create view xovGradeDivisionStudSuccess
as
  select a.*, b.request_user_id, b.request_cls_id, success
  from xovGradeDivisionStud a
  INNER JOIN xonStudMove b ON a.uid = b.grade_stud_uid
  where success = 1;


  /**
  查询学生注册信息
   */

create view xovChildSchoolForm
AS
  select a.*, form_id, key_id, value
  from xovChild a
  inner join xonParentChilds c on a.id = c.child_id
  INNER join xonSchoolFormValue v on v.user_id = c.user_id;

create view xovChildSchoolFormNotChecked
AS
SELECT aa.*, dd.name FROM `xonSchoolFormValue` aa
inner join xonParentChilds cc on aa.user_id = cc.user_id
INNER join xovChild dd on cc.child_id = dd.id
WHERE concat(aa.user_id,aa.form_id) not in (SELECT concat(user_id,form_id) from xonSchoolFormSet);


/*外键约束开启*/
SET FOREIGN_KEY_CHECKS = 1;
