
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

CREATE TABLE xonAuth (
	id BOOLEAN NOT NULL,
	uid VARCHAR(36) NOT NULL,
	name VARCHAR(20) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE KEY uid (uid),
	UNIQUE KEY name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='指标设置';

INSERT INTO xonAuth VALUES (0, replace(uuid(), '-', ''), '非指标生');
INSERT INTO xonAuth VALUES (1, replace(uuid(), '-', ''), '指标生');

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
INSERT INTO xonRole VALUES (6, replace(uuid(), '-', ''), 'regquery', '报名查询', 0, 1);

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
INSERT INTO xonRole VALUES (82, replace(uuid(), '-', ''), 'usereg', '教师注册', 0, 9);
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
INSERT INTO xonGroupRole VALUES (2, 21, replace(uuid(), '-', ''));

/**
  学科主管、年级主管
 */
INSERT INTO xonGroupRole VALUES (50, 1, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (50, 2, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (50, 3, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (50, 4, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (50, 6, replace(uuid(), '-', ''));

INSERT INTO xonGroupRole VALUES (60, 1, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (60, 2, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (60, 3, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (60, 5, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (60, 6, replace(uuid(), '-', ''));

/**
  学校管理员
 */
INSERT INTO xonGroupRole VALUES (70, 1, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (70, 2, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (70, 3, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (70, 4, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (70, 5, replace(uuid(), '-', ''));
INSERT INTO xonGroupRole VALUES (70, 6, replace(uuid(), '-', ''));

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
INSERT INTO xonGroupRole VALUES (99, 6, replace(uuid(), '-', ''));

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
  name VARCHAR(20) NOT NULL,
 	mobil VARCHAR(20) NOT NULL,
  fixed BOOLEAN NOT NULL DEFAULT 0,
  confirmed BOOLEAN NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY mobil (mobil)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户列表';

CREATE TABLE xonUserGroup (
  uid VARCHAR(36) NOT NULL,
  user_id VARCHAR(36) NOT NULL,
  group_id INT(11) NOT NULL,
  PRIMARY KEY (user_id, group_id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (user_id) REFERENCES xonUser(id),
  FOREIGN KEY (group_id) REFERENCES xonGroup(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户分组';

CREATE TABLE xonEduType (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(10) NOT NULL,
  begin INT(11) NOT NULL,
  end INT(11) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学制类型';

INSERT INTO xonEduType VALUES (1, replace(uuid(), '-', ''), '小学', 7, 10);
INSERT INTO xonEduType VALUES (2, replace(uuid(), '-', ''), '初中', 12, 15);
INSERT INTO xonEduType VALUES (3, replace(uuid(), '-', ''), '高中', 15, 18);

CREATE TABLE xonEdu (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(10) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学制类型';

INSERT INTO `xonEdu` (`id`, `uid`, `name`) VALUES
(1, replace(uuid(), '-', ''), '一年级'),
(2, replace(uuid(), '-', ''), '二年级'),
(3, replace(uuid(), '-', ''), '三年级'),
(4, replace(uuid(), '-', ''), '四年级'),
(5, replace(uuid(), '-', ''), '五年级'),
(6, replace(uuid(), '-', ''), '六年级'),
(7, replace(uuid(), '-', ''), '七年级'),
(8, replace(uuid(), '-', ''), '八年级'),
(9, replace(uuid(), '-', ''), '九年级'),
(10, replace(uuid(), '-', ''), '高一年级'),
(11, replace(uuid(), '-', ''), '高二年级'),
(12, replace(uuid(), '-', ''), '高三年级');

CREATE TABLE xonArea (
  id VARCHAR(6) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(20) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='地区列表';

INSERT INTO xonArea VALUES ('321204', replace(uuid(), '-', ''), '泰州市姜堰区');

CREATE TABLE xonSchools (
  id VARCHAR(8) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  code VARCHAR(5) NOT NULL,
  name VARCHAR(20) NOT NULL,
  full_name VARCHAR(50) NOT NULL,
  area_id VARCHAR(6) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY name (name),
  UNIQUE KEY full_name (full_name),
  FOREIGN KEY (area_id) REFERENCES xonArea(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='集团列表';

INSERT INTO xonSchools VALUES ('32120401', replace(uuid(), '-', ''), '01', '实验小学', '泰州市姜堰区实验小学教育集团', '321204');
INSERT INTO xonSchools VALUES ('32120402', replace(uuid(), '-', ''), '02', '实验集团', '泰州市姜堰区实验中学教育集团', '321204');

/* 学校列表：可以分别设置一个学校的不同阶段（小学、初中）；不同阶段必须分开设 */
CREATE TABLE xonSchool (
  id VARCHAR(10) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(20) NOT NULL,
  schs_id VARCHAR(8) NOT NULL,
  code VARCHAR(2) NOT NULL,
  edu_type_id INT(11) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY schs_code (schs_id, code),
  FOREIGN KEY (schs_id) REFERENCES xonSchools(id),
  FOREIGN KEY (edu_type_id) REFERENCES xonEduType(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学校列表';

INSERT INTO xonSchool VALUES ('3212040202', replace(uuid(), '-', ''), '实验初中', '32120402', '02', 2);
INSERT INTO xonSchool VALUES ('3212040101', replace(uuid(), '-', ''), '北街校区', '32120401', '01', 1);

/* 学校学制：可针对不同学校设置不同的学制阶段（小初高） */
CREATE TABLE xonSchoolEdu (
  id VARCHAR(12) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  sch_id VARCHAR(10) NOT NULL,
  edu_id INT(11) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY sch_edu (sch_id, edu_id),
  FOREIGN KEY (edu_id) REFERENCES xonEdu(id),
  FOREIGN KEY (sch_id) REFERENCES xonSchool(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学校学制';

INSERT INTO xonSchoolEdu VALUES ('321204020207', replace(uuid(), '-', ''), '3212040202', 7);
INSERT INTO xonSchoolEdu VALUES ('321204020208', replace(uuid(), '-', ''), '3212040202', 8);
INSERT INTO xonSchoolEdu VALUES ('321204020209', replace(uuid(), '-', ''), '3212040202', 9);



/**
  学生与学校（学校、年度、级、年级、班级）关系表
  存在外键引用的，尽量使用数值型作主键
 */
/** 年度列表，集中管理 **/
CREATE TABLE xonYear (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='年度列表';

INSERT INTO xonYear VALUES (2010, replace(uuid(), '-', ''));
INSERT INTO xonYear VALUES (2011, replace(uuid(), '-', ''));
INSERT INTO xonYear VALUES (2012, replace(uuid(), '-', ''));
INSERT INTO xonYear VALUES (2013, replace(uuid(), '-', ''));
INSERT INTO xonYear VALUES (2014, replace(uuid(), '-', ''));
INSERT INTO xonYear VALUES (2015, replace(uuid(), '-', ''));
INSERT INTO xonYear VALUES (2016, replace(uuid(), '-', ''));
INSERT INTO xonYear VALUES (2017, replace(uuid(), '-', ''));
INSERT INTO xonYear VALUES (2018, replace(uuid(), '-', ''));
INSERT INTO xonYear VALUES (2019, replace(uuid(), '-', ''));
INSERT INTO xonYear VALUES (2020, replace(uuid(), '-', ''));
INSERT INTO xonYear VALUES (2021, replace(uuid(), '-', ''));
INSERT INTO xonYear VALUES (2022, replace(uuid(), '-', ''));


/**
  学校用户 -> 老师
 */
CREATE TABLE xonUserSchool (
  uid VARCHAR(36) NOT NULL,
  user_id VARCHAR(36) NOT NULL,
  sch_id VARCHAR(10) NOT NULL,
  PRIMARY KEY (uid),
  UNIQUE KEY user_id (user_id),
  FOREIGN KEY (user_id) REFERENCES xonUser(id),
  FOREIGN KEY (sch_id) REFERENCES xonSchool(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户注册学校';


CREATE TABLE xonSchoolCode (
  id VARCHAR(20) NOT NULL,  /* id = sch_id + code */
  uid VARCHAR(36) NOT NULL,
  sch_id VARCHAR(10) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (sch_id) REFERENCES xonSchool(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='自定义编号数据';



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

INSERT INTO `xonChild` (`id`, `uid`, `idc`, `name`) VALUES
('130524200312062037', '1d0f85969f2611e8a2e7525400f7e8d6', '130524200312062037', '秦毅'),
('130821200407027514', '1cc958b39f2611e8a2e7525400f7e8d6', '130821200407027514', '费海峰'),
('150123200312103017', '1c96eff79f2611e8a2e7525400f7e8d6', '150123200312103017', '张浩然'),
('15072319990824212X', '1d1bdc7e9f2611e8a2e7525400f7e8d6', '15072319990824212X', '申佳琪'),
('152221200406021631', '1caf539f9f2611e8a2e7525400f7e8d6', '152221200406021631', '蒋子悦'),
('211221200407060646', '1d13a9e09f2611e8a2e7525400f7e8d6', '211221200407060646', '周昭蓉'),
('320121200309300019', '1d02aa6c9f2611e8a2e7525400f7e8d6', '320121200309300019', '周熠'),
('320211200408241010', '1cae9aa89f2611e8a2e7525400f7e8d6', '320211200408241010', '梁祁睿'),
('320322200401168214', '1d1121579f2611e8a2e7525400f7e8d6', '320322200401168214', '李梓训'),
('32038220031101041X', '1cfbadaf9f2611e8a2e7525400f7e8d6', '32038220031101041X', '白家诚');

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


CREATE TABLE xonUserChilds (
  uid VARCHAR(36) NOT NULL,
  user_id VARCHAR(36) NOT NULL,
  child_id VARCHAR(20) NOT NULL,
  relation_id INT(11) NOT NULL,
  PRIMARY KEY (uid),
  UNIQUE KEY user_child (user_id, child_id),
  UNIQUE KEY child_relation (child_id, relation_id),
  FOREIGN KEY (user_id) REFERENCES xonUser(id),
  FOREIGN KEY (child_id) REFERENCES xonChild(id),
  FOREIGN KEY (relation_id) REFERENCES xonRelation(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='家长孩子';



/**
  学生报名表
  同种类型学校，只能报一所
 */
CREATE TABLE xonStudReg (
  uid VARCHAR(36) NOT NULL,
  user_id VARCHAR(36) NOT NULL,
  child_id VARCHAR(20) NOT NULL,
  edu_type_id INT(11) NOT NULL,
  sch_id VARCHAR(10) NOT NULL,
  steps_id VARCHAR(16) NOT NULL,
  confirmed BOOLEAN NOT NULL,
  stud_auth BOOLEAN,
  exam_user_id VARCHAR(36),
  confirm_user_id VARCHAR(36),
  PRIMARY KEY (child_id, edu_type_id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY child_sch (child_id, sch_id),
  FOREIGN KEY (user_id) REFERENCES xonUser(id),
  FOREIGN KEY (child_id) REFERENCES xonChild(id),
  FOREIGN KEY (edu_type_id) REFERENCES xonEduType(id),
  FOREIGN KEY (sch_id) REFERENCES xonSchool(id),
  FOREIGN KEY (steps_id) REFERENCES xonSchoolStep(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学生注册';



/* 学校年度，不同学校有不同的设置 */
CREATE TABLE xonSchoolYear (
  id VARCHAR(14) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  sch_id VARCHAR(10) NOT NULL,
  year INT(11) NOT NULL,
  is_current BOOLEAN NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY sch_year (sch_id, year),
  FOREIGN KEY (sch_id) REFERENCES xonSchool(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学校年度';

INSERT INTO xonSchoolYear VALUES ('32120402022016', replace(uuid(), '-', ''), '3212040202', 2016, 0);
INSERT INTO xonSchoolYear VALUES ('32120402022017', replace(uuid(), '-', ''), '3212040202', 2017, 0);
INSERT INTO xonSchoolYear VALUES ('32120402022018', replace(uuid(), '-', ''), '3212040202', 2018, 1);
INSERT INTO xonSchoolYear VALUES ('32120402022019', replace(uuid(), '-', ''), '3212040202', 2019, 0);

INSERT INTO xonSchoolYear VALUES ('32120401012019', replace(uuid(), '-', ''), '3212040101', 2019, 0);


/**
  分级编号，不存在双轨制。有双轨的划分 => 学校设置
  保证同轨学校并行考核
 */
CREATE TABLE xonSchoolStep (
  id VARCHAR(16) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  sch_id VARCHAR(10) NOT NULL,
  name VARCHAR(20) NOT NULL,
  code VARCHAR(2) NOT NULL,
  years_id VARCHAR(14) NOT NULL,
  graded_year INT(11) NOT NULL COMMENT '毕业年份',
  recruit_end BOOLEAN NOT NULL COMMENT '招生结束',
  graduated BOOLEAN NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (sch_id) REFERENCES xonSchool(id),
  FOREIGN KEY (years_id) REFERENCES xonSchoolYear(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='分级';

INSERT INTO xonSchoolStep VALUES ('3212040202201601', replace(uuid(), '-', ''), '3212040202', '2016级', '01', '32120402022016', 2019, 1, 0);
INSERT INTO xonSchoolStep VALUES ('3212040202201701', replace(uuid(), '-', ''), '3212040202', '2017级', '01', '32120402022017', 2020, 1, 0);
INSERT INTO xonSchoolStep VALUES ('3212040202201801', replace(uuid(), '-', ''), '3212040202', '2018级', '01', '32120402022018', 2021, 1, 0);

INSERT INTO xonSchoolStep VALUES ('3212040101201901', replace(uuid(), '-', ''), '3212040101', '2019级', '01', '32120401012019', 2022, 0, 0);

CREATE TABLE xonStudent (
  id VARCHAR(20) NOT NULL COMMENT '学生录取编号',
  uid VARCHAR(36) NOT NULL,
  child_id VARCHAR(20) NOT NULL,
  sch_id VARCHAR(10) NOT NULL,
  steps_id VARCHAR(16) NOT NULL,
  come_date DATE NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY child_sch (child_id, sch_id),     /* 增加sch_id，是为了防止重复，不可调换顺序 */
  FOREIGN KEY (child_id) REFERENCES xonChild(id),
  FOREIGN KEY (sch_id) REFERENCES xonSchool(id),
  FOREIGN KEY (steps_id) REFERENCES xonSchoolStep(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='录取学生';


/** 年级 **/
CREATE TABLE xonGrade (
  id VARCHAR(18) NOT NULL,  /* 分级编号16+学制编号2  steps_id, edu_id */
  uid VARCHAR(36) NOT NULL,
  steps_id VARCHAR(16) NOT NULL,
  years_id VARCHAR(14) NOT NULL,
  edus_id VARCHAR(12) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (steps_id) REFERENCES xonSchoolStep(id),
  FOREIGN KEY (years_id) REFERENCES xonSchoolYear(id),
  FOREIGN KEY (edus_id) REFERENCES xonSchoolEdu(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='年级';

INSERT INTO xonGrade VALUES ('321204020220160107', replace(uuid(), '-', ''), '3212040202201601', '32120402022016', '321204020207');
INSERT INTO xonGrade VALUES ('321204020220160108', replace(uuid(), '-', ''), '3212040202201601', '32120402022017', '321204020208');
INSERT INTO xonGrade VALUES ('321204020220160109', replace(uuid(), '-', ''), '3212040202201601', '32120402022018', '321204020209');
INSERT INTO xonGrade VALUES ('321204020220170107', replace(uuid(), '-', ''), '3212040202201701', '32120402022017', '321204020207');
INSERT INTO xonGrade VALUES ('321204020220170108', replace(uuid(), '-', ''), '3212040202201701', '32120402022018', '321204020208');
INSERT INTO xonGrade VALUES ('321204020220180107', replace(uuid(), '-', ''), '3212040202201801', '32120402022018', '321204020207');


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


/* 班级数据 */
INSERT INTO xonClass VALUES ('32120402022018010701', replace(uuid(), '-', ''), '321204020220180107', 1);
INSERT INTO xonClass VALUES ('32120402022018010702', replace(uuid(), '-', ''), '321204020220180107', 2);
INSERT INTO xonClass VALUES ('32120402022018010703', replace(uuid(), '-', ''), '321204020220180107', 3);
INSERT INTO xonClass VALUES ('32120402022018010704', replace(uuid(), '-', ''), '321204020220180107', 4);
INSERT INTO xonClass VALUES ('32120402022018010705', replace(uuid(), '-', ''), '321204020220180107', 5);
INSERT INTO xonClass VALUES ('32120402022018010706', replace(uuid(), '-', ''), '321204020220180107', 6);
INSERT INTO xonClass VALUES ('32120402022018010707', replace(uuid(), '-', ''), '321204020220180107', 7);
INSERT INTO xonClass VALUES ('32120402022018010708', replace(uuid(), '-', ''), '321204020220180107', 8);
INSERT INTO xonClass VALUES ('32120402022018010709', replace(uuid(), '-', ''), '321204020220180107', 9);
INSERT INTO xonClass VALUES ('32120402022018010710', replace(uuid(), '-', ''), '321204020220180107', 10);
INSERT INTO xonClass VALUES ('32120402022018010711', replace(uuid(), '-', ''), '321204020220180107', 11);
INSERT INTO xonClass VALUES ('32120402022018010712', replace(uuid(), '-', ''), '321204020220180107', 12);
INSERT INTO xonClass VALUES ('32120402022018010713', replace(uuid(), '-', ''), '321204020220180107', 13);
INSERT INTO xonClass VALUES ('32120402022018010714', replace(uuid(), '-', ''), '321204020220180107', 14);
INSERT INTO xonClass VALUES ('32120402022018010715', replace(uuid(), '-', ''), '321204020220180107', 15);
INSERT INTO xonClass VALUES ('32120402022018010716', replace(uuid(), '-', ''), '321204020220180107', 16);
INSERT INTO xonClass VALUES ('32120402022018010717', replace(uuid(), '-', ''), '321204020220180107', 17);
INSERT INTO xonClass VALUES ('32120402022018010718', replace(uuid(), '-', ''), '321204020220180107', 18);
INSERT INTO xonClass VALUES ('32120402022018010719', replace(uuid(), '-', ''), '321204020220180107', 19);
INSERT INTO xonClass VALUES ('32120402022018010720', replace(uuid(), '-', ''), '321204020220180107', 20);
INSERT INTO xonClass VALUES ('32120402022018010721', replace(uuid(), '-', ''), '321204020220180107', 21);
INSERT INTO xonClass VALUES ('32120402022018010722', replace(uuid(), '-', ''), '321204020220180107', 22);
INSERT INTO xonClass VALUES ('32120402022018010723', replace(uuid(), '-', ''), '321204020220180107', 23);
INSERT INTO xonClass VALUES ('32120402022018010724', replace(uuid(), '-', ''), '321204020220180107', 24);
INSERT INTO xonClass VALUES ('32120402022018010725', replace(uuid(), '-', ''), '321204020220180107', 25);
INSERT INTO xonClass VALUES ('32120402022018010726', replace(uuid(), '-', ''), '321204020220180107', 26);
INSERT INTO xonClass VALUES ('32120402022017010801', replace(uuid(), '-', ''), '321204020220170108', 1);
INSERT INTO xonClass VALUES ('32120402022017010802', replace(uuid(), '-', ''), '321204020220170108', 2);
INSERT INTO xonClass VALUES ('32120402022017010803', replace(uuid(), '-', ''), '321204020220170108', 3);
INSERT INTO xonClass VALUES ('32120402022017010804', replace(uuid(), '-', ''), '321204020220170108', 4);
INSERT INTO xonClass VALUES ('32120402022017010805', replace(uuid(), '-', ''), '321204020220170108', 5);
INSERT INTO xonClass VALUES ('32120402022017010806', replace(uuid(), '-', ''), '321204020220170108', 6);
INSERT INTO xonClass VALUES ('32120402022017010807', replace(uuid(), '-', ''), '321204020220170108', 7);
INSERT INTO xonClass VALUES ('32120402022017010808', replace(uuid(), '-', ''), '321204020220170108', 8);
INSERT INTO xonClass VALUES ('32120402022017010809', replace(uuid(), '-', ''), '321204020220170108', 9);
INSERT INTO xonClass VALUES ('32120402022017010810', replace(uuid(), '-', ''), '321204020220170108', 10);
INSERT INTO xonClass VALUES ('32120402022017010811', replace(uuid(), '-', ''), '321204020220170108', 11);
INSERT INTO xonClass VALUES ('32120402022017010812', replace(uuid(), '-', ''), '321204020220170108', 12);
INSERT INTO xonClass VALUES ('32120402022017010813', replace(uuid(), '-', ''), '321204020220170108', 13);
INSERT INTO xonClass VALUES ('32120402022017010814', replace(uuid(), '-', ''), '321204020220170108', 14);
INSERT INTO xonClass VALUES ('32120402022017010815', replace(uuid(), '-', ''), '321204020220170108', 15);
INSERT INTO xonClass VALUES ('32120402022017010816', replace(uuid(), '-', ''), '321204020220170108', 16);
INSERT INTO xonClass VALUES ('32120402022017010817', replace(uuid(), '-', ''), '321204020220170108', 17);
INSERT INTO xonClass VALUES ('32120402022017010818', replace(uuid(), '-', ''), '321204020220170108', 18);
INSERT INTO xonClass VALUES ('32120402022017010819', replace(uuid(), '-', ''), '321204020220170108', 19);
INSERT INTO xonClass VALUES ('32120402022017010820', replace(uuid(), '-', ''), '321204020220170108', 20);
INSERT INTO xonClass VALUES ('32120402022017010821', replace(uuid(), '-', ''), '321204020220170108', 21);
INSERT INTO xonClass VALUES ('32120402022017010822', replace(uuid(), '-', ''), '321204020220170108', 22);
INSERT INTO xonClass VALUES ('32120402022016010901', replace(uuid(), '-', ''), '321204020220160109', 1);
INSERT INTO xonClass VALUES ('32120402022016010902', replace(uuid(), '-', ''), '321204020220160109', 2);
INSERT INTO xonClass VALUES ('32120402022016010903', replace(uuid(), '-', ''), '321204020220160109', 3);
INSERT INTO xonClass VALUES ('32120402022016010904', replace(uuid(), '-', ''), '321204020220160109', 4);
INSERT INTO xonClass VALUES ('32120402022016010905', replace(uuid(), '-', ''), '321204020220160109', 5);
INSERT INTO xonClass VALUES ('32120402022016010906', replace(uuid(), '-', ''), '321204020220160109', 6);
INSERT INTO xonClass VALUES ('32120402022016010907', replace(uuid(), '-', ''), '321204020220160109', 7);
INSERT INTO xonClass VALUES ('32120402022016010908', replace(uuid(), '-', ''), '321204020220160109', 8);
INSERT INTO xonClass VALUES ('32120402022016010909', replace(uuid(), '-', ''), '321204020220160109', 9);
INSERT INTO xonClass VALUES ('32120402022016010910', replace(uuid(), '-', ''), '321204020220160109', 10);
INSERT INTO xonClass VALUES ('32120402022016010911', replace(uuid(), '-', ''), '321204020220160109', 11);
INSERT INTO xonClass VALUES ('32120402022016010912', replace(uuid(), '-', ''), '321204020220160109', 12);
INSERT INTO xonClass VALUES ('32120402022016010913', replace(uuid(), '-', ''), '321204020220160109', 13);
INSERT INTO xonClass VALUES ('32120402022016010914', replace(uuid(), '-', ''), '321204020220160109', 14);
INSERT INTO xonClass VALUES ('32120402022016010915', replace(uuid(), '-', ''), '321204020220160109', 15);
INSERT INTO xonClass VALUES ('32120402022016010916', replace(uuid(), '-', ''), '321204020220160109', 16);
INSERT INTO xonClass VALUES ('32120402022016010917', replace(uuid(), '-', ''), '321204020220160109', 17);
INSERT INTO xonClass VALUES ('32120402022016010918', replace(uuid(), '-', ''), '321204020220160109', 18);
INSERT INTO xonClass VALUES ('32120402022016010919', replace(uuid(), '-', ''), '321204020220160109', 19);
INSERT INTO xonClass VALUES ('32120402022016010920', replace(uuid(), '-', ''), '321204020220160109', 20);
INSERT INTO xonClass VALUES ('32120402022016010921', replace(uuid(), '-', ''), '321204020220160109', 21);
INSERT INTO xonClass VALUES ('32120402022016010922', replace(uuid(), '-', ''), '321204020220160109', 22);




/** 年级对应分组名称，分类统计用 **/
CREATE TABLE xonGradeGroup (
  id VARCHAR(20) NOT NULL,  /*年级编号18 + 分组序号2*/
  uid VARCHAR(36) NOT NULL,
  grade_id VARCHAR(18) NOT NULL,
  name VARCHAR(20) NOT NULL,  /* 分组名称：智慧班、普通班 */
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (grade_id) REFERENCES xonGrade(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='年级分组设置';

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
  name VARCHAR(20) NOT NULL,
  short VARCHAR(1) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY name (name),
  UNIQUE KEY short (short)
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
INSERT INTO xonSub VALUES (12, replace(uuid(), '-', ''), '艺术', '艺');
INSERT INTO xonSub VALUES (13, replace(uuid(), '-', ''), '体育', '体');
INSERT INTO xonSub VALUES (14, replace(uuid(), '-', ''), '信息', '信');
INSERT INTO xonSub VALUES (15, replace(uuid(), '-', ''), '听力', '听');
INSERT INTO xonSub VALUES (16, replace(uuid(), '-', ''), '口语', '口');
INSERT INTO xonSub VALUES (99, replace(uuid(), '-', ''), '总分', '总');




/** 学籍来源 **/
CREATE TABLE xonStudType (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(10) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学生来源';

INSERT INTO xonStudType VALUES (1, replace(uuid(), '-', ''), '应届生');
INSERT INTO xonStudType VALUES (2, replace(uuid(), '-', ''), '往届生');

CREATE TABLE xonStudStatus (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(10) NOT NULL,
  ico_name VARCHAR(20),
  in_sch BOOLEAN NOT NULL,  /* 进、出学校 true:come; false:go */
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学籍状态';

INSERT INTO `xonStudStatus` (`id`, `uid`, `name`, `ico_name`, `in_sch`) VALUES
(1, '9a0c0387f22911e8915f52540008328e', '正常', NULL, 1),
(2, '9a0f9d32f22911e8915f52540008328e', '复学', 'stud_return', 1),
(3, '9a133e50f22911e8915f52540008328e', '转入', 'stud_come', 1),
(4, '9a1425a4f22911e8915f52540008328e', '借读', 'stud_read', 1),
(5, '9a1504bff22911e8915f52540008328e', '重读', 'stud_repetition', 1),
(21, '9a15e411f22911e8915f52540008328e', '休学', 'stud_down', 0),
(22, '9a16c4dcf22911e8915f52540008328e', '转出', 'stud_out', 0),
(23, '9a17a6c5f22911e8915f52540008328e', '离校', 'stud_leave', 0),
(99, '9a188512f22911e8915f52540008328e', '临时', 'stud_temp', 0);

/** 年级学生，报名审核的时候根据家长登记的学生信息，满足条件添加 **/
CREATE TABLE xonGradeStud (
	id VARCHAR(22) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  grade_id VARCHAR(18) NOT NULL,
  cls_id VARCHAR(20) NOT NULL,
  stud_id VARCHAR(20) NOT NULL,   /* 录取编号 */
  stud_type_id INT(11) NOT NULL,  /* 学生来源：应、往届生 */
  stud_status_id INT(11) NOT NULL,  /* 学籍状态 */
  stud_auth BOOLEAN NOT NULL,  /* 是否指标生 */
  same_group BOOLEAN NOT NULL,  /* 同组标志 */
  stud_code VARCHAR(36),  /* 学籍号，应届生有，往届生无 */
  stud_diploma varchar(36),   /* 毕业证书号码 */
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY grade_stud (grade_id, stud_id),
  FOREIGN KEY (grade_id) REFERENCES xonGrade(id),
  FOREIGN KEY (cls_id) REFERENCES xonClass(id),
  FOREIGN KEY (stud_id) REFERENCES xonStudent(id),
  FOREIGN KEY (stud_type_id) REFERENCES xonStudType(id),
  FOREIGN KEY (stud_status_id) REFERENCES xonStudStatus(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='年度学生';


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





CREATE TABLE xonToken (
  id VARCHAR(20) NOT NULL,
  access_token VARCHAR(1024) NOT NULL,
  expires_in INT(11) NOT NULL,
  create_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='请求参数';



/**
  * 增加的
  学生手续办理
 */

CREATE TABLE xonStudTrans (
  id INT(11) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(20) NOT NULL,  /* 办理手续的文件名称 */
  title varchar(10) not null,
  need_exam BOOLEAN NOT NULL,  /* 需要审核 */
  stud_status_id int(11) not null,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  unique key title (title),
  FOREIGN KEY (stud_status_id) REFERENCES xonStudStatus(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学籍办理分类';

INSERT INTO xonStudTrans VALUES (1, replace(uuid(), '-', ''), 'stud_add', '新增', 0, 1);
INSERT INTO xonStudTrans VALUES (2, replace(uuid(), '-', ''), 'stud_move', '调动', 0, 1);
INSERT INTO xonStudTrans VALUES (3, replace(uuid(), '-', ''), 'stud_jump', '跳级', 1, 1);
INSERT INTO xonStudTrans VALUES (4, replace(uuid(), '-', ''), 'stud_return', '复学', 1, 2);
INSERT INTO xonStudTrans VALUES (5, replace(uuid(), '-', ''), 'stud_come', '区县', 1, 3);
INSERT INTO xonStudTrans VALUES (6, replace(uuid(), '-', ''), 'stud_come', '跨市', 1, 3);
INSERT INTO xonStudTrans VALUES (7, replace(uuid(), '-', ''), 'stud_come', '跨省', 1, 3);
INSERT INTO xonStudTrans VALUES (8, replace(uuid(), '-', ''), 'stud_read', '借读', 1, 4);
INSERT INTO xonStudTrans VALUES (9, replace(uuid(), '-', ''), 'stud_repetition', '重读', 1, 5);
INSERT INTO xonStudTrans VALUES (10, replace(uuid(), '-', ''), 'stud_down', '休学', 1, 21);
INSERT INTO xonStudTrans VALUES (11, replace(uuid(), '-', ''), 'stud_out', '转出', 1, 22);
INSERT INTO xonStudTrans VALUES (12, replace(uuid(), '-', ''), 'stud_leave', '离校', 0, 23);
INSERT INTO xonStudTrans VALUES (99, replace(uuid(), '-', ''), 'stud_temp', '临时', 0, 99);


CREATE TABLE xonGradeStudTask (
  uid VARCHAR(36) NOT NULL,
  grade_stud_id VARCHAR(22) NOT NULL,
  stud_status_id INT(11) NOT NULL,
  task_status_id INT(11) NOT NULL,
  task_memo VARCHAR(2000) NOT NULL,
  has_done BOOLEAN NOT NULL,
  PRIMARY KEY (grade_stud_id, stud_status_id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (grade_stud_id) REFERENCES xonGradeStud(id),
  FOREIGN KEY (stud_status_id) REFERENCES xonStudStatus(id),
  FOREIGN KEY (task_status_id) REFERENCES xonStudStatus(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学生变更任务';



/** 表单相关 **/
CREATE TABLE xonForm (
  id VARCHAR(14) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  name VARCHAR(20) NOT NULL,
  sch_id VARCHAR(10) NOT NULL,
  years_id VARCHAR(14) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (sch_id) REFERENCES xonSchool(id),
  FOREIGN KEY (years_id) REFERENCES xonSchoolYear(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='表单列表';



CREATE TABLE xonFormField (
  id VARCHAR(18) NOT NULL,
  uid VARCHAR(36) NOT NULL,
  form_id VARCHAR(14) NOT NULL,
  name VARCHAR(20) NOT NULL,
  title VARCHAR(20) NOT NULL,
  need_message boolean NOT NULL,

  required boolean NOT NULL,
  tel boolean NOT NULL,
  date boolean NOT NULL,
  number boolean NOT NULL,
  digits boolean NOT NULL,
  chinese boolean NOT NULL,
  idcard boolean NOT NULL,
  idcardrange VARCHAR(100),
  equalTo VARCHAR(100),
  contains VARCHAR(100),
  minlength int(11),
  maxlength int(11),
  rangelength VARCHAR(100),
  min int(11),
  max int(11),
  ranger VARCHAR(100),
  custom VARCHAR(100),

  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (form_id) REFERENCES xonForm(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='表单字段';



CREATE TABLE xonFormValue (
  uid VARCHAR(36) NOT NULL,
  user_id VARCHAR(36) NOT NULL,
  field_id VARCHAR(18) NOT NULL,
  checked boolean NOT NULL,
  value VARCHAR(200),

  PRIMARY KEY (user_id, field_id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (user_id) REFERENCES xonUser(id),
  FOREIGN KEY (field_id) REFERENCES xonFormField(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='表单数据';





/**
  作为查询基类用，不得删除
 */
create view vAppinfo
as select * from cAppinfo;


/**
  视图：非管理用户查询
 */
CREATE VIEW xovUser
AS
SELECT a.*, y.sch_id, z.name as sch_name
FROM xonUser a 
LEFT JOIN xonUserSchool y on a.id = y.user_id
LEFT JOIN xonSchool z on y.sch_id = z.id
WHERE a.id NOT IN (SELECT user_id FROM xonUserGroup WHERE group_id = 99);

/**
  视图：非管理用户，且不是老师（仅仅是普通用户）
 */
CREATE VIEW xovUserOnly
AS
  SELECT *
  FROM xovUser a
  WHERE a.id NOT IN (
    SELECT user_id FROM xonUserSchool
  );

/**
  视图：用户权限
 */
CREATE VIEW xovUserRole
AS
  SELECT a.*, b.name as role_name, b.title as role_title
  FROM (
    SELECT DISTINCT user_id, role_id
    FROM xonUserGroup c INNER JOIN xonGroupRole d ON c.group_id = d.group_id
  ) a LEFT JOIN xonRole b on a.role_id = b.id;

/**
  视图：查询组用户信息
 */
CREATE VIEW xovUserGroup
AS
  SELECT a.*, b.name as user_name, nick_name, b.sch_id
  FROM xonUserGroup a 
  INNER JOIN xovUser b ON a.user_id = b.id;

/**
  视图：查询我的孩子
 */
 CREATE VIEW xovUserChilds
 AS
  SELECT a.*,
    c.uid as child_uid, c.idc as child_idc, c.name as child_name,
    d.name as child_relation
  FROM xonUserChilds a
  LEFT JOIN xonChild c on a.child_id = c.id
  LEFT JOIN xonRelation d on a.relation_id = d.id;






/**
  分班考试
 */
CREATE VIEW xovKaoDivision
AS
  SELECT *
  FROM xonKao
  WHERE to_division = 1;



/**
  孩子性别
 */
CREATE VIEW xovChild
AS
  SELECT A.*, case
      when CHAR_LENGTH(idc) = 10 then IF(MOD(SUBSTRING(idc, 2, 1), 2), '男', '女')
      when CHAR_LENGTH(idc) = 18 then IF(MOD(SUBSTRING(idc, 17, 1), 2), '男', '女')
    else '女' end as sex_name,
    case
      when CHAR_LENGTH(idc) = 10 then IF(MOD(SUBSTRING(idc, 2, 1), 2), 1, 0)
      when CHAR_LENGTH(idc) = 18 then IF(MOD(SUBSTRING(idc, 17, 1), 2), 1, 0)
    else 0 end as sex_num
  FROM xonChild A;

CREATE VIEW xovSchoolEdu
AS
  SELECT a.*, b.name as edus_name
  FROM xonSchoolEdu a
  LEFT JOIN xonEdu b ON a.edu_id = b.id;

CREATE VIEW xovSchools
as
  select a.*, b.name as area_name
  from xonSchools a
  left join xonArea b on a.area_id = b.id;

CREATE VIEW xovSchool
AS
  SELECT a.*,
    concat(b.name, '-', a.name) as schs_name, b.area_id, b.area_name,
    c.name as edu_type_name
  FROM xonSchool a
  LEFT JOIN xovSchools b on a.schs_id = b.id
  LEFT JOIN xonEduType c ON a.edu_type_id = c.id;

CREATE VIEW xovSchoolStep
	AS
	SELECT ss.*, sy.year as come_year,
    concat(sc.schs_name, '-', ss.name) as steps_name,
    sc.schs_name, sc.edu_type_id, sc.edu_type_name, sc.area_id
	FROM xonSchoolStep ss 
	LEFT JOIN xovSchool sc on ss.sch_id = sc.id
  LEFT JOIN xonSchoolYear sy on ss.years_id = sy.id;

/**
  学校学生
 */

CREATE VIEW xovStudent
AS
  SELECT A.*, substring(A.id, -4) as reg_no,
    C2.idc as stud_idc, C2.name as stud_name, C2.sex_name, C2.sex_num,
    S.steps_name, S.schs_name, S.come_year, S.edu_type_name
  FROM xonStudent A
  LEFT JOIN xovChild C2 ON A.child_id = C2.id
  LEFT JOIN xovSchoolStep S ON A.steps_id = S.id;


CREATE VIEW xovStudReg
AS
  SELECT a.*, 
    S.schs_name, S.edu_type_name, S.steps_name,
    C2.uid as child_uid, C2.name as child_name, C2.idc as child_idc,
    U.name as exam_user_name, U2.name as confirm_user_name,
    au.name as auth_name
  FROM xonStudReg a
  LEFT JOIN xovSchoolStep S on a.steps_id = S.id
  LEFT JOIN xovChild C2 on a.child_id = C2.id
  LEFT JOIN xonUser U on a.exam_user_id = U.id
  LEFT JOIN xonUser U2 on a.confirm_user_id = U2.id
  LEFT JOIN xonAuth au on a.stud_auth = au.id;

CREATE VIEW xovUserChildsReg
AS
SELECT a.user_id AS my_user_id, b.*
FROM xonUserChilds a INNER JOIN xovStudReg b
ON a.child_id = b.child_id;




/**
  年级
 */
CREATE VIEW xovGrade
AS
  SELECT A.*,
    S.sch_id, S.schs_name, S.name as step_name, S.edu_type_name, S.graduated,
    B.year as grade_year, B.is_current,
    E.edus_name as grade_name
  FROM xonGrade A
  INNER JOIN xonSchoolYear B ON A.years_id = B.id
  INNER JOIN xovSchoolEdu E ON A.edus_id = E.id
  inner join xovSchoolStep S on A.steps_id = S.id;

/**
  当前年级
 */

CREATE VIEW xovGradeCurrent
AS
  SELECT *
  FROM xovGrade A
  WHERE is_current = 1;

/**
  班级列表
 */
CREATE VIEW xovClass
AS
  SELECT A.*, concat(B.grade_name, '（', A.num, '）班') as cls_name, concat('条号：', right(A.id, 2)) as cls_order
  FROM xonClass A
  left join xovGrade B on A.grade_id = B.id;

/**
  班级学生(在校学生信息)
 */
CREATE VIEW xovGradeStud
AS
  SELECT A.*,
    S.steps_name, S.child_id, S.stud_idc, S.stud_name, S.sex_name, S.sex_num, 
    t.name as type_name,
    C.name AS status_name, C.ico_name, C.in_sch, 
    gg.edu_type_name, gg.schs_name, gg.grade_name, gg.is_current, gg.graduated,
    C2.num as cls_num, C2.cls_name, C2.cls_order
  FROM xonGradeStud A
  LEFT JOIN xovStudent S ON A.stud_id = S.id
  left join xonStudType t on A.stud_type_id = t.id
  LEFT JOIN xonStudStatus C ON A.stud_status_id = C.id
  left join xovGrade gg on A.grade_id = gg.id
  LEFT JOIN xovClass C2 ON A.cls_id = C2.id;



/**

*/
CREATE VIEW xovGradeStudented
as
	select a.*
	from xonGradeStud a;

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
    SELECT C.*, S.sub_id, B.name AS sub_name, B.short AS sub_shortname, S.value, to_division
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



CREATE VIEW xovGradeStudTask
AS
  SELECT a.*, s.name as stud_status_name, s.ico_name as stud_ico_name, t.name as task_status_name, t.ico_name as task_ico_name, b.stud_name, b.sex_name, b.grade_id, b.cls_id, b.cls_name, b.stud_id, b.stud_type_id, b.stud_auth, b.stud_code, b.stud_diploma
  FROM xonGradeStudTask a 
  LEFT JOIN xovGradeStud b on a.grade_stud_id = b.id
  LEFT JOIN xonStudStatus s on a.stud_status_id = s.id
  LEFT JOIN xonStudStatus t on a.task_status_id = t.id;




/*外键约束开启*/
SET FOREIGN_KEY_CHECKS = 1;
