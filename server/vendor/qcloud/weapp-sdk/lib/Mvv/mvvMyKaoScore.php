<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonGradeStud;
use QCloud_WeApp_SDK\Model\xonKao;
use QCloud_WeApp_SDK\Model\xonKaoScore;
use QCloud_WeApp_SDK\Model\xonKaoStud;
use QCloud_WeApp_SDK\Model\xonKaoSub;
use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovGradeStudDiv;
use QCloud_WeApp_SDK\Model\xovGradeStudIn;
use QCloud_WeApp_SDK\Model\xovKaoScore;
use QCloud_WeApp_SDK\Model\xovKaoSub;
use function Sodium\compare;

class mvvMyKaoScore
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

    public static function subs($sch_user_id, $kao_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($kao_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xovKaoSub::getsBy(compact('kao_id'));
        });
        return $result;
    }

    public static function counts($sch_user_id, $grade_id, $kao_id, $sub_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, $kao_id, $sub_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $kao_studs = xonKaoStud::getsBy(compact('kao_id'));
            $kao_stud_scores = xovKaoScore::getsBy(compact('kao_id', 'sub_id'));

            // 统计参加的方式
            $in_count = 0;
            foreach ($kao_studs as $kao_stud) {
                foreach ($kao_stud_scores as $kao_stud_score) {
                    if ($kao_stud->id === $kao_stud_score->kao_stud_id) {
                        $in_count++;
                        break;
                    }
                }
            }
            $notin_count = count($kao_studs) - $in_count;
            $result = compact('in_count', 'notin_count');
        });
        return $result;
    }

    public static function add($sch_user_id, $grade_id, $kao_id, $sub_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, $kao_id, $sub_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $kao_studs = xonKaoStud::getsBy(compact('kao_id'));
            $kao_stud_scores = xovKaoScore::getsBy(compact('kao_id', 'sub_id'));

            $in_count = count($kao_stud_scores);
            foreach ($kao_studs as $kao_stud) {
                $find = false;
                foreach ($kao_stud_scores as $kao_stud_score) {
                    if ($kao_stud->id === $kao_stud_score->kao_stud_id) {
                        $find = true;
                        break;
                    }
                }
                if (!$find) {
                    $uid = x5on::getUid();
                    $kao_stud_id = $kao_stud->id;

                    xonKaoScore::insert(compact('uid', 'kao_stud_id', 'sub_id'));
                    $in_count++;
                }
            }

            $notin_count = count($kao_studs) - $in_count;
            $result = compact('in_count', 'notin_count');
        });
        return $result;
    }

}
