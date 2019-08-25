<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonGradeStud;
use QCloud_WeApp_SDK\Model\xonStudent;
use QCloud_WeApp_SDK\Model\xonStudReg;
use QCloud_WeApp_SDK\Model\xovSchStep;
use QCloud_WeApp_SDK\Model\xovStudent;
use QCloud_WeApp_SDK\Model\xovStudRegNotIn;

class mvvStudInto
{

    public static function steps($sch_user_id) {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use (&$result) {
            $sch_id = $user_sch_group->sch_id;

            // 可以招生的学校分级
            $can_recruit = 1;
            $result = xovSchStep::getsBy(compact('sch_id', 'can_recruit'));
        });
        return $result;
    }

    public static function count($sch_user_id, $steps_id) {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($steps_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $total = xovStudent::count(compact('steps_id'));
            $sex_num = 0;
            $female = xovStudent::count(compact('steps_id', 'sex_num'));
            $sex_num = 1;
            $male = xovStudent::count(compact('steps_id', 'sex_num'));

            $result = compact('total', 'female', 'male');
        });
        return $result;
    }

}
