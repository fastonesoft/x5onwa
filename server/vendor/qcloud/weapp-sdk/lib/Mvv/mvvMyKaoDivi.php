<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonGradeStud;
use QCloud_WeApp_SDK\Model\xonKao;
use QCloud_WeApp_SDK\Model\xonKaoStud;
use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovGradeStudIn;
use function Sodium\compare;

class mvvMyKaoDivi
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

    public static function kaos($sch_user_id, $grade_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $to_division = 1;
            $result = xonKao::getsBy(compact('grade_id', 'to_division'));
        });
        return $result;
    }

    public static function counts($sch_user_id, $grade_id, $kao_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, $kao_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            // 某次考试参加人数情况统计
            // 参加的、未参加的
            $grade_studs = xovGradeStudIn::getsBy(compact('grade_id'));
            $kao_studs = xonKaoStud::getsBy(compact('kao_id'));

            // 统计参加的方式
            $in_count = 0;
            foreach ($grade_studs as $grade_stud) {
                foreach ($kao_studs as $kao_stud) {
                    if ($grade_stud->id === $kao_stud->grade_stud_id) {
                        $in_count++;
                        break;
                    }
                }
            }
            $notin_count = count($grade_studs) - $in_count;

            $result = compact('in_count', 'notin_count');
        });
        return $result;
    }

    public static function add($sch_user_id, $grade_id, $kao_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, $kao_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            // 某次考试参加人数情况统计
            // 参加的、未参加的
            $grade_studs = xovGradeStudIn::getsBySuff(compact('grade_id'), 'order by id');
            $kao_studs = xonKaoStud::getsBy(compact('kao_id'));

            // 统计参加的方式
            $in_count = count($kao_studs);
            foreach ($grade_studs as $grade_stud) {
                $find = false;
                foreach ($kao_studs as $kao_stud) {
                    if ($grade_stud->id === $kao_stud->grade_stud_id) {
                        $find = true;
                        break;
                    }
                }
                if (!$find) {
                    // 添加
                    $maxid = xonKaoStud::max('id', compact('kao_id'));
                    $id = x5on::getMaxId($maxid, $kao_id, 4);
                    $uid = x5on::getUid();
                    $grade_stud_id = $grade_stud->id;

                    xonKaoStud::insert(compact('id', 'uid', 'kao_id', 'grade_stud_id'));
                    $in_count++;
                }
            }

            $notin_count = count($grade_studs) - $in_count;

            $result = compact('in_count', 'notin_count');
        });
        return $result;
    }

}
