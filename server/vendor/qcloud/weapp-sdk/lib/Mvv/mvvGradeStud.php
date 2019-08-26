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
use \Exception;
use QCloud_WeApp_SDK\Model\xovGradeStudTask;
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

            $total = xonGradeStud::count(compact('grade_id'));
            $sex_num = 0;
            $female = xovGradeStud::count(compact('grade_id', 'sex_num'));
            $sex_num = 1;
            $male = xovGradeStud::count(compact('grade_id', 'sex_num'));

            $classes = xovClass::getsBy(compact('grade_id'));
            $counts = compact('total', 'female', 'male');
            $result = compact('classes', 'counts');
        });
        return $result;
    }

    public static function studcls($sch_user_id, $cls_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($cls_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xovGradeStud::getsBySuff(compact('cls_id'), 'order by grade_id, cls_num, sex_num, stud_id');
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
                $result = xovGradeStud::likesBySuff(compact('grade_id', 'cls_id'), compact('stud_name'), 'order by sex_num, id');
            } elseif ($grade_id) {
                $result = xovGradeStud::likesBySuff(compact('grade_id'), compact('stud_name'), 'order by cls_num, sex_num, id');
            } else {
                // 没有指定年级，则返回当前年度，所有学生的查询
                $result = xovGradeStud::likesBySuff(compact('current_year'), compact('stud_name'), 'order by grade_id, cls_num, sex_num, id');
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
            xonChild::add($stud_idc, $stud_name);
            // 通过grade_id找出steps_id，并添加录取学生表
            $grade = xonGrade::getById($grade_id);
            $steps_id = $grade->steps_id;

            // 检测是否为招生分级，如果招生，则不能以这种方式添加学生记录
            $can_recruit = 1;
            $id = $steps_id;
            xonSchStep::existByCustom(compact('id', 'can_recruit'), '招生年级不能以这种方式添加学生');
            $stud_id = xonStudent::add($stud_idc, $steps_id, $stud_auth, $come_date);

            // 添加年度学生
            $uid = xonGradeStud::add($grade_id, $cls_id, $stud_id, $type_id, $status_id, $stud_auth);
            $result = xovGradeStud::getsByUid($uid);
        });
        return $result;
    }


    /**
     * 根据学生序号查询学生信息
     * @param $uid                学生序号
     * @return array
     */
    public static function studByUid($uid)
    {
        if ($uid) {
            return xovGradeStud::getBy(compact('uid'));
        } else {
            return null;
        }
    }

    /**
     * 根据学生序号更新学生班级，完成调动
     * @param $uid                学生序号
     * @param $cls_id             目标班级
     * @throws Exception
     */
    public static function studMove($uid, $cls_id)
    {
        xovGradeStud::checkByUid($uid);
        xonGradeStud::update(compact('cls_id'), compact('uid'));
        return xovGradeStud::getsBy(compact('uid'));
    }

    /**
     * 修改学生信息（身份证号、姓名）
     * @param $uid              学生序号
     * @param $idc              身份证号
     * @param $name             学生姓名
     */
    public static function studModi($grade_stud_uid, $idc, $name, $type_id, $status_id)
    {
        $grade_stud = xovGradeStud::checkByUid($grade_stud_uid);
        $child_id = $grade_stud->child_id;
        xonChild::setsById(compact('idc', 'name'), $child_id);
        xonGradeStud::setsByUid(compact('type_id', 'status_id'), $grade_stud_uid);
        return xovGradeStud::getsByUid($grade_stud_uid);
    }

    /**
     * 指标生变更
     * @param $uid              学生序号
     * @param $stud_auth        指标标志（只接收0、1）
     */
    public static function studAuth($grade_stud_uid, $stud_auth)
    {
        xovGradeStud::checkByUid($grade_stud_uid);
        xonGradeStud::setsByUid(compact('stud_auth'), $grade_stud_uid);
        return xovGradeStud::getsByUid($grade_stud_uid);
    }


    /**
     * 作为任务管理的统一添加方法
     * @param $grade_stud_id
     * @param $task_status_id
     * @param $has_done
     * @param $task_memo
     * @return array
     * @throws Exception
     */

    public static function taskDown($grade_stud_id, $status_id, $task_status_id, $task_memo)
    {
        // 休学记录
        $has_done = 0;
        xonGradeStudTask::add($grade_stud_id, $status_id, $task_status_id, $has_done, $task_memo);
        // 变更年度学生信息
        $status_id = $task_status_id;
        xonGradeStud::setsById(compact('status_id'), $grade_stud_id);
        return xovGradeStud::getsById($grade_stud_id);
    }

    public static function taskTemp($id, $uid, $task_memo)
    {
        // 临时离校
        $res = xonGradeStud::checkBy(compact('id', 'uid'));
        // 记录
        $has_done = 0;
        $task_status_id = $res->status_id;  // 原始学籍状态
        // 添加记录
        xonGradeStudTask::add($id, $task_status_id, $has_done, $task_memo);
        // 变更
        $status_id = x5on::STATUS_TEMP;
        xonGradeStud::setsById(compact('status_id'), $id);
        return xovGradeStud::getsById($id);
    }

    public static function taskOutLeave($id, $uid, $task_memo)
    {
        // 转出、离校记录
        $res = xonGradeStud::checkBy(compact('id', 'uid'));
        // 记录
        $has_done = 1;
        $task_status_id = $res->status_id;  // 原始学籍状态
        // 添加记录
        xonGradeStudTask::add($id, $task_status_id, $has_done, $task_memo);
        // 变更
        $status_id = x5on::STATUS_TEMP;
        xonGradeStud::setsById(compact('status_id'), $id);
        return xovGradeStud::getsById($id);
    }

    public static function gradesDown($id)
    {
        // 休学年级
        return xovGradeCurrent::customsSuff(compact('id'), '>', 'limit 1');
    }

    public static function studReturn($uid, $grade_id, $cls_id)
    {
        // 复学设置
        $has_done = 1;
        $task = xovGradeStudTask::checkByUid($uid);
        xonGradeStudTask::setsByUid(compact('has_done'), $uid);
        $grade = xonGrade::checkById($grade_id);
        $steps_id = $grade->steps_id;
        // 新学生信息
        $stud_id = $task->stud_id;
        $type_id = $task->type_id;
        $status_id = x5on::STATUS_RETURN;
        $stud_auth = $task->stud_auth;
        $same_group = 0;
        $stud_code = $task->stud_code;
        $stud_diploma = $task->stud_diploma;
        // 添加新年度记录
        $grade_stud_id = xonGradeStud::add($grade_id, $cls_id, $stud_id, $type_id, $status_id, $stud_auth, $stud_code, $stud_diploma);
        // 变更学生信息
        xonStudent::setsById(compact('steps_id'), $stud_id);
        return xovGradeStud::getsById($grade_stud_id);
    }

    public static function studBack($uid, $cls_id)
    {
        // 学生回校
        $has_done = 1;
        $task = xovGradeStudTask::checkByUid($uid);
        xonGradeStudTask::setsByUid(compact('has_done'), $uid);

        $grade_stud_id = $task->grade_stud_id;
        $status_id = $task->task_status_id;
        xonGradeStud::setsById(compact('cls_id', 'status_id'), $grade_stud_id);
        return xovGradeStud::getsById($grade_stud_id);
    }


}
