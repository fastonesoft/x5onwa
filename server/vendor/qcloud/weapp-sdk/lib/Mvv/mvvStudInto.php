<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonClass;
use QCloud_WeApp_SDK\Model\xonGrade;
use QCloud_WeApp_SDK\Model\xonGradeStud;
use QCloud_WeApp_SDK\Model\xonStudent;
use QCloud_WeApp_SDK\Model\xonStudReg;
use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovGradeStud;
use QCloud_WeApp_SDK\Model\xovSchStep;
use QCloud_WeApp_SDK\Model\xovStudent;
use QCloud_WeApp_SDK\Model\xovStudentNotInto;
use QCloud_WeApp_SDK\Model\xovStudRegNotIn;

class mvvStudInto
{

    public static function steps($sch_user_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use (&$result) {
            $sch_id = $user_sch_group->sch_id;

            // 可以招生的学校分级
            $can_recruit = 1;
            $result = xovSchStep::getsBy(compact('sch_id', 'can_recruit'));
        });
        return $result;
    }

    public static function count($sch_user_id, $steps_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($steps_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            // 统计未分级的学生人数
            $total = xovStudentNotInto::count(compact('steps_id'));
            $sex_num = 0;
            $female = xovStudentNotInto::count(compact('steps_id', 'sex_num'));
            $sex_num = 1;
            $male = xovStudentNotInto::count(compact('steps_id', 'sex_num'));

            // 查找 分级对应班级
            $grade = xovGradeCurrent::checkByCustom(compact('steps_id'), '当前分级没有设置年级');
            $grade_id = $grade->id;
            $cls = xovClass::getsBySuff(compact('grade_id'), 'order by num desc, id');

            $result = compact('total', 'female', 'male', 'cls');
        });
        return $result;
    }

    public static function enter($sch_user_id, $steps_id, $cls_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($steps_id, $cls_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            // 添加分级的两个前提
            $grade = xovGradeCurrent::checkByCustom(compact('steps_id'), '当前分级没有设置年级');
            $grade_id = $grade->id;

            // 添加分级记录：查询出未分级学生，逐一添加
            $studs = xovStudentNotInto::getsBy(compact('steps_id'));
            foreach ($studs as $stud) {
                $stud_id = $stud->id;
                $stud_auth = $stud->come_auth;

                $uid = x5on::getUid();
                $type_id = 1;
                $status_id = 1;
                $same_group = 0;

                $maxid = xonGradeStud::max('id', compact('grade_id'));
                $id = x5on::getMaxId($maxid, $grade_id, 4);

                xonGradeStud::insert(compact('id', 'uid', 'grade_id', 'cls_id', 'stud_id', 'type_id', 'status_id', 'stud_auth', 'same_group'));
            }

            // 统计未分级的学生人数
            $total = xovStudentNotInto::count(compact('steps_id'));
            $sex_num = 0;
            $female = xovStudentNotInto::count(compact('steps_id', 'sex_num'));
            $sex_num = 1;
            $male = xovStudentNotInto::count(compact('steps_id', 'sex_num'));

            $result = compact('total', 'female', 'male');
        });
        return $result;
    }

    public static function query($sch_user_id, $steps_id, $stud_name)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($steps_id, $stud_name, &$result) {
            $sch_id = $user_sch_group->sch_id;

            // 查询未分级学生名单
            $result = xovGradeStud::likesBySuff(compact('steps_id'), compact('stud_name'), 'order by id');
        });
        return $result;
    }

    public static function out($sch_user_id, $steps_id, $grade_stud_uids_string)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($steps_id, $grade_stud_uids_string, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $count = 0;
            $grade_stud_uids = x5on::getUids($grade_stud_uids_string, ',');
            foreach ($grade_stud_uids as $uid) {
                xovGradeStud::checkByCustom(compact('steps_id', 'uid'), '年级学生系统编号不存在');
                xonGradeStud::delByUid($uid);
                $count++;
            }
            $result = $count;
        });
        return $result;
    }


}
