<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Mysql\Mysql as dbs;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonDiviSet;
use QCloud_WeApp_SDK\Model\xonDivisionSet;
use QCloud_WeApp_SDK\Model\xonGradeStud;
use QCloud_WeApp_SDK\Model\xonGradeStudMove;
use QCloud_WeApp_SDK\Model\xonKao;
use QCloud_WeApp_SDK\Model\xonKaoStud;
use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovClassDivi;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovGradeStudDiv;
use QCloud_WeApp_SDK\Model\xovGradeStudDivCan;
use QCloud_WeApp_SDK\Model\xovGradeStudDived;
use QCloud_WeApp_SDK\Model\xovGradeStudDiving;
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

    public static function moves($sch_user_id, $cls_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($cls_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $request_cls_id = $cls_id;
            $comes = xovGradeStudDiving::getsBy(compact('request_cls_id'));
            $moveds = xovGradeStudDived::getsBy(compact('request_cls_id'));

            $result = compact('comes', 'moveds');
        });
        return $result;
    }

    // 调动查询
    public static function query($sch_user_id, $grade_id, $stud_name)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_id, $stud_name, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xovGradeStudDivCan::likesBySuff(compact('grade_id'), compact('stud_name'), 'order by cls_id, id');
        });
        return $result;
    }

    // 本班标识
    public static function local($sch_user_id, $grade_stud_uid)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_stud_uid, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $same_group = 0;
            $uid = $grade_stud_uid;
            $grade_stud = xovGradeStudDivCan::checkByCustom(compact('uid', 'same_group'), '要调的学生不存在，请重新查找！');

            $grade_id = $grade_stud->grade_id;
            $divi_set = xonDiviSet::checkBy(compact('grade_id'));
            if ($divi_set->finished) throw new \Exception('调动结束，不好再调！');

            $same_group = 1;
            xonGradeStud::setsByUid(compact('same_group'), $uid);

            // 添加进调动记录
            $request_cls_id = $grade_stud->cls_id;
            $exchange_stud_uid = $grade_stud_uid;
            $success = 1;
            xonGradeStudMove::insert(compact('grade_stud_uid', 'request_cls_id', 'exchange_stud_uid', 'success'));

            $result = xovGradeStudDived::getByUid($grade_stud_uid);
        });
        return $result;
    }


    // 申请调动
    public static function req($sch_user_id, $grade_stud_uid, $request_cls_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_stud_uid, $request_cls_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $same_group = 0;
            $uid = $grade_stud_uid;
            $grade_stud = xovGradeStudDivCan::checkByCustom(compact('uid', 'same_group'), '要调的学生不存在，请重新查找！');

            // 添加进调动记录
            xonGradeStudMove::insert(compact('grade_stud_uid', 'request_cls_id'));

            $result = xovGradeStudDiving::getByUid($grade_stud_uid);
        });
        return $result;
    }

    // 去除调动
    public static function remove($sch_user_id, $grade_stud_uid)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($grade_stud_uid, &$result) {
            $sch_id = $user_sch_group->sch_id;

            $result = xonGradeStudMove::delBy(compact('grade_stud_uid'));
        });
        return $result;
    }

    public static function out($sch_user_id, $come_stud_uid, $cls_id)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($come_stud_uid, $cls_id, &$result) {
            $sch_id = $user_sch_group->sch_id;

            // 查询当前调进学生信息
            $come_stud = xovGradeStudDiv::checkByUid($come_stud_uid);
            // 查询跟调进学生分数较接近的本班学生
            $value = $come_stud->value;
            $grade_id = $come_stud->grade_id;
            $sex_num = $come_stud->sex_num;

            $divi_set = xonDiviSet::checkBy(compact('grade_id'));
            if ($divi_set->finished) throw new \Exception('调动结束，不好再调！');
            // 区间设置
            $end = $divi_set->godown ? $value : $value + $divi_set->section;
            $begin = $divi_set->godown ?  $value - $divi_set->section : $value;
            $desc = $divi_set->godown ? 'desc' : '';
            // 是否结束？


            $sex_num = $divi_set->samesex ? $sex_num : !$sex_num;
            $result = dbs::select('xovGradeStudDivCan', ['*'], "cls_id = '$cls_id' and sex_num = $sex_num and value between $begin and $end ", 'and', "order by value $desc limit ". $divi_set->limit_num);
        });
        return $result;
    }

    public static function change($sch_user_id, $come_stud_uid, $out_stud_uid)
    {
        $result = [];
        mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($come_stud_uid, $out_stud_uid, &$result) {
            $sch_id = $user_sch_group->sch_id;


            $same_group = 0;
            $uid = $out_stud_uid;
            $out_stud = xovGradeStudDivCan::checkByCustom(compact('uid', 'same_group'), '要调的学生不存在，请重新查找！');

            $grade_id = $out_stud->grade_id;
            $divi_set = xonDiviSet::checkBy(compact('grade_id'));
            if ($divi_set->finished) throw new \Exception('调动结束，不好再调！');

            // 交换学生班级信息
            $come_stud = xovGradeStudDiv::checkByUid($come_stud_uid);
            // 先出去out
            $come_cls_id = $come_stud->cls_id;
            $out_cls_id = $out_stud->cls_id;

            $cls_id = $come_cls_id;
            xonGradeStud::setsByUid(compact('cls_id'), $out_stud_uid);

            $cls_id = $out_cls_id;
            $same_group = 1;
            xonGradeStud::setsByUid(compact('cls_id', 'same_group'), $come_stud_uid);

            $grade_stud_uid = $come_stud->uid;
            $exchange_stud_uid = $out_stud->uid;
            $success = 1;
            xonGradeStudMove::setsBy(compact('exchange_stud_uid', 'success'), compact('grade_stud_uid'));

            $request_cls_id = $out_cls_id;
            $result = xovGradeStudDived::getsBy(compact('request_cls_id'));
        });
        return $result;
    }


}
