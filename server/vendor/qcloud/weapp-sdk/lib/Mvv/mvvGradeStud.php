<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonChild;
use QCloud_WeApp_SDK\Model\xonGrade;
use QCloud_WeApp_SDK\Model\xonGradeStud;
use QCloud_WeApp_SDK\Model\xonGradeStudTask;
use QCloud_WeApp_SDK\Model\xonSchStep;
use QCloud_WeApp_SDK\Model\xonStudAuth;
use QCloud_WeApp_SDK\Model\xonStudent;
use QCloud_WeApp_SDK\Model\xonStudStatus;
use QCloud_WeApp_SDK\Model\xonStudType;
use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovGradeStud;
use QCloud_WeApp_SDK\Model\xovGradeStudIn;
use \Exception;
use QCloud_WeApp_SDK\Model\xovGradeStudInIn;
use QCloud_WeApp_SDK\Model\xovGradeStudInTask;
use QCloud_WeApp_SDK\Model\xovGradeStudNot;
use QCloud_WeApp_SDK\Model\xovStudent;

class mvvGradeStud
{
    public static function grades($sch_user_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use (&$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xovGradeCurrent::getsBySuff(compact('sch_id'), 'order by id desc');
        });
        return $result;
    }

    public static function classes($sch_user_id, $grade_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $total = xovGradeStudIn::count(compact('grade_id'));
            $sex_num = 0;
            $female = xovGradeStudIn::count(compact('grade_id', 'sex_num'));
            $sex_num = 1;
            $male = xovGradeStudIn::count(compact('grade_id', 'sex_num'));

            $classes = xovClass::getsBy(compact('grade_id'));
            $notins = xovGradeStudNot::getsBySuff(compact('grade_id'), 'order by status_id desc, id');
            $counts = compact('total', 'female', 'male');
            $result = compact('classes', 'counts', 'notins');
        });
        return $result;
    }

    public static function cls($sch_user_id, $grade_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xovClass::getsBySuff(compact('grade_id'), 'order by num, id');
        });
        return $result;
    }

    public static function studcls($sch_user_id, $cls_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($cls_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xovGradeStudIn::getsBySuff(compact('cls_id'), 'order by grade_id, cls_num, sex_num, stud_id');
        });
        return $result;
    }

    public static function query($sch_user_id, $grade_id, $cls_id, $stud_name)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, $cls_id, $stud_name, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $current_year = 1;
            if ($grade_id && $cls_id) {
                $result = xovGradeStudIn::likesBySuff(compact('grade_id', 'cls_id'), compact('stud_name'), 'order by sex_num, id');
            } elseif ($grade_id) {
                $result = xovGradeStudIn::likesBySuff(compact('grade_id'), compact('stud_name'), 'order by cls_num, sex_num, id');
            } else {
                // 没有指定年级，则返回当前年度，所有学生的查询
                $result = xovGradeStudIn::likesBySuff(compact('current_year'), compact('stud_name'), 'order by grade_id, cls_num, sex_num, id');
            }
        });
        return $result;
    }

    public static function type($sch_user_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use (&$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xonStudType::getsColumns(['id', 'name']);
        });
        return $result;
    }

    public static function status($sch_user_id, $in_sch)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($in_sch, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xonStudStatus::getsColumnsBy(['id', 'name'], compact('in_sch'));
        });
        return $result;
    }

    public static function auth($sch_user_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use (&$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xonStudAuth::gets();
        });
        return $result;
    }

    public static function addNoExam($sch_user_id, $grade_id, $cls_id, $stud_name, $stud_idc, $type_id, $status_id, $stud_auth, $come_date)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, $cls_id, $stud_name, $stud_idc, $type_id, $status_id, $stud_auth, $come_date, &$result) {
            $sch_id = $user_sch_group->sch_id;

            // 添加孩子表
            $child = xonChild::add($stud_idc, $stud_name);
            $child_id = $child->id;
            // 通过grade_id找出steps_id，并添加录取学生表
            $grade = xonGrade::checkById($grade_id);
            $steps_id = $grade->steps_id;

            // 检测是否为招生分级，如果招生，则不能以这种方式添加学生记录
            $can_recruit = 1;
            $id = $steps_id;
            xonSchStep::existByCustom(compact('id', 'can_recruit'), '招生年级不能以这种方式添加学生');
            $stud_id = xonStudent::add($child_id, $steps_id, $stud_auth, $come_date);

            // 添加年度学生
            $grade_stud_id = xonGradeStud::add($grade_id, $cls_id, $stud_id, $type_id, $status_id, $stud_auth);
            $result = xovGradeStudIn::getById($grade_stud_id);
        });
        return $result;
    }

    public static function edit($sch_user_id, $grade_stud_uid, $cls_id, $type_id, $status_id, $stud_auth)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_stud_uid, $cls_id, $type_id, $status_id, $stud_auth, &$result) {
            $sch_id = $user_sch_group->sch_id;

            // 获取年度学生记录
            $grade_stud = xovGradeStudIn::checkByUid($grade_stud_uid);
            $cls = xovClass::checkById($cls_id);
            // 一般不会出现
            if ($grade_stud->grade_id !== $cls->grade_id) throw new Exception('年级修改错误');

            xonGradeStud::setsByUid(compact('cls_id', 'type_id', 'status_id', 'stud_auth'), $grade_stud_uid);

            $result = xovGradeStudIn::getByUid($grade_stud_uid);
        });
        return $result;
    }

    public static function temp($sch_user_id, $grade_stud_uid) {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_stud_uid, &$result) {
            $sch_id = $user_sch_group->sch_id;

            // 检测年度学生编号
            $grade_stud = xonGradeStud::checkByUid($grade_stud_uid);
            $grade_id = $grade_stud->grade_id;

            // 学籍状态设置为临时
            $status_id = x5on::STATUS_TEMP;
            xonGradeStud::setsByUid(compact('status_id'), $grade_stud_uid);

            // 返回当前不在校学生名单
            $result = xovGradeStudNot::getByUid($grade_stud_uid);
        });
        return $result;
    }

    public static function backck($sch_user_id, $grade_stud_uid)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_stud_uid, &$result) {
            $sch_id = $user_sch_group->sch_id;

            // 回校检测，只有临时的学生，才可以回校
            $uid = $grade_stud_uid;
            $status_id = x5on::STATUS_TEMP;
            $grade_stud = xovGradeStudNot::checkByCustom(compact('uid', 'status_id'), '只有临时离校的学生才能回校');

            $result = 0;
        });
        return $result;
    }

    public static function back($sch_user_id, $grade_stud_uid, $cls_id, $status_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_stud_uid, $cls_id, $status_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            // 获取年度学生记录
            $grade_stud = xovGradeStudNot::checkByUid($grade_stud_uid);
            $cls = xovClass::checkById($cls_id);
            // 一般不会出现
            if ($grade_stud->grade_id !== $cls->grade_id) throw new Exception('年级修改错误');

            // 临时状态学生，修改回校
            $result = xonGradeStud::setsByUid(compact('cls_id', 'status_id'), $grade_stud_uid);
        });
        return $result;
    }

    public static function backref($sch_user_id, $grade_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xovGradeStudNot::getsBySuff(compact('grade_id'), 'order by status_id desc, id');
        });
        return $result;
    }

}
