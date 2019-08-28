<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonClassDivi;
use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovClass2Divi;
use QCloud_WeApp_SDK\Model\xovClassDivi;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovUser;
use QCloud_WeApp_SDK\Model\xovUserSchool;

class mvvMyDivi
{

    public static function grades($sch_user_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use (&$result) {
            $sch_id = $user_sch_group->sch_id;
            $result = xovGradeCurrent::getsBy(compact('sch_id'));
        });
        return $result;
    }

    public static function clsdiv($sch_user_id, $grade_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $classes = xovClass2Divi::getsBy(compact('grade_id'));
            $classed = xovClassDivi::getsBy(compact('grade_id'));
            $result = compact('classes', 'classed');
        });
        return $result;
    }

    public static function teachs($sch_user_id, $user_name)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($user_name, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xovUserSchool::likesBy(compact('sch_id'), compact('user_name'));
        });
        return $result;
    }

    public static function dist($sch_user_id, $grade_id, $user_uid, $cls_uids_string)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, $user_uid, $cls_uids_string, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $user_sch = xovUserSchool::checkByUid($user_uid);
            $user_id = $user_sch->user_id;

            $cls_uids = x5on::getUids($cls_uids_string, ',');
            foreach ($cls_uids as $cls_uid) {
                $cls_id = xovClass::checkUid2Id($cls_uid);
                xonClassDivi::existByCustom(compact('cls_id', 'user_id'), '班级已分配教师');
                xonClassDivi::add($cls_id, $user_id);
            }
            $result = xovClassDivi::getsBy(compact('grade_id'));
        });
        return $result;
    }

    public static function remove($sch_user_id, $class_div_uid)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($class_div_uid, &$result) {
            $sch_id = $user_sch_group->sch_id;

            xonClassDivi::checkByUid($class_div_uid);
            $result = xonClassDivi::delByUidCustom($class_div_uid);
        });
        return $result;
    }

}
