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
        $step = xovSchStep::checkById($steps_id);
        $sch_id = $step->sch_id;

        // 检查学校、身份证记录是否存在
        // 已经存在，不添加
        $stud = self::getBy(compact('child_id', 'sch_id'));
        if ($stud === null) {
            $maxid = self::max('id', compact('steps_id'));
            $id = x5on::getMaxId($maxid, $steps_id, 4);

            $uid = x5on::getUid();
            // 添加
            self::insert(compact('id', 'uid', 'child_id', 'sch_id', 'steps_id', 'come_auth', 'come_date'));
            // 返回编号
            return $id;
        } else {
            // 判断是否根当前添加记录是同一分级，不是同分级，提示重复信息
            if ($stud->steps_id !== $steps_id) throw new \Exception('该学生已在其他年级注册，请先办理休学，或确认学生信息是否正确！');
            return $stud->id;
        }
    }

}
