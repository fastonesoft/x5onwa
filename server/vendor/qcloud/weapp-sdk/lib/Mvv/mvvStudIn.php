<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonGradeStud;
use QCloud_WeApp_SDK\Model\xonStudent;
use QCloud_WeApp_SDK\Model\xonStudReg;
use QCloud_WeApp_SDK\Model\xovSchStep;
use QCloud_WeApp_SDK\Model\xovStudent;
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

    public static function enter($sch_user_id, $steps_id, $reg_stud_uids_string) {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($steps_id, $reg_stud_uids_string, &$result) {
            $sch_id = $user_sch_group->sch_id;

            // 一、添加录取记录
            $count = 0;
            $reg_stud_uids = x5on::getUids($reg_stud_uids_string, ',');
            foreach ($reg_stud_uids as $reg_stud_uid) {
                $stud_reg = xonStudReg::checkByUid($reg_stud_uid);
                $max_id = xonStudent::max('id', compact($steps_id));

                $id = x5on::getMaxIdex($max_id, $steps_id, 4, 2, 2, x5on::HALL_SIZE);
                $child_id = $stud_reg->child_id;
                $reg_sch_id = $stud_reg->sch_id;
                $reg_steps_id = $stud_reg->steps_id;
                $come_auth = $stud_reg->stud_auth;

                // 检测是否是本校学生
                if ($sch_id !== $reg_sch_id) throw new \Exception('录取学校与学生记录不符');

                // 保存信息
                xonStudent::addStudIn($id, $child_id, $sch_id, $steps_id, $come_auth);
                $count++;
            }

            $result = $count;
        });
        return $result;
    }

    public static function query($sch_user_id, $steps_id, $stud_name) {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($steps_id, $stud_name, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xovStudent::likesBySuff(compact('steps_id'), compact('stud_name'), 'order by id');
        });
        return $result;
    }

    public static function out($sch_user_id, $steps_id, $stud_uids_string) {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($steps_id, $stud_uids_string, &$result) {
            $sch_id = $user_sch_group->sch_id;

            // 一、删除录取记录
            $count = 0;
            $stud_uids = x5on::getUids($stud_uids_string, ',');
            foreach ($stud_uids as $stud_uid) {

                // 检测学生编号
                $student = xovStudent::checkByUid($stud_uid);

                // 判断学生是否已分级
                $stud_id = $student->id;
                $stud_name = $student->stud_name;
                xonGradeStud::existByCustom(compact('stud_id'), $stud_name.'，已分配年级，无法删除');

                // 删除
                xonStudent::delByUid($stud_uid);
                $count++;
            }

            $result = $count;
        });
        return $result;
    }

}
