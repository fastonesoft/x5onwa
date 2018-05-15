
/*这句只能在测试阶段使用，运行阶段删除*/
DROP DATABASE cAuth;
CREATE DATABASE IF NOT EXISTS cAuth DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
CREATE TABLE xonRole (
	id INT(11) NOT NULL AUTO_INCREMENT,
	uid VARCHAR(100) NOT NULL,
	name VARCHAR(20) NOT NULL,
	title VARCHAR(20) NOT NULL,
	to_show boolean NOT NULL,
	PRIMARY KEY (id),
	UNIQUE KEY uid (uid),
	UNIQUE KEY name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='权限列表';

INSERT INTO xonRole VALUES (0, replace(uuid(), '-', ''), 'stud', '学生查询', 1);
INSERT INTO xonRole VALUES (0, replace(uuid(), '-', ''), 'sub', '课表查询', 1);
INSERT INTO xonRole VALUES (0, replace(uuid(), '-', ''), 'kao', '考试安排', 1);
INSERT INTO xonRole VALUES (0, replace(uuid(), '-', ''), 'score', '成绩查询', 1);

CREATE TABLE xonGroup (
	id INT(11) NOT NULL AUTO_INCREMENT,
	uid VARCHAR(100) NOT NULL,
	name VARCHAR(20) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE KEY uid (uid),
	UNIQUE KEY name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='分组列表';

INSERT INTO xonGroup VALUES (0, replace(uuid(), '-', ''), '学生家长');
INSERT INTO xonGroup VALUES (0, replace(uuid(), '-', ''), '科任老师');
INSERT INTO xonGroup VALUES (0, replace(uuid(), '-', ''), '班级主管');
INSERT INTO xonGroup VALUES (0, replace(uuid(), '-', ''), '学科主管');
INSERT INTO xonGroup VALUES (0, replace(uuid(), '-', ''), '年级主管');
INSERT INTO xonGroup VALUES (0, replace(uuid(), '-', ''), '学校管理');
INSERT INTO xonGroup VALUES (0, replace(uuid(), '-', ''), '集团管理');
INSERT INTO xonGroup VALUES (99, replace(uuid(), '-', ''), '系统管理');

CREATE TABLE xonRoleGroup (
	id INT(11) NOT NULL AUTO_INCREMENT,
	uid VARCHAR(100) NOT NULL,
	role_id INT(11) NOT NULL,
	group_id INT(11) NOT NULL,
	has_role boolean NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (role_id) REFERENCES xonRole(id),
	FOREIGN KEY (group_id) REFERENCES xonGroup(id),
	UNIQUE KEY uid (uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='分组权限';

CREATE TABLE xonUser (
  id INT(11) NOT NULL AUTO_INCREMENT,
  uid VARCHAR(100) NOT NULL,  /*unionid*/
  name VARCHAR(100) NOT NULL,
  fixed boolean NOT NULL,
  create_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  last_visit_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户列表';

CREATE TABLE xonGroupUser (
  group_id INT(11) NOT NULL,
  user_id INT(11) NOT NULL,
  PRIMARY KEY (group_id, user_id),
  FOREIGN KEY (group_id) REFERENCES xonGroup(id),
  FOREIGN KEY (user_id) REFERENCES xonUser(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='分组用户';

CREATE TABLE xonEduType (
  id INT(11) NOT NULL AUTO_INCREMENT,
  uid VARCHAR(100) NOT NULL,
  name VARCHAR(20) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学制类型';

INSERT INTO xonEduType VALUES (0, replace(uuid(), '-', ''), '幼儿园');
INSERT INTO xonEduType VALUES (0, replace(uuid(), '-', ''), '小学');
INSERT INTO xonEduType VALUES (0, replace(uuid(), '-', ''), '初中');
INSERT INTO xonEduType VALUES (0, replace(uuid(), '-', ''), '高中');

CREATE TABLE xonEdu (
  id INT(11) NOT NULL AUTO_INCREMENT,
  uid VARCHAR(100) NOT NULL,
  name VARCHAR(20) NOT NULL,
  edu_type_id INT(11) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (edu_type_id) REFERENCES xonEduType(id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='学制编排';

INSERT INTO xonEdu VALUES (0, replace(uuid(), '-', ''), '小班', 1);
INSERT INTO xonEdu VALUES (0, replace(uuid(), '-', ''), '中班', 1);
INSERT INTO xonEdu VALUES (0, replace(uuid(), '-', ''), '大班', 1);
INSERT INTO xonEdu VALUES (0, replace(uuid(), '-', ''), '一年级', 2);
INSERT INTO xonEdu VALUES (0, replace(uuid(), '-', ''), '二年级', 2);
INSERT INTO xonEdu VALUES (0, replace(uuid(), '-', ''), '三年级', 2);
INSERT INTO xonEdu VALUES (0, replace(uuid(), '-', ''), '四年级', 2);
INSERT INTO xonEdu VALUES (0, replace(uuid(), '-', ''), '五年级', 2);
INSERT INTO xonEdu VALUES (0, replace(uuid(), '-', ''), '六年级', 2);
INSERT INTO xonEdu VALUES (0, replace(uuid(), '-', ''), '七年级', 3);
INSERT INTO xonEdu VALUES (0, replace(uuid(), '-', ''), '八年级', 3);
INSERT INTO xonEdu VALUES (0, replace(uuid(), '-', ''), '九年级', 3);
INSERT INTO xonEdu VALUES (0, replace(uuid(), '-', ''), '高一年级', 4);
INSERT INTO xonEdu VALUES (0, replace(uuid(), '-', ''), '高二年级', 4);
INSERT INTO xonEdu VALUES (0, replace(uuid(), '-', ''), '高三年级', 4);

CREATE TABLE xonEduReg (
  uid VARCHAR(100) NOT NULL,
  edu_id INT(11) NOT NULL,
  PRIMARY KEY (uid, edu_id),
  FOREIGN KEY (edu_id) REFERENCES xonEdu(id),
  UNIQUE KEY uid (uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='报名学校';





/*外键约束开启*/
SET FOREIGN_KEY_CHECKS = 1;
