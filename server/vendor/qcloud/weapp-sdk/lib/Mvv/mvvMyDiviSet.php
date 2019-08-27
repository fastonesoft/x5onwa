<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonDiviSet;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;


class mvvMyDiviSet
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

    public static function data($sch_user_id, $grade_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xonDiviSet::getBy(compact('grade_id'));
        });
        return $result;
    }

    public static function update($sch_user_id, $grade_id, $section, $limit_num, $samesex, $godown, $finished)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, $section, $limit_num, $samesex, $godown, $finished, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xonDiviSet::setsBy(compact('section', 'limit_num', 'samesex', 'godown', 'finished'), compact('grade_id'));
        });
        return $result;
    }

}
