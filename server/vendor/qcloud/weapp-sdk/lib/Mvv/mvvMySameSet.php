<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonGradeStud;
use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovGradeStudIn;

class mvvMySameSet
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

    public static function cls($sch_user_id, $grade_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xovClass::getsBySuff(compact('grade_id'), 'order by id');
        });
        return $result;
    }

    public static function studs($sch_user_id, $cls_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($cls_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xovGradeStudIn::getsBySuff(compact('cls_id'), 'order by sex_num, stud_id');
        });
        return $result;
    }

    public static function update($sch_user_id, $param) {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($param, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $count = 0;
            foreach ($param as $uid => $value) {
                $same_group = x5on::getBool($value);
                $count += xonGradeStud::setsByUid(compact('same_group'), $uid);
            }
            $result = $count;
        });
        return $result;
    }



}
