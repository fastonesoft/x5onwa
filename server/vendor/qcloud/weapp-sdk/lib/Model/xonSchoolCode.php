<?php
namespace QCloud_WeApp_SDK\Model;

use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use \Exception;

class xonSchoolCode
{
  public static function saveSchoolCode ($param) {
    $sch_id = $param['sch_id'];
    $form_id = $param['form_id'];
    switch ($form_id) {
      case 1:
        $howMany = (int) $param['howMany'];
        $paraTotal = (int) $param['paraTotal'];
        $paraBit = (int) $param['paraBit'];
        $paraOrd = (int) $param['paraOrd'];
        $paraPrev = $param['paraPrev'];
        $paraSys = $param['paraSys'] === 'true' ? 1 : 0;
        // 首先清除数据
        dbs::delete('xonSchoolCode', compact('sch_id'));
        // 创建分段数据
        $para = 0;
        $count = 0;
        $loop = true;
        while ($loop) {
          $para++;
          for ($i=1; $i<=$paraTotal; $i++) {
            $count++;
            // 构造数据
            $uid = x5on::getUid();
            $id = $paraSys ?
              $sch_id . $paraPrev . sprintf("%'0$paraBit"."s", $para) . sprintf("%'0$paraOrd"."s", $i) :
              $paraPrev . sprintf("%'0$paraBit"."s", $para) . sprintf("%'0$paraOrd"."s", $i);
            // 添加
            dbs::insert('xonSchoolCode', compact('id', 'uid', 'sch_id'));
            if ($count === $howMany) {
              $loop = false;
              break;
            }
          }
        }
        break;
      case 2:
        $howMany = $param['howMany'];
        $orderBit = $param['orderBit'];
        $orderPrev = $param['orderPrev'];
        $orderSys = $param['orderSys'] === 'true' ? 1 : 0;
        // 首先清除数据
        dbs::delete('xonSchoolCode', compact('sch_id'));
        // 创建流水数据
        for ($i=1; $i<=$howMany; $i++) {
          $id = $orderSys ?
            $sch_id . $orderPrev . sprintf("%'0$orderBit"."s", $i) :
            $orderPrev . sprintf("%'0$orderBit"."s", $i);
          $uid = x5on::getUid();
          dbs::insert('xonSchoolCode', compact('id', 'uid', 'sch_id'));
        }
        break;
    }
    // 添加已创建的数据标识到schoolset表
    $set_name = x5on::SCHOOL_SET_CODE;
    xonAppFormSet::saveSchoolSet($sch_id, $form_id, $set_name, 1);
  }

  public static function getSchoolCode ($sch_id) {
    $res = dbs::select('xonSchoolCode', ['*'], compact('sch_id'), 'and', 'limit 1');
    if ( count($res) === 1 ) {
      // 删除记录
      $id = $res[0]->id;
      dbs::delete('xonSchoolCode', compact('id'));
      return $id;
    } else {
      throw new Exception("编号不够，请联系学校管理");
    }
  }
}
