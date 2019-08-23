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

    public static function query($sch_user_id, $steps_id, $child_name) {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($steps_id, $child_name, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xovStudRegNotIn::likesBySuff(compact('steps_id'), compact('child_name'), 'order by child_name, child_id');
        });
        return $result;
    }

    public static function update($sch_user_id, $param) {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($param, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xovStudRegNotIn::likesBySuff(compact('steps_id'), compact('child_name'), 'order by child_name, child_id');
        });
        return $result;
    }

}
