<?php
namespace QCloud_WeApp_SDK\Model;

class xovGradeStud extends vAppinfo
{
  protected static $tableName = 'xovGradeStud';
  protected static $tableTitle = '年度学生';





  public static function getRowsByClsId ($cls_id) {
    return dbs::select('xovGradeStud', ['uid', 'stud_name', 'stud_sex', 'same_group'], compact('cls_id'));
  }

  public static function updateSameGroup ($param) {
    // 计数
    $result = 0;
    foreach ($param as $uid => $value) {
      // 同班设置
      $same_group = $value === 'true' ? 1 : 0;
      $res = dbs::row('xonGradeStud', ['*'], compact('uid', 'same_group'));
      if ( $res === null ) {
        $result++;
        dbs::update('xonGradeStud', compact('same_group'), compact('uid'));
      }
    }
    return $result;
  }

}
