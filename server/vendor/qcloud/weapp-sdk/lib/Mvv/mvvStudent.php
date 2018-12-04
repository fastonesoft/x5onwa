<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonStep;
use QCloud_WeApp_SDK\Model\xonStudent;

class mvvStudent
{
  public static function add ($child_id, $step_id, $come_date) {
    // 检测当前年级对应学校
    $step = xonStep::checkById($step_id);
    $sch_id = $step->sch_id;

    // 检查学生身份证记录是否存在
    // 已经存在，不添加，直接返回
    $res = xonStudent::getBy(compact('child_id', 'sch_id'));
    if ($res !== null) return 0;

    // 不存在，则添加
    // 流水号宽度
    $sn_width = 4;
    // 读取最大编号
    $max = xonStudent::max('id', compact('step_id'));
    if ($max === null) {
      $sn = 0;
    } else {
      $sn = (int)substr($max, - $sn_width);
    }
    $sn++;
    $id = $step_id . substr('0000' . $sn, - $sn_width);
    $uid = x5on::getUid();
    // 添加
    return xonStudent::insert(compact('id', 'uid', 'child_id', 'step_id', 'come_date'));
  }

}
