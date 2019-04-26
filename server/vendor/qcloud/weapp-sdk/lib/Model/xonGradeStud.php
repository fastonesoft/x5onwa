<?php
namespace QCloud_WeApp_SDK\Model;

class xonGradeStud extends cAppinfo
{
  protected static $tableName = 'xonGradeStud';
  protected static $tableTitle = '年度学生';

  public static function add ($grade_id, $cls_id, $stud_id, $stud_type_id, $stud_status_id, $stud_auth, $stud_code, $stud_diploma) {
    // 检测
    $grade = xonGrade::checkById($grade_id);
    xonGradeStud::existBy(compact('grade_id', 'stud_id'));
    // 无重复，添加
    $id = self::max('id', compact('grade_id'));
    $id = x5on::getMaxId($id, $grade_id, 4);
    $uid = x5on::getUid();
    $same_group = 0;
    xonGradeStud::insert(compact('id', 'uid', 'grade_id', 'cls_id', 'stud_id', 'stud_type_id', 'stud_status_id', 'stud_auth', 'same_group', 'stud_code', 'stud_diploma'));
    return $id;
  }





  /**
   * todo 老的要改造的一些方法  要移到 --> mvv 里面
   */

  public static function exchange ($movestud_uid, $changestud_uids) {
    $uid = $movestud_uid;
    $movestud = dbs::row('xonGradeStud', ['*'], compact('uid'));

    // 取第一个，查询相关班级信息
    $uids = explode(',', $changestud_uids);
    $uid = $uids[0];
    $changestud = dbs::row('xonGradeStud', ['*'], compact('uid'));

    // 调动学生变换班级
    $same_group = 1;
    $uid = $movestud_uid;
    $cls_id = $changestud->cls_id;
    dbs::update('xonGradeStud', compact('cls_id', 'same_group'), compact('uid'));

    // 交换学生更改班级
    foreach ($uids as $uid) {
      $cls_id = $movestud->cls_id;
      dbs::update('xonGradeStud', compact('cls_id'), compact('uid'));
    }

    // 返回调动人数
    return count($uids) + 1;
  }

  public static function local ($uid) {
    $res = dbs::row('xonGradeStud', ['*'], compact('uid'));
    if ( $res !== null ) {
      $same_group = 1;
      return dbs::update('xonGradeStud', compact('same_group'), compact('uid'));
    }
  }

  public static function getRowByUid($uid) {
    $res = dbs::row('xonGradeStud', ['*'], compact('uid'));
    if ( $res === null ) {
      throw new Exception('没有找到编号对应年级学生！');
    }
    return $res;
  }

}
