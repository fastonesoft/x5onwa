<?php

namespace QCloud_WeApp_SDK\Model;

class xonStudent extends cAppinfo
{
    protected static $tableName = 'xonStudent';
    protected static $tableTitle = '录取学生';

    // 新生录取自主添加
    public static function addStudIn($id, $child_id, $sch_id, $steps_id, $come_auth)
    {
        $uid = x5on::getUid();
        $come_date = date('Y-m-d');

        self::insert(compact('id', 'uid', 'child_id', 'sch_id', 'steps_id', 'come_auth', 'come_date'));
    }

    // 流水号式添加
    public static function add($child_id, $steps_id, $come_auth, $come_date)
    {
        // 检测当前年级对应学校
        $step = xonStep::checkById($steps_id);
        $sch_id = $step->sch_id;

        // 检查学校、身份证记录是否存在
        // 已经存在，不添加
        $res = self::checkByCustom(compact('child_id', 'sch_id'), '已存在录取记录，请确认是否办理休学或重读？');


        $maxid = self::max('id', compact('steps_id'));
        $id = x5on::getMaxId($maxid, $steps_id, 4);


        $uid = x5on::getUid();
        // 添加
        self::insert(compact('id', 'uid', 'child_id', 'sch_id', 'steps_id', 'come_auth', 'come_date'));
        // 返回编号
        return $id;
    }


    // 以下内容要移到 mvv 中去
    public static function checkStudentEnter($child_id, $sch_id)
    {
        $res = self::getBy(compact('child_id', 'sch_id'));
        if ($res !== null) {
            $entered = true;
            $sch_name = $res->sch_name;
            $step_name = $res->step_name;
            $stud_name = $res->stud_name;
            $stud_id = $res->id;
            $enter_id = substr($stud_id, -4);
            return compact('entered', 'sch_name', 'step_name', 'stud_name', 'stud_id', 'enter_id');
        } else {
            return false;
        }
    }


}
