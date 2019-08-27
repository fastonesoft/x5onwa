<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonGrade;
use QCloud_WeApp_SDK\Model\xonGradeStud;
use QCloud_WeApp_SDK\Model\xonStudent;
use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovGradeStud;
use QCloud_WeApp_SDK\Model\xovGradeStudIn;
use QCloud_WeApp_SDK\Model\xovGradeStudNot;

class mvvStudown
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

    public static function down($sch_user_id, $grade_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $id = $grade_id;
            $downs = xovGradeCurrent::customsBySuff(compact('sch_id'), compact('id'), '>', 'order by id limit 1');
            $notins = xovGradeStudNot::getsBy(compact('grade_id'));
            $result = compact('downs', 'notins');
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

    public static function query($sch_user_id, $grade_id, $stud_name)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, $stud_name, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xovGradeStudIn::likesBySuff(compact('grade_id'), compact('stud_name'), 'order by cls_num, sex_num, id');
        });
        return $result;
    }

    public static function done($sch_user_id, $grade_id, $cls_id, $grade_stud_uid)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, $cls_id, $grade_stud_uid, &$result) {
            $sch_id = $user_sch_group->sch_id;

            // 检测grade_id对应的steps_id，students修改用
            $grade = xonGrade::checkById($grade_id);
            $steps_id = $grade->steps_id;

            // 将高年级的学生记录查询出来，添加到低年级当中
            $grade_stud = xovGradeStudIn::checkByUid($grade_stud_uid);
            $stud_id = $grade_stud->stud_id;
            $type_id = $grade_stud->type_id;
            $status_id = x5on::STATUS_RETURN;
            $stud_auth = $grade_stud->stud_auth;

            // todo: 以后要转成事务
            // 检测学生，在休学年级有没有记录
            xovGradeStud::existByCustom(compact('grade_id', 'stud_id'), '休学年级已存在该学生记录');
            xonGradeStud::add($grade_id, $cls_id, $stud_id, $type_id, $status_id, $stud_auth);

            // 修改学生年度记录、录取记录
            $status_id = x5on::STATUS_DOWN;
            xonGradeStud::setsByUid(compact('status_id'), $grade_stud_uid);
            xonStudent::setsById(compact('steps_id'), $stud_id);

            $result = xovGradeStud::getByUid($grade_stud_uid);
        });
        return $result;
    }

}
