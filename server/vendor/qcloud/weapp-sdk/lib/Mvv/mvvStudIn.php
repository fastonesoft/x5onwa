<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xovSchStep;
use QCloud_WeApp_SDK\Model\xovStudRegNotIn;

class mvvStudIn
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

    public static function notin($sch_user_id, $steps_id) {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($steps_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xovStudRegNotIn::getsBySuff(compact('steps_id'), 'order by child_name, child_id');
        });
        return $result;
    }

}
