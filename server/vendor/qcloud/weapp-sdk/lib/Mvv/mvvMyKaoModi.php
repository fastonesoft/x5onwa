<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonChild;
use QCloud_WeApp_SDK\Model\xonGrade;
use QCloud_WeApp_SDK\Model\xonGradeStud;
use QCloud_WeApp_SDK\Model\xonGradeStudTask;
use QCloud_WeApp_SDK\Model\xonKaoScore;
use QCloud_WeApp_SDK\Model\xonSchStep;
use QCloud_WeApp_SDK\Model\xonStudAuth;
use QCloud_WeApp_SDK\Model\xonStudent;
use QCloud_WeApp_SDK\Model\xonStudStatus;
use QCloud_WeApp_SDK\Model\xonStudType;
use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovGradeStud;
use QCloud_WeApp_SDK\Model\xovGradeStudDiv;
use QCloud_WeApp_SDK\Model\xovGradeStudIn;
use \Exception;
use QCloud_WeApp_SDK\Model\xovGradeStudInIn;
use QCloud_WeApp_SDK\Model\xovGradeStudInTask;
use QCloud_WeApp_SDK\Model\xovGradeStudNot;
use QCloud_WeApp_SDK\Model\xovStudent;

class mvvMyKaoModi
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


    public static function query($sch_user_id, $grade_id, $stud_name)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, $stud_name, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $current_year = 1;
            $result = xovGradeStudDiv::likesBySuff(compact('grade_id'), compact('stud_name'), 'order by cls_num, sex_num, id');
        });
        return $result;
    }

    public static function update($sch_user_id, $kao_stud_id, $value)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($kao_stud_id, $value, &$result) {
            $sch_id = $user_sch_group->sch_id;

            xonKaoScore::setsBy(compact('value'), compact('kao_stud_id'));

            // todo: 临时用的
            $result = xovGradeStudDiv::getBy(compact('kao_stud_id'));
        });
        return $result;
    }


}
