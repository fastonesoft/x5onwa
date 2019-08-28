<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonGradeStud;
use QCloud_WeApp_SDK\Model\xonKao;
use QCloud_WeApp_SDK\Model\xonKaoStud;
use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovClassDivi;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovGradeStudIn;

class mvvMyAdjust
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
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($sch_user_id, $grade_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $user_id = $sch_user_id;
            $result = xovClassDivi::getsBySuff(compact('grade_id', 'user_id'), 'order by cls_id');
        });
        return $result;
    }

}
