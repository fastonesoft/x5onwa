
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
CREATE TABLE xonRoleType (
	id INT(11) NOT NULL,
	uid VARCHAR(60) NOT NULL,
	name VARCHAR(20) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE KEY uid (uid),
	UNIQUE KEY name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='权限分类';

INSERT INTO xonRoleType VALUES (1, replace(uuid(), '-', ''), '报名');
INSERT INTO xonRoleType VALUES (2, replace(uuid(), '-', ''), '学籍');
INSERT INTO xonRoleType VALUES (3, replace(uuid(), '-', ''), '考试');

CREATE TABLE xonRole (
	id INT(11) NOT NULL,
	uid VARCHAR(60) NOT NULL,
	name VARCHAR(20) NOT NULL,
	title VARCHAR(20) NOT NULL,
	can_show BOOLEAN NOT NULL,  /*没有权限时，是否可以显示*/
	role_type_id INT(11) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE KEY uid (uid),
	UNIQUE KEY name (name),
	FOREIGN KEY (role_type_id) REFERENCES xonRoleType(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='权限列表';

INSERT INTO xonRole VALUES (1, replace(uuid(), '-', ''), 'stud', '学生查询', 1, 2);
INSERT INTO xonRole VALUES (2, replace(uuid(), '-', ''), 'sub', '课表查询', 1, 2);
INSERT INTO xonRole VALUES (3, replace(uuid(), '-', ''), 'kao', '考试安排', 1, 3);
INSERT INTO xonRole VALUES (4, replace(uuid(), '-', ''), 'score', '成绩查询', 1,3);

CREATE TABLE xonGroup (
	id INT(11) NOT NULL,
	uid VARCHAR(60) NOT NULL,
	name VARCHAR(20) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE KEY uid (uid),
	UNIQUE KEY name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='分组列表';

INSERT INTO xonGroup VALUES (1, replace(uuid(), '-', ''), '学生家长');
INSERT INTO xonGroup VALUES (2, replace(uuid(), '-', ''), '科任老师');
INSERT INTO xonGroup VALUES (3, replace(uuid(), '-', ''), '班级主管');
INSERT INTO xonGroup VALUES (4, replace(uuid(), '-', ''), '学科主管');
INSERT INTO xonGroup VALUES (5, replace(uuid(), '-', ''), '年级主管');
INSERT INTO xonGroup VALUES (6, replace(uuid(), '-', ''), '学校管理');
INSERT INTO xonGroup VALUES (7, replace(uuid(), '-', ''), '集团管理');
INSERT INTO xonGroup VALUES (99, replace(uuid(), '-', ''), '系统管理');

CREATE TABLE xonGroupRole (
	group_id INT(11) NOT NULL,
	role_id INT(11) NOT NULL,
	uid VARCHAR(60) NOT NULL,
	has_role BOOLEAN NOT NULL,
	PRIMARY KEY (group_id, role_id),
	UNIQUE KEY uid (uid),
	FOREIGN KEY (group_id) REFERENCES xonGroup(id),
	FOREIGN KEY (role_id) REFERENCES xonRole(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='分组权限';

CREATE TABLE xonUser (
  uid VARCHAR(60) NOT NULL,  /*uniond*/
  name VARCHAR(60) NOT NULL,
  mobil VARCHAR(20),  /*绑定学生时，检测是否为空*/
  fixed BOOLEAN NOT NULL DEFAULT 0,
  is_teacher BOOLEAN NOT NULL DEFAULT 0,
  create_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  last_visit_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户列表';

CREATE TABLE xonUserGroup (
  user_uid VARCHAR(60) NOT NULL,
  group_id INT(11) NOT NULL,
  uid VARCHAR(60) NOT NULL,
  PRIMARY KEY (user_uid, group_id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (user_uid) REFERENCES xonUser(uid),
  FOREIGN KEY (group_id) REFERENCES xonGroup(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='分组用户';

CREATE TABLE xonEduType (
  id INT(11) NOT NULL,
  uid VARCHAR(60) NOT NULL,
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
  uid VARCHAR(60) NOT NULL,
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

CREATE TABLE xonSchool (
  id VARCHAR(10) NOT NULL,
  uid VARCHAR(60) NOT NULL,
  name VARCHAR(20) NOT NULL,
  full_name VARCHAR(100) NOT NULL,
  edu_type_id INT(11) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY name (name),
  UNIQUE KEY full_name (full_name),
  FOREIGN KEY (edu_type_id) REFERENCES xonEduType(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学校列表';

INSERT INTO xonSchool VALUES ('32128402', replace(uuid(), '-', ''), '实验初中', '泰州市姜堰区实验初级中学', 2);

CREATE TABLE xonUserSch (
  user_uid VARCHAR(60) NOT NULL,
  edu_type_id INT(11) NOT NULL,
  sch_id VARCHAR(10) NOT NULL,
  uid VARCHAR(60) NOT NULL,
  current_sch BOOLEAN NOT NULL,
  PRIMARY KEY (user_uid, edu_type_id),  /*同类学校只能注册一个*/
  UNIQUE KEY uid (uid),
  FOREIGN KEY (user_uid) REFERENCES xonUser(uid),
  FOREIGN KEY (edu_type_id) REFERENCES xonEduType(id),
  FOREIGN KEY (sch_id) REFERENCES xonSchool(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户注册的学校';

CREATE TABLE xonStudent (
  id VARCHAR(20) NOT NULL,  /* 分级编号 + 学生序号 */
  uid VARCHAR(60) NOT NULL,
  step_id VARCHAR(16) NOT NULL,
  idc VARCHAR(20) NOT NULL,
  name VARCHAR(20) NOT NULL,
  mobil VARCHAR(20),  /*用来记录学生绑定用户的联系电话，只有爸爸、妈妈的电话才会记录*/
  mobil2 VARCHAR(20),
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY idc (idc),
  FOREIGN KEY (step_id) REFERENCES xonStep(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学生表';

CREATE TABLE xonRelation (
  id INT(11) NOT NULL,
  uid VARCHAR(60) NOT NULL,
  name VARCHAR(20) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='关系表';

INSERT INTO xonRelation VALUES (1, replace(uuid(), '-', ''), '爸爸');
INSERT INTO xonRelation VALUES (2, replace(uuid(), '-', ''), '妈妈');
INSERT INTO xonRelation VALUES (3, replace(uuid(), '-', ''), '亲戚');
INSERT INTO xonRelation VALUES (4, replace(uuid(), '-', ''), '朋友');

/**
  用户与学生的关系表
  可以根据与不同学生的关系，关注不同的学生
 */
CREATE TABLE xonUserStud (
  user_uid VARCHAR(60) NOT NULL,
  stud_id VARCHAR(20) NOT NULL,
  relation_id INT(11) NOT NULL,
  uid VARCHAR(60) NOT NULL,
  pay_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  pay_day INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (user_uid, stud_id, relation_id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (user_uid) REFERENCES xonUser(uid),
  FOREIGN KEY (stud_id) REFERENCES xonStudent(uid),
  FOREIGN KEY (relation_id) REFERENCES xonRelation(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户学生表';

/**
  学生与学校（学校、年度、级、年级、班级）关系表
  存在外键引用的，尽量使用数值型作主键
 */
/** 年度 **/
CREATE TABLE xonYear (
  id INT(11) NOT NULL,
  uid VARCHAR(60) NOT NULL,
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
INSERT INTO xonYear VALUES (2017, replace(uuid(), '-', ''), 1);
INSERT INTO xonYear VALUES (2018, replace(uuid(), '-', ''), 0);

/**
  分级编号 定义规则：
  同年进，同年出，不需要分级
  同年进，异年出，分级定义
  比如，完中：一年级，七年级，这种类型学校的分级，就必须要分
 */
CREATE TABLE xonStep (
  id VARCHAR(16) NOT NULL,  /*学校10+分级序号6（2018、201801）*/
  uid VARCHAR(60) NOT NULL,
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
  uid VARCHAR(60) NOT NULL,
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
  uid VARCHAR(60) NOT NULL,
  grade_id VARCHAR(18) NOT NULL,
  num VARCHAR(2) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (grade_id) REFERENCES xonGrade(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='班级';

/** 年级对应分组名称，分类统计用 **/
CREATE TABLE xonGradeGroup (
  id VARCHAR(20) NOT NULL,  /*年级编号18 + 分组序号2(CONCAT(grade_id, num))*/
  uid VARCHAR(60) NOT NULL,
  grade_id VARCHAR(18) NOT NULL,
  num VARCHAR(2) NOT NULL,  /* 分组序号 */
  name VARCHAR(20) NOT NULL,  /* 分组名称：智慧班、普通班 */
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (grade_id) REFERENCES xonGrade(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='年级对应分组';

/** 分组对应班级，分类统计用 **/
CREATE TABLE xonClassGroup (
  uid VARCHAR(60) NOT NULL,
  grade_group_id VARCHAR(20) NOT NULL,
  cls_id VARCHAR(20) NOT NULL,
  PRIMARY KEY (uid),
  FOREIGN KEY (cls_id) REFERENCES xonClass(id),
  FOREIGN KEY (grade_group_id) REFERENCES xonGradeGroup(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='分组对应班级';

/** 年级教师 **/
CREATE TABLE xonGradeUser (
  uid VARCHAR(60) NOT NULL,
  grade_id VARCHAR(18) NOT NULL,
  user_uid VARCHAR(60) NOT NULL,
  PRIMARY KEY (uid),
  FOREIGN KEY (grade_id) REFERENCES xonGrade(id),
  FOREIGN KEY (user_uid) REFERENCES xonUser(uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='年级教师';

/** 班级教师 **/
CREATE TABLE xonClassUser (
  uid VARCHAR(60) NOT NULL,
  cls_id VARCHAR(18) NOT NULL,
  sub_id INT(11) NOT NULL,
  user_uid VARCHAR(60) NOT NULL,
  is_master BOOLEAN NOT NULL,
  PRIMARY KEY (cls_id, sub_id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (sub_id) REFERENCES xonSub(id),
  FOREIGN KEY (user_uid) REFERENCES xonUser(uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='班级教师';

/** 学科设置 **/
CREATE TABLE xonSub (
  id INT(11) NOT NULL,
  uid VARCHAR(60) NOT NULL,
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
  uid VARCHAR(60) NOT NULL,
  name VARCHAR(10) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学籍状态';

INSERT INTO xonStudType VALUES (1, replace(uuid(), '-', ''), '应届生');
INSERT INTO xonStudType VALUES (2, replace(uuid(), '-', ''), '往届生');

/** 学籍办理信息 **/
CREATE TABLE xonStudCome (
  id INT(11) NOT NULL,
  uid VARCHAR(60) NOT NULL,
  name VARCHAR(10) NOT NULL,
  name_display BOOLEAN NOT NULL,
  stud_come_id INT(11) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  FOREIGN KEY (stud_come_id) REFERENCES xonStudCome(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学籍办理信息';

INSERT INTO xonStudCome VALUES (1, replace(uuid(), '-', ''), '正常', 0, 1);
INSERT INTO xonStudCome VALUES (2, replace(uuid(), '-', ''), '休复', 1, 1);
INSERT INTO xonStudCome VALUES (3, replace(uuid(), '-', ''), '转入', 1, 1);
INSERT INTO xonStudCome VALUES (4, replace(uuid(), '-', ''), '跨省', 1, 1);
INSERT INTO xonStudCome VALUES (5, replace(uuid(), '-', ''), '借读', 1, 1);
INSERT INTO xonStudCome VALUES (6, replace(uuid(), '-', ''), '重读', 1, 2);

/** 学籍变更信息 **/
CREATE TABLE xonStudOut (
  id INT(11) NOT NULL,
  uid VARCHAR(60) NOT NULL,
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
  uid VARCHAR(60) NOT NULL,
  grade_id VARCHAR(18) NOT NULL,
  cls_id VARCHAR(20) NOT NULL,
  stud_id VARCHAR(20) NOT NULL,
  stud_type_id INT(11) NOT NULL,  /* 学籍状态：应届生、往届生 */
  stud_come_id INT(11) NOT NULL,  /* 学籍办理信息 */
  in_sch BOOLEAN NOT NULL,
  auth_stud BOOLEAN NOT NULL,  /* 是否指标生 */
  same_group VARCHAR(60),  /* 同组标志 */
  stud_code VARCHAR(60),  /* 学籍号，应届生有，往届生无 */
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
  uid VARCHAR(60) NOT NULL,
  grade_stud_id VARCHAR(22) NOT NULL,
  stud_out_id INT(11) NOT NULL,
  begin_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,  /* 手续开启时间 */
  end_time INT(11) NOT NULL DEFAULT 0,  /* 多长时间到期提醒 */
  done BOOLEAN NOT NULL DEFAULT 0,
  memo VARCHAR(60) DEFAULT NULL,
  PRIMARY KEY (uid),
  FOREIGN KEY (grade_stud_id) REFERENCES xonGradeStud(id),
  FOREIGN KEY (stud_out_id) REFERENCES xonStudOut(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='年级学生变更';




/*分级数据*/
INSERT INTO xonStep VALUES ('321284022004', replace(uuid(), '-', ''), '2004级', '32128402', 1);
INSERT INTO xonStep VALUES ('321284022005', replace(uuid(), '-', ''), '2005级', '32128402', 1);
INSERT INTO xonStep VALUES ('321284022006', replace(uuid(), '-', ''), '2006级', '32128402', 1);
INSERT INTO xonStep VALUES ('321284022007', replace(uuid(), '-', ''), '2007级', '32128402', 1);
INSERT INTO xonStep VALUES ('321284022008', replace(uuid(), '-', ''), '2008级', '32128402', 1);
INSERT INTO xonStep VALUES ('321284022009', replace(uuid(), '-', ''), '2009级', '32128402', 1);
INSERT INTO xonStep VALUES ('321284022010', replace(uuid(), '-', ''), '2010级', '32128402', 1);
INSERT INTO xonStep VALUES ('321284022011', replace(uuid(), '-', ''), '2011级', '32128402', 1);
INSERT INTO xonStep VALUES ('321284022012', replace(uuid(), '-', ''), '2012级', '32128402', 1);
INSERT INTO xonStep VALUES ('321284022013', replace(uuid(), '-', ''), '2013级', '32128402', 1);
INSERT INTO xonStep VALUES ('321284022014', replace(uuid(), '-', ''), '2014级', '32128402', 1);
INSERT INTO xonStep VALUES ('321284022015', replace(uuid(), '-', ''), '2015级', '32128402', 0);
INSERT INTO xonStep VALUES ('321284022016', replace(uuid(), '-', ''), '2016级', '32128402', 0);
INSERT INTO xonStep VALUES ('321284022017', replace(uuid(), '-', ''), '2017级', '32128402', 0);
INSERT INTO xonStep VALUES ('321284022018', replace(uuid(), '-', ''), '2018级', '32128402', 0);

/*年级数据*/
INSERT INTO xonGrade VALUES ('32128402200409', replace(uuid(), '-', ''), '321284022004', 2006, 9);
INSERT INTO xonGrade VALUES ('32128402200508', replace(uuid(), '-', ''), '321284022005', 2006, 8);
INSERT INTO xonGrade VALUES ('32128402200509', replace(uuid(), '-', ''), '321284022005', 2007, 9);
INSERT INTO xonGrade VALUES ('32128402200607', replace(uuid(), '-', ''), '321284022006', 2006, 7);
INSERT INTO xonGrade VALUES ('32128402200608', replace(uuid(), '-', ''), '321284022006', 2007, 8);
INSERT INTO xonGrade VALUES ('32128402200609', replace(uuid(), '-', ''), '321284022006', 2008, 9);
INSERT INTO xonGrade VALUES ('32128402200707', replace(uuid(), '-', ''), '321284022007', 2007, 7);
INSERT INTO xonGrade VALUES ('32128402200708', replace(uuid(), '-', ''), '321284022007', 2008, 8);
INSERT INTO xonGrade VALUES ('32128402200709', replace(uuid(), '-', ''), '321284022007', 2009, 9);
INSERT INTO xonGrade VALUES ('32128402200807', replace(uuid(), '-', ''), '321284022008', 2008, 7);
INSERT INTO xonGrade VALUES ('32128402200808', replace(uuid(), '-', ''), '321284022008', 2009, 8);
INSERT INTO xonGrade VALUES ('32128402200809', replace(uuid(), '-', ''), '321284022008', 2010, 9);
INSERT INTO xonGrade VALUES ('32128402200907', replace(uuid(), '-', ''), '321284022009', 2009, 7);
INSERT INTO xonGrade VALUES ('32128402200908', replace(uuid(), '-', ''), '321284022009', 2010, 8);
INSERT INTO xonGrade VALUES ('32128402200909', replace(uuid(), '-', ''), '321284022009', 2011, 9);
INSERT INTO xonGrade VALUES ('32128402201007', replace(uuid(), '-', ''), '321284022010', 2010, 7);
INSERT INTO xonGrade VALUES ('32128402201008', replace(uuid(), '-', ''), '321284022010', 2011, 8);
INSERT INTO xonGrade VALUES ('32128402201009', replace(uuid(), '-', ''), '321284022010', 2012, 9);
INSERT INTO xonGrade VALUES ('32128402201107', replace(uuid(), '-', ''), '321284022011', 2011, 7);
INSERT INTO xonGrade VALUES ('32128402201108', replace(uuid(), '-', ''), '321284022011', 2012, 8);
INSERT INTO xonGrade VALUES ('32128402201109', replace(uuid(), '-', ''), '321284022011', 2013, 9);
INSERT INTO xonGrade VALUES ('32128402201207', replace(uuid(), '-', ''), '321284022012', 2012, 7);
INSERT INTO xonGrade VALUES ('32128402201208', replace(uuid(), '-', ''), '321284022012', 2013, 8);
INSERT INTO xonGrade VALUES ('32128402201209', replace(uuid(), '-', ''), '321284022012', 2014, 9);
INSERT INTO xonGrade VALUES ('32128402201307', replace(uuid(), '-', ''), '321284022013', 2013, 7);
INSERT INTO xonGrade VALUES ('32128402201308', replace(uuid(), '-', ''), '321284022013', 2014, 8);
INSERT INTO xonGrade VALUES ('32128402201309', replace(uuid(), '-', ''), '321284022013', 2015, 9);
INSERT INTO xonGrade VALUES ('32128402201407', replace(uuid(), '-', ''), '321284022014', 2014, 7);
INSERT INTO xonGrade VALUES ('32128402201408', replace(uuid(), '-', ''), '321284022014', 2015, 8);
INSERT INTO xonGrade VALUES ('32128402201409', replace(uuid(), '-', ''), '321284022014', 2016, 9);
INSERT INTO xonGrade VALUES ('32128402201507', replace(uuid(), '-', ''), '321284022015', 2015, 7);
INSERT INTO xonGrade VALUES ('32128402201508', replace(uuid(), '-', ''), '321284022015', 2016, 8);
INSERT INTO xonGrade VALUES ('32128402201509', replace(uuid(), '-', ''), '321284022015', 2017, 9);
INSERT INTO xonGrade VALUES ('32128402201607', replace(uuid(), '-', ''), '321284022016', 2016, 7);
INSERT INTO xonGrade VALUES ('32128402201608', replace(uuid(), '-', ''), '321284022016', 2017, 8);
INSERT INTO xonGrade VALUES ('32128402201707', replace(uuid(), '-', ''), '321284022017', 2017, 7);



/*外键约束开启*/
SET FOREIGN_KEY_CHECKS = 1;
